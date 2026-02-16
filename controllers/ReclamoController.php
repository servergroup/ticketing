<?php

namespace app\controllers;

use Yii;
use app\models\clientService;
use app\models\ContactForm;
use app\models\Mail;
use app\models\Ticket;

class ReclamoController extends \yii\web\Controller
{
public function actionMessageTicket($codice_ticket)
{
    $model=new Mail();
    $function = new ContactForm();

   
if($model->load(Yii::$app->request->post())){
    if ($function->contactTicket($codice_ticket,$model->messagio)) {
        Yii::$app->session->setFlash('success', 'Mail inviata');
        return $this->redirect(['message-ticket']);
    }else{
        Yii::$app->session->setFlash('success', 'Mail non  inviata');
        return $this->redirect(['message-ticket']);
    }
}

    return $this->render('message', [
        'model' => $model
    ]);
}


}
