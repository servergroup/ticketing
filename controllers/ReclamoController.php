<?php

namespace app\controllers;

use Yii;
use app\models\clientService;
use app\models\Reclami;

class ReclamoController extends \yii\web\Controller
{
    public function actionReclamo()
    {
        $reclamo = new Reclami();
        $function = new clientService();

        if ($reclamo->load(Yii::$app->request->post())) {
            if ($function->reclami($reclamo->problema, $reclamo->azienda)) {
                Yii::$app->session->setFlash('success', 'Reclamo inviato correttamente');
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('success', 'Reclamo inviato correttamente');
                return $this->refresh();
            }
        }
        return $this->render('reclamo', ['reclamo' => $reclamo]);
    }
}
