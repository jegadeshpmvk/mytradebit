

<?php
$a = $b = $ap = $bp = [];
// echo '<pre>';
// print_r($nifty_data);exit;
if (!empty($nifty_data)) {
    $i  = true;
    foreach($nifty_data as $dk => $res) {
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
        
         if(isset($res[count($res)-1]["ce_ltp"]) && isset($res[0]["ce_ltp"])) {
            if(@$res[count($res)-1]["ce_ltp"] != @$res[0]["ce_ltp"]) {
                $ce_price_change = $res[count($res)-1]["ce_ltp"] - $res[0]["ce_ltp"];
                $ap = [$ce_price_change];
            } else {
                $ce_price_change = !empty($ap) ? $ap[0] : 0;
            }
        }
        if($ce_oi_change < 0 && $ce_price_change < 0) {
            $calls = 'Call unwinding';
        } else if($ce_oi_change > 0 && $ce_price_change < 0) {
            $calls = 'Call Short Build up';
        } else if($ce_oi_change > 0 && $ce_price_change > 0) {
            $calls = 'Call Long built up';
        } else if($ce_oi_change < 0 && $ce_price_change > 0) {
             $calls = 'Call short covering';
        }
        
         if(isset($res[count($res)-1]["pe_oi"]) && isset($res[0]["pe_oi"])) {
            if(@$res[count($res)-1]["pe_oi"] != @$res[0]["pe_oi"]) {
                $pe_oi_change = $res[count($res)-1]["pe_oi"] - $res[0]["pe_oi"];
                $b = [$pe_oi_change];
            } else {
                $pe_oi_change = !empty($b) ? $b[0] : 0;
            }
        }
        
         if(isset($res[count($res)-1]["pe_ltp"]) && isset($res[0]["pe_ltp"])) {
            if(@$res[count($res)-1]["pe_ltp"] != @$res[0]["pe_ltp"]) {
                $pe_price_change = $res[count($res)-1]["pe_ltp"] - $res[0]["pe_ltp"];
                $bp = [$pe_price_change];
            } else {
                $pe_price_change = !empty($bp) ? $bp[0] : 0;
            }
        }
        
          if($pe_oi_change < 0 && $pe_price_change < 0) {
            $p_calls = 'Put unwinding';
        } else if($pe_oi_change > 0 && $pe_price_change < 0) {
            $p_calls = 'Put Short Build up';
        } else if($pe_oi_change > 0 && $pe_price_change > 0) {
            $p_calls = 'Put Long built up';
        } else if($pe_oi_change < 0 && $pe_price_change > 0) {
             $p_calls = 'Put short covering';
        }
?>
        <tr>
            <td><?= $calls; ?></td>
             <td><?php if($res[0]['strike_price'] > $live_value && $i) { $i = false; echo '<span class="plans_header">'.$res[0]['strike_price'].'</span>'; } else { echo $res[0]['strike_price']; } ?></td>
            <td><?= $p_calls; ?></td>
            <td>Strong Support</td>
        </tr>
<?php  } } ?>