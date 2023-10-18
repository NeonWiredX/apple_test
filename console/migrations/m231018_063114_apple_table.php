<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m231018_063114_apple_table
 */
class m231018_063114_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@admin';
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $user->save();

        $this->createTable('apple', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'fell_at' => $this->dateTime(),
            'eaten_percent' => $this->decimal(3, 2),
            'created_at' => $this->dateTime()->comment('По сути не нужно'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('apple');
        $admin = User::findOne(['email' => 'admin@admin']);
        if ($admin) {
            $admin->delete();
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231018_063114_apple_table cannot be reverted.\n";

        return false;
    }
    */
}
