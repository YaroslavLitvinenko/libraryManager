<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 14.03.17
 * Time: 12:17
 */

namespace app\models\db;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['category_id' => 'category_id']);
    }
}