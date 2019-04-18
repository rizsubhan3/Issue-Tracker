<?php

namespace app\components;

use Yii;
use yii\web\Controller;
//use yii\filters\VerbFilter;
/**
 * Description of CustomController
 *
 * @author Adminit
 */
class CustomController extends Controller {
    //put your code here
    
    public function afterAction($action, $result)
    {	
        $writeLog = true;
        if($writeLog)
        {
            $sql = 'INSERT INTO logs(user_id,ip_address,log_time,controller,action,details) VALUES (' . Yii::$app->user->id . ',\''.$_SERVER['REMOTE_ADDR'].'\',\''. date("Y-m-d H:i:s"). '\',\''.$this->id . '\',\''. $this->action->id .'\',\''. Yii::$app->request->method .'\')';
            $command = Yii::$app->db->createCommand($sql);
            $command->execute();
        }
        return parent::afterAction($action, $result); 		
    }
    
}
