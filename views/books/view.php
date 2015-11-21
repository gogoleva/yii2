<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Books;

/* @var $this yii\web\View */
/* @var $model app\models\Books */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'preview',
                'value' => Yii::getAlias('@web') . $model->preview,
                'format' => ['image', ['height' => '150']],
            ],
            [
                'attribute' => 'authors.firstname',
                'format' => 'text',
                'value' => $model->authors->firstname . ' ' . $model->authors->lastname,
            ],
            [
                'attribute' => 'date',
                'format' => 'text',
                'value' => Books::formatDate($model->date)
            ],
            [
                'attribute' => 'date_create',
                'format' => 'text',
                'value' => Books::formatDate($model->date_create)
            ],
            [
                'attribute' => 'date_update',
                'format' => 'text',
                'value' => Books::formatDate($model->date_update)
            ],
        ],
    ])
    ?>

</div>
