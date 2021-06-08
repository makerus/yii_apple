<?php


namespace backend\helpers;


use backend\models\Apple\AppleRecord;
use yii\helpers\Html;

class FormGeneration
{
    public static function getFormAppleTake(AppleRecord $apple)
    {
        return '<div class="form-group">'
            . Html::input(
                'text',
                null,
                null,
                [
                    'placeholder' => 'Сколько хотите съесть?',
                    'class' => 'form-control',
                    'id' => $apple->id
                ]
            )
            . '</div>'
            . Html::a(
                'Съесть',
                '#',
                [
                    'onclick' => 'eatApple(' . $apple->id . ');',
                    'class' => 'btn btn-primary'
                ]
            );
    }
}