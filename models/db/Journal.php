<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 15:07
 */

namespace app\models\db;

use yii\db\ActiveRecord;

class Journal extends ActiveRecord
{
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['admin_id' => 'admin_id']);
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['client_id' => 'client_id']);
    }

    public function getBook()
    {
        return $this->hasOne(Book::className(), ['book_id' => 'book_id']);
    }
}