<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 14.03.17
 * Time: 12:14
 */

namespace app\models\db;


use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['author_id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'book_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    public function getCell() {
        return $this->hasOne(Cell::className(), ['book_id' => 'book_id']);
    }
}