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
}
