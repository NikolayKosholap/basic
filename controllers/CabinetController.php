<?php
/**
 * Created by PhpStorm.
 * User: nik0
 * Date: 17.04.2019
 * Time: 20:17
 */

namespace app\controllers;


use app\components\PreController;
use app\models\User;
use app\models\UserOrders;
use Yii;
use yii\data\ActiveDataProvider;


class CabinetController extends PreController
{
    public function actionIndex(){
        $user = User::findById(Yii::$app->user->id);
        $dataProvider = new ActiveDataProvider([
            'query' => UserOrders::find()->where(['from_id'=>$user->id]),
            'sort' => ['defaultOrder'=>['id'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

}