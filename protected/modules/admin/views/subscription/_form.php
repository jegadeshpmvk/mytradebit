<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
?>
<h1 class="page_title"><?php echo $model->isNewRecord ? "Create" : "Update"; ?> Subscription</h1>
<div class="model_form widgets">
    <h1 class="widgets_title">Subscription details</h1>
    <div class="widgets_content">
        <div class="_3_col_form form_widget_group">
            <?= $form->field($model, 'user_id', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>', 'options' => ['class' => 'form-group col']])->dropDownList(\app\models\Customer::listAsArray(), ['prompt' => 'Please select...']); ?>
            <div class="_2divs form_widget_group">
                <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'required' => 'required', 'maxlength' => 255]) ?>
                <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'required' => 'required', 'maxlength' => 255]) ?>
            </div>
        </div>
    </div>
</div>
<div class="options">
    <?= Html::submitButton('<span>Save</span>', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>