<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 22.03.17
 * Time: 15:48
 */

use app\models\db\Role;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'admin-form',
]) ?>

<?php
if ($model->admin_id != null)
    echo $form->field($model, 'admin_id')->textInput(['readonly' => true]);
?>
<?= $form->field($model, 'first_name') ?>
<?= $form->field($model, 'last_name') ?>
<?= $form->field($model, 'middle_name') ?>
<?= Html::activeHiddenInput($model, 'user_id') ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password') ?>
<?= $form->field($model, 'roles')->checkboxList(Role::find()->select(['role_name', 'role_id'])->indexBy('role_id')->column()) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
