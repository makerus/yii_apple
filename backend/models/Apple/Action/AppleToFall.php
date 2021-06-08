<?php

namespace backend\models\Apple\Action;

use backend\models\Apple\AppleRecord;
use backend\models\Apple\Exception\TryEatNothingException;

class AppleToFall implements Eat, Rotten
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
        if (intval($pieceSize) === 0) {
            throw new TryEatNothingException();
        }
        $this->apple->eat($pieceSize);
        $this->apple->save();
    }

    public function rot()
    {
        $this->apple->rot();
    }

    public function canRotten()
    {
        return $this->apple->getTimeExpires() <= 0;
    }
}