<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IssueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issue-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',        
        'options' => [
            'data-pjax' => 1,
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'Issue_Id') ?>

    <?= $form->field($model, 'Description') ?>

    <?= $form->field($model, 'Module_Id') ?>

    <?= $form->field($model, 'Raised_By') ?>

    <?= $form->field($model, 'Created_Date') ?>

    <?php // echo $form->field($model, 'Close_Date') ?>

    <?php // echo $form->field($model, 'Comments') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Closed_By') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
