<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 14.03.17
 * Time: 13:43
 */

$this->title = 'Personal Area';

use yii\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        [
            'attribute' => 'Book',
            'content' => function ($model, $key, $index, $column) {
                return $model->book != null ? $model->book->name : "<font color='green'>Empty</font>";
            },
        ],
        [
            'header' => $newLink,
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                return Yii::$app->urlManager->createUrl(["form/cell-$action", "id" => $model->cell_id]);
            }
        ]
    ]
]);
?>
