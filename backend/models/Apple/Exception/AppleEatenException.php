<?php


namespace backend\models\Apple\Exception;


use Throwable;

class AppleEatenException extends \LogicException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Вы пытаетесь укусить яблочко, которое уже съели, задумайтесь об этом...', $code, $previous);
    }

}