<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="dash_title"><span>FII & DII trading activity on <?= date('jS F Y (l)', $datas->date); ?></span></div>
                <div class="fill_dil_slider" data-slider='<?= $result; ?>' data-cat='<?= $cat; ?>'>
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>Stocks</span>
                                            <span class="fill_color <?= $datas->stocks_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst($datas->stocks_sentiment); ?></span>
                                        </div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">FII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->stocks_fii > 0 ? 'green' : 'red'; ?>"><?= $datas->stocks_fii ? Yii::$app->function->checkNumbervalues($datas->stocks_fii) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text ">DII</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->stocks_dii > 0 ? 'green' : 'red'; ?>"><?= $datas->stocks_dii ? Yii::$app->function->checkNumbervalues($datas->stocks_dii) : '---'; ?></div>
                                                <div class="sub_text" data-type="stocks">(View history)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Futures</span>
                                            <span class="fill_color <?= $datas->fif_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst($datas->stocks_sentiment); ?></span>
                                        </div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">NIFTY</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fif_nifty > 0 ? 'green' : 'red'; ?>"><?= $datas->fif_nifty ? Yii::$app->function->checkNumbervalues($datas->fif_nifty) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">BANKNIFTY</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fif_banknifty > 0 ? 'green' : 'red'; ?>"><?= $datas->fif_banknifty ? Yii::$app->function->checkNumbervalues($datas->fif_banknifty) : '---'; ?></div>
                                                <div class="sub_text">(View history)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Calls</span>
                                            <span class="fill_color <?= $datas->ficc_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst($datas->ficc_sentiment); ?></span>
                                        </div>
                                        <div class="fill_sub_title">(Net <?= $datas->ficc_value; ?> Qty)</div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                                <div class="sub_text <?= $datas->ficc_long_percentage > 0 ? 'green' : 'red'; ?>"><?= $datas->ficc_long_percentage ? '(' . $datas->ficc_long_percentage . '%)' : '---'; ?></div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->ficc_long > 0 ? 'green' : 'red'; ?>"><?= $datas->ficc_long ? Yii::$app->function->checkNumbervalues($datas->ficc_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                                <div class="sub_text <?= $datas->ficc_short_percentage > 0 ? 'green' : 'red'; ?>"><?= $datas->ficc_short_percentage ? '(' . $datas->ficc_short_percentage . '%)' : 0; ?></div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->ficc_short > 0 ? 'green' : 'red'; ?>"><?= $datas->ficc_short ? Yii::$app->function->checkNumbervalues($datas->ficc_short)  : '----'; ?></div>
                                                <div class="sub_text">(View history)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Puts</span>
                                            <span class="fill_color <?= $datas->fipc_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst($datas->fipc_sentiment); ?></span>
                                        </div>
                                        <div class="fill_sub_title">(Net <?= $datas->fipc_value; ?> Qty)</div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                                <div class="sub_text <?= $datas->fipc_long_percentage > 0 ? 'green' : 'red'; ?>"><?= $datas->fipc_long_percentage ? '(' . $datas->fipc_long_percentage . '%)' : '---'; ?></div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fipc_long > 0 ? 'green' : 'red'; ?>"><?= $datas->fipc_long ? Yii::$app->function->checkNumbervalues($datas->fipc_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                                <div class="sub_text <?= $datas->fipc_short_percentage > 0 ? 'green' : 'red'; ?>"><?= $datas->fipc_short_percentage ?  '(' . $datas->fipc_short_percentage . '%)' : '---'; ?></div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fipc_short > 0 ? 'green' : 'red'; ?>"><?= $datas->fipc_short ? Yii::$app->function->checkNumbervalues($datas->fipc_short) : '---'; ?></div>
                                                <div class="sub_text">(View history)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Calls</span>
                                            <span class="fill_color <?= $datas->fic_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst($datas->fic_sentiment); ?></span>
                                        </div>
                                        <div class="fill_sub_title">(Net <?= $datas->fic_value; ?> Qty)</div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>

                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fic_long > 0  ? 'green' : 'red'; ?>"><?= $datas->fic_long ? Yii::$app->function->checkNumbervalues($datas->fic_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fic_short > 0 ? 'green' : 'red'; ?>"><?= $datas->fic_short ? Yii::$app->function->checkNumbervalues($datas->fic_short) : '---'; ?></div>
                                                <div class="sub_text">(View history)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_col _col_5 swiper-slide">
                                <div class="fill_content content-equal-heights">
                                    <div class="fill_common_title">
                                        <div class="fill_title"><span>FII Index Puts</span>
                                            <span class="fill_color <?= $datas->fip_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst($datas->fip_sentiment); ?></span>
                                        </div>
                                        <div class="fill_sub_title">(Net <?= $datas->fip_value; ?> Qty)</div>
                                    </div>
                                    <div class="fill_list_content">
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>

                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fip_long > 0 ? 'green' : 'red'; ?>"><?= $datas->fip_long ? Yii::$app->function->checkNumbervalues($datas->fip_long) : '---'; ?></div>
                                            </div>
                                        </div>
                                        <div class="fill_list">
                                            <div class="fill_list_left">
                                                <div class="text">Long OI Chg</div>
                                            </div>
                                            <div class="fill_list_right">
                                                <div class="text <?= $datas->fip_short > 0 ?  'green' : 'red'; ?>"><?= $datas->fip_short ? Yii::$app->function->checkNumbervalues($datas->fip_short) : '----'; ?></div>
                                                <div class="sub_text">(View history)</div>
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
                        <select>
                            <option>Jun 2023</option>
                            <option>July 2023</option>
                            <option>Aug 2023</option>
                            <option>Sep 2023</option>
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
                <table class="custom_table_data display" style="width:100%">
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
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                        <tr>
                            <td>28 Jun 2023</td>
                            <td>18972.1 <span class="green">+0.82%</span></td>
                            <td>-69.7 K</td>
                            <td>-163.3 K</td>
                            <td><span class="red">-₹848 Cr</span></td>
                            <td><span class="green">+56.1 K</span></td>
                            <td><span class="green">+9.2 K</span></td>
                            <td><span class="green">+₹12,350 Cr</span></td>
                            <td><span class="red">+₹1,025 Cr</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>