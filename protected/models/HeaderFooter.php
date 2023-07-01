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
            [['header_menu', 'footer_menu', 'text', 'email', 'social_media'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function beforeSave($insert)
    {
        $this->header_menu = json_encode($this->header_menu);
        $this->footer_menu = json_encode($this->footer_menu);
        $this->social_media = json_encode($this->social_media);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->header_menu = json_decode($this->header_menu, true);
        $this->footer_menu = json_decode($this->footer_menu, true);
        $this->social_media = json_decode($this->social_media, true);
    }

    public function getSocial()
    {
        return [
            "fa fa-facebook" => "Facebook",
            "fa fa-twitter" => "Twitter",
            "fa fa-instagram" => "Instagram",
            "fa fa-linkedin" => "Linkedin",
            "fa fa-youtube" => "Youtube",
            "fa fa-telegram"  => "Telegram"
        ];
    }
}
