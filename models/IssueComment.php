<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "issue_comment".
 *
 * @property int $id
 * @property string $description
 * @property int $comment_by
 * @property string $comment_date
 * @property int $issue_id
 */
class IssueComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['description', 'comment_by', 'comment_date', 'issue_id'], 'required'],
            [['description'], 'string'],
            [['comment_by', 'issue_id'], 'integer'],
            [['comment_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Comment'),
            'comment_by' => Yii::t('app', 'Comment By'),
            'comment_date' => Yii::t('app', 'Comment Date'),
            'issue_id' => Yii::t('app', 'Issue ID'),
        ];
    }
    
    public function  getBackendUser()
    {
         return $this->hasOne(BackendUser::className(), ['id'=>'comment_by']);
    }
    
    public static function search($id)
    {
        $query = IssueComment::find();

        // add conditions that should always apply here        
        $query->andFilterWhere([
            'issue_id' => $id ,                       
        ]);   
                        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$id) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }               
       $query->joinWith('backendUser')->orderBy('id desc');
            
        return $dataProvider;
    }
}
