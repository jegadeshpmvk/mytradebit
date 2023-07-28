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
                        <li><a class="" href="/market-pulse"><span>Market Pulse</span></a></li>
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
                                <li><a class="" href="/intraday-setups"><span>Intraday Setups</span></a></li>
                                <li><a class="" href="/positional-setups"><span>Positions Setups</span></a></li>
                            </ul>
                        </li>
                        <li><a class="" href="/fii-dii"><span>FII - DII Data</span></a></li>
                        <li>
                            <a class="menu_profile" href="/dashboard">
                                <?php
                                $image = \app\models\Media::find()->where(['id' => isset(Yii::$app->user->identity->profile_img) ? Yii::$app->user->identity->profile_img : 0])->one();
                                echo Yii::$app->file->asImageTag($image, '100x100');
                                ?>
                                <span>Hey <?= Yii::$app->user->identity->fullname; ?> !</span>
                            </a>
                            <ul class="sub_menus">
                                <li><a class="" href="/account-details"><span>Account Details</span></a></li>
                                <li><a class="" href="/plans"><span>My Trade Bit Plans</span></a></li>
                                <li><a class="" href="/"><span>Contact Us</span></a></li>
                                <li><a class="" href="/logout"><span>Logout</span></a></li>
                            </ul>
                        </li>
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