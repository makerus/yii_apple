<?php

namespace backend\models\Apple;

use backend\models\Apple\Exception\AppleNotExistException;
use backend\models\Apple\Exception\AppleNotFallException;
use backend\models\Apple\Exception\BigPieceException;
use backend\models\Apple\Exception\AppleRottenException;
use yii\db\ActiveRecord;
use yii\helpers\Html;

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
    public static function tableName()
    {
        return 'apple';
    }

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
        $this->status = AppleStatus::STATUS_FALL;
        $this->dateFall = time();
        $this->save();
    }

    public function rot()
    {
        $this->fresh = false;
        $this->save();
    }

    public function growOnTree($userId, $color)
    {
        $this->dateFall = 0;
        $this->dateCreated = time();
        $this->fresh = true;
        $this->user_id = $userId;
        $this->status = AppleStatus::STATUS_ON_TREE;
        $this->size = 100;
        $this->color = $color;
    }

    public function eat($pieceSize)
    {
        if ($this->size === 0) {
            throw new AppleNotExistException();
        }

        if ($this->size - $pieceSize < 0) {
            throw new BigPieceException();
        }

        if (!$this->isFresh()) {
            throw new AppleRottenException();
        }

        $this->size -= $pieceSize;
        $this->save();

    }

    public function getTimeExpires()
    {
        $end = $this->getDateFall() + (3600 * 5);
        return $end - time();
    }


    public static function getFreshAndEntire($userId)
    {
        return AppleRecord::find()->where('user_id = ' . $userId)
            ->andWhere('fresh = true')
            ->andWhere('size > 0')
            ->all();
    }

    public static function getColorSet(): array
    {
        return [
            'красное',
            'красно-зеленое',
            'зеленоватое',
            'изумрудное',
            'рубиновое',
            'розовое',
            'белое',
            'бело-розовое'
        ];
    }
}