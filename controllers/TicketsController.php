<?php

namespace app\controllers;
use Yii;
use app\models\Ticket;
use app\models\ticketfunction;
use app\models\userService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TableTicketController implements the CRUD actions for Ticket model.
 */
class TicketsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Ticket models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ticketfunction();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $ticket= new Ticket();
        $function=new ticketfunction();
        if ($this->request->isPost) {
            if ($ticket->load($this->request->post()))  {
               if($function->newTicket(
                 $ticket->problema,
                $ticket->ambito,
                $ticket->scadenza,
                $ticket->priorita,
               )){
                Yii::$app->session->setFlash('success','Ticket creatro');
            }
        } else {
            $ticket->loadDefaultValues();
        }

      
    }
      return $this->render('newTicket', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $ticket = $this->findModel($id);
        $function=new ticketfunction();
        if ($this->request->isPost && $ticket->load($this->request->post()))
             {
                if($function->modificaTicket($ticket->codice_ticket,$ticket->problema,$ticket->priorita,$ticket->ambito,$ticket->scadenza)){
                    Yii::$app->session->setFlash('success','Modifica effettuata correttamente');
                }
            return $this->redirect(['modifyTicket', 'ticket' => $ticket]);
        }

        return $this->render('modifyTicket', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMyTicket()
{
    $searchModel = new ticketfunction();

    // Passiamo i queryParams come sempre
    $params = Yii::$app->request->queryParams;

    // Aggiungiamo il filtro per l'utente loggato
    $params['ticketfunction']['id_cliente'] = Yii::$app->user->identity->id;

    $dataProvider = $searchModel->search($params);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    public function actionOpen()
{
    $searchModel = new ticketfunction();

    // Passiamo i queryParams come sempre
    $params = Yii::$app->request->queryParams;

    // Aggiungiamo il filtro per l'utente loggato
    $params['ticketfunction']['stato'] ='aperto';

    $dataProvider = $searchModel->search($params);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    public function actionClose()
{
    $searchModel = new ticketfunction();

    // Passiamo i queryParams come sempre
    $params = Yii::$app->request->queryParams;

    // Aggiungiamo il filtro per l'utente loggato
    $params['ticketfunction']['stato'] ='chiuso';

    $dataProvider = $searchModel->search($params);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    public function actionScadence()
{
    $searchModel = new ticketfunction();

    // Passiamo i queryParams come sempre
    $params = Yii::$app->request->queryParams;

    // Aggiungiamo il filtro per l'utente loggato
    $params['ticketfunction']['stato'] ='scaduto';

    $dataProvider = $searchModel->search($params);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}
}
