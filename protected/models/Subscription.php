<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Subscription extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%subscription}}';
    }

    public function rules()
    {
        $rules = [
            [['user_id', 'start_date', 'end_date'], 'required']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function getUser()
    {
        return $this->hasOne(Customer::className(), ['id' => 'user_id']);
    }
}
