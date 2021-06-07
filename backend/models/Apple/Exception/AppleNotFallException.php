<?php


namespace backend\models\Apple\Exception;


use Throwable;

class AppleNotFallException extends \LogicException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Нельзя кушать яблоко прямо с дерева!', $code, $previous);
    }

}