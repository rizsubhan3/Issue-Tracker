<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\IssueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Issues');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Issue'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
               'attribute'=>'Issue_Id',                 
               'headerOptions' => ['style' => 'width: 50px;'],
            ] 
            ,
            [
              'attribute'=>'Raised_By',
              'value'=>'backendUser.firstName',
              
              'headerOptions' => ['style' => 'width: 100px;'],
            ]
            ,
            'Description:ntext',
            [
              'attribute'=>'Module_Id',
              'value'=>'appModule.Module_Name',
              'filter' => app\models\AppModule::getModuleList(),
            ]
            ,                                   
            [
              'attribute'=>'Created_Date',
              'label' => 'Raised Date',
              'value'=> 'Created_Date',              
              'format'=>'raw',
              'filter'=> DatePicker::widget([
                  'model'=> $searchModel,
                  'attribute'=> 'Created_Date',
                  'options' => ['class' => 'form-control'],
                  'dateFormat' => 'yyyy-MM-dd',
              ])                
            ]
            ,
            [
              'attribute'=>'Assigned_To',
              'value'=>'assignedTo.firstName',
              'headerOptions' => ['style' => 'width: 100px;'],
            ]
            ,
            [
              'attribute'=>'Status',
              'value'=>function ($searchModel) {
              if($searchModel->Status == 1) 
              {
                return "Open";    
              }
              elseif ($searchModel->Status == 2) {
               return "Assigned";
              }
              else{
                return "Close";  
              }
              },
              'filter' => ['1' => 'Open', '2' => 'Assigned', '3' => 'Close'],
              'filterInputOptions' => ['prompt' => 'Status', 'class' => 'form-control', 'id' => null]
            ],                        
            //'Closed_By',

            ['class' => 'yii\grid\ActionColumn',
             'visibleButtons' => [
                'update' => function () {
                    return \Yii::$app->user->can('updateIssueReport');
                },
                'delete' => function () {
                    return \Yii::$app->user->can('deleteIssue');
                },
             ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
