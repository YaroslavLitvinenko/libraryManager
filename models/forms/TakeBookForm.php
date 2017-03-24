<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 21.03.17
 * Time: 16:15
 */

namespace app\models\forms;


use yii\base\Model;

class TakeBookForm extends Model
{
    public $recordId;
    public $cell;
    public $dateFactReturn;

    public function rules()
    {
        return [
            [['dateFactReturn', 'cell'], 'required'],
            [['dateFactReturn'], 'date'],
            [['recordId', 'cell'], 'integer']
        ];
    }
}