<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 17.03.17
 * Time: 14:29
 */

namespace app\models\forms;


use app\models\db\Journal;
use yii\base\Model;

class IssueBookForm extends Model
{
    public $book;
    public $client;
    public $dateIssue;
    public $dateReturn;

    public function rules()
    {
        return [
            [['book', 'client', 'dateIssue', 'dateReturn'], 'required'],
            [['dateIssue', 'dateReturn'], 'date'],
            [['book', 'client'], 'integer']
        ];
    }

    public function getJournalRecord($admin_id)
    {
        $record = new Journal();
        $record->admin_id = $admin_id;
        $record->client_id = $this->client;
        $record->book_id = $this->book;
        $record->date_issue = $this->dateIssue;
        $record->date_return = $this->dateReturn;

        return $record;
    }
}