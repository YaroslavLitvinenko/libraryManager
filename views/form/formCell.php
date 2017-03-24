<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 16.03.17
 * Time: 9:57
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Admin area';

$form = ActiveForm::begin([
    'id' => 'cell-form',
]) ?>

<?php
if ($model->cell_id != null)
    echo $form->field($model, 'cell_id')->textInput(['readonly' => true]);
?>
<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'book')->dropdownList($column, ['prompt'=>'Empty']) ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>

