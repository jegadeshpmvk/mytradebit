<?php

use app\models\HeaderFooter;

$header = HeaderFooter::find()->one();
$meta = Yii::$app->controller->meta;

use yii\helpers\Url;
?>
<div class="header">
    <div class="c">
        <div class="p_rel header_content">
            <a class="logo" href="/">
                <img class="logo_img" src="<?= Yii::getAlias('@icons') ?>/logo.png"> <span class=""><?= $meta['title']; ?></span>
            </a>
            <div class="header_menu">
                <?php
                if (Yii::$app->user->identity) {
                ?>
                    <ul>
                        <li><a class="" href="/dashboard"><span>Dashboard</span></a></li>
                        <li><a class="" href="/dashboard"><span>Market Pulse</span></a></li>
                        <li>
                            <a class="" href="/dashboard">
                                <span class="sub_menu">Index Analysis <span class="menu_arrow"></span>
                            </a>
                            <ul class="sub_menus">
                                <li><a class="" href="/dashboard"><span>Options Board</span></a></li>
                                <li><a class="" href="/dashboard"><span>Futures Board</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="" href="/dashboard">
                                <span class="sub_menu">Stocks Buzz <span class="menu_arrow"></span>
                            </a>
                            <ul class="sub_menus">
                                <li><a class="" href="/dashboard"><span>Intraday Setups</span></a></li>
                                <li><a class="" href="/dashboard"><span>Positions Setups</span></a></li>
                            </ul>
                        </li>
                        <li><a class="" href="/dashboard"><span>FII - DII Data</span></a></li>
                        <li><a class="menu_profile" href="/dashboard"><img src="<?= Yii::getAlias('@icons') ?>/circle.png" /><span>Hey Joel!</span></a></li>
                    </ul>
                    <?php } else {
                    if (isset($header->header_menu) && is_array($header->header_menu) && count($header->header_menu) > 0) { ?>
                        <?php
                        foreach ($header->header_menu as $key => $value) { ?>
                            <li><a class="<?= $value["link_type"] === 'button' ? 'btn btn_blue' : ''; ?>" href="<?= Yii::$app->function->constructLink($value["link"]); ?>"><span><?= $value["name"]; ?></span></a></li>
                        <?php } ?>

                <?php }
                } ?>
            </div>
        </div>
    </div>
</div>