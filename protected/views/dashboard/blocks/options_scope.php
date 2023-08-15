<?php
if (!empty($nifty_less_data)) {
    foreach ($nifty_less_data as $k => $d) {
?>
        <tr>
            <td>Call Unwinding</td>
            <td><?= $d['strike_price']; ?></td>
            <td>Put Unwinding</td>
            <td>Strong Support</td>
        </tr>
<?php }
}
?>