<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 09.03.17
 * Time: 13:01
 */

namespace app\models\db;


use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['book_id' => 'book_id'])
            ->viaTable('book_author', ['author_id' => 'author_id']);
    }
}