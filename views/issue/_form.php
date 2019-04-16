<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\AppModule;

/* @var $this yii\web\View */
/* @var $model app\models\Issue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issue-form">
 <div class="row">
   <div class="col-lg-6">
    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'Module_Id')->dropDownList(ArrayHelper::map(AppModule::find()->all(), 'Module_Id', 'Module_Name')
            ,['prompt'=>'----']) ?>
       
    <?= $form->field($model, 'Description')->textarea(['rows' => 5]) ?>   
    <?= $form->field($model, 'imageFile')->fileInput()  ?>        
    <?= $form->field($commentsModel, 'description')->textarea(['rows' => 6]) ?>
     
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
   </div>
 </div>
</div>
