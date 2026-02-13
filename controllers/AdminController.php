<?php

namespace app\controllers;

use app\eccezioni\existUserException;
use Yii;
use Exception;
use app\models\User;
use app\models\userService;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Ticket;
use app\models\Turni;
use app\models\ticketFunction;
use app\models\Reclami;
use app\models\TempiTicket;

class AdminController extends \yii\web\Controller
{

public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'only' => ['ticketing','scadence','open','delegate','attese','approva','block-user','reset'],
            'rules' => [
                [
                    'actions' => ['ticketing','scadence','open','delegate','attese','approva','block-user','reset'],
                    'allow' => true,
                    'roles' => ['@'], // deve essere loggato
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->identity->ruolo === 'amministratore';
                    }
                ],
            ],
            'denyCallback' => function () {
                Yii::$app->session->setFlash('error','Non sei autorizzato ad accedere a questa rotta, questa rotta e\' riservata agli amministratori del sistema');
                return Yii::$app->response->redirect(['site/login']);
            }
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


public function actionTicketing()
{
    $searchTicket = new Ticket();

    // Creiamo la query base
    $query = Ticket::find()->with('cliente'); // Assicurati che 'cliente' sia la relazione verso User

    // Filtra per live search se arriva AJAX
    if (Yii::$app->request->isAjax && $searchTicket->load(Yii::$app->request->post())) {
        $query->andFilterWhere(['like', 'codice_ticket', $searchTicket->codice_ticket]);
        $tickets = $query->all();
        return $this->renderAjax('_ticketTable', ['ticket' => $tickets]);
    }

    // Visualizzazione normale
    $ticket = $query->all();

    return $this->render('allTicketing', [
        'ticket' => $ticket,
        'searchTicket' => $searchTicket
    ]);
}



public function actionScaduto()
{
    $searchTicket = new Ticket(); // Modello per il form
    $query = Ticket::find()->where(['stato' => 'scaduto']);

    if ($searchTicket->load(Yii::$app->request->post()) && $searchTicket->codice_ticket) {
        $query->andWhere(['codice_ticket' => $searchTicket->codice_ticket]);
    }

    $ticket = $query->all();

    if (empty($ticket)) {
        Yii::$app->session->setFlash('error', 'Al momento non è stato rilevato alcun ticket scaduto');
        return $this->redirect(['site/index']);
    }

    return $this->render('allTicketScadence', [
        'ticket' => $ticket,
        'searchTicket' => $searchTicket
    ]);
}

public function actionChiuso()
{
    $searchTicket = new Ticket(); // Modello per il form
    $query = Ticket::find()->where(['stato' => 'chiuso']);

    if ($searchTicket->load(Yii::$app->request->post()) && $searchTicket->codice_ticket) {
        $query->andWhere(['codice_ticket' => $searchTicket->codice_ticket]);
    }

    $ticket = $query->all();

    if (empty($ticket)) {
        Yii::$app->session->setFlash('error', 'Al momento non è stato rilevato alcun ticket chiuso');
        return $this->redirect(['site/index']);
    }

    return $this->render('allTicketScadence', [
        'ticket' => $ticket,
        'searchTicket' => $searchTicket
    ]);
}

