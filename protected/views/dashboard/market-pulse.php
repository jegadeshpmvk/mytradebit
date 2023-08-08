<div class="dashboard">
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner">
                <div class="intra_title stocks_type_groups">
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
                            <span class="">Pre Market Data <span title="test">(?)</span></span>
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
                            <table class="custom_table_data">
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
                                            $number = ((Yii::$app->function->getAmount($pre_close[$stock->name][1]) - Yii::$app->function->getAmount($pre_close[$stock->name][0])) / Yii::$app->function->getAmount($pre_close[$stock->name][0])) * 100;
                                            $change =  number_format((float)$number, 2, '.', '');
                                    ?>
                                            <tr>
                                                <td><?= $stock->name; ?></td>
                                                <td align="center"><?= @$pre_close[$stock->name][0] ?></td>
                                                <td align="center"><?= @$pre_close[$stock->name][1] ?></td>
                                                <td align="center"><?= $change; ?></td>
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
                    <div class="dash_sec_inner custom_table_scroll top_gainer_padd">
                        <div class="intra_title">
                            <span class="">Top Gainer List</span>
                        </div>
                        <div class="top_gainer" id="top_gaiers"></div>
                    </div>
                </div>
                <div class="_col _col_4">
                    <div class="dash_sec_inner custom_table_scroll top_gainer_padd">
                        <div class="intra_title">
                            <span class="">Top Losers List</span>
                        </div>
                        <div class="top_losers" id="top_losers"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dash_sec dash_sec_padd">
        <div class="c">
            <div class="dash_sec_inner" style="position:relative">
                <div class="intra_title">
                    <span>Market Cheat Sheet <span title="test">(?)</span></span>
                    <span class="cheat_sheet_radio">
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
                <div class="dash_content">
                    <table class="custom_table_data display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Symbol</th>
                                <th>Gap Analysis</th>
                                <th>Gap %</th>
                                <th>Open Equals</th>
                                <th>Opening Range Breakout (ORB)</th>
                                <th>Narrow Range (NR4/NR7)</th>
                                <th>Triangle / Box Formation</th>
                                <th>Inside Bars</th>
                            </tr>
                        </thead>
                        <tbody class="market_cheat_sheet">
                            <?php
                            $gap_up = explode(',', @$gap_up->stocks);
                            $gap_down = explode(',', @$gap_down->stocks);
                            $open_high = explode(',', @$open_high->stocks);
                            $open_low = explode(',', @$open_low->stocks);
                            $orb_30_h = explode(',', @$orb_30_h->stocks);
                            $orb_30_l = explode(',', @$orb_30_l->stocks);
                            $orb_60_h = explode(',', @$orb_60_h->stocks);
                            $orb_60_l = explode(',', @$orb_60_l->stocks);
                            $l1 = explode(',', @$l1->stocks);
                            $l2 = explode(',', @$l2->stocks);
                            $l3 = explode(',', @$l3->stocks);
                            $nr4 = explode(',', @$nr4->stocks);
                            $nr7 = explode(',', @$nr7->stocks);
                            $insrk = explode(',', @$insrk->stocks);
                            $inside = explode(',', @$inside->stocks);
                            if (!empty($stocks)) {
                                foreach ($stocks as $k => $stock) {
                                    $number = ((Yii::$app->function->getAmount($pre_close[$stock->name][1]) - Yii::$app->function->getAmount($pre_close[$stock->name][0])) / Yii::$app->function->getAmount($pre_close[$stock->name][0])) * 100;
                                    $change =  number_format((float)$number, 2, '.', '');
                                    $gap = '---';
                                    if (in_array($stock->name, $gap_up)) {
                                        $gap = 'Gap Up';
                                    } else if (in_array($stock->name, $gap_down)) {
                                        $gap = 'Gap Down';
                                    }
                                    $open = '---';

                                    if (in_array($stock->name, $open_high)) {
                                        $open = 'O = H';
                                    } else if (in_array($stock->name, $open_low)) {
                                        $open = 'O = L';
                                    }
                            ?>
                                    <tr>
                                        <td><?= $stock->name; ?></td>
                                        <td><?= $gap; ?></td>
                                        <td><?= $change; ?></td>
                                        <td><?= $open; ?></td>
                                        <td>
                                            <?php
                                            $orb = '';
                                            if (in_array($stock->name, $orb_30_h)) {
                                                $orb = '30 Mins - High,';
                                            }
                                            if (in_array($stock->name, $orb_30_l)) {
                                                $orb .= '30 Mins - Low,';
                                            }
                                            if (in_array($stock->name, $orb_60_h)) {
                                                $orb .= '60 Mins - High,';
                                            }
                                            if (in_array($stock->name, $orb_60_l)) {
                                                $orb .= '60 Mins - Low';
                                            }
                                            echo $orb !== '' ? rtrim($orb, ',') : '---';
                                            ?>
                                        </td>
                                        <td> <?php
                                                $nr = '';
                                                if (in_array($stock->name, $nr4)) {
                                                    $nr .= 'NR4/';
                                                }
                                                if (in_array($stock->name, $nr7)) {
                                                    $nr .= 'NR7';
                                                }
                                                echo $nr !== '' ? rtrim($nr, '/') : '---';
                                                ?></td>
                                        <td>
                                            <?php
                                            if (in_array($stock->name, $l1) || in_array($stock->name, $l2) || in_array($stock->name, $l3)) {
                                                if (in_array($stock->name, $l1)) {
                                                    echo '<span class="triangle_box color_l1"></span>';
                                                }
                                                if (in_array($stock->name, $l2)) {
                                                    echo '<span class="triangle_box color_l1"></span><span class="triangle_box color_l2"></span>';
                                                }
                                                if (in_array($stock->name, $l3)) {
                                                    echo '<span class="triangle_box color_l1"></span><span class="triangle_box color_l2"></span><span class="triangle_box color_l3"></span>';
                                                }
                                            } else {
                                                echo '---';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $in = '';
                                            if (in_array($stock->name, $insrk)) {
                                                $in .= 'SHARK 32,';
                                            }
                                            if (in_array($stock->name, $inside)) {
                                                $in .= '1D INS';
                                            }
                                            echo $in !== '' ? rtrim($in, ',') : '---';
                                            ?>
                                        </td>
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
</div>