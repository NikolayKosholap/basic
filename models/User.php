<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property double $balance
 *
 * @property UserOrders[] $userOrders
 * @property UserOrders[] $userOrders0
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['balance'], 'number'],
            [['username'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'balance' => 'Balance',
        ];
    }
    public static function getUserByUsername($username){
        $user = self::find()->where(['username'=>$username])->one();
        if(!$user){
            $user = new self();
            $user->username =$username;
            $user->balance=0;
            if(!$user->save()){
                return false;
            }
        }
        return $user;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOrders()
    {
        return $this->hasMany(UserOrders::className(), ['from_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOrders0()
    {
        return $this->hasMany(UserOrders::className(), ['to_id' => 'id']);
    }


    public static function findIdentity($id)
    {
        return self::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['accessToken'=>$token]);
    }
    public static function findByUsername($username)
    {
        return self::findOne(['username'=>$username]);
    }

    public static function findById($id)
    {
        return self::findOne(['id'=>$id]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    public function getUsername()
    {
        return $this->username;
    }


}
