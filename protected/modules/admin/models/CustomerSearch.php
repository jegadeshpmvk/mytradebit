<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

class CustomerSearch extends Customer
{

    public function rules()
    {
        return [
            [['username', 'email'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Customer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => Yii::$app->admin->identity->getCookie('list_total')]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andWhere(['>=', 'deleted', 0]);

        $query->andFilterWhere([
            'deleted' => @trim($this->deleted) != "" ? (int) $this->deleted : $this->deleted
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
