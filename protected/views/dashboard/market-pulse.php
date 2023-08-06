<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="intra_title">
                    <span>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" checked value="Nifty 50"><span class="pre_market_radio"></span> <span>NIFTY 50</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="BANKNIFTY"><span class="pre_market_radio"></span> <span>BANKNIFTY</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="NIFTY F&O"><span class="pre_market_radio"></span> <span>NIFTY F&O</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="FINNIFTY"><span class="pre_market_radio"></span> <span>FINNIFTY</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="NIFTY AUTO"><span class="pre_market_radio"></span> <span>NIFTY AUTO</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="NIFTY IT"><span class="pre_market_radio"></span> <span>NIFTY IT</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="NIFTY FMCG"><span class="pre_market_radio"></span> <span>NIFTY FMCG</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="NIFTY METAL"><span class="pre_market_radio"></span> <span>NIFTY METAL</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="NIFTY PHARMA"><span class="pre_market_radio"></span> <span>NIFTY PHARMA</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="NIFTY OIL & GAS"><span class="pre_market_radio"></span> <span>NIFTY OIL & GAS</span>
                        </label>
                        <label>
                            <input class="stocks_type" name="stocks_type" type="radio" value="all"><span class="pre_market_radio"></span> <span>ALL</span>
                        </label>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="intra_row">
                <div class="_col _col_2">
                    <div class="dash_sec_inner custom_table_scroll">
                        <div class="intra_title">
                            <span class="">Pre Market Data <span class="sub_text">23rd Jun, 3.30pm</span></span>
                            <span>
                                <label>
                                    <input name="market_cap" class="market_cap" checked type="radio" value="Large Cap"><span class="pre_market_radio"></span> <span>Large Cap</span>
                                </label>
                                <label>
                                    <input name="market_cap" class="market_cap" type="radio" value="Mid Cap"><span class="pre_market_radio"></span> <span>Mid Cap</span>
                                </label>
                                <label>
                                    <input name="market_cap" class="market_cap" type="radio" value="Small Cap"><span class="pre_market_radio"></span> <span>Small Cap</span>
                                </label>
                            </span>
                        </div>
                        <div class="dash_content">
                            <table class="custom_table">
                                <thead>
                                    <tr>
                                        <th>Symbol</th>
                                        <th>Prev.close</th>
                                        <th>Open</th>
                                        <th>% Change</th>
                                        <th>Sector</th>
                                    </tr>
                                </thead>
                                <tbody class="pre_market_data">
                                    <?php
                                    if (!empty($stocks)) {
                                        foreach ($stocks as $k => $stock) {
                                    ?>
                                            <tr>
                                                <td><?= $stock->name; ?></td>
                                                <td><?= @$pre_close[$stock->name][0] ?></td>
                                                <td><?= @$pre_close[$stock->name][1] ?></td>
                                                <td>19.12</td>
                                                <td><?= $stock->sector; ?></td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo '<tr><td colspan="5">No datas found</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="_col _col_4">
                    <div class="dash_sec_inner">
                        <div class="intra_title">
                            <span class="">Top Gainer List<span class="sub_text">23rd Jun, 3.30pm</span></span>
                        </div>
                        <div class="top_gainer" id="top_gaiers"></div>
                    </div>
                </div>
                <div class="_col _col_4">
                    <div class="dash_sec_inner">
                        <div class="intra_title">
                            <span class="">Top Losers List<span class="sub_text">23rd Jun, 3.30pm</span></span>
                        </div>
                        <div class="top_losers" id="top_losers"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="intra_title">
                    <span>Market Cheat Sheet</span>
                    <span>
                        <label>
                            <input name="market_sheet_cap" class="market_sheet_cap" type="radio" checked value="Large Cap"><span class="pre_market_radio"></span> <span>Large Cap</span>
                        </label>
                        <label>
                            <input name="market_sheet_cap" class="market_sheet_cap" type="radio" value="Mid Cap"><span class="pre_market_radio"></span> <span>Mid Cap</span>
                        </label>
                        <label>
                            <input name="market_sheet_cap" class="market_sheet_cap" type="radio" value="Small Cap"><span class="pre_market_radio"></span> <span>Small Cap</span>
                        </label>
                    </span>
                </div>
                <table class="custom_table_data display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Gap Analysis</th>
                            <th>Gap %</th>
                            <th>Open Equals</th>
                            <th>Opening Range Breakout (ORB)</th>
                            <th>Narrow Range (NR7/NR4)</th>
                            <th>Triangle / Box Formation</th>
                            <th>Inside Bars</th>
                        </tr>
                    </thead>
                    <tbody class="market_cheat_sheet">
                        <?php
                        if (!empty($stocks)) {
                            foreach ($stocks as $k => $stock) {
                        ?>
                                <tr>
                                    <td><?= $stock->name; ?></td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                        <?php }
                        } else {
                            echo '<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No data available in table</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>