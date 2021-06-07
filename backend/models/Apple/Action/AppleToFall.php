<?php

namespace backend\models\Apple\Action;

use backend\models\Apple\AppleRecord;

class AppleToFall
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

    public function getTimeExpires()
    {
        $end = $this->apple->getDateFall() + (3600 * 5);
        return $end - $this->apple->getDateFall();
    }

    public function eat($sizePiece)
    {
        $this->apple->eat($sizePiece);
        $this->apple->save();
    }

    public function isFresh()
    {
        return $this->apple->isFresh();
    }
}