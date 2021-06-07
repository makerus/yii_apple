<?php

namespace backend\models\Apple\Action;

use backend\models\Apple\AppleActionFactory;
use backend\models\Apple\AppleRecord;
use backend\models\Apple\Exception\AppleNotFallException;
use backend\models\Apple\Exception\NotRottenOnTreeException;

class AppleOnTree implements Eat, Rotten
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


    public function eat($pieceSize)
    {
        throw new AppleNotFallException();
    }

    public function rot()
    {
        throw new NotRottenOnTreeException();
    }
}