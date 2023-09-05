<?php
$cat = $put = $call = $a = $b = [];
$pcr = 0;
 if (!empty($nifty_data)) {
    foreach ($nifty_data as $k => $res) {
        $cat[] =   $k;
        $put[] =    $res[count($res)-1]["pe_oi"];
        $call[] =    $res[count($res)-1]["ce_oi"];
    }
    
}

$t_call = $t_put  = [];
 if (!empty($nifty_max_data)) {
    foreach ($nifty_max_data as $k => $res) {
        $t_put[] =    $res[count($res)-1]["pe_oi"];
        $t_call[] =    $res[count($res)-1]["ce_oi"];
    }
     $pcr = abs(((float) (array_sum($t_put) / array_sum($t_call))));
}

 ?>

<div id="total_open"  data-put='<?= json_encode($put); ?>' data-date='<?= date('d M Y', strtotime(str_replace('/', '-', $current_date))); ?>'  data-call='<?= json_encode($call); ?>' data-cat='<?= json_encode($cat); ?>'></div>
<div class="total_text_view">
    <div class="total_text_left">
        <span>TOTAL OI View</span> <span><?php
         if($pcr < 0.85) {
              echo '<span style="color:#E96767">Bearish</span>';
         } else if($pcr > 0.8 && $pcr < 1.15) {
            echo '<span style="color:#ffa500">Neutral</span>';
         } else if($pcr > 1.15) {
               echo '<span style="color:#62D168">Bullish</span>';
          }
          
          ?></span>
    </div>
    <div class="total_text_right">
        <div class="">
            <span>TOTAL CE OI</span> <span style="color:#62D168"><?= !empty($t_call) ? number_format(array_sum($t_call), 2, '.', ',') : '---'; ?></span>
        </div>
        <div class="">
            <span>TOTAL PE OI</span> <span style="color:#E96767"><?= !empty($t_put) ? number_format(array_sum($t_put), 2, '.', ',') : '---'; ?></span>
        </div>
        <div class="">
            <span>Total PCR</span> <span><?php
          if($pcr < 0.85) {
              echo '<span style="color:#E96767">'.number_format($pcr, 2, '.', '').'</span>';
          } else if($pcr > 0.8 && $pcr < 1.15) {
            echo '<span style="color:#ffa500">'.number_format($pcr, 2, '.', '').'</span>';
          } else if($pcr > 1.15) {
               echo '<span style="color:#62D168">'.number_format($pcr, 2, '.', '').'</span>';
          }
          ?></span>
        </div>
    </div>
</div>