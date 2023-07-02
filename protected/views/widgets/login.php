<?php

use app\models\LoginForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$LoginForm = new LoginForm();
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
                <div class="forms">
                    <div class="login_form_content form">
                        <h2 class="title text_color_gradiant align_center">Login</h2>
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'contact-form-' . uniqid(),
                            'options' => [
                                'class' => 'login_form',
                                'data-redirect' => Url::to(['/dashboard']),
                            ],
                            'method' => 'post',
                            'action' => Url::to(['/login-form']),
                        ]);
                        ?>
                        <div class="server_error"></div>
                        <div class="form_group">
                            <?= $form->field(
                                $LoginForm,
                                'email',
                                ['template' => '{label}{input}{error}']
                            )
                                ->textInput(['class' => 'form-control input', 'maxlength' => 255])->label('Email/Mobile Number');
                            ?>
                        </div>
                        <div class="form_group">
                            <?= $form->field(
                                $LoginForm,
                                'password',
                                ['template' => '{label}{input}{error}']
                            )
                                ->textInput(['type' => 'password', 'class' => 'form-control input']);
                            ?>
                        </div>
                        <div class="form_group login_button_submit">
                            <?= Html::submitButton('<span>Login</span>', ['class' => 'btn btn_blue']) ?>
                        </div>
                        <div class="form_group">
                            <div class="or"><span>or</span></div>
                        </div>
                        <div class="form_group">
                            <a class="btn login_google"><i class="fa fa-google"></i><span>Login with Google</span></a>
                        </div>
                        <div class="form_group">
                            <p class="text align_center">New User! <a class="text_color_gradiant">Create your account here</a></p>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>