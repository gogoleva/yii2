<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BooksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-search" style="width: 40%">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'author_id')->dropDownList(array_merge(['Автор'], $authors)) ?>

    <?= $form->field($model, 'name') ?>


    <div class="form-group field-bookssearch-date">

        <?= Html::activeLabel($model, 'date', ['style' => 'display:block;width:100%']) ?>

        <?= Html::textInput('BooksSearch[date_from]', $model->date_from, ['placeholder' => date('d/m/Y', time()), 'class' => 'form-control datepicker', 'style' => 'display:inline-block;width:49%']) ?>

        <?= Html::textInput('BooksSearch[date_to]', $model->date_to, ['placeholder' => date('d/m/Y', time()), 'class' => 'form-control datepicker', 'style' => 'display:inline-block;width:50%']) ?>

        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php $this->registerJs("$(document).on('click', 'button[type=reset]', function () {
                                                           window.location.href = '" . Url::toRoute(['index']) . "';    
                                    });"); ?>

</div>
