<div class="panel panel-<?=$model->readedAt ? 'info' : 'warning' ?>">
    <div class="panel-heading"><?= $model->title ?></div>
    <div class="panel-body"><?= $model->body ?></div>
    <div class="panel-footer clearfix">
        <span class="label label-default pull-left"><?=Yii::$app->formatter->asDateTime($model->createdAt)?></span>
        <span class="label label-primary pull-right">From: <?=$model->user ? $model->user->username : 'system'?></span>
    </div>
</div>
