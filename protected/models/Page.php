<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class Page extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%content}}';
    }

    public function rules()
    {
        $rules = [
            [['name', 'page'], 'required'],
            [['url'], 'unique'],
            [['snippet'], 'string', 'max' => 1000],
            [['name'], 'string', 'max' => 255],
            [['meta_tag'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function attributeLabels()
    {
        $attribute_labels = [
            'page' => 'Page',
            'name' => "Name"
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $attribute_labels);
    }

    public function beforeSave($insert)
    {
        $this->url = trim($this->url) != '' ? Yii::$app->function->seourl($this->url) : Yii::$app->function->seourl($this->name);
        return parent::beforeSave($insert);
    }
}
