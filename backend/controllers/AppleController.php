<?php

namespace backend\controllers;

use backend\models\Apple\Factory\AppleActionFactory;
use backend\models\Apple\Factory\AppleFactory;
use backend\models\Apple\AppleRecord;
use common\models\User;
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
        $user = \Yii::$app->getUser();
        $apples = AppleRecord::getFreshAndEntire($user->getId());

        // Процесс гниения
        foreach ($apples as $apple) {
            $action = AppleActionFactory::getAction($apple);

            // Если может портиться и уже сгнило, делаем соответствующую отметку
            if ($action->canRotten()) {
                $action->rot();
            }
        }

        return $this->render('index', ['data' => $apples]);
    }

    public function actionGenerate()
    {
        try {
            $min = random_int(5, 7);
            $max = random_int(10, 15);
            $apples = count(AppleFactory::someRandomCreate(\Yii::$app->getUser(), $min, $max));
            return $this->asJson(['success' => 'Успешно сгенерировано ' . $apples . ' яблок']);

        } catch (\Exception $exception) {
            return $this->asJson(['error' => 'Что-то пошло не так... Сожалеем о случившимся.']);

        }
    }

    public function actionShakeTree()
    {
            $user = \Yii::$app->getUser();

            $apples = AppleRecord::getFreshAndEntire($user->getId());
            shuffle($apples);

        try {
            $someElement = array_chunk($apples, random_int(0, floor(count($apples) / 3)));
            if ($someElement) {

                foreach ($someElement[0] as $apple) {
                    /** @var AppleRecord $apple */
                    $apple->fall();
                }

                return $this->asJson(['success' => 'Вы потрясли дерево и с него упало ' . count($someElement[0]) . ' яблока!']);

            } else {
                return $this->asJson(['error' => 'Яблоки, к сожалению закончились. Нужно вырастить новые...']);

            }
        } catch (\Exception $exception) {
            return $this->asJson(['error' => 'Что-то пошло не так... Сожалеем о случившимся.']);

        }
    }

    public function actionEatApple()
    {
        $appleId = $this->request->post('apple_id', false);
        $pieceSize = $this->request->post('size', false);

        if ($appleId !== false and $pieceSize !== false) {

            /** @var AppleRecord $apple */
            $apple = AppleRecord::findOne(['id' => $appleId]);

            if (!$apple) {
                return $this->asJson(['error' => 'Это яблочко не было найдено, возможно отправлены некорректные данные.']);
            }

            try {
                $action = AppleActionFactory::getAction($apple);
                $action->eat($pieceSize);
                return $this->asJson(['success' => 'Вы откусили ' . $pieceSize . ', у вас осталось: ' . $apple->getSize() . '% яблока']);

            } catch (\Throwable $exception) {
                return $this->asJson(['error' => $exception->getMessage()]);

            }

        }

        return $this->asJson(['error' => 'Что-то пошло не так, отсутствуют необходимые параметры.']);
    }
}