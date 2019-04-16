<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue".
 *
 * @property int $Issue_Id
 * @property string $Description
 * @property int $Module_Id
 * @property string $Raised_By
 * @property string $Created_Date
 * @property string $Close_Date
 * @property string $Comments
 * @property int $Status
 * @property int $Closed_By
 * @property int $Assigned_To
 */
class Issue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;
    public $assignStatus; 
    
    public static function tableName()
    {
        return 'issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Description', 'Module_Id', 'Raised_By', 'Created_Date', 'Status'], 'required'],
            [['Description', 'Comments'], 'string'],
            [['Module_Id', 'Status','Assigned_To'], 'integer'],
            [['Created_Date', 'Close_Date'], 'safe'],
//            [['Closed_By'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Issue_Id' => 'Issue ID',
            'Description' => 'Issue Description',
            'Module_Id' => 'Module ',
            'Raised_By' => 'Raised By',
            'Created_Date' => 'Created Date',
            'Close_Date' => 'Close Date',
            'Comments' => 'Comments',
            'Status' => 'Status',
            'Closed_By' => 'Closed By',
            'Assigned_To' => 'Assigned To',
        ];
    }
    
    public function  getAppModule()
    {
         return $this->hasOne(AppModule::className(), ['Module_Id'=>'Module_Id']);
    }
    
    public function  getBackendUser()
    {
         return $this->hasOne(BackendUser::className(), ['id'=>'Raised_By']);
    }
    
    public function  getAssignedTo()
    {
         return $this->hasOne(BackendUser::className(), ['id'=>'Assigned_To']);
    }
    
    public function  getClosedBy()
    {
         return $this->hasOne(BackendUser::className(), ['id'=>'Closed_By']);
    }
    
    public function  getIssueAssignments()
    {
        return $this->hasMany(IssueAssignment::className(), ['issue_id'=>'Issue_Id'])->orderBy('id desc');
    }

    
    public function  upload()
    {
        if($this->imageFile)
        {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.'  . $this->imageFile->extension );
            $this->File_Name = $this->imageFile->baseName . '.'  . $this->imageFile->extension  ;
            $this->File_Ext = $this->imageFile->extension;
        }
    }
    
}
