<?php

/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 22.03.17
 * Time: 11:06
 */
use yii\helpers\Html;

function getHtmlField($field, $record, $label) {
    $id = getClassName($record) . "." . $field;

    $html = "<tr><td width='120px'>";
    $html .= Html::label($label, $id) . "</td><td>";
    $html .= Html::textInput('record_id', $record->$field, [
        'class' => 'form-control',
        'id' => $id,
        'readonly' => 'true'
    ]) . "</td></tr>";

    return $html;
}

function getClassName($record) {
    $str = get_class($record); //  получаем имя текущего класса
    $temp = explode('\\', $str); //  разделяем строку по символу "\"
    return end($temp);
}


?>

<table width="400px">
<?=  getHtmlField('record_id', $record, "Record ID:")?>
<?=  getHtmlField('date_issue', $record, "Date issue:")?>
<?=  getHtmlField('date_return', $record, "Date return:")?>
<?=  getHtmlField('date_fact_return', $record, "Date fact return:")?>
</table>

<h2>Book</h2>
<table width="400px">
<?=  getHtmlField('book_id', $record->book, "Book ID:")?>
<?=  getHtmlField('code1', $record->book, "Code #1:")?>
<?=  getHtmlField('code2', $record->book, "Code #2:")?>
<?=  getHtmlField('name', $record->book, "Name")?>
<?=  getHtmlField('year', $record->book, "Year:")?>
</table>

<h2>Client</h2>
<table width="400px">
<?=  getHtmlField('client_id', $record->client, "Client ID:") ?>
<?=  getHtmlField('first_name', $record->client, "First name:") ?>
<?=  getHtmlField('last_name', $record->client, "Last name:") ?>
<?=  getHtmlField('passport_id', $record->client, "Passport:") ?>
<?=  getHtmlField('adds', $record->client, "Adds:") ?>
<?=  getHtmlField('phone', $record->client, "Phone:") ?>
</table>

<h2>Administrator</h2>
<table width="400px">
<?=  getHtmlField('admin_id', $record->admin, "Administrator ID:") ?>
<?=  getHtmlField('first_name', $record->admin, "First name:") ?>
<?=  getHtmlField('last_name', $record->admin, "Last name:") ?>
<?=  getHtmlField('middle_name', $record->admin, "Middle name:") ?>
</table>
