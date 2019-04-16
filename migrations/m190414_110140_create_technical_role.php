<?php

use yii\db\Migration;

/**
 * Class m190414_110140_create_technical_role
 */
class m190414_110140_create_technical_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $auth = Yii::$app->authManager;
                               
        // add "author" role and give this role the "createPost" permission
        $technical = $auth->createRole('technical');
        $auth->add($technical);
        
        $author = $auth->getRole('author');
        $auth->addChild($technical, $author);
        
        //add update issue permission
        $updateIssue = $auth->getPermission('updateIssueReport');
        $auth->addChild($technical, $updateIssue); 
        
        //assign this role
        $auth->assign($technical, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190414_110140_create_technical_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190414_110140_create_technical_role cannot be reverted.\n";

        return false;
    }
    */
}
