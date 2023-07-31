<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss('
.select2-container {
 width: 100% !important;
}
');
?>

<?php $form = ActiveForm::begin(); ?>
<h1 class="p-tl"><?php echo $model->isNewRecord ? "Create" : "Update"; ?> Page</h1>
<div class="model-form widgets">
    <h1 class="widgets_title">Data Attributes</h1>
    <div class="widgets_content">
        <?=
        $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
            'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
            'dateFormat' => 'php:d/m/Y',
            'class' => 'form-control',
        ])->label('Date');
        ?>
        <div class="_2divs">
            <?= $form->field($model, 'common_nifty')->textInput()->label('Nifty'); ?>
            <?= $form->field($model, 'common_banknifty')->textInput()->label('BankNifty'); ?>
        </div>
    </div>
</div>

<div class="model-form widgets">
    <h1 class="widgets_title">Stock</h1>
    <div class="widgets_content">
        <div class="form-group radio_button">
            <label class="control-label">Sentiment</label>
            <?=
            $this->render('@app/widgets/radio-list', [
                'form' => $form,
                'model' => $model,
                'field' => 'stocks_sentiment',
                'list' => (['bullish' => 'Bullish', 'bearish' => 'Bearish'])
            ]);
            ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'stocks_fii')->textInput()->label('Fii'); ?>
            <?= $form->field($model, 'stocks_dii')->textInput()->label('Dii'); ?>
        </div>
    </div>
</div>

<div class="model-form widgets">
    <h1 class="widgets_title">FII Index Futures</h1>
    <div class="widgets_content">
        <div class="_2divs">
            <div class="form-group radio_button">

                <label class="control-label">Sentiment</label>
                <?=
                $this->render('@app/widgets/radio-list', [
                    'form' => $form,
                    'model' => $model,
                    'field' => 'fif_sentiment',
                    'list' => (['bullish' => 'Bullish', 'bearish' => 'Bearish'])
                ]);
                ?>
            </div>
            <?= $form->field($model, 'fif_value')->textInput()->label('Value'); ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'fif_nifty')->textInput()->label('Nifty'); ?>
            <?= $form->field($model, 'fif_banknifty')->textInput()->label('BankNifty'); ?>
        </div>
    </div>
</div>

<div class="model-form widgets">
    <h1 class="widgets_title">FII Index Calls (Change)</h1>
    <div class="widgets_content">
        <div class="_2divs">
            <div class="form-group radio_button">
                <label class="control-label">Sentiment</label>
                <?=
                $this->render('@app/widgets/radio-list', [
                    'form' => $form,
                    'model' => $model,
                    'field' => 'ficc_sentiment',
                    'list' => (['bullish' => 'Bullish', 'bearish' => 'Bearish'])
                ]);
                ?>
            </div>
            <?= $form->field($model, 'ficc_value')->textInput()->label('Value'); ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'ficc_long')->textInput()->label('Long'); ?>
            <?= $form->field($model, 'ficc_long_percentage')->textInput()->label('Percentage'); ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'ficc_short')->textInput()->label('Short'); ?>
            <?= $form->field($model, 'ficc_short_percentage')->textInput()->label('Percentage'); ?>
        </div>
    </div>
</div>

<div class="model-form widgets">
    <h1 class="widgets_title">FII Index Puts (Change)</h1>
    <div class="widgets_content">
        <div class="_2divs">
            <div class="form-group radio_button">
                <label class="control-label">Sentiment</label>
                <?=
                $this->render('@app/widgets/radio-list', [
                    'form' => $form,
                    'model' => $model,
                    'field' => 'fipc_sentiment',
                    'list' => (['bullish' => 'Bullish', 'bearish' => 'Bearish'])
                ]);
                ?>
            </div>
            <?= $form->field($model, 'fipc_value')->textInput()->label('Value'); ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'fipc_long')->textInput()->label('Long'); ?>
            <?= $form->field($model, 'fipc_long_percentage')->textInput()->label('Percentage'); ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'fipc_short')->textInput()->label('Short'); ?>
            <?= $form->field($model, 'fipc_short_percentage')->textInput()->label('Percentage'); ?>
        </div>
    </div>

    <div class="model-form widgets">
        <h1 class="widgets_title">FII Index Calls</h1>
        <div class="widgets_content">
            <div class="_2divs">
                <div class="form-group radio_button">
                    <label class="control-label">Sentiment</label>
                    <?=
                    $this->render('@app/widgets/radio-list', [
                        'form' => $form,
                        'model' => $model,
                        'field' => 'fic_sentiment',
                        'list' => (['bullish' => 'Bullish', 'bearish' => 'Bearish'])
                    ]);
                    ?>
                </div>
                <?= $form->field($model, 'fic_value')->textInput()->label('Value'); ?>
            </div>
            <div class="_2divs">
                <?= $form->field($model, 'fic_long')->textInput()->label('Long'); ?>
                <?= $form->field($model, 'fic_short')->textInput()->label('Short'); ?>
            </div>
        </div>
    </div>

    <div class="model-form widgets">
        <h1 class="widgets_title">FII Index Puts</h1>
        <div class="widgets_content">
            <div class="_2divs">
                <div class="form-group radio_button">
                    <label class="control-label">Sentiment</label>
                    <?=
                    $this->render('@app/widgets/radio-list', [
                        'form' => $form,
                        'model' => $model,
                        'field' => 'fip_sentiment',
                        'list' => (['bullish' => 'Bullish', 'bearish' => 'Bearish'])
                    ]);
                    ?>
                </div>
                <?= $form->field($model, 'fip_value')->textInput()->label('Value'); ?>
            </div>
            <div class="_2divs">
                <?= $form->field($model, 'fip_long')->textInput()->label('Long'); ?>
                <?= $form->field($model, 'fip_short')->textInput()->label('Short'); ?>
            </div>
        </div>
    </div>

    <div class="options">
        <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>