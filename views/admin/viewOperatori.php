<?php
use yii\helpers\Html;
use app\models\User;
/** @var yii\web\View $this */
/** @var app\models\User[] $dipendenti */
?>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<h1 class="text-center">Stato dei miei ticket</h1>
<p class="text-center">Qui vedrai lo stato dei tuoi ticket</p>

<?php if (empty($dipendenti)): ?>
    <p class="text-center mt-4">Non hai ancora ticket aperti.</p>
<?php else: ?>

<table class="table table-bordered table-striped mt-4">
    <thead class="table-dark">
        <tr>
            <th>Dati anagrafici</th>
           <th>ruolo</th>
          
        </tr>
    </thead>

    <tbody>
       <?php foreach ($dipendenti as $dipendenti): 
   ?>
        <tr> 
          
               
                    <td><?= Html::encode($dipendenti->nome . ' '.$dipendenti->cognome); ?></td>
                    <td><?= Html::encode($dipendenti->ruolo); ?></td>
                    <td>
                        <?= Html::a('gestisci turni',[''],['class'=>'btn btn-primary']) ?>
                        <?= Html::a('',['']) ?>
                    </td>
                  

                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>
