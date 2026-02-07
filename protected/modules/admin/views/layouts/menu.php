<?php

use yii\helpers\Html;

$menu = Yii::$app->request->get('tab', false);
if ($menu !== false)
    $tab = $menu;
else
    $tab = isset(Yii::$app->controller->tab) ? Yii::$app->controller->tab : '';
?>
<ul class="nav">
    <li<?php if ($tab == 'header-footer') echo ' class="active"'; ?> title="Header Footer"><?= Html::a('<span>Header Footer</span>', ['header-footer/index'], ['class' => 'dashicons-before dashicons-admin-page']) ?></li>
        <li<?php if ($tab == 'fii-dii') echo ' class="active"'; ?> title="FII-DII Data"><?= Html::a('<span>FII-DII Data</span>', ['fii-dii/index'], ['class' => 'fa fa-comments']) ?></li>
            <li<?php if ($tab == 'option-chain') echo ' class="active"'; ?>><?= Html::a('<span>Option Chain</span>', ['option-chain/index'], ['class' => 'fa fa-address-book']) ?></li>
                <li<?php if ($tab == 'custom-page') echo ' class="active"'; ?> title="Pages"><?= Html::a('<span>Pages</span>', ['custom-page/index'], ['class' => 'fa fa-h-square']) ?></li>
                    <li<?php if ($tab == 'contact') echo ' class="active"'; ?> title="Contact Request"><?= Html::a('<span>Contact Request</span>', ['contact-request/index'], ['class' => 'fa fa-comments']) ?></li>
                    <li<?php if ($tab == 'subscription') echo ' class="active"'; ?> title="Subscription"><?= Html::a('<span>Subscription</span>', ['subscription/index'], ['class' => 'fa fa-comments']) ?></li>


</ul>
<ul class="nav">
    <li<?php if ($tab == 'user') echo ' class="active"'; ?>><?= Html::a('<span>Admin</span>', ['user/index'], ['class' => 'fa fa-address-book']) ?></li>
        <li<?php if ($tab == 'customer') echo ' class="active"'; ?>><?= Html::a('<span>Customer</span>', ['customer/index'], ['class' => 'fa fa-address-book']) ?></li>

</ul>
<ul class="nav">
    <li<?php if ($tab == 'settings') echo ' class="active"'; ?> title="Settings"><?= Html::a('<span>Settings</span>', ['user/settings'], ['class' => 'fa fa-cog']) ?></li>
        <li<?php if ($tab == 'cache') echo ' class="active"'; ?>><?= Html::a('<span>Clear Cache</span>', ['default/clear'], ['class' => 'fa fa-codiepie']) ?></li>
            <li title="Logout"><?= Html::a('<span>Logout</span>', ['default/logout'], ['class' => 'fa fa-sign-out', 'data-action' => '']) ?></li>
</ul>