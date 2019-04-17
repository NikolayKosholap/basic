<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_orders".
 *
 * @property int $id
 * @property int $from_id
 * @property int $to_id
 * @property double $amount
 * @property double $balance_before
 * @property int $time_create
 * @property string $description
 *
 * @property User $from
 * @property User $to
 */
class UserOrders extends \yii\db\ActiveRecord
{
    const LIMIT = -1000;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id', 'time_create'], 'integer'],
            [['amount', 'balance_before'], 'number'],
            [['description'], 'string','max'=>100],
            [['from_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_id' => 'id']],
            [['to_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
            'amount' => 'Amount',
            'balance_before' => 'Balance Before',
            'time_create' => 'Time create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_id']);
    }
}
