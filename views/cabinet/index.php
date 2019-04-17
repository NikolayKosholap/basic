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
            'id',
            'description',
            'amount',
            'balance_before',
            [
                'label'=>'Balance after',
                'content'=>function($data){
                    return $data->balance_before+$data->amount;
                },
            ],
            'time_create:date',
        ],
    ]);
    ?>
</div>