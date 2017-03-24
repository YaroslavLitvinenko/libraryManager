<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 14.03.17
 * Time: 17:00
 */

namespace app\models\forms;


use app\models\db\Book;
use yii\base\Model;
use yii\helpers\Html;

class BookForm extends Model
{
    public $book_id;
    public $code1;
    public $code2;
    public $name;
    public $year;
    public $category;
    public $authors;
    public $cell;

    public function rules()
    {
        return [
            [['book_id'], 'string'],
            [['code1', 'code2', 'name', 'year', 'category', 'authors'], 'required'],
            [['cell'], 'number']
        ];
    }

    public static function getForm(Book $book) {
        $form =  new BookForm();
        $form->book_id = $book->book_id;
        $form->code1 = $book->code1;
        $form->code2 = $book->code2;
        $form->name = $book->name;
        $form->year = $book->year;
        $form->category = $book->category;
        $form->authors = $book->authors;
        $form->cell = $book->cell;
        return $form;
    }

    public function getBook() {
        if ($this->book_id != null)
            $book = Book::findOne($this->book_id);
        else $book = new Book();

        $book->code1 = Html::encode($this->code1);
        $book->code2 = Html::encode($this->code2);
        $book->name = Html::encode($this->name);
        $book->year = Html::encode($this->year);

        return $book;
    }

}