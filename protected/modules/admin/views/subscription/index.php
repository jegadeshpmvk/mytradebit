<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">
    <?= Html::a('<span>Add New Subscription</span>', ['subscription/create'], ['class' => 'fa fa-plus']) ?>

    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
</div>
<h1 class="p-tl">Subscription</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'user_id',
            'label' => 'User',
            'value' => function ($model) {
                return $model->user->id .' - '. $model->user->fullname;
            }
        ],
        [
            'attribute' => 'start_date',
            'value' => function ($model) {
                return $model->start_date > 0 ? date('d F Y h:i:s a', $model->start_date) : '---';
            }
        ],
        [
            'attribute' => 'end_date',
            'value' => function ($model) {
                return $model->end_date > 0 ? date('d F Y h:i:s a', $model->end_date) : '---';
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:d F Y H:i:s a']
        ],
        [
            'class' => 'app\extended\ActionColumn',
            'contentOptions' => ['class' => 'grid-actions']
        ],
    ],
]);
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>