<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="_row">
                    <div class="_col _col_senti_f">
                        <?php
                        $i = 0;
                        if (!empty($getGlobalSentiments)) {
                            foreach ($getGlobalSentiments as $k => $getGlobalSentiment) {
                                $i += $getGlobalSentiment->dayChangePerc;
                            }
                        }
                        ?>
                        <div class="dash_title <?= $i; ?>"><span>Global Sentiments - </span><span class="dash_title_iiner <?= $i > 0 ? 'btn_green' : 'btn_red'; ?>"><?= $i > 0 ? 'Bullish' : 'Bearish'; ?></span></div>
                        <div class="dash_content">
                            <table class="custom_table">
                                <thead>
                                    <tr>
                                        <th>Index Name</th>
                                        <th>Prev Close</th>
                                        <th>Last Traded</th>
                                        <th>Day Change (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     if (!empty($getGlobalSentiments)) {
                                         foreach ($getGlobalSentiments as $k => $getGlobalSentiment) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <div class="table_col">
                                                        <img src="<?= @$getGlobalSentiment->logoUrl; ?>" />
                                                        <?= @$getGlobalSentiment->name; ?><br />
                                                        <span><?= date('d M, h:i A', @$getGlobalSentiment->tsInMillis) ?></span>
                                                    </div>
                                                </td>
                                                <td><?= number_format((float)@$getGlobalSentiment->close, 2, '.', ''); ?></td>
                                                <td><?= number_format((float)@$getGlobalSentiment->value, 2, '.', ''); ?></td>
                                                <td><?= number_format((float)@$getGlobalSentiment->dayChange, 2, '.', ''); ?> (<?= number_format((float)@$getGlobalSentiment->dayChangePerc, 2, '.', '') . '%'; ?>)</td>
                                            </tr>
                                    <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="_col _col_senti_s">
                        <div class="dash_title"><span>FII - DII Cash Sentiment -</span><span class="dash_title_iiner <?= @$stocks_sentiment == 'bullish' ? 'btn_green' : 'btn_red' ?>"><?= ucfirst(@$stocks_sentiment); ?></span><br /><span>(<?= $date; ?>)</span></div>
                        <div class="dash_content">
                            <div id="fii_cash_chart" data-details="<?= json_encode($details); ?>"></div>
                        </div>
                    </div>
                    <div class="_col _col_senti_t">
                        <div class="dash_title"><span>Pre Market & Live Market Performance in SECTOR WISE <br /><span>(<?= $pre_market_date; ?>)</span></span></div>
                        <div class="dash_content">
                            <div id="pre_market" data-cat='<?= json_encode($cat); ?>' data-percentChange='<?= json_encode($percentChange); ?>' data-open='<?= json_encode($open); ?>'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="_row">
                    <div class="_col">
                        <div class="dash_title"><span>Live Performances Heat Map</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>