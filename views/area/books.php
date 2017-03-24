<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 03.03.17
 * Time: 15:34
 */

$this->title = 'Personal Area';

use app\models\db\Cell;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'code1',
        'code2',
        'name',
        'year',
        [
            'attribute' => 'Category',
            'value' => function ($data) {
                return $data->category->name;
            },
        ],
        [
            'header' => $authorsLink,
            'value' => function ($data) {
                $authors = "";
                foreach ($data->authors as $author) {
                    $authors .= "$author->last_name " . $author->first_name{0} . ".";
                    if ($author->middle_name != null)
                        $authors.= $author->middle_name{0} . ".";
                    $authors .= ", ";
                }
                $authors = substr($authors, 0, -2);
                return $authors;
            },
        ],
        [
            'header' => $cellsLink,
            'content' => function ($model, $key, $index, $column) {
                $cell = Cell::findOne(['book_id' => $model->book_id]);
                return $cell != null ? $cell->name : "<font color='red'>On hand</font>";
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => $newLink,
            'template' => '{update} {delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                return Yii::$app->urlManager->createUrl(["form/book-$action", "id" => $model->book_id]);
            }
        ]
    ]
]);
?>


