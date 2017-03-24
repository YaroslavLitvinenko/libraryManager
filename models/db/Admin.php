<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 15:07
 */

namespace app\models\db;

use yii\db\ActiveRecord;

class Admin extends ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}