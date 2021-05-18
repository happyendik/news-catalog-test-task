<?php

use yii\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'News';
$this->params['header'] = $this->title;
$this->params['breadcrumbs'] = [
    $this->title
];

/**
 * @var ActiveDataProvider $dataProvider
 */

?>
<div class="news_index">
    <div class="box box-primary">
        <div class="box-header">
            <?= Html::a('Добавить', ['news/update'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?=GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => ActionColumn::class,
                        'headerOptions' => [
                            'width' => 150,
                        ],
                    ],
                    'id',
                    'title',
                ],
            ])?>
        </div>
    </div>
</div>
