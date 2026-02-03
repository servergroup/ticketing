<?php

namespace app\controllers;

use app\models\Ticket;
use app\models\ticketFunction;
use app\models\User;
use Yii;

class TicketController extends \yii\web\Controller
{
    public function actionNewTicket()
    {
        $ticket = new Ticket();
        $function = new ticketFunction();

        if ($ticket->load(Yii::$app->request->post())) {

            $function->ticketScaduto();
            // Se esiste già un ticket simile
            if ($function->verifyTicket($ticket->problema, $ticket->azienda)) {
                Yii::$app->session->setFlash(
                    'success',
                    "È stato inviato un sollecito ai nostri esperti che, al più presto, si occuperanno del suo ticket. Ci scusiamo per il disagio."
                );
            }


            // Creazione nuovo ticket
            if ($function->newTicket(
                $ticket->problema,
                $ticket->ambito,
                $ticket->scadenza,
                $ticket->azienda,
                $ticket->priorita,
                $ticket->recapito_telefonico
            )) {
                Yii::$app->session->setFlash('success', 'Richiesta di ticketing inviata correttamente');
                $function->ticketScaduto();
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash(
                    'error',
                    "Problema durante la richiesta di invio ticketing. Al momento abbiamo delle difficoltà riguardanti il sistema. 
                    Contattare l'azienda e riferire il problema. Ci scusiamo per il disagio."
                );

                return $this->redirect(['new-ticket']);
            }

            return $this->redirect(['newTicket']);
        }

        return $this->render('newTicket', [
            'ticket' => $ticket
        ]);
    }


    public function actionMyTicket()
    {
        $cliente = User::findOne(['username' => Yii::$app->user->identity->username]);

        $ticket = Ticket::find()
            ->where(['id_cliente' => $cliente->id])
            ->all();

        $count = Ticket::find()
            ->where(['id_cliente' => $cliente->id])
            ->count();

        if ($count == 0) {
            Yii::$app->session->setFlash('error', 'Non hai ancora creato nessun ticket');
            return $this->redirect(['ticket/new-ticket']);
        }

        return $this->render('myTicket', [
            'ticket' => $ticket
        ]);
    }
}
