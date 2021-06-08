<?php


namespace backend\models\Apple\Factory;


use backend\models\Apple\Action\AppleOnTree;
use backend\models\Apple\Action\AppleToFall;
use backend\models\Apple\AppleRecord;
use backend\models\Apple\AppleStatus;

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
}