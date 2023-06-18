<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">Banner</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'banner'])->label(false) ?>
        <?= $form->field($model, $keyprefix . '[content][size]')->dropDownList(['big-banner' => 'Big', 'small-banner' => 'Small'])->label("Size") ?>
        
    </div> 
    <?= $this->render('@app/widgets/flexible-options', ['attribute' => $attribute, 'key' => $key]); ?>
</div>