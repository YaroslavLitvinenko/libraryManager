<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 14.03.17
 * Time: 13:25
 */

namespace app\models\db;


use yii\db\ActiveRecord;

class Cell extends ActiveRecord
{
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['book_id' => 'book_id']);
    }
}