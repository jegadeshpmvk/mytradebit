<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class HeaderFooter extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%header-footer}}';
    }

    public function rules()
    {
        $rules = [
            [['copyrights'], 'required'],
            [['header_menu', 'footer_menu'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function beforeSave($insert) {
        $this->header_menu = json_encode($this->header_menu);
        return parent::beforeSave($insert);
    }

    public function afterFind() {
        $this->header_menu = json_decode($this->header_menu, true);
    }
}
