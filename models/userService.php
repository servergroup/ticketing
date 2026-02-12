<?php

namespace app\models;
use yii\helpers\Html;
use Yii;
use yii\web\UploadedFile;
use app\models\User;
use yii\base\Model;
use yii\web\Cookie;

class userService extends Model
{

    // =========================
    // GESTIONE TURNI
    // =========================
    public function defineTurni($id_operatore,$entrata,$uscita,$pausa)
    {
        // Crea un nuovo record Turni
        $turni=new Turni();

        // Assegna i valori
        $turni->id_operatore=$id_operatore;
        $turni->entrata=$entrata;
        $turni->uscita=$uscita;
        $turni->pausa=$pausa;

        // Salva e ritorna risultato
        if(!$turni->save()){
            // Se fallisce non fai nulla (qui potresti loggare errore)
        }
        return $turni->save(); // ⚠ doppio save inutile
    }

    // =========================
    // INVIO EMAIL GENERICA
    // =========================
    public function contact($email, $messagio, $oggetto)
    {
        // Compone ed invia email
        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['senderEmail'])
            ->setFrom($email)
            ->setReplyTo([$email => $email])
            ->setSubject($oggetto)
            ->setHtmlBody($messagio) // ⚠ stai inviando HTML come testo
            ->send();
    }

    // =========================
    // VERIFICA SE USERNAME O EMAIL ESISTONO
    // =========================
    public function verifyUser($username,$email)
    {
        // Controllo username
        if(User::findOne(['username' => $username]) ){
            return true; 
        }

        // Controllo email
        if(User::findOne(['email' => $email]))
        {
            return true;
        }

        return false;
    }

    // =========================
    // RICHIESTA RECUPERO PASSWORD
    // =========================
    public function emailRequest($email)
    {
        // Trova utente
        $user = User::findOne(['email' => $email]);

        // Crea cookie temporaneo con email
        $cookie = new Cookie([
            'name' => 'recupero',
            'value' => $user->email,
            'expire' => time() + 600 // valido 10 minuti
        ]);

        // Aggiunge cookie alla response
        $cookie = Yii::$app->response->cookies->add($cookie);

        $cookies = Yii::$app->request->cookies;

        // Invia email con link recupero (link vuoto ⚠)
        $this->contact($user->email, '
        <html>
        <body>
        <p>E\' stata inviata al nostro portale una richiesta di modifica della password,
        pertanto, le inviamo <a href="http://localhost:8000/site/recupero-password">il link di recupero di essa</a>.
        Grazie e buon proseguimento</p>
        </body>
        </html>
        ', 'Richiesta di recupero della password');

        return true;
    }

    // =========================
    // REGISTRAZIONE UTENTE / ADMIN
    // =========================
    public function registerAdmin($nome, $cognome, $password, $email, $ruolo,$partita_iva,$azienda,$recapito_telefonico)
    {
        $user = new User();

        // Gestione upload immagine
        $file=UploadedFile::getInstance($user,'immagine');

        if($file){
            $fileName=Yii::$app->security->generateRandomString().'.'.'svg';
            $file->saveAs('./img/upload/'.$fileName);
            $user->immagine='web/img/upload/'.$fileName;
        }

        // Assegna campi
        $user->nome = $nome;
        $user->cognome = $cognome;
        $user->username =$nome[0].'.'.$cognome; // ⚠ possibile duplicato
        $user->password = Yii::$app->security->generatePasswordHash($password);
        $user->email = $email;
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString();
        $user->ruolo = $ruolo;
        $user->azienda=$azienda;
        $user->recapito_telefonico=$recapito_telefonico;
        $user->tentativi=10;
        $user->blocco=false;
        $user->partita_iva=$partita_iva;

        // Logica approvazione cliente
        if($user->partita_iva!=null && $user->ruolo=='cliente'){
            $user->approvazione=true;
        }else{
            $user->approvazione=false;
        }

        // Default azienda
        if($user->azienda ==null || $user->azienda == ''){
            $user->azienda='Dataseed';
        }

        if ($user->save()) {

            // Se non cliente crea turno base
            if($user->ruolo!='cliente'){
                $this->defineTurni($user->id,null,null,null);   
            }

            // Se non approvato crea cookie temporaneo
            if(!$user->approvazione){
                $cookie=new Cookie([
                    'name'=>'utente',
                    'value'=>$email,
                    'expire'=>time() + 600,
                ]);

                Yii::$app->response->cookies->add($cookie);
            }

            return true;
        } else {
            return false;
        }
    }

    // =========================
    // MODIFICA PASSWORD TRAMITE COOKIE
    // =========================
    public function modifyPassword($password)
    {
        $cookie = Yii::$app->request->cookies;

        // Trova utente tramite cookie recupero
        $user = User::findOne(['email' => $cookie->getValue('recupero')]);

        $user->password = Yii::$app->security->generatePasswordHash($password);

        if ($user->save()) {
            return true;
        } else {
            return false;
        }
    }

    // =========================
    // INVIO MAIL RECUPERO
    // =========================
   public function invioMail($email)
{
    if ($this->validate()) {

        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$email => $email])
            ->setSubject('RICHIESTA DI RECUPERO')
            ->setHtmlBody('
                <p>Salve sig. ' . Html::encode($email) . ',</p>
                <p>Abbiamo ricevuto la richiesta di modifica della password.
                Pertanto le inviamo il link per il recupero:</p>
                <p><a href="http://localhost:8000/site/recupero-password">
                Clicca qui per recuperare la password</a></p>
            ')
            ->send();

        return true;
    }

    return false;
}

    // =========================
    // VERIFICA COOKIE EMAIL
    // =========================
    public function verifyCookie()
    {
        $cookie=Yii::$app->request->cookies;

        if($cookie->has('email')){
            return User::findOne(['email' => $cookie->getValue('email')]);
        }
    }

    // =========================
    // MODIFICA EMAIL UTENTE LOGGATO
    // =========================
    public function recoveryEmail($nuovaEmail)
    {
        $user = User::findOne(['username' => Yii::$app->user->identity->username]);

        if (!$user) {
            return false;
        }

        // Aggiorna username e email
        $user->username = $nuovaEmail;
        $user->email = $nuovaEmail;

        if ($user->save()) {

            // Notifica modifica via email
            Yii::$app->mailer->compose()
                ->setTo([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setFrom($user->email)
                ->setReplyTo([$user->email => $user->email])
                ->setSubject('RICHIESTA DI RECUPERO')
                ->setTextBody('Salve ' . $user->email .
                    ', la informiamo che in data ' . date('Y-m-d') .
                    ' alle ore ' . date('H:i:s') .
                    ' è stata effettuata la modifica della sua email.')
                ->send();

            return true;
        }else{
            return false;
        }
    }

    // =========================
    // RESET LOGIN
    // =========================
    public function resetLogin($username){
        $user=User::findOne(['username'=>$username]);

        $user->tentativi=10; // reset tentativi
        $user->blocco=false; // sblocca utente

        return $user->save() ? true : false;
    }

    // =========================
    // APPROVAZIONE UTENTE
    // =========================
    public function verifyApprovazione($username){
        $user=User::findOne(['username'=>$username]);
        return $user->approvazione;
    }

    public function approva($username)
    {
        $user=User::findOne(['username'=>$username]);
        $user->approvazione=true;
        return $user->save();
    }

    // =========================
    // MODIFICA PARTITA IVA
    // =========================
    public function ModifyPartitaIva($partitaIva)
    {
        $user=User::findOne(['username'=>Yii::$app->user->identity->username]);
        $user->partita_iva=$partitaIva;

        if($user->save()){
            return true;
        }else{
            return false;
        }
    }

    // =========================
    // MODIFICA IMMAGINE PROFILO
    // =========================
    public function modifyImmagine()
    {
        $user=User::findOne(['username'=>Yii::$app->user->identity->username]);
        $file=UploadedFile::getInstance($user,'immagine');

        $fileName=Yii::$app->security->generateRandomString().'.'.'svg';

        $file->saveAs('upload/'.$fileName);
        $user->immagine=$fileName;

        return $user->save();
    }

    // =========================
    // MODIFICA TURNI
    // =========================
    public function modifyTurni($id_operatore,$entrata,$uscita,$pausa)
    {
        $turni=Turni::findOne(['id_operatore'=>$id_operatore]);

        $turni->entrata=$entrata;
        $turni->uscita=$uscita;
        $turni->pausa=$pausa;

        return $turni->save();
    }

    // =========================
    // INSERIMENTO / CALCOLO STATO PAUSA
    // =========================
    public function insertPausa($id_operatore)
    {
        $turni = Turni::findOne(['id_operatore' => $id_operatore]);
        if ($turni === null) {
            return false;
        }

        $oraAttuale = time();

        $inizioPausa = null;
        if (!empty($turni->pausa)) {
            $tsPausa = strtotime($turni->pausa);
            if ($tsPausa !== false) {
                $inizioPausa = $tsPausa;
            }
        }

        $finePausa = ($inizioPausa !== null) ? $inizioPausa + 3600 : null;

        $timestampUscita = null;
        if (!empty($turni->uscita)) {
            $tsUscita = strtotime($turni->uscita);
            if ($tsUscita !== false) {
                $timestampUscita = $tsUscita;
            }
        }

        $inizioServizio = strtotime('today 09:00');
        $fineServizio = strtotime('today 18:00');

        if ($timestampUscita !== null && $oraAttuale >= $timestampUscita) {
            $turni->stato = 'Fuori servizio';
        } elseif ($inizioPausa !== null && $oraAttuale >= $inizioPausa && $oraAttuale <= $finePausa) {
            $turni->stato = 'In pausa';
        } elseif ($oraAttuale >= $inizioServizio && $oraAttuale <= $fineServizio) {
            $turni->stato = 'In servizio';
        } else {
            $turni->stato = 'Non in servizio';
        }

        return $turni->save();
    }

    // =========================
    // SALTA PAUSA
    // =========================
    public function saltaPausa($id)
    {
        $turni = Turni::findOne(['id_operatore' => $id]);

        // Posticipa pausa di 1 ora
        $turni->pausa = date('Y-m-d H:i:s', strtotime($turni->pausa . ' +1 hour'));

        $turni->stato = 'In servizio';

        return $turni->save();
    }

    // =========================
    // METTI FUORI SERVIZIO
    // =========================
    public function fuoriServizio(){
        $turni=Turni::findOne(['id_operatore'=>Yii::$app->user->identity->id]);

        if(!$turni) return;

        $turni->stato='Fuori Servizio';
        return $turni->save();
    }

    // =========================
    // GESTIONE RUOLI
    // =========================
    public function assegnaRuolo($id,$ruolo)
    {
        $user=User::findOne($id);
        $user->ruolo=$ruolo;
        return $user->save();
    }

    public function resetRuolo($id)
    {
        $user=User::findOne($id);
        $user->ruolo='personale';
        return $user->save();
    }

    public function modifyRuolo($id,$ruolo)
    {
        $user=User::findOne($id);
        $user->ruolo=$ruolo;
        return $user->save();
    }

    // =========================
    // SEGNARE RECLAMO VISUALIZZATO
    // =========================
    public function visualizzato($codice_ticket)
    {
        // ⚠ find() ritorna ActiveQuery, non modello
        $reclamo=Reclami::find()->where(['codice_ticket'=>$codice_ticket]);

        $reclamo->visualizzato=true; // ⚠ errore logico

        return $reclamo->save();
    }

     // =========================
    // AVANZA UNA RIAPERTURA
    // =========================
public function avanzaRiapertura($codice_ticket, $id_operatore)
{
    // Recupera tutti gli admin
    $user = User::find()->where(['ruolo' => 'amministratore'])->all();
    $operatore = User::findOne($id_operatore);
    $ticket=Ticket::findOne(['codice_ticket'=>$codice_ticket]);
    $tutteInviate = true; // assumiamo successo

    foreach ($user as $user_item) {

        $success = $this->contact(
            $user_item->email,
            '
            <html>
            <body>
            <p>E\' stata avanzata una richiesta di ticket risolto ma da riaprire<br>
            Codice ticket: ' . $codice_ticket . '
            <br> da: ' . $operatore->nome . ' ' . $operatore->cognome . '
            </p>
            </body>
            </html>
            ',
            'richiesta di avanzo del ticket'
        );

    $cookie=new Cookie(
        [
            'name'=>'richiesta',
            'value'=>'yes' . $ticket->codice_ticket . $id_operatore,
            'expire'=>time() + 999999
        ]
    );


    Yii::$app->response->cookies->add($cookie);

    
        if (!$success) {
            $tutteInviate = false;
            
        }
    }

    return $tutteInviate;
}


}
