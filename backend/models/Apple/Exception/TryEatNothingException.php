<?php


namespace backend\models\Apple\Exception;


use Throwable;

class TryEatNothingException extends \LogicException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct("Вы съели... хм.. ничего не съели, вы на диете? Введите корректное значение (число больше 0)!", $code, $previous);
    }

}