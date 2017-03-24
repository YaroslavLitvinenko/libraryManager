<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 15:13
 */

$this->title = 'Personal Area';

use yii\grid\GridView;
use yii\helpers\Html;

?>

<div style="display: block; height: 25px" >
    <?= Html::a('Issue Book', ['form/issue-book'], ['class' => 'btn btn-primary', 'style' => 'float:right'])?>
    <?= Html::a('Take Book', ['form/take-book'], ['class' => 'btn btn-primary', 'style' => 'float:right'])?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'Client',
            'value' => function ($data) {
                return "[" . $data->client->passport_id . "] " .
                    $data->client->last_name . " " . $data->client->first_name;
            },
        ],
        [
            'attribute' => 'Book',
            'value' => function ($data) {
                return "[" . $data->book->code1 . "]" . " [" . $data->book->code2 . "] " . $data->book->name;
            },
        ],
        [
            'label' => 'Date Issue',
            'value' => function ($data) {
                return Yii::$app->formatter->asDate($data->date_issue, 'long');
            },
        ],
        [
            'label' => 'Date Return',
            'value' => function ($data) {
                return Yii::$app->formatter->asDate($data->date_return, 'long');
            },
        ],
        [
            'label' => 'Date Fact Return',
            'value' => function ($data) {
                return $data->date_fact_return != null ?
                    Yii::$app->formatter->asDate($data->date_fact_return, 'long') : "";
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'urlCreator' => function ($action, $model, $key, $index) {
                return Yii::$app->urlManager->createUrl(["form/record-$action", "id" => $model->record_id]);
            }
        ]
    ]
]);
?>


