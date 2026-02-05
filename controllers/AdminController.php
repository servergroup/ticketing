<?php

namespace app\controllers;

use app\eccezioni\existUserException;
use Yii;
use Exception;
use app\models\User;
use app\models\userService;
use app\models\LoginForm;
use app\models\Ticket;
use app\models\ticketFunction;

class AdminController extends \yii\web\Controller
{

    public function actionTicketing()
    {
        // Modello usato solo per ricevere i dati del form di ricerca
        $searchTicket = new Ticket();

        // Recupera tutti i ticket (visualizzazione iniziale)
        $ticket = Ticket::find()->all();

        // Se il form è stato inviato e i dati sono stati caricati nel modello
        if ($searchTicket->load(Yii::$app->request->post()))
        {
            // Filtra i ticket cercando quelli con il codice inserito
            // findAll restituisce SEMPRE un array → perfetto per il foreach
            $ticket = Ticket::findAll(['codice_ticket' => $searchTicket->codice_ticket]);

            // Se il campo è vuoto, torna a mostrare tutti i ticket
            if ($searchTicket->codice_ticket == null || $searchTicket->codice_ticket == '')
            {
                $ticket = Ticket::find()->all();
            }

            
        }

        // Passa alla vista sia i ticket (filtrati o meno) sia il modello del form
        return $this->render('allTicketing', [
            'ticket' => $ticket,
            'searchTicket' => $searchTicket
        ]);
    }

    public function actionScadence()
    {
        // Recupera tutti i ticket con stato "scaduto"
        $ticket = Ticket::find()->where(['stato' => 'scaduto'])->all();

        // Conta quanti ticket scaduti esistono
        $ticketCount = Ticket::find()->where(['stato' => 'scaduto'])->count();

        // Se non ci sono ticket scaduti → messaggio + redirect alla home
        if ($ticketCount == 0) {
            Yii::$app->session->setFlash('error', 'Al momento non e\' stato rilevato alcun ticket scaduto');
            return $this->redirect(['site/index']);
        }

        // Mostra la vista con i ticket scaduti
        return $this->render('allTicketScadence', [
            'ticket' => $ticket
        ]);
    }

    public function actionOpen()
    {
        // Recupera tutti i ticket con stato "aperto"
        $ticket = Ticket::find()->where(['stato' => 'aperto'])->all();

        // Conta quanti ticket aperti esistono
        $ticketCount = Ticket::find()->where(['stato' => 'aperto'])->count();

        // Se non ci sono ticket aperti → messaggio + redirect
        if ($ticketCount == 0) {
            Yii::$app->session->setFlash('error', 'Al momento non e\' stato rilevato alcun ticket aperto');
            return $this->redirect(['site/index']);
        }

        // Mostra la vista con i ticket aperti
        return $this->render('allTicketOpen', [
            'ticket' => $ticket
        ]);
    }

    public function actionDelegate($codice_ticket, $ambito)
    {
        // Classe che contiene la logica di assegnazione dei ticket
        $function = new ticketFunction();

        // Controlla se il ticket è già assegnato
        if ($function->verifyDelegate($codice_ticket)) {
            Yii::$app->session->setFlash('info', 'Il ticket è gia\' in lavorazione');
            return $this->redirect(['ticketing']);
        }

        // Prova ad assegnare il ticket
        if ($function->assegnaTicket($codice_ticket, $ambito)) {
            Yii::$app->session->setFlash('success', 'Ticket assegnato a qualcuno');
            return $this->redirect(['ticketing']);
        } else {
            // Se l'assegnazione fallisce
            Yii::$app->session->setFlash('error', 'Ticket non  assegnato a nessuno');
            return $this->redirect(['ticketing']);
        }
    }

    public function actionAttese()
    {
        $user=User::find()->where(['approvazione'=>false])->all();

        return $this->render('userInAttesa',['user'=>$user]);
    }


    public function actionApprova($username)
    {
           $user=User::findOne(['approvazione'=>false]);
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
}
