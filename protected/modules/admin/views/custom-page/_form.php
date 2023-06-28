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
    <h1 class="widgets_title">Page Attributes</h1>
    <div class="widgets_content">
        <?= $form->field($model, 'name') ?>

        <div class="form-group field-custompage-parent_page">
            <label class="control-label" for="custompage-parent_page">Parent Page</label>
            <div class="flexible-default-dropdown">
                <select id="custompage-parent_page" class="form-control" name="CustomPage[parent_page]">
                    <option value="">Please Select...</option>
                    <?php foreach ($model->parentPageAll as $id => $option) { ?>
                        <option value="<?= (string) $id ?>" <?= $model->parent_page == $id ? ' selected' : '' ?> ><?= $option ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="help-block"></div>
        </div>

        <?= $form->field($model, 'url', ['errorOptions' => ['encode' => false, 'class' => 'help-block'], 'template' => '{label}<div>{input}</div>{error}'])->label("Slug (Leave it blank to autogenerate...)"); ?>
    </div>

</div>

<div class="model-form widgets">
    <h1 class="widgets_title">Widgets</h1>
    <div class="widgets_content">
        <div class="widgets_content_title">Content</div>
        <?php
        if (!is_array($model->content_widgets)) {
            $model->content_widgets = [];
        }
        echo $this->render('@app/modules/admin/views/widgets/populate', [
            'form' => $form,
            'model' => $model,
            'attribute' => 'content_widgets'
        ]);
        ?>
    </div>
</div>

<?php
echo $this->render('@app/modules/admin/views/widgets/metatag', [
    'form' => $form,
    'model' => $model,
    'attribute' => 'meta_tag'
]);
?>

<div class="options">
    <a class="fa fa-info" data-scroll=".seo-section">
        <span>Meta Tags</span>
    </a>
    <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>
<?=
$this->render('@app/modules/admin/views/widgets/allPageArr', []);
?>

<?=
$this->render('@app/modules/admin/views/widgets/templates', [
    'form' => $form,
    'model' => new \app\models\CustomPage(),
    'key' => count($model->content_widgets),
    'attribute' => 'content_widgets'
]);
?>