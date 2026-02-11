<?php

namespace app\models;
use Yii;
use yii\base\Model;
use app\models\ticketFunction;
use app\models\reclami;
class clientService extends Model
{
    public function reclami($problema)
    {
       $reclami=new Reclami();
       $cliente=User::findOne(['username'=>Yii::$app->user->identity->username]);
       $function=new ticketFunction();
       $reclami->problema=$problema;
       $reclami->azienda=$cliente->azienda;
       $reclami->id_cliente=$cliente->id;
       $reclami->visualizzato=false;
       
       if($reclami->save())
        {     
       $function->contact($cliente->email,
       '<html>
       <body>
       <p>E \' stato segnalato un reclamo da '.
        $reclami->azienda.'Per ulteriori informazioni controllare la sezione <a href="">Reclami</a>'.
        'Reclamo da '. $cliente->azienda
        .'</p>
        </body>
        </html>','Reclamo da '.$cliente->azienda); 
       return true;

        }else{
            return false;
        }
    }

    
    
}
?>