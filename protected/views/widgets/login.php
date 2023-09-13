<?php

use app\models\LoginForm;
use app\models\ChangePasswordFront;
use app\models\Customer;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;

$LoginForm = new LoginForm();
$CustomerForm = new Customer();
$ChangePasswordFront = new ChangePasswordFront();
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
                            <div class="form_group">
                                <?= $form->field(
                                    $LoginForm,
                                    'email',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['class' => 'form-control input email', 'maxlength' => 255])->label('Email/Mobile Number');
                                ?>
                            </div>
                            <div class="form_group">
                                <?= $form->field(
                                    $LoginForm,
                                    'password',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['type' => 'password', 'class' => 'form-control input password']);
                                ?>
                            </div>
                            <div class="form_group button_submit">
                                <?= Html::submitButton('<span>Login</span>', ['class' => 'btn btn_blue']) ?>
                            </div>
                            <div class="form_group">
                                <div class="or"><span>or</span></div>
                            </div>
                            <div class="form_group">
                                <a class="btn login_google"><i class="fa fa-google"></i><span>Login with Google</span></a>
                            </div>
                            <div class="form_group">
                                <p class="text align_center">New User! <a class="text_color_gradiant register_section">Create your account here</a></p>
                            </div>
                            <div class="form_group">
                                <p class="text align_center"><a class="forgot_text forgot_section">Forgot your password?</a></p>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="login_form_content form">
                            <h2 class="title text_color_gradiant align_center">Create an account</h2>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'contact-form-' . uniqid(),
                                'options' => [
                                    'class' => 'register_form',
                                    'data-redirect' => Url::to(['/dashboard']),
                                ],
                                'method' => 'post',
                                'action' => Url::to(['/register-form']),
                            ]);
                            ?>
                            <div class="form_group">
                                <?= $form->field(
                                    $CustomerForm,
                                    'fullname',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['class' => 'form-control input fullname', 'maxlength' => 255])->label('Full Name');
                                ?>
                            </div>
                            <div class="form_group">
                                <?= $form->field(
                                    $CustomerForm,
                                    'email',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['class' => 'form-control input email', 'maxlength' => 255])->label('Email');
                                ?>
                            </div>
                            <div class="form_group">
                                <?= $form->field(
                                    $CustomerForm,
                                    'mobile_number',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['class' => 'form-control input mobile_number', 'maxlength' => 255])->label('Mobile Number (WhatsApp No.)');
                                ?>
                            </div>
                            <div class="form_group">
                                <?= $form->field(
                                    $CustomerForm,
                                    'password',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['type' => 'password', 'class' => 'form-control input password', 'maxlength' => 255])->label('Enter Your Password');
                                ?>
                            </div>
                            <div class="form_group">
                                <?= $form->field(
                                    $CustomerForm,
                                    'password_repeat',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['type' => 'password', 'class' => 'form-control input password_repeat', 'maxlength' => 255])->label('Re-enter Your Password');
                                ?>
                            </div>
                            <div class="form_group button_submit">
                                <?= Html::submitButton('<span>Create Account</span>', ['class' => 'btn btn_blue']) ?>
                            </div>
                            <div class="form_group">
                                <a class="btn login_google"><i class="fa fa-google"></i><span>Sign up with Google</span></a>
                            </div>
                            <div class="form_group">
                                <p class="text align_center">Existing User! <a class="text_color_gradiant login_section">Login Here.</a></p>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="login_form_content form">
                            <h2 class="title text_color_gradiant align_center">Forgot Password</h2>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'contact-form-' . uniqid(),
                                'options' => [
                                    'class' => 'forgot_password'
                                ],
                                'method' => 'post',
                                'action' => Url::to(['/forgot-password']),
                            ]);
                            ?>
                            <div class="form_group" style="margin-top:50px;">
                                <?= $form->field(
                                    $ChangePasswordFront,
                                    'email',
                                    ['template' => '{label}{input}{error}']
                                )
                                    ->textInput(['class' => 'form-control input email', 'maxlength' => 255])->label('Email');
                                ?>
                            </div>
                            <div class="form_group button_submit">
                                <?= Html::submitButton('<span>Submit</span>', ['class' => 'btn btn_blue']) ?>
                            </div>
                            <div class="form_group">
                                <p class="text align_center">Existing User! <a class="text_color_gradiant login_section">Login Here.</a></p>
                            </div>
                            <div class="form_group">
                                <?= AuthChoice::widget([
                                    'baseAuthUrl' => ['site/auth'],
                                    'popupMode' => false,
                                ]) ?>
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