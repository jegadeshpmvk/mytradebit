<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="_row">
                    <div class="_col _account_col">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'contact-form-' . uniqid(),
                            'options' => [
                                'class' => 'login_form',
                                'data-redirect' => Url::to(['/account-details']),
                            ],
                            'method' => 'post',
                            'action' => Url::to(['/update-profile/' . Yii::$app->user->identity->id]),
                        ]);
                        ?>
                        <div class="_row">
                            <div class="_col _account_col_first">
                                <div class="form-group">
                                    <?=
                                    $this->render('@app/widgets/fileuploadFront', [
                                        'name' => 'Customer-profileImg',
                                        'hidden' => 'Customer[profile_img]',
                                        'hidden_id' => 'Customer-profile_img',
                                        'existing' => $model->profileImage,
                                        'browse' => false,
                                        'text' => 'Profile pic'
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field(
                                        $model,
                                        'fullname',
                                        ['template' => '{label}{input}{error}']
                                    )
                                        ->textInput(['class' => 'form-control input email', 'maxlength' => 255])->label('Full Name');
                                    ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field(
                                        $model,
                                        'email',
                                        ['template' => '{label}{input}{error}']
                                    )
                                        ->textInput(['class' => 'form-control input email', 'maxlength' => 255])->label('Email');
                                    ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field(
                                        $model,
                                        'mobile_number',
                                        ['template' => '{label}{input}{error}']
                                    )
                                        ->textInput(['class' => 'form-control input email', 'maxlength' => 255])->label('Mobile Number (WhatsApp No.)');
                                    ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field($model, 'countryId', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>'])->dropDownList(\app\models\Country::listAsArray(), ['prompt' => 'Select Country...'])->label("Country"); ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field($model, 'stateId', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>'])->dropDownList(\app\models\State::listAsArray(), ['prompt' => 'Select State...'])->label("State"); ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field($model, 'cityId', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>'])->dropDownList(\app\models\City::listAsArray(), ['prompt' => 'Select City...'])->label("City"); ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field(
                                        $model,
                                        'current_plan',
                                        ['template' => '{label}{input}{error}']
                                    )
                                        ->textInput(['class' => 'form-control input email', 'maxlength' => 255])->label('Current Plan');
                                    ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field(
                                        $model,
                                        'plan_expires',
                                        ['template' => '{label}{input}{error}']
                                    )
                                        ->textInput(['type' => 'date', 'class' => 'form-control input email', 'maxlength' => 255])->label('Plan Expires on');
                                    ?>
                                </div>
                            </div>
                            <div class="_col _account_col_first">
                                <?= Html::submitButton('<span>Update</span>', ['class' => 'btn btn_blue']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>