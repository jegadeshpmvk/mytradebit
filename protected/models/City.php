<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class City extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%city}}';
    }

    public function rules()
    {
        $rules = [
            [['city_name', 'countryId', 'stateId'], 'required']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function attributeLabels()
    {
        $labels = [
            'city_name' => 'Name'
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    public static function listAsArray()
    {
        $options = [];
        $list = self::find()->active()->all();

        foreach ($list as $l) {
            $id = (string) $l->id;
            $options[$id] = $l->city_name;
        }

        return $options;
    }
}
