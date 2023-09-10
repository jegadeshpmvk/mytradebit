<div class="dashboard futures_board">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="intra_title stocks_type_groups">
                    <label>
                        <input class="options_board_change" name="future_stocks_type" type="radio" checked value="nifty" data-value="<?= $nifty_live; ?>">
                        <span class="pre_market_radio"></span> <span>NIFTY - <?= $nifty_live; ?></span>
                    </label>
                    <label>
                        <input class="options_board_change" name="future_stocks_type" type="radio" value="nifty-bank"data-value="<?= $bank_live; ?>">
                        <span class="pre_market_radio"></span> <span>BANKNIFTY - <?= $bank_live; ?></span>
                    </label>
                    <div class="options_form_group">
                        <label>Trade Date</label>
                        <div class="custom_date_picker">
                            <input type="text" name="future_trade_date" value="<?= $date; ?>" max="<?= $date; ?>"  readonly="readonly" class="trade_date_datepicker options_form_control options_board_change" />
                        </div>
                    </div>
                    <div class="options_form_group">
                        <label>Expiry Date</label>
                        <div class="custom_date_picker <?= date('D'); ?>">
                            <input type="text" name="future_expiry_date" value="<?= !empty($dates) ? date('Y-m-d',strtotime($dates[0])) : (date('D') !== 'Thu' ? date('Y-m-d', strtotime('next thursday')) : date('Y-m-d')); ?>"  readonly="readonly" data-expirydate='<?= json_encode($dates); ?>' class="expiry_date_datepicker options_form_control options_board_change" />
                        </div>
                    </div>
                    <div class="options_form_group">
                        <label>Time Period</label>
                        <div class="">
                            <select name="future_minutes"  class="expiry_date_datepicker options_form_control options_board_change">
                                <option value="5" selected>5 Minutes</option>
                                <option value="10">10 Minutes</option>
                                 <option value="15">15 Minutes</option>
                                  <option value="20">20 Minutes</option>
                                     <option value="30">30 Minutes</option>
                            </select>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="dash_content futures_board_data">
                    
                </div>
            </div>
        </div>
    </div>
</div>