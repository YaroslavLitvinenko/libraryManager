<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 21.03.17
 * Time: 15:31
 */

use app\models\db\Cell;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Admin area';

$form = ActiveForm::begin([
    'id' => 'book_take-form',
])
?>

<?= $form->field($model, 'cell')->dropdownList(
    Cell::find()->select(['name', 'cell_id'])->where(['book_id' => null])->indexBy('cell_id')->column(),
    ['prompt'=>'Select Category']
) ?>

<?= $form->field($model, "dateFactReturn")->textInput()?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'Book',
            'value' => function ($data) {
                return "[" . $data->book->code1 . "]" . " [" . $data->book->code2 . "] " . $data->book->name;
            },
        ],
        [
            'attribute' => 'Client',
            'value' => function ($data) {
                return "[" . $data->client->passport_id . "] " .
                    $data->client->last_name . " " . $data->client->first_name;
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
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'take' => function ($url, $model, $key) {
                    return Html::button('Take', [
                        'class' => 'btn btn-default',
                        'type' => 'submit',
                        'name' => 'TakeBookForm[recordId]',
                        'value' => "$model->record_id"
                    ]);
                }
            ],
            'template' => '{take}',
        ]
    ]
]);
?>

<?php ActiveForm::end() ?>
