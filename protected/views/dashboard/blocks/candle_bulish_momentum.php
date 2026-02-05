    <?php
    if(!empty($candlestick_patterns)) {
                    foreach ($candlestick_patterns as $k => $cp) {
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
                    <?php } } else {
                        echo '<div class="no_data">No Data Found</div>';
                    }?>