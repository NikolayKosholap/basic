<?php
/**
 * @var $user \app\models\User
 */
?>
<div class="site-index">
    <div class="row">
        <div class="col-sm-6">
            <h3>User <?=$user->username?></h3>
        </div>
        <div class="col-sm-6">
            <h3 style="text-align: right;">Balance: <?=$user->balance?></h3>
        </div>
    </div>
    <br>
    <?php
    echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'description',
            'amount',
//            'balance',
            'time_create:date',
        ],
    ]);
    ?>
</div>