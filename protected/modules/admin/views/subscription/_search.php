<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="search-form">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>
    <?= $form->field($model, 'user_id', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>', 'options' => ['class' => 'form-group col']])->dropDownList(\app\models\Customer::listAsArray(), ['prompt' => 'Please select...']); ?>


    <div class="form-group actions">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>