<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue_attachment".
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_ext
 * @property int $upload_by
 * @property string $upload_date
 * @property int $issue_id
 */
class IssueAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name', 'file_ext', 'upload_by', 'upload_date', 'issue_id'], 'required'],
            [['upload_by', 'issue_id'], 'integer'],
            [['upload_date'], 'safe'],
            [['file_name'], 'string', 'max' => 250],
            [['file_ext'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_name' => Yii::t('app', 'File Name'),
            'file_ext' => Yii::t('app', 'File Ext'),
            'upload_by' => Yii::t('app', 'Upload By'),
            'upload_date' => Yii::t('app', 'Upload Date'),
            'issue_id' => Yii::t('app', 'Issue ID'),
        ];
    }
}
