<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\User;

use yii\base\Model;
use yii\web\Cookie;

class userService extends Model
{


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
    ', 'Richiesta di recuipero della password');

        return true;
    }

  

    public function registerAdmin($nome, $cognome, $password, $email, $ruolo,$partita_iva,$azienda,$recapito_telefonico)
    {
        $user = new User();

        $file=UploadedFile::getInstance($user,'immagine');

        if($file){
            $fileName=Yii::$app->security->generateRandomString().'.'.'svg';


            $file->saveAs('./img/upload/'.$fileName);
            $user->immagine=$fileName;
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



}
