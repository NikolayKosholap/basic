<?php

namespace app\models;


use yii\base\Model;

/**
 * Class OrderForm
 * @package app\models
 * @property double $amount
 * @property string $receiver
 * @property User $owner
 */

class OrderForm extends Model {

    public $owner;
    public $amount;
    public $receiver;

    public function rules()
    {
        return [
            [['receiver', 'amount'], 'required'],
            [['amount'], 'number'],
            [['receiver'], 'validateSendTo'],
            [['amount'], 'validateAmount'],
        ];
    }

    public function validateSendTo($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $user = User::findByUsername($this->receiver);
            if (!$user) {
                $this->addError($attribute, 'User not found');
            }else{
                if($this->owner->id == $user->id) {
                    $this->addError($attribute, 'You can`t transfer money for yourself');
                }
            }
        }
    }

    public function validateAmount($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->amount > 0) {
                if(!preg_match('/^\d+(?:\.\d{1,2})?$/',$this->amount)){
                    $this->addError($attribute, 'Incorrect amount (Example: 1.01)');
                }else{
                    if(UserOrders::LIMIT > ($this->owner->balance - $this->amount)){
                        $this->addError($attribute, 'Not enough on balance');
                    }
                }
            }else{
                $this->addError($attribute, 'Incorrect amount');
            }
        }
    }

}