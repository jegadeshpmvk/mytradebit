<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="intra_row">
                <div class="_col _col_4">
                    <div class="dash_sec_inner">
                        <div class="intra_title">
                            <span class="">Bulish Momentum & Reversal</span>
                        </div>
                        <div class="dash_content">
                            <table class="custom_table">
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
                            <table class="custom_table">
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
                            <table class="custom_table">
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
                            <table class="custom_table">
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
    </div>
</div>