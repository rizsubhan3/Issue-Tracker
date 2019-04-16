<?php

use yii\db\Migration;

/**
 * Class m190414_105250_create_delete_permission
 */
class m190414_105250_create_delete_permission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

       // add "deleteIssue" permission
        $deleteIssue = $auth->createPermission('deleteIssue');
        $deleteIssue->description = 'Delete all issues';
        $auth->add($deleteIssue);
      
        // add "author" role and give this role the "createPost" permission
        $admin = $auth->getRole('admin');        
        $auth->addChild($admin, $deleteIssue);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190414_105250_create_delete_permission cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190414_105250_create_delete_permission cannot be reverted.\n";

        return false;
    }
    */
}
