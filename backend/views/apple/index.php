<?php

/* @var $this yii\web\View */

/* @var $data array */

use backend\assets\AppAsset;
use backend\helpers\FormGeneration;
use backend\models\Apple\AppleStatus;
use yii\data\ArrayDataProvider;

$this->title = 'Яблочки, яблочки...';

$provider = new ArrayDataProvider([
    'allModels' => $data,
    'sort' => [
        'attributes' => ['id', 'dateCreated', 'dateFall', 'fresh']
    ],
    'pagination' => [
        'pageSize' => 5,
    ],
]);

$asset = $this->getAssetManager();
$bundle = $asset->getBundle(AppAsset::class);
$bundle->js[] = 'js/manage.js';
$bundle->publish($asset);

?>

    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12" id="alert"></div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <?= \yii\grid\GridView::widget([
                        'dataProvider' => $provider,
                        'columns' => [
                            'id',
                            'color',
                            ['attribute' => 'dateCreated', 'format' => ['date', 'php:Y-m-d']],
                            ['attribute' => 'dateFall', 'format' => ['date', 'php:Y-m-d']],

                            ['attribute' => 'status', 'content' => function($model) {
                                switch ($model->getStatus()) {
                                    case AppleStatus::STATUS_ON_TREE: return 'На дереве';
                                    case AppleStatus::STATUS_FALL: return 'На земле';
                                    default: return 'У хацкера в руках!';
                                }
                            }],

                            ['attribute' => 'size', 'content' => function($model) {
                                 if ($model->getSize() === 1.0) {
                                     return 'Целое';
                                }
                                 return $model->getSize() . '%';
                            }],

                            ['attribute' => 'fresh', 'format' => 'boolean'],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{take}',
                                'buttons' => [
                                    'take' => function ($url, $model) {
                                        return FormGeneration::getFormAppleTake($model);
                                    }
                                ]
                            ]
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <button class='btn btn-primary btn-block' onclick="shakeTree()">Потрясти дерево</button>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <button class='btn btn-primary btn-block' onclick="generateApples()">Генерировать яблочки</button>
                </div>
            </div>
        </div>
    </div>