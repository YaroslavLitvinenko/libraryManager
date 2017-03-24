<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'author-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<?php
    if ($model->author_id != null)
        echo $form->field($model, 'author_id')->textInput(['readonly' => true]);
?>
<?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'last_name') ?>
<?= $form->field($model, 'middle_name') ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
