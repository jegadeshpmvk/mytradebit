<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class PreMarketData extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%pre_market_data}}';
    }

    public function rules()
    {
        $rules = [
             [['open', 'previousClose', 'percentChange'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }
}
