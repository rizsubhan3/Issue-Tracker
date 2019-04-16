<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_module".
 *
 * @property int $Module_Id
 * @property string $Module_Name
 * @property int $Status
 */
class AppModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Module_Id', 'Module_Name', 'Status'], 'required'],
            [['Module_Id', 'Status'], 'integer'],
            [['Module_Name'], 'string', 'max' => 150],
            [['Module_Id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Module_Id' => 'Module ID',
            'Module_Name' => 'Module Name',
            'Status' => 'Status',
        ];
    }
    
    public static function  getModuleList()
    {
        $q = sprintf("SELECT * FROM app_module ");
        $data = Yii::$app->db->createCommand($q)->queryAll();
        //print_r($data[0]['Module_Name']);
        
        $modules = [];
        foreach ($data as $d) {
            $modules[$d['Module_Id']] = $d['Module_Name'];
        }
        return $modules;
    }
    
}
