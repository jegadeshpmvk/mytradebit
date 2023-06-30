<?php
$prefix = $attribute . '[' . $key . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <?= $form->field($model, $prefix . "[name]")->textInput(['required' => 'required'])->label('Name') ?>
        <?= $form->field($model, $prefix . '[link]', ['template' => '{label}<div class="select2-wrapper">{input}</div>{error}'])->dropDownList([], ['class' => 'select2-dropdown-links', 'data-value' => @$model->{$attribute}[$key]['link']])->label("Link") ?>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>