<div class="panel panel-<?=$model->readedAt ? 'info' : 'danger' ?>">
    <div class="panel-heading clearfix">
        <span class="pull-left"><?= $model->title ?></span>
        <?php if (!$model->readedAt) : ?>
            <span class="pull-right">
                <a href="<?=\yii\helpers\Url::to(['read', 'id' => $model->id, 'returnUrl' => $returnUrl])?>">
                    <i class="glyphicon glyphicon-eye-open" data-pjax="0"></i>
                </a>
            </span>
        <?php endif ?>
    </div>
    <div class="panel-body"><?= nl2br($model->body) ?></div>
    <div class="panel-footer clearfix">
        <span class="label label-default pull-left"><?=Yii::$app->formatter->asDateTime($model->createdAt)?></span>
        <span class="label label-primary pull-right">
            From: <?=$model->sender ? $model->sender->username : 'system'?>
        </span>
    </div>
</div>
