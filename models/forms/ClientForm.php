<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 12:52
 */

namespace app\models\forms;


use app\models\db\Client;
use app\models\db\Role;
use app\models\db\User;
use yii\base\Model;

class ClientForm extends Model
{
    public $client_id;
    public $first_name;
    public $last_name;
    public $adds;
    public $passport_id;
    public $phone;
    public $user_id;
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'adds', 'passport_id', 'phone', 'username', 'password'], 'required'],
            [['first_name', 'last_name', 'passport_id', 'phone', 'username', 'password'], 'string'],
            [['user_id', 'client_id'], 'integer'],
            [['adds'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    public static function getForm(Client $client)
    {
        $form = new ClientForm();
        $form->client_id = $client->client_id;
        $form->first_name = $client->first_name;
        $form->last_name = $client->last_name;
        $form->adds = $client->adds;
        $form->passport_id = $client->passport_id;
        $form->phone = $client->phone;
        $form->user_id = $client->user_id;
        if ($client->user != null) {
            $form->username = $client->user->username;
            $form->password = $client->user->password;
        }

        return $form;
    }

    public function getClient() {
        if ($this->client_id != null)
            $client = Client::findOne($this->client_id);
        else $client = new Client();
        $client->first_name = $this->first_name;
        $client->last_name = $this->last_name;
        $client->adds = $this->adds;
        $client->passport_id = $this->passport_id;
        $client->phone = $this->phone;
        $client->user_id = $this->user_id;

        return $client;
    }

    public function getUser() {
        if ($this->user_id != null)
            $user = User::findOne($this->user_id);
        else $user = new User();
        $user->username = $this->username;
        $user->password = $this->password;

        return $user;
    }
}