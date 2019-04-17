<?php

/**
 * Created by PhpStorm.
 * User: nik0
 * Date: 16.04.2019
 * Time: 23:37
 */
namespace app\components;
use \Yii;

class PreController extends \yii\web\Controller {

    public $user;
    public function __construct($id, $module, $config = []) {
        parent::__construct($id, $module, $config);
        if (!Yii::$app->user->isGuest) {
            $this->user = Yii::$app->user->getIdentity();
        }
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['/site/login']);
                },

                'rules' => [

                    [
                        'allow' => !Yii::$app->user->isGuest,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}