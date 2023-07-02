<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Customer extends User
{

    public function init()
    {
        $this->type = self::TYPE_CUSTOMER;
    }

    public static function find()
    {
        $find = parent::find();
        return $find->andWhere(['type' => self::TYPE_CUSTOMER]);
    }

    public function rules()
    {
        $rules = [
            [['fullname', 'mobile_number'], 'required']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }  

    public function attributeLabels()
    {
        $labels = [
            'fullname' => 'Full Name'
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }
}
