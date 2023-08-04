<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Webhook extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%webhook}}';
    }

    public function rules()
    {
        $rules = [
            [['stocks', 'trigger_prices'], 'required'],
            [['triggered_at', 'scan_name', 'scan_url', 'alert_name', 'webhook_url'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function attributeLabels()
    {
        $labels = [
            'Stocks' => 'stocks'
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }
}
