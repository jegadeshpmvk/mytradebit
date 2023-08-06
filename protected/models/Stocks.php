<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Stocks extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%stocks}}';
    }

    public function rules()
    {
        $rules = [
            [['name', 'market_cap'], 'required'],
            [['sector', 'company_name', 'types'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function attributeLabels()
    {
        $labels = [
            'Name' => 'Name'
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }
}
