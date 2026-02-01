<?php
$cat = $put = $call = $a = $b = [];
$pcr = 0;
 if (!empty($nifty_max_data)) {
        foreach ($nifty_max_data as $k => $res) {
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
        $put[] =    $pe_oi_change;
        $call[] =    $ce_oi_change;
        }
        $pcr = abs(((float) (array_sum($put) / array_sum($call))));
    }
    
 ?>
<div id="canvas-holder" style="width:100%">
    <div class="intra_title">
        <span class="">Options Sentiment</span>
    </div>
    <canvas id="gaugeChart" data-chart="<?= number_format($pcr, 2, '.', ''); ?>" width="500px" height="150px"></canvas>
</div>

<div class="gaugeChart_content">
    <div class="gauge_title">Sentiment Meter</div>
    <div class="gauge_contnet">
        <div class=""><span class="title">Max Call</span><span style="color:#62D168"><?= @$nifty_max_call_data[0]['strike_price'] ? @$nifty_max_call_data[0]['strike_price'] .'CE' : '---'; ?></span></div>
        <div class=""><span class="title">Max Put</span><span style="color:#E96767"><?= @$nifty_max_put_data[0]['strike_price'] ? @$nifty_max_put_data[0]['strike_price'].'PE' : '---'; ?></span></div>
        <div class=""><span class="title">CE OI Change</span><span style="color:#E96767"><?= !empty($call) ? array_sum($call) : '---'; ?></span></div>
        <div class=""><span class="title">PE OI Change</span><span style="color:#62D168"><?= !empty($put) ? array_sum($put) : '---'; ?></span></div>
         <div class=""><span class="title">Total PCR</span><span>
         <?php
          if($pcr < 0.85) {
              echo '<span style="color:#E96767">'.number_format($pcr, 2, '.', '').'</span>';
          } else if($pcr > 0.8 && $pcr < 1.15) {
            echo '<span style="color:#ffa500">'.number_format($pcr, 2, '.', '').'</span>';
          } else if($pcr > 1.15) {
               echo '<span style="color:#62D168">'.number_format($pcr, 2, '.', '').'</span>';
          }
          ?></span></div>
          <div class=""><span class="title">OI View</span><span><?php
         if($pcr < 0.85) {
              echo '<span style="color:#E96767">Bearish</span>';
         } else if($pcr > 0.8 && $pcr < 1.15) {
            echo '<span style="color:#ffa500">Neutral</span>';
         } else if($pcr > 1.15) {
               echo '<span style="color:#62D168">Bullish</span>';
          }
          
          ?></span></div>

    </div>
</div>