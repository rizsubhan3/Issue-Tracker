<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue_assignment".
 *
 * @property int $id
 * @property int $assignee_id
 * @property int $assigned_to
 * @property string $assigned_date
 * @property int $issue_id
 *
 * @property Issue $issue
 */
class IssueAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assignee_id', 'assigned_to', 'assigned_date', 'issue_id'], 'required'],
            [['assignee_id', 'assigned_to', 'issue_id','status'], 'integer'],
            [['assigned_date'], 'safe'],
            [['issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Issue::className(), 'targetAttribute' => ['issue_id' => 'Issue_Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'assignee_id' => Yii::t('app', 'Assignee ID'),
            'assigned_to' => Yii::t('app', 'Assigned To'),
            'assigned_date' => Yii::t('app', 'Assigned Date'),
            'issue_id' => Yii::t('app', 'Issue ID'),
            'status' => Yii::t('app', 'Assigned Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssue()
    {
        return $this->hasOne(Issue::className(), ['Issue_Id' => 'issue_id']);
    }
}
