<?php

/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 12:45
 */
use yii\grid\GridView;


$this->title = 'Personal Area';
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'first_name',
        'last_name',
        'adds',
        'passport_id',
        'phone',
        [
            'label' => 'Username',
            'value' => function ($data) {
                return $data->user->username;
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => $newLink,
            'template' => '{update} {delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                return Yii::$app->urlManager->createUrl(["form/client-$action", "id" => $model->client_id]);
            }
        ]
    ]
]);
?>