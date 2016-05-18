<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = ($model->isNewRecord ? 'Create' : 'Update') . ' article';
?>
<div class="page-header">
    <h3><?=$this->title?></h3>
</div>
<?php
$form = ActiveForm::begin([
    'id' => 'user-form',
    'options' => ['class' => 'form-horizontal'],
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'validateOnChange' => false,
    'validateOnBlur' => false,
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]); ?>

<?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'body')->textarea([
    'rows' => 5
]) ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Применить', ['class' => 'btn btn-primary', 'name' => 'apply']) ?>
        <?= Html::submitButton('Отмена', ['class' => 'btn btn-primary', 'name' => 'cancel']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>