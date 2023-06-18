<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">
    <?= Html::a('<span>Add New Page</span>', ['custom-page/create'], ['class' => 'fa fa-plus']) ?>
    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
</div>
<h1 class="p-tl">Pages</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => 'N/A'],
    'showFooter' => true,
    'columns' => [
        [
            'attribute' => 'name',
            'footer' => 'Name'
        ],
        [
            'attribute' => 'url',
            'value' => function ($model, $key, $index) {
                $link = $model->getEntireUrl((string) $model->id);
                return Html::a($link, $link, ['class' => 'normal-link', 'target' => '_blank']);
            },
            'format' => "raw"
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'php:d M Y'],
            'footer' => 'Last Updated'
        ],
        [
            'class' => 'app\extended\ActionColumn',
            'contentOptions' => ['class' => 'grid-actions']
        ],
    ],
]);
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>