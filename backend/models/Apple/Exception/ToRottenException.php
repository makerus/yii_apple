<?php


namespace backend\models\Apple\Exception;


use Throwable;

class ToRottenException extends \LogicException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Нельзя есть испорченное яблоко, можно получить отравление!', $code, $previous);
    }

}