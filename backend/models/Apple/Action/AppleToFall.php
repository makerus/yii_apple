<?php

namespace backend\models\Apple\Action;

use backend\models\Apple\AppleRecord;

class AppleToFall implements Eat
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

    public function eat($pieceSize)
    {
        $this->apple->eat($pieceSize);
        $this->apple->save();
    }

    public function throwRot()
    {
        if ($this->apple->getTimeExpires() <= 0) {
            $this->apple->rot();
        }
    }
}