<?php
namespace app\components\manager;

use app\models\User;
use app\models\UserOrders;
use Yii;
use yii\db\Exception;


class TransferManager  {
    private $from, $to, $amount_from, $amount_to,$description;
    public $error='';

    public function __construct(User $from, User $to, $amount_from, $amount_to,$description) {
        $this->from = $from;
        $this->to = $to;
        $this->amount_from = -$amount_from;
        $this->amount_to = $amount_to;
        $this->description = $description;
    }

    public function transfer(){
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction('SERIALIZABLE');
        try {
            $this->changeBalanceFrom();
            $this->changeBalanceTo();

            $transaction->commit();
            return true;
        } catch (Exception $ex) {

        } catch (\Error $error) {

        }
        $transaction->rollback();
        return false;
    }

    public function changeBalanceFrom() {
        $this->from->refresh();
        if (($this->from->balance + $this->amount_from) > UserOrders::LIMIT) {
            $balance_before = $this->from->balance;
            $this->from->balance += $this->amount_from;
            if ($this->from->update()) {
                $this->addHistory($this->from->id, $this->amount_from, $balance_before, $this->to->id);
            } else {
                $this->error = 'Error update deposit from';
                throw new Exception($this->error);
            }
        } else {
            $this->error = 'Limit is exceeded';
            throw new Exception($this->error);
        }

    }

    public function changeBalanceTo() {
        $this->to->refresh();
        if ($this->amount_to > 0) {
            $balance_before = $this->to->balance;
            $this->to->balance += $this->amount_to;

            if ($this->to->update()) {
                $this->addHistory($this->to->id, $this->amount_to, $balance_before, $this->from->id);

            } else {
                $this->error = 'Error update deposit to';
                throw new Exception($this->error);
            }
        } else {
            $this->error ='Incorrect amount to';
            throw new Exception($this->error);
        }

    }

    public function addHistory($deposit_id, $amount, $balance_before, $second_deposit_id) {


        $history = new UserOrders();
        $history->amount = $amount;
        $history->balance_before = $balance_before;
        $history->from_id = $deposit_id;
        $history->to_id = $second_deposit_id;
        $history->time_create = time();
        $history->description = $this->description ." {{$amount}}";
        if ($history->save()) {
            return $history->id;
        } else {

            throw new Exception('Error deposit history #' . $deposit_id);
        }


    }

}