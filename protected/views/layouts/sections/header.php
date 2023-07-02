<?php

use app\models\HeaderFooter;

$header = HeaderFooter::find()->one();

use yii\helpers\Url;
?>
<div class="header">
    <div class="c">
        <div class="p_rel header_content">
            <a class="logo" href="/">
                <img class="logo_img" src="<?= Yii::getAlias('@icons') ?>/logo.png">
            </a>
            <?php
            if (isset($header->header_menu) && is_array($header->header_menu) && count($header->header_menu) > 0) { ?>
                <div class="header_menu">
                    <?php
                    foreach ($header->header_menu as $key => $value) { ?>
                        <a class="<?= $value["link_type"] === 'button' ? 'btn btn_blue' : ''; ?>" href="<?= Yii::$app->function->constructLink($value["link"]); ?>"><span><?= $value["name"]; ?></span></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>