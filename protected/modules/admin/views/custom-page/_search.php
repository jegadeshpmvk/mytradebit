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
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, "deleted")->dropDownList(["" => "Select Deleted Status", 1 => "Yes", 0 => "No"]) ?>

    <div class="form-group actions">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
