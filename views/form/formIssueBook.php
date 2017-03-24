<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 17.03.17
 * Time: 14:28
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Admin area';

$form = ActiveForm::begin([
    'id' => 'book_issue-form',
]) ?>

<table width="100%" style="border-collapse: separate; border-spacing: 15px;">
    <tr>
        <td width="50%">
            <?= $form->field($model, 'book')->dropdownList(
                $columnBook,
                [
                    'size' => '15',
                    'style' => 'height:350px'
                ]
            ) ?>
        </td>
        <td width="50%">
            <?= $form->field($model, 'client')->dropdownList(
                $columnClient,
                [
                    'size' => '15',
                    'style' => 'height:350px'
                ]
            ) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?= $form->field($model, "dateIssue")->textInput()?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?= $form->field($model, "dateReturn")->textInput()?>
        </td>
    </tr>
</table>



    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>