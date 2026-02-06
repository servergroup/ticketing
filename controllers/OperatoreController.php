<?php

namespace app\controllers;

use Yii;
use app\models\Assegnazioni;

class OperatoreController extends \yii\web\Controller
{
    public function actionViewTicket()
    {
        $assegnazione = Assegnazioni::findOne(['id_operatore' => Yii::$app->user->identity->id]);
        $assenazioneCount = Assegnazioni::findOne(['id_operatore' => Yii::$app->user->identity->id]);

        if ($assenazioneCount == 0) {
            Yii::$app->session->setFlash('error', 'Nessun ticket è assegnato a tale operatore');
            return $this->redirect(['site/index']);
        }
        return $this->render('index', ['assegnazione' => $assegnazione]);
    }
}
