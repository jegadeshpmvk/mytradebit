<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class GlobalSentiments extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%global-sentiments}}';
    }

    public function rules()
    {
        $rules = [
             [['logoUrl', 'name', 'tsInMillis', 'close', 'value', 'dayChange', 'dayChangePerc'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }
}
