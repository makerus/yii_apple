<?php

namespace backend\models\Apple\Action;

use backend\models\Apple\AppleActionFactory;
use backend\models\Apple\AppleRecord;

class AppleOnTree
{
    protected $apple;

    /**
     * AppleOnTree constructor.
     * @param AppleRecord $apple
     */
    public function __construct(AppleRecord $apple)
    {
        $this->apple = $apple;
    }

    public function shakeTree(): AppleToFall
    {
        $this->apple->fall();
        $this->apple->save();

        return AppleActionFactory::getAction($this->apple);
    }


}