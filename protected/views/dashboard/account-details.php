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
                                    <?= $form->field($model, 'countryId', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>'])->dropDownList(\app\models\Country::listAsArray(), ['prompt' => 'Select Country...', 'data-attr' => $model->countryId])->label("Country"); ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field($model, 'stateId', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>'])->dropDownList([], ['prompt' => 'Select State...','data-attr' => $model->stateId])->label("State"); ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <?= $form->field($model, 'cityId', ['template' => '{label}<div class="p_relative dd_arrow">{input}{error}</div>'])->dropDownList([], ['prompt' => 'Select City...','data-attr' => $model->cityId])->label("City"); ?>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                      <div class="form-group field-customer-plan_expires">
                                            <label class="control-label" for="customer-plan_expires">Current Plan</label>
                                        <div class="control-label-text"><?= $plan->amount ?  Yii::$app->formatter->asCurrency($plan->amount) : '---'?></div>
                                        </div>
                                </div>
                            </div>
                            <div class="_col _col_3">
                                <div class="acc_form_group">
                                    <div class="acc_form_group">
                                        <div class="form-group field-customer-plan_expires">
                                            <label class="control-label" for="customer-plan_expires">Plan Expires on</label>
                                        <div class="control-label-text"><?= $plan->end_date ?  date('d-m-Y', $plan->end_date) : '---'?></div>
                                        </div>
                                    </div>
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
            <div class="dash_sec_inner">
                <h5 class="transaction_history">Transaction History</h5>
                <table class="custom_table custom_table_data">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Transaction ID</th>
                            <th>Transaction Date</th>
                            <th>Amount</th>
                            <th>Plan Start Date</th>
                            <th>Plan End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (!empty($plans)) {
                                foreach ($plans as $k => $plan) {
                                    echo '<tr>';
                                    echo '<td>'.(int) ($k + 1).'</td>';
                                     echo '<td>'.$plan->merchant_order_id.'</td>';
                                      echo '<td>'.date('d-m-Y', $plan->created_at).'</td>';
                                    echo '<td>'.($plan->amount ? Yii::$app->formatter->asCurrency($plan->amount, 'INR') : "---").'</td>';
                                    echo '<td>'.date('d-m-Y', $plan->start_date).'</td>';
                                    echo '<td>'.date('d-m-Y', $plan->end_date).'</td>';
                                    echo '<td>'.$plan->status.'</td>';
                                    echo '</tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
