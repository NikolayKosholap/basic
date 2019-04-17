<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderForm */
/* @var $form ActiveForm */
?>
<div class="transfer-index">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'receiver') ?>
    <?= $form->field($model, 'amount') ?>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- transfer-index -->
