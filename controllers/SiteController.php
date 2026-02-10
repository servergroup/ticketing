<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\userService;
use app\models\Assegnazioni;
use app\eccezioni\existUserException;
use app\eccezioni\tentativiSuperati;
use app\models\User;
use app\models\Ticket;
use app\models\ticketFunction;
use Exception;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index','contact','attesa','account','modify-username','recovery-mail','reset','modify-iva','modify-image','modify-email'],
                'rules' => [
                    [
                        'actions' => ['index','contact', 'logout','index','contact','mail','recupero-password','attesa','account','modify-username','recovery-mail','reset','modify-iva','modify-image','modify-email'],
                        'allow' => true,
                        'roles' => ['@'],



                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */




public function actionIndex()
{
  
$user=User::findOne(['username'=>Yii::$app->user->identity->username]);
// Ticket dell’utente
$ticket = Ticket::find()->where(['id_cliente' => Yii::$app->user->identity->id])->all();
$assegnazioni = Assegnazioni::find()->all();
// Conteggio corretto dei ticket dell’utente
$countTicket = Ticket::find()->where(['id_cliente' => Yii::$app->user->identity->id])->count();

$function=new ticketFunction();

$function->ticketScaduto();
// Ultimo ticket dell’utente
$ultimoTicket = Ticket::find()
    ->where(['id_cliente' => Yii::$app->user->identity->id])
    ->orderBy(['data_invio' => SORT_DESC])
    ->one();

    if(!$user->approvazione){
        Yii::$app->session->setFlash('info','Attendere l\'approvazione da parte di uno dei nostri amministratori');
     return $this->redirect(['attesa']);  
    }
return $this->render('index', [
    'user' => $user,
    'ticket' => $ticket,
    'countTicket' => $countTicket,
    'ultimoTicket' => $ultimoTicket,
    'assegnazioni'=>$assegnazioni
]);
}


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $function = new userService();
        $register=new User();

        if ($model->load(Yii::$app->request->post())) {

            try{

            if ($model->verifyBlocco($model->username)) {
               throw new tentativiSuperati('A causa della superazione del limite dei tentativi massimi di accesso è \' stato applicato il blocco antiAccesso');
               
            }

    

         
            if ($model->login()) {
                
                if (Yii::$app->user->identity->ruolo == 'amministratore') {
                    return $this->redirect(['attesa']);
                } else if (Yii::$app->user->identity->ruolo == 'developer') {
                   
                    return $this->redirect(['attesa']);
                } else if (Yii::$app->user->identity->ruolo == 'itc') {
                   return $this->redirect(['attesa']);
                } else if (Yii::$app->user->identity->ruolo == 'cliente') {
                    return $this->redirect(['index']);
                }
                //return $this->redirect(['index']);
            }else{
              
            Yii::$app->session->setFlash('error', 'Credenziali errate');
           
            }
            $model->password = '';
           
            return $this->render('login', ['model' => $model]);
     
           }catch(tentativiSuperati $e){
            Yii::$app->session->setFlash('error','A causa dei tentativi di accesso superati e \' stato attivato il blocco antiAccesso');
        }

    }

        return $this->render('login', [
            'model' => $model,
            'register'=>$register,
        ]);

    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'], 'b')) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */


    public function actionMail()
    {
        $user = new User();
        $function = new userService();
        if ($user->load(Yii::$app->request->post())) {

            $userFind = User::findOne(['email' => $user->email]);

            if (!$userFind) {
                Yii::$app->session->setFlash('error', 'la mail inserita non coincide con nessun utente registrato');
                return $this->redirect('mail');
            }
            if ($user && $function->emailRequest($user->email)) {
                Yii::$app->session->setFlash('success', 'Controlla la tua email, ti abbiamo inviato il link di recupero');
                return $this->redirect('mail');
            } else {
                Yii::$app->session->setFlash('error', 'Qualcosa è andato storto nel tentativo di recupero dei dati');
                return $this->redirect('mail');
            }
        }
        return $this->render('recuperoMail', ['user' => $user]);
    }
    public function actionRecuperoPassword()
    {
        $user = new User();
        $function = new userService();

        if ($user->load(Yii::$app->request->post())) {

            if ($function->modifyPassword($user->password)) {
                Yii::$app->session->setFlash('success', 'Password modificata correttamente');
                return $this->redirect(['login']);
            } else {

                Yii::$app->session->setFlash('error', 'Problema durante la modifica della password, riprovare');
                var_dump($function->modifyPassword($user->passw));
                return $this->refresh();
            }
        }

        return $this->render('modifyPassword', ['user' => $user]);
    }

    public function actionAttesa()
    {
      
        $user=User::findOne(['username'=>Yii::$app->user->identity->username]);
        // Ticket dell’utente
$ticket = Ticket::find()->where(['id_cliente' => Yii::$app->user->identity->id])->all();

// Conteggio corretto dei ticket dell’utente
$countTicket = Ticket::find()->where(['id_cliente' => Yii::$app->user->identity->id])->count();

//ulitmo ticket rilevato

$ultimoTicket = Ticket::find()
    ->where(['id_cliente' => Yii::$app->user->identity->id])
    ->orderBy(['data_invio' => SORT_DESC])
    ->one();


        if(!$user->approvazione){
      Yii::$app->session->setFlash('info','Si prega di attendere l\'approvazione da parte di uno degli amministratori,grazie per l\'attesa');

        }else{
         return $this->redirect(['index']);

    }
      return $this->render('approved',[
            'user'=>$user,
         'ticket'=>$ticket,
         'countTicket'=>$countTicket,
         'ultimoTicket'=>$ultimoTicket]);
    }
    public function actionRegister()
    {
        $user = new User();
        $function = new userService();

        if ($user->load(Yii::$app->request->post())) {
            try {
                if ($function->verifyUser($user->username, $user->email)) {
                    Yii::$app->session->setFlash('error', 'Utente già registrato');
                
                }else if ($function->registerAdmin($user->nome, $user->cognome, $user->password, $user->email, $user->ruolo,$user->partita_iva,$user->azienda,$user->recapito_telefonico)) {
                    Yii::$app->session->setFlash('success', 'Registrazione avvenuta correttamente');
                    return $this->redirect(['login']);
                } else {

                    Yii::$app->session->setFlash('error', 'Registrazione fallita, riprovare');
                }

                return $this->refresh();
            } catch (existUserException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->refresh();
            }
        }


        return $this->render('register', ['user' => $user]);
    }

    public function actionAccount()
    {
        $account = User::findOne(['username' => Yii::$app->user->identity->username]);

        $count = User::find()->where(['username' => Yii::$app->user->identity->username])->count();
        if ($count == 0) {
            Yii::$app->session->setFlash('error', 'Non hai ancora creato nessun ticket');
            return $this->redirect(['ticket/new-ticket']);
        }
        return $this->render('myAccount', ['account' => $account]);
    }

    public function actionModifyUsername()
    {
         $user=new User();
         $function=new userService();

         if($user->load(Yii::$app->request->post()))
            {
                /*
                if($function->verifyCookie()){
                      Yii::$app->session->setFlash('error','Email inesistente');
                      return $this->redirect(['index']);
                }
                */
                if($function->recoveryEmail($user->email))
                    {
                        Yii::$app->session->setFlash('success','Recupero email effettuata con successo');
                        return $this->redirect(['site/index']);
                        }else{
                         Yii::$app->session->setFlash('error','Recupero email non  effettuata con successo');
                         
                         return $this->redirect(['site/index']);
                    }
            }
            return $this->render('modifyEmail',['user'=>$user]);
         
    }

    public function actionReset($username){
        $user=User::findOne(['blocco'=>true]);
        $function=new userService();
        
                if($function->resetLogin($username))
                    {
                        Yii::$app->session->setFlash('success','Reset effettuato correttamente');
                        return $this->redirect(['index']);
                    }else{
                         Yii::$app->session->setFlash('error','Reset  non effettuato correttamente');
                         return $this->redirect(['index']);

                    }


            
    }


    public function actionModifyIva()
    {
        $user=new User();
        $function=new userService();

        if($user->load(Yii::$app->request->post()))
            {
                if($function->ModifyPartitaIva($user->partita_iva))
                    {
                        Yii::$app->session->setflash('success','Modifica della partita iva effettuata correttamente');
                        return $this->redirect(['index']);
                    }else{
                         Yii::$app->session->setflash('success','Modifica della partita iva non effettuata correttamente');
                         return $this->redirect(['index']);
                    }


            }
    }

    
public function actionModifyImage()
{
    $account = User::findOne(['username' => Yii::$app->user->identity->username]);
    $service = new userService();

    if ($account->load(Yii::$app->request->post())) {

        if ($service->modifyImmagine()) {
            Yii::$app->session->setFlash('success', 'Immagine modificata con successo');
        } else {
            Yii::$app->session->setFlash('error', 'Errore nella modifica dell\'immagine');
        }

        return $this->redirect(['account']);
    }

    return $this->render('myAccount', [
        'account' => $account
    ]);
}

public function actionModifyEmail()
{
    $user=User::findOne(['username'=>Yii::$app->user->identity->username]);
    $function=new userService();

    if($user->load(Yii::$app->request->post()))
        {
            if($function->recoveryEmail($user->email))
                {
                    Yii::$app->session->setFlash('success','Email recuperatacon successo');
                    return $this->redirect(['logout']);
                }else{
                     Yii::$app->session->setFlash('success','Email non recuperatacon successo');
                }
        }
        return $this->render('modifyEmail',[
            'user'=>$user
        ]);
}


    

    



}
