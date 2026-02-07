<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="login sec_pad" id="login">
    <div class="c">
        <div class="_row">
            <div class="_col _login_left vAlign_middle">
                <?php
                $image = \app\models\Media::find()->where(['id' => isset($data['content']["image_id"]) ? $data['content']["image_id"] : 0])->one();
                echo '<div class="banner_image">' . Yii::$app->file->asBackground($image, '1920x1000') . '</div>';
                ?>
            </div>
            <div class="_col _login_right vAlign_middle">
                <div class="forms_overflow">
                    <div class="forms">
                        <div class="login_form_content form">
                            <h2 class="title text_color_gradiant align_center">Reset Password</h2>
                            <?php
                            $id = Yii::$app->request->get('id');

                            $form = ActiveForm::begin([
                                'id' => 'contact-form-' . uniqid(),
                                'options' => [
                                    'class' => 'reset_form',
                                    'data-redirect' => Url::to(['/login']),
                                ],
                                'method' => 'post',
                                'action' => Url::to(['/reset-password?id=' . $id]),
                            ]);
                            ?>
                            <div class="form_group">
                                <?= $form->field(
                                    $model,
                                    'password',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['type' => 'password', 'class' => 'form-control input password', 'maxlength' => 255])->label('Password');
                                ?>
                            </div>
                            <div class="form_group">
                                <?= $form->field(
                                    $model,
                                    'password_repeat',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['type' => 'password', 'class' => 'form-control input password']);
                                ?>
                            </div>
                            <div class="form_group button_submit">
                                <?= Html::submitButton('<span>Submit</span>', ['class' => 'btn btn_blue']) ?>
                            </div>
                            <div class="form_group">
                                <div class="or"><span>or</span></div>
                            </div>
                            <div class="form_group">
                                <p class="text align_center">New User! <a class="text_color_gradiant register_section">Create your account here</a></p>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>