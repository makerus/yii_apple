<?php


namespace backend\models\Apple\Factory;

use backend\models\Apple\AppleRecord;
use yii\web\User;

class AppleFactory
{
    /**
     * @throws \Exception
     */
    public static function someRandomCreate(User $user, $min, $max)
    {
        AppleRecord::deleteAll(['user_id' => $user->getId()]);

        $arr = array();

        $count = random_int($min, $max);

        for($index = 0; $index < $count; $index++) {
            $colors = AppleRecord::getColorSet();

            $randomColorIndex = random_int(0, count($colors) - 1);

            $apple = new AppleRecord();
            $apple->growOnTree($user->getId(), $colors[$randomColorIndex]);
            $apple->save();

            $arr[] = $apple;
        }

        return $arr;
    }
}