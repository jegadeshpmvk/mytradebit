<?php

return [
    'access' => [
        'class' => yii\filters\AccessControl::className(),
        'user' => 'user',
        'except' => ['password'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    $user = Yii::$app->user->identity;
                    if ($user->session_id !== Yii::$app->session->id) {
                        Yii::$app->user->logout();
                        Yii::$app->session->setFlash(
                            'error',
                            'You were logged out because your account was logged in from another device.'
                        );

                        return false;
                    }
                    return true;
                }
            ]
        ],
    ]
];
