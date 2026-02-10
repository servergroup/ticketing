<?php

namespace app\controllers;

use Yii;
use app\models\Assegnazioni;
use app\models\Ticket;

class OperatoreController extends \yii\web\Controller
{
    public function actionViewTicket()
    {
        $assegnazione = Assegnazioni::find()->where(['id_operatore' => Yii::$app->user->identity->id])->all();
       
        $assenazioneCount = Assegnazioni::find()->where(['id_operatore' => Yii::$app->user->identity->id])->count();

        if ($assenazioneCount == 0) {
            Yii::$app->session->setFlash('error', 'Nessun ticket è assegnato a tale operatore');
            return $this->redirect(['site/index']);
        }
        return $this->render('viewTicket', ['assegnazione' => $assegnazione]);
    }

   
}
