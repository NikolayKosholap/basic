<?php
/**
 * Created by PhpStorm.
 * User: nik0
 * Date: 16.04.2019
 * Time: 23:35
 */

namespace app\controllers;


use app\components\manager\TransferManager;
use app\models\OrderForm;
use app\models\User;
use \Yii;
use app\components\PreController;;

class TransferController extends  PreController {

    public function actionTransfer(){
        $model = new OrderForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->owner = User::findOne(['id'=>Yii::$app->user->id]);
            if($model->validate()){
                $to_id = User::findByUsername($model->receiver);
                $transafer = new TransferManager($model->owner,$to_id, $model->amount, $model->amount,'Transafer from '.$model->owner->username.' to '.$to_id->username.' ');
                if($transafer->transfer()){
                    Yii::$app->session->setFlash('success','success');
                }else{
                    Yii::$app->session->setFlash('error','error');
                }
                return $this->redirect('/cabinet/index');

            }

        }

        return $this->render('transfer', [
            'model' => $model,
        ]);
    }

}