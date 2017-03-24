<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 14.03.17
 * Time: 17:10
 */
use app\models\db\Category;
use app\models\db\Author;
use app\models\db\Cell;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'book-form',
]) ?>
<table width="100%" style="border-collapse: separate; border-spacing: 15px;">
    <tr>
        <td width="50%">
            <?php
            if ($model->book_id != null)
                echo $form->field($model, 'book_id')->textInput(['readonly' => true]);
            ?>
            <?= $form->field($model, 'code1')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'code2') ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'year') ?>
            <?= $form->field($model, 'category')->textInput(['list' => 'categoryes']) ?>
            <datalist id="categoryes">
                <?php
                $categoryes = Category::find()->all();
                foreach ($categoryes as $category)
                    echo "<option value='$category->name'>"
                ?>
            </datalist>
            <?php
            if ($model->book_id == null || ($model->book_id != null && $model->cell != null)) {
                echo $form->field($model, 'cell')->dropdownList(
                    Cell::find()->select(['name', 'cell_id'])->where(['book_id' => null])
                        ->orWhere(['book_id' => $model->book_id])->indexBy('cell_id')->column()
                );
            } else {
                echo $form->field($model, 'cell')->dropdownList(['On hand'], ['disabled' => true]);
            }

            ?>

        </td>
        <td width="50%" >
            <?= $form->field($model, 'authors')->dropdownList(
                Author::find()->select(["concat(last_name, ' ', first_name)", 'author_id'])->indexBy('author_id')->column(),
                [
                    'multiple' => 'multiple',
                    'size' => '27'
                ]
            ) ?>
        </td>
    </tr>
</table>



<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>

