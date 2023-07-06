<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class ExpiryDates extends ActiveRecord {

    public static function tableName() {
        return '{{%expiry-dates}}';
    }

    public function rules() {
        $rules = [
            [['date'], 'required']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

}
