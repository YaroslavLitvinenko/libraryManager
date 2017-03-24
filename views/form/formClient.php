<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 13:22
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'client-form',
]) ?>

<?php
if ($model->client_id != null)
    echo $form->field($model, 'client_id')->textInput(['readonly' => true]);
?>
<?= $form->field($model, 'first_name') ?>
<?= $form->field($model, 'last_name') ?>
<?= $form->field($model, 'adds') ?>
<?= $form->field($model, 'phone') ?>
<?= $form->field($model, 'passport_id') ?>
<?= Html::activeHiddenInput($model, 'user_id') ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password') ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
