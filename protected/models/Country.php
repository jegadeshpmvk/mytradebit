<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Country extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%country}}';
    }

    public function rules()
    {
        $rules = [
            [['name'], 'required'],
             [['iso'], 'safe']
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

    public static function listAsArray()
    {
        $options = [];
        $list = self::find()->active()->all();

        foreach ($list as $l) {
            $id = (string) $l->id;
            $options[$id] = $l->name;
        }

        return $options;
    }
}
