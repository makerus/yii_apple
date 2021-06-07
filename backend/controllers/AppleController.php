<?php

namespace backend\controllers;

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
                        'actions' => ['generate', 'eatApple', 'shakeTree', 'index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'generate' => ['post'],
                    'eatApple' => ['post'],
                    'shakeTree' => ['post'],
                    'index' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', ['data' => [1, 2, 3]]);
    }
}