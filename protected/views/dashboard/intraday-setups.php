<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="intra_row">
                <a class="_col _col_1 intra_row_title">
                    <div class=""><span>Intraday Meteor Stocks</span></div>
                </a>
                <div class="_col _col_1 intra_row_content">
                    <div class="_col _col_4">
                        <div class="dash_sec_inner">
                            <div class="intra_title">
                                <span class="">Bulish Momentum & Reversal</span>
                            </div>
                            <div class="dash_content">
                                <table class="custom_table custom_table_intra">
                                    <thead>
                                        <tr>
                                            <th>Symbol</th>
                                            <th>Prev. Close</th>
                                            <th>LTP</th>
                                            <th>% Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stocks = [];
                                        $trigger_prices = [];
                                        if ($bulish_momentum !== '' && isset($bulish_momentum['stocks'])) {
                                            $stocks = explode(',', $bulish_momentum['stocks']);
                                            $trigger_prices = explode(',', $bulish_momentum['trigger_prices']);
                                        }
                                        if (!empty($stocks)) {
                                            for ($i = 0; $i < count($stocks); $i++) {
                                                $number = (($trigger_prices[$i] - Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) / Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) * 100;
                                                $change =  number_format((float)$number, 2, '.', '')
                                        ?>
                                                <tr>
                                                    <td><?= $stocks[$i]; ?></td>
                                                    <td><?= Yii::$app->function->getAmount($pre_close[$stocks[$i]][0]); ?></td>
                                                    <td><?= $trigger_prices[$i]; ?></td>
                                                    <td><?= $change . '%'; ?></td>
                                                </tr>
                                            <?php }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="4" align="center">No datas found</td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="custom_table_link align_right">
                                    <a href="" class="text_color_gradiant">Learn to trade this setup</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_col _col_4">
                        <div class="dash_sec_inner">
                            <div class="intra_title">
                                <span class="">Bearish Momentum & Reversal</span>
                            </div>
                            <div class="dash_content">
                                <table class="custom_table custom_table_intra">
                                    <thead>
                                        <tr>
                                            <th>Symbol</th>
                                            <th>Prev. Close</th>
                                            <th>LTP</th>
                                            <th>% Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stocks = [];
                                        $trigger_prices = [];
                                        if (@$bearish_momentum !== '' && isset($bearish_momentum['stocks'])) {
                                            $stocks = explode(',', $bearish_momentum['stocks']);
                                            $trigger_prices = explode(',', $bearish_momentum['trigger_prices']);
                                        }
                                        if (!empty($stocks)) {
                                            for ($i = 0; $i < count($stocks); $i++) {
                                                $number = (($trigger_prices[$i] - Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) / Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) * 100;
                                                $change =  number_format((float)$number, 2, '.', '')
                                        ?>
                                                <tr>
                                                    <td><?= $stocks[$i]; ?></td>
                                                    <td><?= Yii::$app->function->getAmount($pre_close[$stocks[$i]][0]); ?></td>
                                                    <td><?= $trigger_prices[$i]; ?></td>
                                                    <td><?= $change . '%'; ?></td>
                                                </tr>
                                            <?php }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="4" align="center">No datas found</td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="custom_table_link align_right">
                                    <a href="" class="text_color_gradiant">Learn to trade this setup</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_col _col_4">
                        <div class="dash_sec_inner">
                            <div class="intra_title">
                                <span class="">Bullish Impulse</span>
                            </div>
                            <div class="dash_content">
                                <table class="custom_table custom_table_intra">
                                    <thead>
                                        <tr>
                                            <th>Symbol</th>
                                            <th>Prev. Close</th>
                                            <th>LTP</th>
                                            <th>% Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stocks = [];
                                        $trigger_prices = [];
                                        if (@$bullish_impulse !== '' && isset($bullish_impulse['stocks'])) {
                                            $stocks = explode(',', $bullish_impulse['stocks']);
                                            $trigger_prices = explode(',', $bullish_impulse['trigger_prices']);
                                        }
                                        if (!empty($stocks)) {
                                            for ($i = 0; $i < count($stocks); $i++) {
                                                $number = (($trigger_prices[$i] - Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) / Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) * 100;
                                                $change =  number_format((float)$number, 2, '.', '')
                                        ?>
                                                <tr>
                                                    <td><?= $stocks[$i]; ?></td>
                                                    <td><?= Yii::$app->function->getAmount($pre_close[$stocks[$i]][0]); ?></td>
                                                    <td><?= $trigger_prices[$i]; ?></td>
                                                    <td><?= $change . '%'; ?></td>
                                                </tr>
                                            <?php }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="4" align="center">No datas found</td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="custom_table_link align_right">
                                    <a href="" class="text_color_gradiant">Learn to trade this setup</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_col _col_4">
                        <div class="dash_sec_inner">
                            <div class="intra_title">
                                <span class="">Bearish Impulse</span>
                            </div>
                            <div class="dash_content">
                                <table class="custom_table custom_table_intra">
                                    <thead>
                                        <tr>
                                            <th>Symbol</th>
                                            <th>Prev. Close</th>
                                            <th>LTP</th>
                                            <th>% Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stocks = [];
                                        $trigger_prices = [];
                                        if (@$bearish_impulse !== '' && isset($bearish_impulse['stocks'])) {
                                            $stocks = explode(',', $bearish_impulse['stocks']);
                                            $trigger_prices = explode(',', $bearish_impulse['trigger_prices']);
                                        }
                                        if (!empty($stocks)) {
                                            for ($i = 0; $i < count($stocks); $i++) {
                                                $number = (($trigger_prices[$i] - Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) / Yii::$app->function->getAmount($pre_close[$stocks[$i]][0])) * 100;
                                                $change =  number_format((float)$number, 2, '.', '')
                                        ?>
                                                <tr>
                                                    <td><?= $stocks[$i]; ?></td>
                                                    <td><?= Yii::$app->function->getAmount($pre_close[$stocks[$i]][0]); ?></td>
                                                    <td><?= $trigger_prices[$i]; ?></td>
                                                    <td><?= $change . '%'; ?></td>
                                                </tr>
                                            <?php }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="4" align="center">No datas found</td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="custom_table_link align_right">
                                    <a href="" class="text_color_gradiant">Learn to trade this setup</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intra_row" style="margin-top:20px">
                <a class="_col _col_1 intra_row_title">
                    <div class=""><span>Intraday Candlestick Patterns</span>
                        <div class="intraday_radio">
                            <label>
                                <input name="candle_pattern" class="candle_pattern" checked type="radio" value="bulish"><span class="pre_market_radio"></span> <span>Bulish Pattern</span>
                            </label>
                            <label>
                                <input name="candle_pattern" class="candle_pattern" type="radio" value="bearish"><span class="pre_market_radio"></span> <span>Bearish Pattern</span>
                            </label>
                            <label>
                                <input name="candle_pattern_time" class="candle_pattern_time" checked type="radio" value="5"><span class="pre_market_radio"></span> <span>5 mins</span>
                            </label>
                            <label>
                                <input name="candle_pattern_time" class="candle_pattern_time" type="radio" value="10"><span class="pre_market_radio"></span> <span>10 mins</span>
                            </label>
                            <label>
                                <input name="candle_pattern_time" class="candle_pattern_time" type="radio" value="15"><span class="pre_market_radio"></span> <span>15 mins</span>
                            </label>
                        </div>
                    </div>
                </a>
                <div class="_col _col_1 intra_row_content candlestick_patterns">
                    <?php
                    foreach ($candlestick_scan as $k => $cp) {
                    ?>
                        <div class="_col _col_4">
                            <div class="dash_sec_inner">
                                <div class="intra_title">
                                    <span class=""><?= $cp['name'];?></span>
                                </div>
                                <div class="dash_content">
                                    <table class="custom_table custom_table_intra">
                                        <thead>
                                            <tr>
                                                <th>Symbol</th>
                                                <th>Prev. Close</th>
                                                <th>LTP</th>
                                                <th>% Change</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bulish_momentum">
                                            <?php
                                            $stocks = [];
                                            $trigger_prices = [];
                                            if ($cp['value'] !== '' && isset($cp['value']->stocks)) {
                                                $stocks = explode(',', $cp['value']->stocks);
                                                $trigger_prices = explode(',', $cp['value']->trigger_prices);
                                            }
                                            if (!empty($stocks)) {
                                                for ($i = 0; $i < count($stocks); $i++) {
                                                    $symbol = $stocks[$i];
    
                                                    if (isset($pre_close[$symbol][0])) {
    
                                                        $prevClose = Yii::$app->function->getAmount($pre_close[$symbol][0]);
    
                                                        if ($prevClose > 0) {
                                                            $number = (($trigger_prices[$i] - $prevClose) / $prevClose) * 100;
                                                            $change = number_format($number, 2, '.', '');
                                                        } else {
                                                            $change = "0.00";
                                                        }
                                                    } else {
    
                                                        // Symbol missing in array
                                                        $change = "N/A";
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><?= $stocks[$i]; ?></td>
                                                        <td><?php if (isset($pre_close[$stocks[$i]][0])): ?>
        <?= Yii::$app->function->getAmount($pre_close[$stocks[$i]][0]); ?>
    <?php else: ?>
        <?= "N/A"; ?>
    <?php endif; ?></td>
                                                        <td><?= $trigger_prices[$i]; ?></td>
                                                        <td><?= $change . '%'; ?></td>
                                                    </tr>
                                                <?php }
                                            } else {
                                                ?>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="custom_table_link align_right">
                                        <a href="" class="text_color_gradiant">Learn to trade this setup</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            
            <div class="intra_row" style="margin-top:20px">
                <a class="_col _col_1 intra_row_title">
                    <div class=""><span>Intraday Chart Patterns</span>
                        <div class="intraday_radio">
                            <label>
                                <input name="chart_pattern" class="chart_pattern" checked type="radio" value="bulish"><span class="pre_market_radio"></span> <span>Bulish Pattern</span>
                            </label>
                            <label>
                                <input name="chart_pattern" class="chart_pattern" type="radio" value="bearish"><span class="pre_market_radio"></span> <span>Bearish Pattern</span>
                            </label>
                            <label>
                                <input name="chart_pattern_time" class="chart_pattern_time" checked type="radio" value="5"><span class="pre_market_radio"></span> <span>5 mins</span>
                            </label>
                            <label>
                                <input name="chart_pattern_time" class="chart_pattern_time" type="radio" value="10"><span class="pre_market_radio"></span> <span>10 mins</span>
                            </label>
                            <label>
                                <input name="chart_pattern_time" class="chart_pattern_time" type="radio" value="15"><span class="pre_market_radio"></span> <span>15 mins</span>
                            </label>
                        </div>
                    </div>
                </a>
                <div class="_col _col_1 intra_row_content chart_patterns">
                    <?php
                    foreach ($chart_scan as $k => $cp) {
                    ?>
                        <div class="_col _col_4">
                            <div class="dash_sec_inner">
                                <div class="intra_title">
                                    <span class=""><?= $cp['name'];?></span>
                                </div>
                                <div class="dash_content">
                                    <table class="custom_table custom_table_intra">
                                        <thead>
                                            <tr>
                                                <th>Symbol</th>
                                                <th>Prev. Close</th>
                                                <th>LTP</th>
                                                <th>% Change</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bulish_momentum">
                                            <?php
                                            $stocks = [];
                                            $trigger_prices = [];
                                            if ($cp['value'] !== '' && isset($cp['value']->stocks)) {
                                                $stocks = explode(',', $cp['value']->stocks);
                                                $trigger_prices = explode(',', $cp['value']->trigger_prices);
                                            }
                                            if (!empty($stocks)) {
                                                for ($i = 0; $i < count($stocks); $i++) {
                                                    $symbol = $stocks[$i];
    
                                                    if (isset($pre_close[$symbol][0])) {
    
                                                        $prevClose = Yii::$app->function->getAmount($pre_close[$symbol][0]);
    
                                                        if ($prevClose > 0) {
                                                            $number = (($trigger_prices[$i] - $prevClose) / $prevClose) * 100;
                                                            $change = number_format($number, 2, '.', '');
                                                        } else {
                                                            $change = "0.00";
                                                        }
                                                    } else {
    
                                                        // Symbol missing in array
                                                        $change = "N/A";
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><?= $stocks[$i]; ?></td>
                                                        <td><?php if (isset($pre_close[$stocks[$i]][0])): ?>
        <?= Yii::$app->function->getAmount($pre_close[$stocks[$i]][0]); ?>
    <?php else: ?>
        <?= "N/A"; ?>
    <?php endif; ?></td>
                                                        <td><?= $trigger_prices[$i]; ?></td>
                                                        <td><?= $change . '%'; ?></td>
                                                    </tr>
                                                <?php }
                                            } else {
                                                ?>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="custom_table_link align_right">
                                        <a href="" class="text_color_gradiant">Learn to trade this setup</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>



        </div>
    </div>
</div>