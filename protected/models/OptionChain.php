<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class OptionChain extends ActiveRecord {

    public static function tableName() {
        return '{{%option-chain}}';
    }

    public function rules() {
        $rules = [
            [['type', 'strike_price','expiry_date'], 'required'],
            [['ce_ltp', 'ce_oi', 'pe_oi', 'pe_ltp'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

}
