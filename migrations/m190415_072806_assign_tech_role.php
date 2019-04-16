<?php

use yii\db\Migration;

/**
 * Class m190415_072806_assign_tech_role
 */
class m190415_072806_assign_tech_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $auth = Yii::$app->authManager;
       $technical = $auth->getRole('technical');
       $auth->assign($technical, 7);       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190415_072806_assign_tech_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190415_072806_assign_tech_role cannot be reverted.\n";

        return false;
    }
    */
}
