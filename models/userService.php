<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\User;

use yii\base\Model;
use yii\web\Cookie;

class userService extends Model
{



      public function defineTurni($id_operatore,$entrata,$uscita,$pausa)
      {
        $turni=new Turni();

        $turni->id_operatore=$id_operatore;
        $turni->entrata=$entrata;
        $turni->uscita=$uscita;
        $turni->pausa=$pausa;


      if(!$turni->save()){
          var_dump($turni->getErrors());

      }
        return $turni->save();
      }

    public function contact($email, $messagio, $oggetto)
    {
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$email => $email])
            ->setSubject($oggetto)
            ->setTextBody($messagio)
            ->send();
    }

    public function verifyUser($username,$email)
    {
        if(User::findOne(['username' => $username]) ){
        return true; 
        }

        if(User::findOne(['email' => $email]))
        {
            return true;
        }

        return false;
    }




    public function emailRequest($email)
    {
        $user = User::findOne(['email' => $email]);

        $cookie = new Cookie([
            'name' => 'recupero',
            'value' => $user->email,
            'expire' => time() + 600
        ]);

        $cookie = Yii::$app->response->cookies->add($cookie);


        $cookies = Yii::$app->request->cookies;





        $this->contact($user->email, '
    
    <html>
    <body>

    <p>E\' stata inviata al nostro portale una richiesta di modifica della password, pertanto, le inviamo <a href="">il link di recupero di essa</a>.Grazie e buon proseguimento</p>
    </body>
    </html>
    ', 'Richiesta di recupero della password');

        return true;
    }

  

    public function registerAdmin($nome, $cognome, $password, $email, $ruolo,$partita_iva,$azienda,$recapito_telefonico)
    {
        $user = new User();

        $file=UploadedFile::getInstance($user,'immagine');

        if($file){
            $fileName=Yii::$app->security->generateRandomString().'.'.'svg';


            $file->saveAs('./img/upload/'.$fileName);
            $user->immagine='web/img/upload/'.$fileName;
        }

        $user->nome = $nome;
        $user->cognome = $cognome;
        $user->username =$nome[0].'.'.$cognome;
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
        
        
        if($user->partita_iva!=null && $user->ruolo='cliente')
            {
                $user->approvazione=true;
            }else{
                $user->approvazione=false;
            }

            if($user->azienda ==null || $user->azienda == '')
                {
                    $user->azienda='Dataseed';
                }
        if ($user->save()) {
            if($user->ruolo!='cliente'){
              $this->defineTurni($user->id,null,null,null);   
            } 
        if(!$user->approvazione)
            {
        $cookie=new Cookie(
            [
                'name'=>'utente',
                'value'=>$email,
                'expire'=>time() + 600,
            ]
        );

        Yii::$app->response->cookies->add($cookie);
            }
            return true;
        } else {
        var_dump($user->getErrors());
            return false;
        }
    }


    public function modifyPassword($password)
    {
        $cookie = Yii::$app->request->cookies;
        $user = User::findOne(['email' => $cookie->getValue('recupero')]);

        $user->password = Yii::$app->security->generatePasswordHash($password);

        if ($user->save()) {
            return true;
        } else {

            return false;
        }
    }

    public function invioMail($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$email => $email])
                ->setSubject('RICHIESTA DI RECUPERO')
                ->setTextBody('
                <p>Salve sig ' . $email . ' ' . 'Abbiamo ricevuto la richiesta di modifica della password, pertanto le inviamo il link di recupero di essa:</p>' . '<a href="http://localhost:8000/admin/recupero-password">http://localhost:8000/admin/recupero-password</a>')
                ->send();

            return true;
        }
        return false;
    }




  

    public function verifyCookie()
    {
        $cookie=Yii::$app->request->cookies;

        if($cookie->has('email'))
            {
                return User::findOne(['email' => $cookie->getValue('email')]);
            }


    }

    public function recoveryEmail($nuovaEmail)
{

    $user = User::findOne(['username' => Yii::$app->user->identity->username]);

    if (!$user) {
        return false;
    }

    // AGGIORNA DATI
    $user->username = $nuovaEmail;
    $user->email = $nuovaEmail;

    if ($user->save()) {

    Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$user->email => $user->email])
            ->setSubject('RICHIESTA DI RECUPERO')
            ->setTextBody('Salve ' . $user->email . ', la informiamo che in data ' . date('Y-m-d') .
                ' alle ore ' . date('H:i:s') .
                ' è stata effettuata la modifica della sua email.')
            ->send();

        return true;
    }else{

    return false;
}
}

