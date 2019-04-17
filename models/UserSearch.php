<?php
/**
 * Created by PhpStorm.
 * User: nik0
 * Date: 16.04.2019
 * Time: 23:56
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class UserSearch extends User {

    public function rules()
    {
        return [
            [['balance'], 'number'],
            [['username'], 'string'],
        ];
    }
    public function search($params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>['id'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'balance', $this->balance]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        return $dataProvider;
    }
}