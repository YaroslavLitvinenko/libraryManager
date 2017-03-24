<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 23.03.17
 * Time: 14:11
 */
use yii\grid\GridView;


$this->title = 'Personal Area';
?>

<h1><?= "Hello $client->last_name $client->first_name" ?></h1>

<div style="margin-left: 40px; margin-top: 50px">
    <?php if($debtBook != null) {?>
        <h2>Book for return:</h2>
        <div class="alert alert-danger" style="margin-left: 40px">
            <table width="100%">
                <?php
                foreach ($debtBook as $record) {
                    $book = $record->book;
                    echo "<tr><td width='60%'>[$book->code1][$book->code2] $book->name</td>" .
                        "<td width='20%'>$record->date_issue</td>" .
                        "<td width='20%'>Return to: $record->date_return</td></tr>";
                }
                ?>
            </table>
        </div>
    <?php }?>


    <div style="margin-top: 50px">
        <h2>History:</h2>
        <div style="margin-left: 40px">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Here you will see all the books you took',
                'columns' => [
                    [
                        'label' => 'Book',
                        'value' => function ($data) {
                            $book = $data->book;
                            return "[$book->code1][$book->code2] $book->name";
                        },
                    ],
                    [
                        'label' => 'Date issue',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asDate($data->date_issue, 'long');
                        },
                    ],
                    [
                        'label' => 'Date return',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asDate($data->date_fact_return, 'long');
                        },
                    ],
                ]
            ]);
            ?>
    </div>
</div>
