<?php
$cat = $put = $call = $a = $b = [];
 if (!empty($nifty_data)) {
        foreach ($nifty_data as $k => $res) {
        $ce_oi_change = $ce_price_change = $pe_oi_change = $pe_price_change = 0;
        $calls = $p_calls = '----';
        if(isset($res[count($res)-1]["ce_oi"]) && isset($res[0]["ce_oi"])) {
            if($res[count($res)-1]["ce_oi"] != $res[0]["ce_oi"]) {
                $ce_oi_change = $res[count($res)-1]["ce_oi"] - $res[0]["ce_oi"];
                $a = [$ce_oi_change];
            } else {
                $ce_oi_change = !empty($a) ? $a[0] : 0;
            }
        }
        if(isset($res[count($res)-1]["pe_oi"]) && isset($res[0]["pe_oi"])) {
            if($res[count($res)-1]["pe_oi"] != $res[0]["pe_oi"]) {
                $pe_oi_change = $res[count($res)-1]["pe_oi"] - $res[0]["pe_oi"];
                $b = [$pe_oi_change];
            } else {
                $pe_oi_change = !empty($b) ? $b[0] : 0;
            }
        }
        $cat[] =   $k;
        $put[] =    $pe_oi_change;
        $call[] =    $ce_oi_change;
        }
    }
 ?>
<div class="" id="net_OI" data-put='<?= array_sum($put); ?>'  data-call='<?= array_sum($call); ?>'></div>
<div class="" id="OI_change" data-put='<?= json_encode($put); ?>' data-date='<?= date('d M Y', strtotime(str_replace('/', '-', $current_date))); ?>'  data-call='<?= json_encode($call); ?>' data-cat='<?= json_encode($cat); ?>'></div>