public function resetLogin($username){
    $user=User::findOne(['username'=>$username]);

    $user->tentativi=10;
    $user->blocco=false;

    return $user->save() ? true : false;
}

public function verifyApprovazione($username){
    $user=User::findOne(['username'=>$username]);

    return$user->approvazione;
}

public function approva($username)
{
    $user=User::findOne(['username'=>$username]);
    $user->approvazione=true;

    return $user->save();


}

public function ModifyPartitaIva($partitaIva)
{
    $user=User::findOne(['username'=>Yii::$app->user->identity->username]);

    $user->partita_iva=$partitaIva;

    if($user->save())
        {
            return true;
        }else{
            return false;
        }
}


public function modifyImmagine()
{
    $user=User::findOne(['username'=>Yii::$app->user->identity->username]);
   $file=UploadedFile::getInstance($user,'immagine');

        
          $fileName=Yii::$app->security->generateRandomString().'.'.'svg';


            $file->saveAs('upload/'.$fileName);
            $user->immagine=$fileName;
            return $user->save();

        
        
        }

           public function modifyTurni($id_operatore,$entrata,$uscita,$pausa)
      {
        $turni=Turni::findOne(['id_operatore'=>$id_operatore]);

       
        $turni->entrata=$entrata;
        $turni->uscita=$uscita;
        $turni->pausa=$pausa;
        return $turni->save();

}

public function insertPausa($id_operatore)
{
    $turni = Turni::findOne(['id_operatore' => $id_operatore]);
    if ($turni === null) {
        return false;
    }

    $oraAttuale = time();

    // Calcola inizio pausa (timestamp) se il valore è valido, altrimenti null
    $inizioPausa = null;
    if (!empty($turni->pausa)) {
        $tsPausa = strtotime($turni->pausa);
        if ($tsPausa !== false) {
            // Se la pausa è una ora (es. "09:30") vogliamo il timestamp di oggi a quell'ora
            // strtotime gestisce anche "09:30" come oggi 09:30
            $inizioPausa = $tsPausa;
        }
    }

    // Durata pausa: 1 ora (3600 secondi) solo se $inizioPausa è definito
    $finePausa = ($inizioPausa !== null) ? $inizioPausa + 3600 : null;

    // Calcola timestamp uscita se presente e valido
    $timestampUscita = null;
    if (!empty($turni->uscita)) {
        $tsUscita = strtotime($turni->uscita);
        if ($tsUscita !== false) {
            $timestampUscita = $tsUscita;
        }
    }

    // Orario servizio giornaliero (oggi 09:00 - oggi 18:00)
    $inizioServizio = strtotime('today 09:00');
    $fineServizio = strtotime('today 18:00');

    // Determina lo stato con priorità:
    // 1) Fuori servizio (se uscita passata)
    // 2) In pausa (se siamo nella finestra pausa)
    // 3) In servizio (se siamo nella fascia 09-18)
    // 4) Non in servizio (altrimenti)
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


public function saltaPausa($id)
{
    $turni = Turni::findOne(['id_operatore' => $id]);

    // Porta avanti di 1 ora l'orario della pausa
    $turni->pausa = date('Y-m-d H:i:s', strtotime($turni->pausa . ' +1 hour'));

    // Resetta lo stato
    $turni->stato = 'In servizio';

    return $turni->save();
}

public function fuoriServizio(){
    $turni=Turni::findOne(['id_operatore'=>Yii::$app->user->identity->id]);

    if(!$turni) return ;
    $turni->stato='Fuori Servizio';

    return $turni->save();
}

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

}