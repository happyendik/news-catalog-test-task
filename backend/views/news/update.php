<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use backend\models\News;

/**
 * @var News $model
 */

$this->title = ($model->isNewRecord ? 'Добавление' : 'Редактирование') . ' новости';
$this->params['header'] = $this->title;
$this->params['breadcrumbs'] = [
    [
        'label' => 'News',
        'url' => ['index'],
    ],
    $this->title
];

$form = ActiveForm::begin([
    'enableClientValidation' => false,
]);
?>
<div class="news_update">
    <div class="box box-primary">
        <div class="box-body">

            <?= $form->field($model, 'title') ?>

            <?= $form->field($model, 'text') ?>

            <?= $form->field($model, 'image')->fileInput(['class' => 'btn btn-success']) ?>

        </div>
        <div class="box-footer">
            <?= Html::submitButton('<i class="fa fa-save"></i> Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<?php
$form->end();
