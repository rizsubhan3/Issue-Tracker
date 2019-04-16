<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'New User Registeration');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Login'), 'url' => ['login']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="backend-user-create">

<h1><?= Html::encode($this->title) ?></h1>
    
<div class="backend-user-form">
   <div class="row">
     <div class="col-lg-7"> 
   
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>
    
     <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

     </div>      
   </div>     
    
    <?php ActiveForm::end(); ?>

</div>

</div>