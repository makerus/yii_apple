<?php

use yii\db\Migration;

/**
 * Class m210607_090830_apple
 */
class m210607_090830_apple extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('apple', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'color' => $this->string()->defaultValue('red'),
            'dateCreated' => $this->integer(),
            'dateFall' => $this->integer(),
            'status' => $this->integer(),
            'size' => $this->integer(),
            'fresh' => $this->boolean()
        ]);
    }

    public function down()
    {
        $this->dropTable('apple');
    }
}
