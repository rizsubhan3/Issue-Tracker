<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Issue;

/**
 * IssueSearch represents the model behind the search form of `app\models\Issue`.
 */
class IssueSearch extends Issue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Issue_Id', 'Status'], 'integer'],
            [['Description', 'Raised_By','Assigned_To', 'Created_Date', 'Close_Date', 'Comments', 'Closed_By','Module_Id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {        
        $query = Issue::find();

        // add conditions that should always apply here
        if( \Yii::$app->user->can('viewAllIssue') == FALSE && \Yii::$app->user->can('updateIssueReport'))
        {
          $query->andFilterWhere([
             'Raised_By' => \yii::$app->user->id ,             
          ]);
          
          $query->orFilterWhere([
             //'Raised_By' => \yii::$app->user->id ,
             'Assigned_To' => \yii::$app->user->id ,
          ]);  
        }        
        elseif( \Yii::$app->user->can('viewAllIssue') == FALSE)
        {
         $query->andFilterWhere([
            'Raised_By' => \yii::$app->user->id ,                       
         ]);   
        }
                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
              'defaultOrder'=>[
                  'Issue_Id' => SORT_DESC ,
              ],
              'attributes'=>[
                'Issue_Id',
                'Description',
                'Module_Id',
                'Created_Date',
                'Status',
                'Raised_By'=>[
                    'asc' => ['r.username' => SORT_ASC],
                    'desc' => ['r.username' => SORT_DESC],
                    'default' => SORT_DESC
                ],
                'Assigned_To'=>[
                    'asc' => ['a.username' => SORT_ASC],
                    'desc' => ['a.username' => SORT_DESC],
                    'default' => SORT_DESC
                ]
              ]
                
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
       //$query->joinWith('appModule');
       $query->joinWith('backendUser r');
       $query->joinWith('assignedTo a');
       
        // grid filtering conditions
        $query->andFilterWhere([
            'Issue_Id' => $this->Issue_Id,
            'Module_Id' => $this->Module_Id,
            'Created_Date' => $this->Created_Date,
            'Close_Date' => $this->Close_Date,
            'issue.Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'r.firstName', $this->Raised_By])
            ->andFilterWhere(['like', 'a.firstName', $this->Assigned_To])             
            ->andFilterWhere(['like', 'Closed_By', $this->Closed_By]);
            //->andFilterWhere(['like', 'app_module.Module_Name', $this->Module_Id]);
        
        return $dataProvider;
    }
}
