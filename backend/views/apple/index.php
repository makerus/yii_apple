<?php

/* @var $this yii\web\View */

/* @var $data array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Яблочки, яблочки';

$provider = new \yii\data\ArrayDataProvider([
    'allModels' => $data,
    'sort' => [
        'attributes' => ['id', 'dateCreated', 'dateFall', 'fresh']
    ],
    'pagination' => [
        'pageSize' => 5,
    ],
]);

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
                            ['attribute' => 'status', 'content' => function($data) {
                                switch ($data->getStatus()) {
                                    case \backend\models\Apple\AppleStatus::STATUS_ON_TREE: return 'On tree';
                                    case \backend\models\Apple\AppleStatus::STATUS_FALL: return 'On ground';
                                    default: return 'nowhere';
                                }
                            }],
                            'size',
                            ['attribute' => 'fresh', 'format' => 'boolean'],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{eat}',
                                'buttons' => [
                                    'eat' => function ($url, $model, $key) {
                                        return '<div class="form-group">' . Html::input('text', null, null, ['placeholder' => 'Сколько хотите съесть?', 'class'=>'form-control', 'id' => $model->id]) . '</div>' . Html::a('Съесть', '#', ['onclick' => 'eatApple(' . $model->id . ');', 'class' => 'btn btn-primary']);
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

<?php

$asset = $this->getAssetManager();
$bundle = $asset->getBundle(\backend\assets\AppAsset::class);
$bundle->js[] = 'js/manage.js';
$bundle->publish($asset);