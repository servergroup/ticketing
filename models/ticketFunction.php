<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\History;
use app\models\User;
use function PHPSTORM_META\type;

class ticketFunction extends Model
{


   public function code_random()
{
    $length = 6;
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $code;
}

    public function contact($email, $messagio, $oggetto)
    {
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$email => $email])
            ->setSubject('ticket in arrivo')
            ->setTextBody($messagio)
            ->send();
    }
    public function verifyTicket($problema)
    {
        return Ticket::findOne(['problema' => $problema, 'id_cliente' => Yii::$app->user->identity->id]);
    }

    public function newTicket($problema, $ambito, $scadenza, $priorita)
    {
        $ticket = new Ticket();
        $admins = User::find()->where(['ruolo' => ['amministratore', 'itc', 'developer']])->all();

        $cliente = User::findOne(['username' => Yii::$app->user->identity->username]);
        if (!$cliente) {
            Yii::error("Utente loggato non trovato.");
            throw new \Exception("Utente loggato non trovato.");
        }

        $ticket->problema = $problema;
        $ticket->ambito = $ambito;
        $ticket->stato = 'aperto';
        $ticket->codice_ticket = strval($this->code_random());
        $ticket->scadenza =$scadenza ?? null;
        $ticket->data_invio = date('Y-m-d H:i:s');
        $ticket->id_cliente = $cliente->id;
        $ticket->priorita = $priorita;
       
    
            foreach ($admins as $admin) {
                $this->contact(
                    $admin->email,
                    '<html><body><p>Attenzione, mancano 3 giorni alla scadenza del ticket con codice '
                        . $ticket->codice_ticket
                        . '. Al fine di evitare scadenza si prega di prenderlo in carico il prima possibile.</p></body></html>',
                    'Scadenza in arrivo'
                );
            }
        

        if ($ticket->save()) {
             foreach ($admins as $admin) {
                $this->contact(
                    $admin->email,
                    '<html>
                    <body>
                    <p>
                    Nuovo ticket in arrivo '
                        .'codice ticket: '.$ticket->codice_ticket.'<br>'
                        . 'Richiesta:'.$ticket->problema
                        .'Azienda richiedente:'.$cliente->azienda
                        .'</p'
                        .'</body>'
                        .'</html>'
                        .'</html>','Nuovo ticket in arrivo'
                );
            }
            return true;
        } else {
            return false;
        }
    }

    public function chiudiTicket($id_ticket)
    {
        $ticket = Ticket::findOne($id_ticket);
        $ticket->stato = 'risolto';

       return $ticket->save();
    }
    public function ticketScaduto()
    {
        $tickets = Ticket::find()->where(['stato' => 'aperto'])->all();

        $data_corrente = new \DateTime();
        $history=new History();

        foreach ($tickets as $ticket) {
            $data_scadenza =$ticket->scadenza;
            $personale=User::find()->where(['username'=>['ammistratore','cliente','itc','sviluppatore']])->all();
            if ($data_corrente < $data_scadenza) {
                $ticket->stato = 'scaduto';
                $ticket->save();

                 foreach($personale as $personale_item){
                $this->contact($personale_item->email,'
                <html>
                <p>si comunica che,in data '. date('Y-m-d') . ' alle ore'. date('H:i:s').' è scaduto un ticket. '. 
                '
                <ul>
                <li>codice ticket='. $ticket->stato.'</li>
                <li> Scaduto il: '.$ticket->scadenza.'</li>
                
                </ul>
                '.
                'Consultare la pagina <a href="#">https:// per ulteriori informazioni</a>'.
                '
                 </p>
                </html>','Eliminazione ticket');
                }

                $history->id_ticket=$ticket->id;
                $history->id_operatore=1;
                $history->id_cliente=$ticket->id_cliente;
                $history->stato=$ticket->stato;
                $history->save();

                
            }
        }
    }

 

    
            public function  deleteTicket($id){
                $history=new History();
                $cliente=User::findOne(['username'=>Yii::$app->user->identity->username]); 
                $personale=User::find()->where(['username'=>['ammistratore','cliente','itc','sviluppatore']])->all();
                $ticket=Ticket::findOne($id);
                $history->id_ticket=$ticket->id;
                $history->id_operatore=$cliente->id;
                $ticket->id_cliente=$cliente->id;
                $ticket->stato=$ticket->stato;
                $history->save();

                foreach($personale as $personale_item){
                $this->contact( $personale_item->email,'
                <html>
                <p>si comunica che,in data '. date('Y-m-d') . ' alle ore'. date('H:i:s').' è stato cancellato un ticket da'.  $cliente->nome.' '. $cliente->cognome. ' </p>
                </html>','Eliminazione ticket');
                }
                return $ticket->delete();
            }


            public function random_num($ambito)
            {

            $ticket=Ticket::findOne(['ambito'=>$ambito]);
            $random=0;
            
            if($ticket->ambito=='itc')
                {
                    $countItc=User::find()->where(['ruolo'=>'itc'])->all();

                   $random=array_rand($countItc);
                    

                }

               if ($ticket->ambito == 'sviluppo') {

    $developers = User::find()->where(['ruolo' => 'developer'])->all();



    $randomIndex = array_rand($developers);

    return $developers[$randomIndex]->id;
}

            if ($ticket->ambito == 'itc') {

    $developers = User::find()->where(['ruolo' => 'itc'])->all();

    if (!$developers) {
        return null; // nessun developer trovato
    }

    $randomIndex = array_rand($developers);

    return $developers[$randomIndex]->id;
}

                return $random;

            }

            public function verifyDelegate($codice_ticket)
            {
                return Assegnazioni::findOne(['codice_ticket'=>$codice_ticket]);
            }
            public function assegnaTicket($codice_ticket,$ambito){
               $assegnazioni=new Assegnazioni();
               $ticket=Ticket::findOne(['codice_ticket'=>$codice_ticket]);
               $assegnazioni->id_operatore=$this->random_num($ambito);
               $assegnazioni->codice_ticket=$codice_ticket;
               $assegnazioni->ambito=$ambito;
               $ticket->stato='In lavorazione';

               $ticket->save();
               if($assegnazioni->save()){
                return true;
               }else{
                return false;
               }

            }


            public function ritiraAssegnazione($codice_ticket)
            {
                $assegnazione=Assegnazioni::findOne(['codice_ticket'=>$codice_ticket]);
                $ticket=Ticket::findOne(['codice_ticket'=>$codice_ticket]);
                
                $ticket->stato='aperto';
                $assegnazione->delete();
                return $ticket->save();



            }

            public function modificaTicket($codice_ticket,$problema,$priorita)
            {
                $ticket=Ticket::findOne(['codice_ticket'=>$codice_ticket]);

                $ticket->problema=$problema;
                $ticket->priorita=$priorita;

                return $ticket->save();
            }

                
        public function verifyData($scadenza)
{
   //convertiamo una stringa in data
    return strtotime($scadenza) >= time();
}

public function insertScadence($codice_ticket,$scadenza){
    $ticket=Ticket::findOne(['codice_ticket'=>$codice_ticket]);

    $ticket->scadenza=$scadenza;

    return $ticket->save();

    
    
    }

    
}
