<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class FiiDii extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%fii-dii}}';
    }

    public function rules()
    {
        $rules = [
            [['date', 'stocks_sentiment', 'common_nifty', 'common_banknifty', 'fif_sentiment', 'ficc_sentiment',  'fipc_sentiment', 'fic_sentiment',  'fip_sentiment'], 'required'],
            [[
                'stocks_fii', 'stocks_fii_color',  'stocks_dii', 'stocks_dii_Color',
                'fif_nifty', 'fif_value', 'fif_nifty_color', 'fif_banknifty', 'fif_banknifty_color',
                'ficc_value', 'ficc_long', 'ficc_long_color', 'ficc_long_percentage', 'ficc_long_percentage_color', 'ficc_short', 'ficc_short_color', 'ficc_short_percentage', 'ficc_short_percentage_color',
                'fipc_value', 'fipc_long', 'fipc_long_color', 'fipc_long_percentage', 'fipc_long_percentage_color', 'fipc_short', 'fipc_short_color', 'fipc_short_percentage', 'fipc_short_percentage_color',
                'fic_value', 'fic_long', 'fic_long_color', 'fic_short', 'fic_short_color',
                'fip_value', 'fip_long', 'fip_long_color',  'fip_short', 'fip_short_color',
            ], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }
}
