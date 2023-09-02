<div class="dashboard futures_board">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="intra_title stocks_type_groups">
                    <label>
                        <input class="options_board_change" name="stocks_type" type="radio" checked value="nifty" data-value="<?= $nifty_live; ?>">
                        <span class="pre_market_radio"></span> <span>NIFTY - <?= $nifty_live; ?></span>
                    </label>
                    <label>
                        <input class="options_board_change" name="stocks_type" type="radio" value="nifty-bank"data-value="<?= $bank_live; ?>">
                        <span class="pre_market_radio"></span> <span>BANKNIFTY - <?= $bank_live; ?></span>
                    </label>
                    <div class="options_form_group">
                        <label>Trade Date</label>
                        <div class="custom_date_picker">
                            <input type="text" name="trade_date" value="<?= date('Y-m-16'); ?>" max="<?= date('Y-m-d'); ?>" class="trade_date_datepicker options_form_control options_board_change" />
                        </div>
                    </div>
                    <div class="options_form_group">
                        <label>Expiry Date</label>
                        <div class="custom_date_picker <?= date('D'); ?>">
                            <input type="text" name="expiry_date" value="<?= date('D') !== 'Thu' ? date('Y-m-d', strtotime('next thursday')) : date('Y-m-d'); ?>" class="expiry_date_datepicker options_form_control options_board_change" />
                        </div>
                    </div>
                    <div class="options_form_group">
                        <label>Time Period</label>
                        <div class="">
                            <select name="minutes"  class="expiry_date_datepicker options_form_control options_board_change">
                                <option value="5">5 Minutes</option>
                                <option value="10">10 Minutes</option>
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