public function actionOpen()
{
    $searchTicket = new Ticket();
    $query = Ticket::find()
        ->where(['stato' => 'aperto'])
        ->with('cliente'); // ottimizzazione

    // 🔎 LIVE SEARCH AJAX
    if (Yii::$app->request->isAjax) {

        $searchTicket->load(Yii::$app->request->post());

        $searchValue = trim($searchTicket->codice_ticket);

        $query->andFilterWhere([
            'like',
            'codice_ticket',
            $searchValue
        ]);

        $tickets = $query->all();

        return $this->renderAjax('_ticketTable', [
            'ticket' => $tickets
        ]);
    }

    // 🟢 Caricamento normale pagina
    $ticket = $query->all();

    return $this->render('allTicketOpen', [
        'ticket' => $ticket,
        'searchTicket' => $searchTicket
    ]);
}



    public function actionDelegate($codice_ticket, $ambito)
    {
        // Classe che contiene la logica di assegnazione dei ticket
        $function = new ticketFunction();
    

        if($function->random_num($ambito)==null){
            Yii::$app->session->setFlash('error','Nessun operatore è al momento disponibile per la risoluzione del ticket');
            return $this->redirect(['ticketing']);
        }
        // Controlla se il ticket è già assegnato
        if ($function->verifyDelegate($codice_ticket)) {
            Yii::$app->session->setFlash('info', 'Il ticket è gia\' in lavorazione');
            return $this->redirect(['ticketing']);
        }

        // Prova ad assegnare il ticket
        if ($function->assegnaTicket($codice_ticket, $ambito)) {
            Yii::$app->session->setFlash('success', 'Ticket assegnato correttamente');
            return $this->redirect(['ticketing']);
        } else {
            // Se l'assegnazione fallisce
            Yii::$app->session->setFlash('error', 'Ticket non  assegnato a nessuno');
            return $this->redirect(['ticketing']);
        }
    }

  public function actionAttese()
{
    // usa $users (plurale) per evitare shadowing della variabile
    $users = User::find()->where(['approvazione' => false])->all();
    $function = new UserService();
     $newUser=new User();
      foreach ($users as $u) {
     $user=User::findOne($u->id);
      }


    return $this->render('userInAttesa', ['users' => $users]);
}



    public function actionApprova($username)
    {
           $users=User::findOne(['approvazione'=>false]);
        $function=new userService();

        if($function->approva($username))
            {
                Yii::$app->session->setFlash('success','Approvazione effettuata correttamente ');
                return $this->redirect(['site/index']);
            }else{
                Yii::$app->session->setFlash('error','Approvazione non  effettuata correttamente ');
                 return $this->redirect(['site/index']);
            }
    }

    public function actionBlockUser()
    {
         $user=User::find()->where(['blocco'=>true])->all();

        return $this->render('userBloccato',['user'=>$user]);
    }

    public function actionReset($username){
        $function=new userService();

        if($function->resetLogin($username))
            {
                Yii::$app->session->setFlash('success','Reset effettuato correttamente');
                return $this->redirect(['site/index']);
            }else{
                Yii::$app->session->setFlash('error','Reset non  effettuato correttamente');
                return $this->redirect(['site/index']);
            }
    }

    public function actionScadence($codice_ticket)
    {
        $ticket=new Ticket();
        $function=new ticketFunction();

        if($ticket->load(Yii::$app->request->post()))
            {
                if($function->insertScadence($codice_ticket,$ticket->scadenza))
                    {
                        Yii::$app->session->setFlash('success','Scadenza impostata correttamente');
                        $this->redirect(['ticketing']);
                    }else{
                        Yii::$app->session->setFlash('error','Scandenza non impostata correttamente');
                    $this->redirect(['ticketing']);
                        }
            }



            
    }

    public function actionGestioneDipendenti()
{
    $dipendenti = User::find()
        ->where(['ruolo' => ['developer', 'ict']])
        ->all();

    return $this->render('viewOperatori', ['dipendenti' => $dipendenti]);
}


public function actionModifyTurni($id_operatore){
   $function=new userService();
   $personale=User::findOne($id_operatore);
$model=new Turni();


if($model->load(Yii::$app->request->post()))
        {
            if($function->modifyTurni($id_operatore,$model->entrata,$model->uscita,$model->pausa))
                {
                    Yii::$app->session->setFlash('success','Turni definiti correttamente');
                    return $this->redirect(['gestione-dipendenti']);
                }else{
                     Yii::$app->session->setFlash('error','Errore nella definizione dei turni');
                      return $this->redirect(['gestione-dipendenti']);
                }

        }
        return $this->render('Turni',['model'=>$model,'personale'=>$personale]);
}


public function actionModifyRuolo($id)
{
    $user = User::findOne($id);
    $function = new UserService();

    if ($user->load(Yii::$app->request->post())) {

        $ruolo = $user->ruolo;

        if ($function->assegnaRuolo($id, $ruolo)) {
            Yii::$app->session->setFlash('success', "Ruolo assegnato correttamente");
        } else {
            Yii::$app->session->setFlash('error', "Errore nell'assegnamento del ruolo");
        }

        return $this->redirect(['admin/attese']);
    }

    Yii::$app->session->setFlash('error', "Dati non validi");
    return $this->redirect(['admin/attese']);
}

public function actionUpdateRuolo($id)
{

 $user = User::findOne($id);
    $function = new UserService();

     if($function->resetRuolo($id)){
        Yii::$app->session->setFlash('success','Abbiamo resettato il ruolo per permetterle di effettuare la modifica');
        return $this->redirect(['attese']);
     }
        
        
}

public function actionVerifyRuolo()
{
    $user=User::find()->all();

    return $this->render('viewRuoli',['user'=>$user]);
    }

    public function actionTempi()
    {
        $tempi=TempiTicket::find()->all();

        return $this->render('TimeTicket',['tempi'=>$tempi]);
    }



    }
