<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 9:58
 */

namespace app\models\forms;


use app\models\db\Cell;
use yii\base\Model;
use yii\helpers\Html;

class CellForm extends Model
{
    public $cell_id;
    public $name;
    public $book;

    public function rules()
    {
        return [
            [['cell_id'], 'string'],
            [['book'], 'number'],
            [['name'], 'required'],
        ];
    }

    public static function getForm(Cell $cell) {
        $form =  new CellForm();
        $form->cell_id = $cell->cell_id;
        $form->name = $cell->name;
        $form->book = $cell->book;

        return $form;
    }

    public function getCell() {
        if ($this->cell_id != null)
            $cell = Cell::findOne($this->cell_id);
        else $cell = new Cell();

        $cell->name = Html::encode($this->name);
        $cell->book_id = Html::encode($this->book);

        return $cell;
    }

}