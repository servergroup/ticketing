<?php

namespace app\controllers;

use app\models\Ticket;
use app\models\ticketFunction;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\userService;
use app\models\User;
use app\eccezioni\dataException;
use Yii;

class TicketController extends \yii\web\Controller
{

public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'only' => [
                'new-ticket','my-ticket','delete-ticket','ritiro',
                'modify-ticket','reintegra','resolve','my-reparto',
                'my-reparto-open'
            ],
            'rules' => [

                // 1️⃣ CLIENTE (solo alcune azioni)
                [
                    'allow' => true,
                    'actions' => ['new-ticket','my-ticket','delete-ticket','modify-ticket'],
                    'roles' => ['@'],
                    'matchCallback' => function () {
                        return Yii::$app->user->identity->ruolo != 'developer'|| Yii::$app->user->identity->ruolo != 'ict';
                    }
                ],

                // 2️⃣ OPERATORE (azioni riservate)
                [
                    'allow' => true,
                    'actions' => ['ritiro','resolve','my-reparto','my-reparto-open'],
                    'roles' => ['@'],
                    'matchCallback' => function () {
                        return Yii::$app->user->identity->ruolo === 'developer'|| Yii::$app->user->identity->ruolo != 'ict';
                    }
                ],
                 [
                    'allow' => true,
                    'actions' => ['resolve','my-reparto','my-reparto-open'],
                    'roles' => ['@'],
                    'matchCallback' => function () {
                        return Yii::$app->user->identity->ruolo === 'ict';
                    }
                ],

                // 3️⃣ AMMINISTRATORE (azioni speciali)
                [
                    'allow' => true,
                    'actions' => ['reintegra','ritiro'],
                    'roles' => ['@'],
                    'matchCallback' => function () {
                        return Yii::$app->user->identity->ruolo === 'amministratore';
                    }
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



    public function actionNewTicket()
    {
        $ticket = new Ticket();
        $function = new ticketFunction();
        $admins = User::find()->where(['ruolo' => ['amministratore', 'itc', 'developer']])->all();

        if ($ticket->load(Yii::$app->request->post())) {
            try{
        /*if($function->verifyData($ticket->scadenza))
            {
             
            }
            // Se esiste già un ticket simile
            if ($function->verifyTicket($ticket->problema)) {
                Yii::$app->session->setFlash(
                    'success',
                    "È stato inviato un sollecito ai nostri esperti che, al più presto, si occuperanno del suo ticket. Ci scusiamo per il disagio."
                );
            }
*/

            // Creazione nuovo ticket
            if ($function->newTicket(
                $ticket->problema,
                $ticket->ambito,
                $ticket->scadenza,
                $ticket->priorita,

            )) {
                  // Notifica preventiva (opzionale)
        foreach ($admins as $admin) {
            $function->contact(
                $admin->email,
                '<p>E\' stata avanzato un nuovo ticket con codice' . $ticket->codice_ticket . '.</p>',
                'Nuovo ticket in arrivo'
            );
        }
                Yii::$app->session->setFlash('success', 'Richiesta di ticketing inviata correttamente');
                $function->ticketScaduto();
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash(
                    'error',
                    "Problema durante la richiesta di invio ticketing. Al momento abbiamo delle difficoltà riguardanti il sistema. 
                    Contattare l'azienda e riferire il problema. Ci scusiamo per il disagio."
                );

               // return $this->redirect(['new-ticket']);
            }

           
        }catch(dataException $e){
               Yii::$app->session->setFlash('success','La data inserita risulta essere nel passato');
                return $this->refresh();
        }

        }
        return $this->render('newTicket', [
            'ticket' => $ticket
        ]);
    }

public function actionMyTicket()
{
    $utente = Yii::$app->user->identity;

    if (!$utente) {
        throw new \yii\web\ForbiddenHttpException('Utente non autenticato.');
    }

    $cliente = User::findOne(['username' => $utente->username]);

    if (!$cliente) {
        Yii::$app->session->setFlash('error', 'Utente non trovato.');
        return $this->redirect(['site/index']);
    }

    $searchTicket = new Ticket();

    // Query base
    $query = Ticket::find()
        ->where(['id_cliente' => $cliente->id])
        ->with('cliente');

    // LIVE SEARCH via AJAX
    if (Yii::$app->request->isAjax) {
        $searchTicket->load(Yii::$app->request->post());
        $query->andFilterWhere(['like', 'codice_ticket', $searchTicket->codice_ticket]);
        $tickets = $query->all();
        return $this->renderAjax('_ticketTable', ['ticket' => $tickets]);
    }

    // Visualizzazione normale
    $ticket = $query->all();

    if (empty($ticket)) {
        Yii::$app->session->setFlash('error', 'Non hai ancora creato nessun ticket.');
        return $this->redirect(['ticket/new-ticket']);
    }

    return $this->render('myTicket', [
        'ticket' => $ticket,
        'searchTicket' => $searchTicket
    ]);
}


    public function actionDeleteTicket($id)
    {
        $function = new ticketFunction();
        $user=new userService();
         $personale = User::find()->where(['ruolo' => ['amministratore', 'cliente', 'itc', 'developer']])->all();
          $cliente = User::findOne(['username' => Yii::$app->user->identity->username]);

        if ($function->deleteTicket($id)) {


        foreach ($personale as $p) {
            $user->contact(
                $p->email,
                '<p>Si comunica che in data ' . date('Y-m-d') . ' alle ore ' . date('H:i:s') . ' è stato cancellato un ticket da ' . ($cliente ? ($cliente->nome . ' ' . $cliente->cognome) : 'utente sconosciuto') . '.</p>',
                'Eliminazione ticket'
            );
        }
            Yii::$app->session->setFlash('success', 'Eliminazione effettuata con successo');
            return $this->redirect(['site/index']);
        } else {
            Yii::$app->session->setFlash('error', 'eliminazione fallita a causa di un problema');
            return $this->redirect(['site/index']);
        }
    }

    public function actionRitiro($codice_ticket)
    {
        $function = new ticketFunction();

        if ($function->ritiraAssegnazione($codice_ticket)) {
            Yii::$app->session->setflash('success', 'Ritiro effettuato correttamente');
            return $this->redirect(['site/index']);
        } else {
            Yii::$app->session->setflash('else', 'Ritiro non effettuato correttamente');
            return $this->redirect(['site/index']);
        }
    }

    public function actionModifyTicket($codiceTicket)
    {
        $ticket = Ticket::findOne(['codice_ticket' => $codiceTicket]);
        
        $function = new ticketFunction();

        if($ticket->load(Yii::$app->request->post()))
            {
        if ($function->modificaTicket($ticket->codice_ticket, $ticket->problema, $ticket->priorita,$ticket->ambito,$ticket->scadenza)) {
            Yii::$app->session->setFlash('success', 'modifica del ticket avvenuta con successo');
            return $this->redirect(['site/index']);
        } else {
            Yii::$app->session->setFlash('error', 'Modifica del ticket non effettuata con successo');
            return $this->redirect(['site/index']);
        }

            }
        return $this->render('modifyTicket', [
            'ticket' => $ticket,
           

        ]);
    }

    public function actionReintegra($codice_ticket)
    {
        $ticket=Ticket::findOne(['codice_ticket'=>$codice_ticket]);
        $function=new ticketFunction();
        if($function->prolungate($ticket->codice_ticket))
            {
                Yii::$app->session->setFlash('success','Ticket nuovamente gestibile e lavorabile');
               
                }else{
                Yii::$app->session->setFlash('error','Reintegrazione del ticket fallita');
               
               
            }

            return $this->redirect(['admin/ticketing']);
    }

    public function actionResolve($id)
    {
        $ticket=Ticket::findOne($id);
        $user=new userService();
        $function=new ticketFunction();
          $personale = User::find()->where(['ruolo' => ['amministratore', 'cliente', 'itc', 'developer']])->all();
        

            if($function->chiudiTicket($ticket->id))
                {
                     foreach ($personale as $p) {
                    $user->contact(
                        $p->email,
                        '<p>Si comunica che in data ' . date('Y-m-d') . ' alle ore ' . date('H:i:s') . ' è scaduto un ticket.<br>Codice ticket: ' . $ticket->codice_ticket . '<br>Scaduto il: ' . $ticket->scadenza . '</p>',
                        'Ticket scaduto'
                    );
                }
                    Yii::$app->session->setFlash('success','Ticket risolto correttamente');
                    return $this->redirect(['operatore/view-ticket']);
                }else{
                    Yii::$app->session->setFlash('error','Ticket purtroppo non risolto correttamente');
                    return $this->redirect(['operatore/view-ticket']);
                }
        

        return $this->redirect(['operatore/view-ticket']);
    }

   

public function actionMyReparto()
{

    $ticket=Ticket::find()->where(['ambito'=>'sviluppo'])->all();

    return $this->render('myDepartment',['ticket'=>$ticket]);
}

public function actionMyRepartoOpen()
{
    $ticket=Ticket::find()->where(['ambito'=>'sviluppo','stato'=>'aperto'])->all();

    return $this->render('myDepartment',['ticket'=>$ticket]);
}
}
