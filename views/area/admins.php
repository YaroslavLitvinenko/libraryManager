<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 03.03.17
 * Time: 15:34
 */

$this->title = 'Personal Area';


use yii\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'first_name',
        'last_name',
        'middle_name',
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
                return Yii::$app->urlManager->createUrl(["form/admin-$action", "id" => $model->admin_id]);
            }
        ]
    ]
]);
?>



