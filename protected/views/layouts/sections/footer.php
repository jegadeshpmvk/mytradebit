<?php

use app\models\HeaderFooter;
use yii\helpers\Url;

$header = HeaderFooter::find()->one();
?>
<div class="footer">
    <div class="footer_top">
        <div class="footer_top_inner align_right">
            <p class="foot_text"><?= $header->text; ?></p>
            <a class="btn foot_btn" href="mailto:<?= $header->email; ?>">Send us a mail</a>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="footer_menu align_center">
            <?php
            if (isset($header->footer_menu) && is_array($header->footer_menu) && count($header->footer_menu) > 0) {
                echo '<div class="menu-list">';
                foreach ($header->footer_menu as $key => $f) {
                    echo '<a href="' . Yii::$app->function->constructLink($f["link"]) . '"><span>' . $f["name"] . '</span></a>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="footer_menu">
            <?php
            if (isset($header->social_media) && is_array($header->social_media) && count($header->social_media) > 0) {
                echo '<div class="social-links align_center">';
                foreach ($header->social_media as $key => $value) {
                    echo '<a href="' . $value["link"] . '"><span class="' . $value["name"] . '"></a>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="copyrights align_center"><?= $header->copyrights; ?></div>
    </div>
</div>