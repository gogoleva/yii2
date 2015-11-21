<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Books;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel, 'authors' => $authors]); ?>

    <p>
        <?= Html::a('Create Books', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'label' => 'Превью',
                'format' => 'raw',
                'value' => function ($data) {
                    return '<a href="' . Yii::getAlias('@web') . $data->preview . '" data-lightbox="example-set"><img src="' . Yii::getAlias('@web') . $data->preview . '" height="100"/></a>';
                },
            ],
            [
                'attribute' => 'authors.firstname',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->authors->firstname . ' ' . $data->authors->lastname;
                },
            ],
            [
                'attribute' => 'date',
                'format' => 'raw',
                'value' => function ($data) {
                    return Books::formatDate($data->date);
                },
                'filter' => TRUE,
            ],
            [
                'attribute' => 'date_create',
                'format' => 'raw',
                'value' => function ($data) {
                    return Books::formatDate($data->date_create);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Кнопки действий',
                'template' => '{update}{view}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update', 'id' => $model->id]), ['title' => Yii::t('app', 'Update'), 'data-pjax' => '0', 'class' => 'update', 'data-params' => $_SERVER["REQUEST_URI"]]);
                    },
                            'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['view', 'id' => $model->id]), ['title' => Yii::t('app', 'View'), 'data-pjax' => '0', 'class' => 'view']);
                    },
                        ]
                    ],
                ],
            ]);
            ?>
            <?php \yii\widgets\Pjax::end(); ?>
            <?php $this->registerJs("$(document).on('click', 'td a', function (e) {
                                                            e.preventDefault();
                                                            var class_name = $(this).attr('class');
                                                            if(class_name == 'view'){
                                                                $.ajax({ 
                                                                    type: 'GET', 
                                                                    url: $(this).attr('href'),
                                                                    success:function (data) {
                                                                            bootbox.dialog({
                                                                                title: 'Информация о книге',
                                                                                message: data,
                                                                            }); 
                                                                            }
                                                                });
                                                            }else{
                                                                window.location.href = $(this).attr('href')+'&params='+escape($(this).data('params'));
                                                            }     
                                    });"); ?>
</div>
