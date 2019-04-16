<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Issue */

$this->title = Yii::t('app', 'Update Issue: {name}', [
    'name' => $model->Issue_Id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Issue_Id, 'url' => ['view', 'id' => $model->Issue_Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="issue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'model' => $model,
        'commentsModel'=> $commentsModel,
        'assignmentModel'=>$assignmentModel ,
    ]) ?>

</div>
