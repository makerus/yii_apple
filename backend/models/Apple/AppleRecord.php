<?php

namespace backend\models\Apple;

use backend\models\Apple\Exception\ToBigPieceException;
use backend\models\Apple\Exception\ToRottenException;
use yii\db\ActiveRecord;

/**
 * Class AppleRecord
 * @package backend\models\Apple
 * @property integer $id
 * @property integer $user_id
 * @property string $color
 * @property integer $dateCreated
 * @property integer $dateFall
 * @property integer $status
 * @property integer $size
 * @property bool $fresh
 */

class AppleRecord extends ActiveRecord
{

    public function getColor()
    {
        return $this->color;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function getDateFall()
    {
        return $this->dateFall;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getSize(): float
    {
        return $this->size / 100;
    }

    public function isFresh()
    {
        return $this->fresh;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function fall()
    {
        $this->setStatus(AppleStatus::STATUS_FALL);
        $this->dateFall = time();
    }

    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    public function setColor(string $color)
    {
        $this->color = $color;
    }

    public function rot()
    {
        $this->fresh = false;
    }

    public function createdOnTree()
    {
        $this->dateFall = 0;
        $this->dateCreated = time();
        $this->fresh = true;
        $this->setStatus(AppleStatus::STATUS_ON_TREE);
        $this->size = 100;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function eat($sizePeace)
    {
        if ($this->size - $sizePeace < 0) {
            throw new ToBigPieceException();
        }

        if ($this->isFresh()) {
            $this->size -= $sizePeace;
        }

        throw new ToRottenException();

    }

    public function randomCountCreate($min, $max)
    {
        $user = \Yii::$app->getUser();
        $this::deleteAll(['user_id' => $user->getId()]);

        $count = random_int($min, $max);
        for($index = 0; $index > $count; $index++) {
            $apple = new self();
            $apple->setColor('red');
            $apple->createdOnTree();
            $apple->save();
        }
    }


}