<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
<h1 class="p-tl"><?php echo $model->isNewRecord ? "Create" : "Update"; ?> Header & Footer</h1>
<div class="model-form widgets">
    <h1 class="widgets_title">Header Information</h1>

    <div class="widgets_content">
        <div class="form-group">
            <label class="control-label">Menu</label>
            <div class="repeater-wrap">
                <ol class="repeater _2cols" data-rel="header_menu">
                    <?php
                    if (isset($model->header_menu) && count($model->header_menu) > 0) {
                        foreach ($model->header_menu as $k => $dl) {
                            echo $this->render('@app/modules/admin/views/header-footer/template/header_menu', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $k,
                                'attribute' => "header_menu"
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
    </div>
</div>
<div class="model-form widgets">
    <h1 class="widgets_title">Footer Information</h1>
    <div class="widgets_content">
        <?= $form->field($model, 'text') ?>
        <?= $form->field($model, 'email') ?>
        <div class="form-group">
            <label class="control-label">Menu</label>
            <div class="repeater-wrap">
                <ol class="repeater _2cols" data-rel="footer_menu">
                    <?php
                    if (isset($model->footer_menu) && count($model->footer_menu) > 0) {
                        foreach ($model->footer_menu as $k => $dl) {
                            echo $this->render('@app/modules/admin/views/header-footer/template/footer_menu', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $k,
                                'attribute' => "footer_menu"
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
        <?= $form->field($model, 'copyrights') ?>
    </div>
</div>
<div class="model-form widgets">
    <h1 class="widgets_title">Social Media</h1>

    <div class="widgets_content">
        <div class="form-group">
            <div class="repeater-wrap">
                <ol class="repeater _2cols" data-rel="social_media">
                    <?php
                    if (isset($model->social_media) && count($model->social_media) > 0) {
                        foreach ($model->social_media as $k => $dl) {
                            echo $this->render('@app/modules/admin/views/header-footer/template/social_media', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $k,
                                'attribute' => "social_media"
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
    </div>
</div>
<div class="options">
    <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>
<?=
$this->render('@app/modules/admin/views/widgets/allPageArr', []);
?>
<div class="nifty_data"></div>
<div class="templates">
    <div data-for="footer_menu">
        <?=
        $this->render('@app/modules/admin/views/header-footer/template/footer_menu', [
            'model' => $model,
            'form' => $form,
            'key' => is_array($model->footer_menu) ? count($model->footer_menu) + 1 : 1,
            'attribute' => "footer_menu"
        ]);
        ?>
    </div>
    <div data-for="header_menu">
        <?=
        $this->render('@app/modules/admin/views/header-footer/template/header_menu', [
            'model' => $model,
            'form' => $form,
            'key' => is_array($model->header_menu) ? count($model->header_menu) + 1 : 1,
            'attribute' => "header_menu"
        ]);
        ?>
    </div>
    <div data-for="social_media">
        <?=
        $this->render('@app/modules/admin/views/header-footer/template/social_media', [
            'model' => $model,
            'form' => $form,
            'key' => $model->social_media ? count($model->social_media) + 1 : 1,
            'attribute' => "social_media"
        ]);
        ?>
    </div>

</div>