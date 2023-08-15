<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="intra_title stocks_type_groups">
                    <label>
                        <input class="stocks_type" name="stocks_type" type="radio" checked value="">
                        <span class="pre_market_radio"></span> <span>NIFTY - <?= $nifty_live; ?></span>
                    </label>
                    <label>
                        <input class="stocks_type" name="stocks_type" type="radio" checked value="">
                        <span class="pre_market_radio"></span> <span>BANKNIFTY - <?= $bank_live; ?></span>
                    </label>
                    <div class="options_form_group">
                        <label>Trade Date</label>
                        <input type="date" name="trade_date" class="options_form_control" />
                    </div>
                    <div class="options_form_group">
                        <label>Expiry Date</label>
                        <input type="date" name="expiry_date" class="options_form_control" />
                    </div>
                    <div class="options_form_group">
                        <label>Start Time</label>
                        <input type="text" name="start_time" class="options_form_control" />
                    </div>
                    <div class="options_form_group">
                        <label>End Time</label>
                        <input type="text" name="end_time" class="options_form_control" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class=""></div>
                <div class="timings">
                    <label>
                        <input class="timing" name="stocks_type" type="radio" checked value="">
                        <span class="timing_button">Last 5 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="stocks_type" type="radio" value="">
                        <span class="timing_button">Last 10 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="stocks_type" type="radio" value="">
                        <span class="timing_button">Last 15 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="stocks_type" type="radio" value="">
                        <span class="timing_button">Last 30 mins</span>
                    </label>
                    <label>
                        <input class="timing" name="stocks_type" type="radio" value="">
                        <span class="timing_button">Last 1 Hrs</span>
                    </label>
                    <label>
                        <input class="timing" name="stocks_type" type="radio" value="">
                        <span class="timing_button">Last 2 Hrs</span>
                    </label>
                    <label>
                        <input class="timing" name="stocks_type" type="radio" value="">
                        <span class="timing_button">Last 3 Hrs</span>
                    </label>
                    <label>
                        <input class="timing" name="stocks_type" type="radio" value="">
                        <span class="timing_button">Full Day</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="intra_row">
                <div class="_col _option_scope">
                    <div class="dash_sec_inner">
                        <div class="intra_title">
                            <span class="">Options Scope <span title="test">(?)</span></span>
                        </div>
                        <div class="dash_content">
                            <table class="custom_table_data">
                                <thead>
                                    <tr>
                                        <th>Calls</th>
                                        <th>Strike</th>
                                        <th>Puts</th>
                                        <th>Level Analysis</th>
                                    </tr>
                                </thead>
                                <tbody class="pre_market_data">
                                    <?php
                                    if (!empty($nifty_less_data)) {
                                        foreach ($nifty_less_data as $k => $d) {
                                    ?>
                                            <tr>
                                                <td>Call Unwinding</td>
                                                <td><?= $d['strike_price']; ?></td>
                                                <td>Put Unwinding</td>
                                                <td>Strong Support</td>
                                            </tr>
                                    <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="_col _option_scope_center">
                    <div class="dash_sec_inner">
                        <div class="dash_content">
                            <div class="" id="net_OI"></div>
                            <div class="" id="OI_change"></div>
                        </div>
                    </div>
                </div>
                <div class="_col _option_scope_last">
                    <div class="dash_sec_inner">
                        <div class="dash_content">
                            <div id="canvas-holder" style="width:100%">
                                <div class="intra_title">
                                    <span class="">Options Sentiment <span title="test">(?)</span></span>
                                </div>
                                <canvas id="gaugeChart" width="500px" height="175px"></canvas>
                            </div>
                            <div class="gaugeChart_content">
                                <div class="gauge_title">Sentiment Meter</div>
                                <div class="gauge_contnet">
                                    <div class=""><span class="title">Max Call</span><span>18800 CE</span></div>
                                    <div class=""><span class="title">Max Call</span><span>18800 CE</span></div>
                                    <div class=""><span class="title">Max Call</span><span>18800 CE</span></div>
                                    <div class=""><span class="title">Max Call</span><span>18800 CE</span></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="dash_content">
                    <div class="" id="total_open"></div>
                    <div class="total_text_view">
                        <div class="total_text_left">
                            <span>TOTAL OI View</span> <span>BULLISH</span>
                        </div>
                        <div class="total_text_right">
                            <div class="">
                                <span>TOTAL CE OI</span> <span>27,85,369</span>
                            </div>
                            <div class="">
                                <span>TOTAL PE OI</span> <span>27,85,369</span>
                            </div>
                            <div class="">
                                <span>Total PCR</span> <span>27,85,369</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>