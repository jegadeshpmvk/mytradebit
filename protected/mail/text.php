<?php

use yii\helpers\Url;

$html = '';
if ($title == 'Password Reset') {
    $link = Url::to(['reset-password', 'id' => $user->email_hash], true);
    $html .= 'Please activate your account by clicking on the link below.<br>';
    $html .= '<a href="' . $link . '">' . $link . '</a>';
} else if ($title == 'Password Reset Set to Customer') {
    $link =   Yii::getAlias('@baseUrl') . Url::to(['/reset-password', 'id' => $user->email_hash, true]);
    $html .= 'Please activate your account by clicking on the link below.<br>';
    $html .= '<a href="' . $link . '">' . $link . '</a>';
}
echo $html;
