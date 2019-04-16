<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\AppModule;
use app\models\BackendUser;

use yii\jui\DatePicker ;
/* @var $this yii\web\View */
/* @var $model app\models\Issue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issue-form">

  <div class="row">
   <div class="col-lg-6">
       
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Description')->textarea(['rows' => 5,'readonly' => true]) ?>

    <?= $form->field($model, 'Module_Id')->dropDownList(ArrayHelper::map(AppModule::find()->all(), 'Module_Id', 'Module_Name')
            ,['prompt'=>'--Select Module--'] ) ?>
   
    <?= $form->field($model, 'Status')->dropDownList([
        1 => 'Open',
        2 => 'Assigned',
        3 => 'Close'
    ],
    ['prompt'=>'----']) ?>
    
    <?= $form->field($model, 'Assigned_To')->dropDownList(ArrayHelper::map(BackendUser::find()->where(['id'=>[1,7]])->all() , 'id', 'firstName'),
    ['prompt'=>'----']) ?>

       
    <?= $form->field($assignmentModel, 'status')->dropDownList([
        1=>'Accepted',
        2=>'Rejected'
    ],
    ['prompt'=>'----'])  ?> 
    
    <?= $form->field($model, 'imageFile')->fileInput()  ?> 
       
    <?php
    if($model->Status == 2 || $model->Status == 3){ 
        echo $form->field($model, 'Close_Date')->widget(DatePicker::class, [   
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
        // ... you can configure more DatePicker properties here    
    ]);
    }
    ?>
   
    <?= $form->field($commentsModel, 'description')->textarea(['rows' => 6]) ?>
     
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
   </div>
  </div>
</div>
