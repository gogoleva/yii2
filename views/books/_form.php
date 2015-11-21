<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Books */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-books-preview">

        <?= Html::activeLabel($model, 'preview') ?>

        <?= Html::hiddenInput('Books[preview]', $model->preview) ?>

        <?= Html::fileInput('preview') ?>

        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'date')->textInput(['placeholder' => date('d/m/Y', time()), 'class' => 'form-control datepicker', 'style' => 'width:30%', 'value' => $model->isNewRecord ? '' : date('d/m/Y', strtotime($model->date))]) ?>

    <?= $form->field($model, 'author_id')->dropDownList($authors, ['style' => 'width:30%']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
