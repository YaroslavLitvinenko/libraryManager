<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 09.03.17
 * Time: 18:37
 */

namespace app\models\forms;


use app\models\db\Author;
use yii\base\Model;
use yii\helpers\Html;

class AuthorForm extends Model
{
    public $author_id;
    public $first_name;
    public $last_name;
    public $middle_name;

    public function rules()
    {
        return [
            [['author_id', 'middle_name'], 'string'],
            [['first_name', 'last_name'], 'required'],
        ];
    }

    public static function getForm(Author $author) {
        $form = new AuthorForm();
        $form->author_id = $author->author_id;
        $form->first_name = $author->first_name;
        $form->last_name = $author->last_name;
        $form->middle_name = $author->middle_name;

        return $form;
    }

    public function getAuthor() {
        if ($this->author_id != null)
            $author = Author::findOne($this->author_id);
        else $author = new Author();

        $author->first_name = Html::encode($this->first_name);
        $author->last_name =  Html::encode($this->last_name);
        $author->middle_name =  Html::encode($this->middle_name);

        return $author;
    }
}