<?php

use yii\db\Migration;

/**
 * Class m190402_061543_init_rbac
 */
class m190402_061543_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

       // add "viewAllIssue" permission
        $viewAllIssue = $auth->createPermission('viewAllIssue');
        $viewAllIssue->description = 'View all issues';
        $auth->add($viewAllIssue);
      
        // add "author" role and give this role the "createPost" permission
        $admin = $auth->getRole('admin');        
        $auth->addChild($admin, $viewAllIssue);
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190402_061543_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190402_061543_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
