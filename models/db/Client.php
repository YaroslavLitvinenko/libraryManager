<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 12:42
 */

namespace app\models\db;

use yii\db\ActiveRecord;

class Client extends ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }


}