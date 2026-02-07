<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Subscription;

class SubscriptionSearch extends Subscription
{

    public function rules()
    {
        return [
            [['user_id'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Subscription::find();

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

        $query->andFilterWhere(['like', 'user_id', $this->user_id]);

        return $dataProvider;
    }
}
