<?php

namespace app\controllers;

use Yii;
use app\models\Issue;
use app\models\IssueSearch;
use app\models\IssueAssignment;
use app\models\IssueAttachment;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
/**
 * IssueController implements the CRUD actions for Issue model.
 */
class IssueController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            
            'access' => [
            'class' => AccessControl::className(),
            'only' => ['index','create','update','delete'],
            'rules' => [              
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['viewIssueReport'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['createIssueReport'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['createIssueReport'],
                ],
                [
                    'allow' => true,
                    'actions' => ['update'],
                    'roles' => ['updateIssueReport'],
                ],
                [
                    'allow' => true,
                    'actions' => ['delete'],
                    'roles' => ['deleteIssue'],
                ],
                
            ],
        ],
            
        ];
    }

    /**
     * Lists all Issue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IssueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Issue model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Issue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Issue();
        $commentsModel = new \app\models\IssueComment();
        $model->Created_Date = date('Y-m-d H:i:s');
        $model->Raised_By = Yii::$app->user->id;
        $model->Status = 1;

        if ($model->load(Yii::$app->request->post()) && $commentsModel->load(\Yii::$app->request->post())  ) {
            
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->upload();
            $model->save();
            
            if($commentsModel->description)
            {
                $commentsModel->comment_by = Yii::$app->user->id;
                $commentsModel->comment_date = date('Y-m-d H:i:s');
                $commentsModel->issue_id = $model->Issue_Id;
                $commentsModel->save();
            }
            
            \Yii::$app->session->setFlash('issueCreated',"A new issue request created successfully.");
            return $this->redirect(['view', 'id' => $model->Issue_Id]);
        }

        return $this->render('create', [
            'model' => $model,
            'commentsModel' => $commentsModel,
        ]);
    }

    /**
     * Updates an existing Issue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $commentsModel = new \app\models\IssueComment();
        $sql = sprintf("SELECT * FROM issue_assignment WHERE id = (select max(id) from issue_assignment where issue_id=%d) ",$id );
        $assignmentModel = IssueAssignment::findBySql($sql)->one();
        $oldAssignTo = $model->Assigned_To ;        
        
        if ($model->load(Yii::$app->request->post()) && $commentsModel->load(Yii::$app->request->post()) && $assignmentModel->load(Yii::$app->request->post()) ) {
            
            if($model->Status == 2 && $oldAssignTo != $model->Assigned_To )
            {
                $model->Assigned_Date = date('Y-m-d H:i:s');                
            }
            
            if($model->Status == "3")
            {
              $model->Closed_By = Yii::$app->user->id;
            }
            //save file upload here
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->upload();
                        
            if($model->save())
            {            
                if($model->Status == 2 && $oldAssignTo != $model->Assigned_To )
                {
                   $assignment = new IssueAssignment();
                   $assignment->assignee_id = Yii::$app->user->id ;
                   $assignment->assigned_to = $model->Assigned_To ;
                   $assignment->assigned_date = date('Y-m-d H:i:s');
                   $assignment->issue_id = $model->Issue_Id;
                   $assignment->save();
                }
                
                if($assignmentModel->status == 1 || $assignmentModel->status == 2)
                //if(isset($assignmentModel->status))
                {                                      
                   $assignmentModel->save();                   
                }
                
                if($model->imageFile)
                {
                    $attachment = new IssueAttachment();
                    $attachment->file_name = $model->File_Name ;
                    $attachment->file_ext = $model->File_Ext;
                    $attachment->issue_id = $model->Issue_Id;
                    $attachment->upload_by = Yii::$app->user->id ;
                    $attachment->upload_date = date('Y-m-d H:i:s');
                    $attachment->save();
                }

                //save comment if there
                if($commentsModel->description)
                {
                    $commentsModel->comment_by = Yii::$app->user->id;
                    $commentsModel->comment_date = date('Y-m-d H:i:s');
                    $commentsModel->issue_id = $model->Issue_Id;
                    $commentsModel->save();
                }
                return $this->redirect(['view', 'id' => $model->Issue_Id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'commentsModel'=> $commentsModel,
            'assignmentModel'=> $assignmentModel,
        ]);
    }

    /**
     * Deletes an existing Issue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Issue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Issue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Issue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
