<?php


namespace backend\models\Apple\Exception;


use Throwable;

class BigPieceException extends \InvalidArgumentException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Вы пытаетесь съесть слишком большой кусочек. Размер яблока меньше, чем ваши аппетиты!', $code, $previous);
    }

}