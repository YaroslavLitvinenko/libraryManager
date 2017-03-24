<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 22.03.17
 * Time: 15:39
 */

namespace app\models\forms;


use app\models\db\Admin;
use app\models\db\User;
use yii\base\Model;

class AdminForm extends Model
{
    public $admin_id;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $user_id;
    public $username;
    public $password;

    public $roles;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'middle_name', 'username', 'password', 'roles'], 'required'],
            [['first_name', 'last_name', 'middle_name', 'username', 'password'], 'string'],
            [['user_id', 'admin_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    public static function getForm(Admin $admin)
    {
        $form = new AdminForm();
        $form->admin_id = $admin->admin_id;
        $form->first_name = $admin->first_name;
        $form->last_name = $admin->last_name;
        $form->middle_name = $admin->middle_name;
        $form->user_id = $admin->user_id;
        if ($admin->user != null) {
            $form->username = $admin->user->username;
            $form->password = $admin->user->password;

            $form->roles = $admin->user->roles;
        }

        return $form;
    }

    public function getAdmin() {
        if ($this->admin_id != null)
            $admin = Admin::findOne($this->admin_id);
        else $admin = new Admin();

        $admin->first_name = $this->first_name;
        $admin->last_name = $this->last_name;
        $admin->middle_name = $this->middle_name;
        $admin->user_id = $this->user_id;

        return $admin;
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