<?php


namespace backend\models\Apple\Exception;


use Throwable;

class AppleNotRottenOnTreeException extends \LogicException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Яблоко не гниет на дереве!', $code, $previous);
    }

}