<?php


namespace backend\models\Apple;


use backend\models\Apple\Action\AppleOnTree;
use backend\models\Apple\Action\AppleToFall;

class AppleActionFactory
{
    public static function getAction(AppleRecord $apple)
    {
        switch ($apple) {
            case AppleStatus::STATUS_ON_TREE: return new AppleOnTree($apple);
            case AppleStatus::STATUS_FALL: return new AppleToFall($apple);
            default: return null;
        }
    }
}