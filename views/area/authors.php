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
        'first_name',
        'last_name',
        'middle_name',
        [
            'header' => $authorsLink,
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                return Yii::$app->urlManager->createUrl(["form/author-$action", "id" => $model->author_id]);
            }
        ]
    ]
]);
?>
