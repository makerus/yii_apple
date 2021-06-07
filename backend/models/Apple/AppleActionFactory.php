<?php


namespace backend\models\Apple;


use backend\models\Apple\Action\AppleOnTree;
use backend\models\Apple\Action\AppleToFall;

class AppleActionFactory
{
    public static function getAction(AppleRecord $apple)
    {
        switch ($apple->getStatus()) {
            case AppleStatus::STATUS_ON_TREE: return new AppleOnTree($apple);
            case AppleStatus::STATUS_FALL: return new AppleToFall($apple);
            default: return null;
        }
    }

    public static function someRandomCreate($min, $max)
    {
        $user = \Yii::$app->getUser();
        AppleRecord::deleteAll(['user_id' => $user->getId()]);

        $arr = array();

        $count = random_int($min, $max);
        for($index = 0; $index < $count; $index++) {
            $apple = new AppleRecord();
            $apple->setUserId($user->getId());
            $apple->setColor('red');
            $apple->createdOnTree();
            $apple->save();

            $arr[] = $apple;
        }

        return $arr;
    }
}