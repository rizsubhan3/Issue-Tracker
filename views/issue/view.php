<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\IssueComment;
/* @var $this yii\web\View */
/* @var $model app\models\Issue */

$this->title = $model->Issue_Id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Issues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php if (Yii::$app->session->hasFlash('issueCreated')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
<!--         <h4><i class="icon fa fa-check"></i>Saved!</h4>-->
         <?= Yii::$app->session->getFlash('issueCreated') ?>
    </div>
<?php endif; ?>

<div class="issue-view">

    <h1>Issue: <?= Html::encode($this->title) ?></h1>

    <p>
        <?php if( \Yii::$app->user->can('updateIssueReport') == TRUE){
          echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->Issue_Id], ['class' => 'btn btn-primary']);
         }
        ?>
        <?php if( \Yii::$app->user->can('deleteIssue') == TRUE){ 
          echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->Issue_Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
          ]); 
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Issue_Id',
            [
              'attribute'=>'Status',
              'value'=>function ($model) {
              if($model->Status === 1) 
              {
                return "Open";    
              }
              elseif ($model->Status === 2) {
               return "Assigned";
              }
              else{
                return "Close";  
              }
              },              
            ],     
            'Description:ntext',
            'appModule.Module_Name',
            [ 
              'label'=> 'Raised By',
              'value'=> function ($model) { 
               return $model->backendUser->firstName . ' ' . $model->backendUser->lastName  ;
              }
            ],
            [
              'label'=>'Raised Date',
              'attribute'=>'Created_Date',
            ],
            [ 
              'label'=> 'Assigned To',
              'value'=> function ($model) { 
               if($model->Assigned_To)
               {
                return $model->assignedTo->firstName ;
               }
              }
            ],
            'Assigned_Date',
            [
              'label'=>'Assigned Status',
              'value'=> function($model){
                 if($model->issueAssignments){
                   if($model->issueAssignments[0]->status == 1)
                   {
                       return "Accepted";                       
                   }
                   elseif ($model->issueAssignments[0]->status == 2)
                   {
                       return "Rejected";
                   }
                 }
              } 
            ],
            [ 
              'label'=> 'Closed By',
              'value'=> function ($model) { 
                if($model->Closed_By)
                {
                  return $model->closedBy->username ;
                }
              }
            ],                                              
            'Close_Date',
            [              
              'label'=>'Uploaded File',
              'value'=>function ($model) {
              if($model->File_Name) 
              {
                return Html::a($model['File_Name'], '../uploads/' . $model['File_Name'] );                    
              }
             },
             'format' => 'html',
            ],
                                           
        ],
    ]) ?>

</div>

<div class="issue-index">

    <h1>History</h1>
 

    <?= GridView::widget([
        'dataProvider' => IssueComment::search($model->Issue_Id)  ,        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'headerOptions' => ['style' => 'width: 550px;'],
                'label'=> 'Comment',
                'value' => 'description',  
            ], 
            [                
                'label'=> 'Comment Date',
                'value' => 'comment_date',  
            ],             
            [
                'label'=>'Comment By',
                'value'=> 'backendUser.firstName',
            ]
            ,            
        ],
    ]); ?>

  
</div>
