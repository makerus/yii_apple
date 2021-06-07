<?php

namespace backend\controllers;

use backend\models\Apple\AppleActionFactory;
use backend\models\Apple\AppleRecord;
use backend\models\Apple\Exception\AppleEatenException;
use backend\models\Apple\Exception\ToBigPieceException;
use backend\models\Apple\Exception\ToRottenException;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AppleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['generate', 'eat-apple', 'shake-tree', 'index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'generate' => ['post'],
                    'eat-apple' => ['post'],
                    'shake-tree' => ['post'],
                    'index' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('form');
    }

    public function actionGenerate()
    {
        try {
            $min = random_int(5, 7);
            $max = random_int(10, 15);
        } catch (\Exception $exception) {
            return $this->asJson(['error' => 'Что-то пошло не так... Сожалеем о случившимся.']);
        }

        $apples = count(AppleActionFactory::someRandomCreate($min, $max));
        return $this->asJson(['success' => 'Успешно сгенерировано ' . $apples . ' яблок']);
    }

    public function actionShakeTree()
    {
        $user = \Yii::$app->getUser();

        $apples = AppleRecord::findAll(['user_id' => $user->getId(), 'fresh' => true, 'dateFall' => 0]);
        shuffle($apples);
        $someElement = array_chunk($apples, random_int(3, 5));

        if ($someElement) {
            foreach ($someElement[0] as $apple) {
                /** @var AppleRecord $apple */
                $apple->rot();
            }

            return $this->asJson(['fallApples' => count($someElement[0])]);
        } else {
            return $this->asJson(['error' => 'Яблоки, к сожалению закончились. Нужно вырастить новые...']);
        }
    }

    public function actionEatApple()
    {
        if ($this->request->get('apple_id', false) and $this->request->get('size', false)) {
            $appleId = $this->request->get('apple_id');
            $pieceSize = $this->request->get('size');

            /** @var AppleRecord $apple */
            $apple = AppleRecord::findOne(['id' => $appleId]);

            if($apple) {
                try {
                    $apple->eat($pieceSize);
                    return $this->asJson(['success' => 'Вы откусили ' . $pieceSize . ', у вас осталось: ' . $apple->getSize() . '% яблока']);
                } catch (ToBigPieceException | ToRottenException | AppleEatenException $exception) {
                    return $this->asJson(['error' => $exception->getMessage()]);
                }
            }

            return $this->asJson(['error' => 'Это яблочко не было найдено, возможно введены некорректные данные']);
        } else {
            return $this->asJson(['error' => 'Что-то пошло не так, отсутствуют необходимые параметры.']);
        }
    }
}