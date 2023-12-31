<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="dash_title"><span>FII & DII trading activity on <?= @$datas->date ? date('jS F Y (l)', @$datas->date) : '---'; ?></span></div>
                <div class="fill_dil_slider" data-slider='<?= @$result; ?>' data-cat='<?= @$cat; ?>'>
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>Stocks</span>
                                            <span class="fill_color <?= @$datas->stocks_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$datas->stocks_sentiment); ?></span>
                                        </div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">FII</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->stocks_fii > 0 ? 'green' : 'red'; ?>"><?= @$datas->stocks_fii ? Yii::$app->function->checkNumbervalues(@$datas->stocks_fii) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text ">DII</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->stocks_dii > 0 ? 'green' : 'red'; ?>"><?= @$datas->stocks_dii ? Yii::$app->function->checkNumbervalues(@$datas->stocks_dii) : '---'; ?></div>
                                                <a class="sub_text fii_dii_get_data active" data-type="stocks">(View history)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Futures</span>
                                            <span class="fill_color <?= @$datas->fif_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$datas->fif_sentiment); ?></span>
                                        </div>
                                        <?php if (@$datas->fif_value) { ?>
                                            <div class="fill_sub_title">(Net <?= Yii::$app->function->checkNumbervalues(@$datas->fif_value); ?>)</div>
                                        <?php } ?>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">NIFTY</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fif_nifty > 0 ? 'green' : 'red'; ?>"><?= @$datas->fif_nifty ? Yii::$app->function->checkNumbervalues(@$datas->fif_nifty) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">BANKNIFTY</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fif_banknifty > 0 ? 'green' : 'red'; ?>"><?= @$datas->fif_banknifty ? Yii::$app->function->checkNumbervalues(@$datas->fif_banknifty) : '---'; ?></div>
                                                  <a class="sub_text fii_dii_get_data" data-type="fif">(View history)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Futures OI</span>
                                            <span class="fill_color <?= @$datas->ffo_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$datas->ffo_sentiment); ?></span>
                                        </div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Change in Fut OI</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->ffo_full > 0 ? 'green' : 'red'; ?>"><?= @$datas->ffo_full ? Yii::$app->function->checkNumbervalues(@$datas->ffo_full) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Total Fut OI</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->ffo_fut > 0 ? 'green' : 'red'; ?>"><?= @$datas->ffo_fut ? Yii::$app->function->checkNumbervalues(@$datas->ffo_fut) : '---'; ?></div>
                                                 <a class="sub_text fii_dii_get_data" data-type="ffo">(View history)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Calls</span>
                                            <span class="fill_color <?= @$datas->ficc_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$datas->ficc_sentiment); ?></span>
                                        </div>
                                        <?php if (@$datas->ficc_value) { ?>
                                            <div class="fill_sub_title">(Net <?= Yii::$app->function->checkNumbervalues(@$datas->ficc_value); ?> Qty)</div>
                                        <?php } ?>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                                <div class="sub_text <?= @$datas->ficc_long_percentage > 0 ? 'green' : 'red'; ?>"><?= @$datas->ficc_long_percentage ? '(' . @$datas->ficc_long_percentage . '%)' : '---'; ?></div>

                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->ficc_long > 0 ? 'green' : 'red'; ?>"><?= @$datas->ficc_long ? Yii::$app->function->checkNumbervalues(@$datas->ficc_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Short OI Chg</div>
                                                <div class="sub_text <?= @$datas->ficc_short_percentage > 0 ? 'green' : 'red'; ?>"><?= @$datas->ficc_short_percentage ? '(' . @$datas->ficc_short_percentage . '%)' : 0; ?></div>

                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->ficc_short > 0 ? 'green' : 'red'; ?>"><?= @$datas->ficc_short ? Yii::$app->function->checkNumbervalues(@$datas->ficc_short)  : '----'; ?></div>
                                                  <a class="sub_text fii_dii_get_data" data-type="ficc">(View history)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Puts</span>
                                            <span class="fill_color <?= @$datas->fipc_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$datas->fipc_sentiment); ?></span>
                                        </div>
                                        <?php if (@$datas->fipc_value) { ?>
                                            <div class="fill_sub_title">(Net <?= Yii::$app->function->checkNumbervalues(@$datas->fipc_value); ?> Qty)</div>
                                        <?php } ?>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                                <div class="sub_text <?= @$datas->fipc_long_percentage > 0 ? 'green' : 'red'; ?>"><?= @$datas->fipc_long_percentage ? '(' . @$datas->fipc_long_percentage . '%)' : '---'; ?></div>

                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fipc_long > 0 ? 'green' : 'red'; ?>"><?= @$datas->fipc_long ? Yii::$app->function->checkNumbervalues(@$datas->fipc_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Short OI Chg</div>
                                                <div class="sub_text <?= @$datas->fipc_short_percentage > 0 ? 'green' : 'red'; ?>"><?= @$datas->fipc_short_percentage ?  '(' . @$datas->fipc_short_percentage . '%)' : '---'; ?></div>

                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fipc_short > 0 ? 'green' : 'red'; ?>"><?= @$datas->fipc_short ? Yii::$app->function->checkNumbervalues(@$datas->fipc_short) : '---'; ?></div>
                                                <a class="sub_text fii_dii_get_data" data-type="fipc">(View history)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Total Call OI</span>
                                            <span class="fill_color <?= @$datas->fic_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$datas->fic_sentiment); ?></span>
                                        </div>
                                        <?php if (@$datas->fic_value) { ?>
                                            <div class="fill_sub_title">(Net <?= Yii::$app->function->checkNumbervalues(@$datas->fic_value); ?> Qty)</div>
                                        <?php } ?>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fic_long > 0  ? 'green' : 'red'; ?>"><?= @$datas->fic_long ? Yii::$app->function->checkNumbervalues(@$datas->fic_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Short</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fic_short > 0 ? 'green' : 'red'; ?>"><?= @$datas->fic_short ? Yii::$app->function->checkNumbervalues(@$datas->fic_short) : '---'; ?></div>
                                               <a class="sub_text fii_dii_get_data" data-type="fic">(View history)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Total Put OI</span>
                                            <span class="fill_color <?= @$datas->fip_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$datas->fip_sentiment); ?></span>
                                        </div>
                                        <?php if (@$datas->fip_value) { ?>
                                            <div class="fill_sub_title">(Net <?= Yii::$app->function->checkNumbervalues(@$datas->fip_value); ?> Qty)</div>
                                        <?php } ?>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fip_long > 0 ? 'green' : 'red'; ?>"><?= @$datas->fip_long ? Yii::$app->function->checkNumbervalues(@$datas->fip_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Short</div>
                                                <div class="sub_text opacity_none">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= @$datas->fip_short > 0 ?  'green' : 'red'; ?>"><?= @$datas->fip_short ? Yii::$app->function->checkNumbervalues(@$datas->fip_short) : '----'; ?></div>
                                                  <a class="sub_text fii_dii_get_data" data-type="fip">(View history)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="fill_btn fill_btn_prev"></a>
                    <a class="fill_btn  fill_btn_next"></a>
                </div>
            </div>
            <div class="dash_sec_inner">
                <div class="dash_title"><span>View historical data</span>
                    <span class="dropdown_select">
                        <select class="historical_deropdown_select">
                            <?php 
                             echo '<option value="'.date("Y-m").'">'.date("M Y").'</option>';
                            for ($i = 1; $i <= 12; $i++) {
                                echo '<option value="'.date("Y-m", strtotime(date('Y-m-01' )." -$i months")).'">'.date("M Y", strtotime(date('Y-m-01' )." -$i months")).'</option>';
                            }
                            ?>
                        </select></span>
                </div>
                <div class="" id="historical_Data"></div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="dash_title">
                    <span>Past Activity</span>
                    <span class="dropdown_select">
                        <select>
                            <option>Jun 2023</option>
                            <option>July 2023</option>
                            <option>Aug 2023</option>
                            <option>Sep 2023</option>
                        </select>
                    </span>
                </div>
                <div class="dash_content">
                    <table class="fill_table_data display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Nifty</th>
                                <th>FII Call</th>
                                <th>FII Put</th>
                                <th>FII Future</th>
                                <th>FII Index Future OI</th>
                                <th>FII Index Future OI Chg</th>
                                <th>FII Cash</th>
                                <th>DII Cash</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($all_datas)) { ?>
                                <?php foreach ($all_datas as $k => $data) { ?>
                                    <tr>
                                        <td><span style="display:none;"><?= @$data->date; ?></span><?= date('j M Y', @$data->date); ?></td>
                                        <td><?= $data->common_nifty ? $data->common_nifty : '---' ?> <span class="green"></span></td>
                                        <td><span class="<?= $data->ficc_value > 0 ? 'green' : 'red' ?>"><?= $data->ficc_value ? Yii::$app->function->checkNumbervalues($data->ficc_value) : '---' ?></td>
                                        <td><span class="<?= $data->fipc_value > 0 ? 'green' : 'red' ?>"><?= $data->fipc_value ? Yii::$app->function->checkNumbervalues($data->fipc_value) : '---'  ?></td>
                                        <td><span class="<?= $data->fif_value > 0 ? 'green' : 'red' ?>"><?= @$data->fif_value ? Yii::$app->function->checkNumbervalues($data->fif_value) : '---' ?></span></td>
                                        <td><span class="<?= $data->ffo_full > 0 ? 'green' : 'red' ?>"><?= @$data->ffo_full ? Yii::$app->function->checkNumbervalues($data->ffo_full) : '---' ?></span></td>
                                        <td><span class="<?= $data->ffo_fut > 0 ? 'green' : 'red' ?>"><?= @$data->ffo_fut ? Yii::$app->function->checkNumbervalues($data->ffo_fut) : '---' ?></span></td>
                                        <td><span class="<?= $data->stocks_fii > 0 ? 'green' : 'red' ?>"><?= $data->stocks_fii ? Yii::$app->function->checkNumbervalues($data->stocks_fii) : '---'  ?></span></td>
                                        <td><span class="<?= $data->stocks_dii > 0 ? 'green' : 'red' ?>"><?= $data->stocks_dii ? Yii::$app->function->checkNumbervalues($data->stocks_dii) : '---'  ?></span></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="9">No data found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>