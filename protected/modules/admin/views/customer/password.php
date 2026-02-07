<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
?>

<div class="model_form widgets">
    <h1 class="widgets_title">Change Password for <?= $model->fullname; ?></h1>
    <div class="widgets_content">
        <div class="_2_col_form form_widget_group">
            <?= $form->field($model, 'password')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'password_repeat')->textInput(['maxlength' => 255]) ?>
        </div>
    </div>
</div>
<div class="options">
    <?= Html::submitButton('<span>Save</span>', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>