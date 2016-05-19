<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\notification\Event;
use \yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;
use app\models\notification\channels\Channel;

$this->title = ($model->isNewRecord ? 'Create' : 'Update') . ' notfication';

$placeholders = '';
$placeholders = $this->render('_placeholders', [
    'items' => Yii::$app->notifier->getPlaceholdersKeys($model)
]);

$fieldWithPlaceholders = "{label}\n<div class=\"col-lg-7\">{input}\n<div class=\"event-placeholders\">{$placeholders}</div></div>\n<div class=\"col-lg-4\">{error}</div>";
?>
<div class="page-header">
    <h3><?=$this->title?></h3>
</div>
<?php
$form = ActiveForm::begin([
    'id' => 'notification-form',
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

<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'eventName')->dropDownList(ArrayHelper::map(Event::find()->asArray()->orderBy(['name' => SORT_ASC])->all(), 'name', 'name'), [
    'prompt' => 'Select event'
]) ?>
<?= $form->field($model, 'senderId')->dropDownList(ArrayHelper::map(User::find()->asArray()->orderBy(['username' => SORT_ASC])->all(), 'id', 'username'), [
    'prompt' => 'System'
]) ?>
<?= $form->field($model, 'recipientId')->dropDownList(ArrayHelper::map(User::find()->asArray()->orderBy(['username' => SORT_ASC])->all(), 'id', 'username'), [
    'prompt' => 'Send all'
]) ?>
<?= $form->field($model, 'channelsAttr')->checkboxList(ArrayHelper::map(Channel::find()->asArray()->orderBy(['title' => SORT_ASC])->all(), 'id', 'title')) ?>
<?= $form->field($model, 'title', [
    'template' => $fieldWithPlaceholders,
])->textInput() ?>
<?= $form->field($model, 'body', [
    'template' => $fieldWithPlaceholders,
])->textarea([
    'rows' => 5
]) ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Apply', ['class' => 'btn btn-primary', 'name' => 'apply']) ?>
        <?= Html::submitButton('Cancel', ['class' => 'btn btn-primary', 'name' => 'cancel']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs('
    $("#' . Html::getInputId($model, 'eventName') . '").on("change", function(){
        var $this = $(this);
        $.ajax({
            url: "' . Url::to(['event-placeholders']) . '?name=" + $this.val(),
            dataType: "html",
            beforeSend: function() {
                $(".event-placeholders").html("");
            },
            success: function(data) {
                $(".event-placeholders").html(data);
            }
        });
    });
');
?>
