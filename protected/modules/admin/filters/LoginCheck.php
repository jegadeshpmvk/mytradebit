<?php

return [
    'access' => [
        'class' => yii\filters\AccessControl::className(),
        'user' => 'admin',
        'except' => ['password'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    if (Yii::$app->user->identity->type === "admin")
                        return true;
                    return false;
                }
            ]
        ],
    ]
];
