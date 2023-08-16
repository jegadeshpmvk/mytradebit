<?php
$a = $b = $ap = $bp = [];
if (!empty($nifty_less_data)) {
    $d = $nifty_less_data;
    foreach($d as $dk => $res) {
        $ce_oi_change = $ce_price_change = $pe_oi_change = $pe_price_change = 0;
        if(isset($d[$dk-1]["ce_oi"])) {
            if($d[$dk-1]["ce_oi"] != $res['ce_oi']) {
                $ce_oi_change = $res['ce_oi'] - $d[$dk-1]["ce_oi"];
                $a = [$ce_oi_change];
            } else {
                $ce_oi_change = !empty($a) ? $a[0] : 0;
            }
        }
        
        if(isset($d[$dk-1]["ce_ltp"])) {
            if($d[$dk-1]["ce_ltp"] != $res['ce_ltp']) {
                $ce_price_change = $res['ce_ltp'] - $d[$dk-1]["ce_ltp"];
                $ap = [$ce_price_change];
            } else {
                $ce_price_change = !empty($ap) ? $ap[0] : 0;
            }
        }
        $calls = '----';
        if($ce_oi_change < 0 && $ce_price_change < 0) {
            $calls = 'Call unwinding';
        } else if($ce_oi_change > 0 && $ce_price_change < 0) {
            $calls = 'Call Short Build up';
        } else if($ce_oi_change > 0 && $ce_price_change > 0) {
            $calls = 'Call Long built up';
        } else if($ce_oi_change < 0 && $ce_price_change > 0) {
             $calls = 'Call short covering';
        }
        
        if(isset($d[$dk-1]["pe_oi"])) {
            if($d[$dk-1]["pe_oi"] != $res['pe_oi']) {
                $pe_oi_change = $res['pe_oi'] - $d[$dk-1]["ce_oi"];
                $a = [$pe_oi_change];
            } else {
                $pe_oi_change = !empty($a) ? $a[0] : 0;
            }
        }
        
        if(isset($d[$dk-1]["pe_ltp"])) {
            if($d[$dk-1]["pe_ltp"] != $res['pe_ltp']) {
                $pe_price_change = $res['pe_ltp'] - $d[$dk-1]["pe_ltp"];
                $ap = [$pe_price_change];
            } else {
                $pe_price_change = !empty($ap) ? $ap[0] : 0;
            }
        }
        $p_calls = '----';
        if($pe_oi_change < 0 && $pe_price_change < 0) {
            $p_calls = 'Call unwinding';
        } else if($pe_oi_change > 0 && $pe_price_change < 0) {
            $p_calls = 'Call Short Build up';
        } else if($pe_oi_change > 0 && $pe_price_change > 0) {
            $p_calls = 'Call Long built up';
        } else if($pe_oi_change < 0 && $pe_price_change > 0) {
             $p_calls = 'Call short covering';
        }
?>
        <tr>
            <td><?= $calls; ?></td>
            <td><?= $res['strike_price']; ?></td>
            <td><?= $p_calls; ?></td>
            <td>Strong Support</td>
        </tr>
<?php }
}
?>
<?php
$a = $b = $ap = $bp = [];
if (!empty($nifty_more_data)) {
    $d = $nifty_more_data;
    foreach($d as $dk => $res) {
        $pe_oi_change = $pe_price_change = 0;
        
        if(isset($d[$dk-1]["ce_oi"])) {
            if($d[$dk-1]["ce_oi"] != $res['ce_oi']) {
                $ce_oi_change = $res['ce_oi'] - $d[$dk-1]["ce_oi"];
                $a = [$ce_oi_change];
            } else {
                $ce_oi_change = !empty($a) ? $a[0] : 0;
            }
        }
        
        if(isset($d[$dk-1]["ce_ltp"])) {
            if($d[$dk-1]["ce_ltp"] != $res['ce_ltp']) {
                $ce_price_change = $res['ce_ltp'] - $d[$dk-1]["ce_ltp"];
                $ap = [$ce_price_change];
            } else {
                $ce_price_change = !empty($ap) ? $ap[0] : 0;
            }
        }
        $calls = '----';
        if($ce_oi_change < 0 && $ce_price_change < 0) {
            $calls = 'Call unwinding';
        } else if($ce_oi_change > 0 && $ce_price_change < 0) {
            $calls = 'Call Short Build up';
        } else if($ce_oi_change > 0 && $ce_price_change > 0) {
            $calls = 'Call Long built up';
        } else if($ce_oi_change < 0 && $ce_price_change > 0) {
             $calls = 'Call short covering';
        }
        
        if(isset($d[$dk-1]["pe_oi"])) {
            if($d[$dk-1]["pe_oi"] != $res['pe_oi']) {
                $pe_oi_change = $res['pe_oi'] - $d[$dk-1]["ce_oi"];
                $a = [$pe_oi_change];
            } else {
                $pe_oi_change = !empty($a) ? $a[0] : 0;
            }
        }
        
        if(isset($d[$dk-1]["pe_ltp"])) {
            if($d[$dk-1]["pe_ltp"] != $res['pe_ltp']) {
                $pe_price_change = $res['pe_ltp'] - $d[$dk-1]["pe_ltp"];
                $ap = [$pe_price_change];
            } else {
                $pe_price_change = !empty($ap) ? $ap[0] : 0;
            }
        }
        $p_calls = '----';
        if($pe_oi_change < 0 && $pe_price_change < 0) {
            $p_calls = 'Call unwinding';
        } else if($pe_oi_change > 0 && $pe_price_change < 0) {
            $p_calls = 'Call Short Build up';
        } else if($pe_oi_change > 0 && $pe_price_change > 0) {
            $p_calls = 'Call Long built up';
        } else if($pe_oi_change < 0 && $pe_price_change > 0) {
             $p_calls = 'Call short covering';
        }
?>
        <tr>
            <td><?= $calls; ?></td>
            <td><?php if($dk === 0) { echo '<span class="plans_header">'.$res['strike_price'].'</span>'; } else { echo $res['strike_price']; } ?></td>
            <td><?= $p_calls; ?></td>
            <td>Strong Support</td>
        </tr>
<?php }
}
?>