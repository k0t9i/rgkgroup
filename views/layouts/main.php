<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

\app\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body<?=Yii::$app->user->isGuest ? ' class="auth-page"': ''?>>
    <?php $this->beginBody() ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header pull-left">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/">rgk-group</a>
                    </div>
                    <div class="collapse navbar-collapse pull-left" id="main-menu">
                        <?=Menu::widget([
                            'items' => [
                                [
                                    'label' => 'Messages',
                                    'url' => ['/message'],
                                    'active' => Yii::$app->controller->id == 'message'
                                ],
                                [
                                    'label' => 'Articles',
                                    'url' => ['/article'],
                                    'visible' => Yii::$app->user->can('article.viewList'),
                                    'active' => Yii::$app->controller->id == 'article'
                                ],
                                [
                                    'label' => 'Notifications',
                                    'url' => ['/notification'],
                                    'visible' => Yii::$app->user->can('notification.viewList'),
                                    'active' => Yii::$app->controller->id == 'notification'
                                ]
                            ],
                            'options' => [
                                'class' => 'nav navbar-nav'
                            ]
                        ])?>
                    </div>
                    <p class="navbar-text pull-right">Hello, <?=Yii::$app->user->identity->username?>! <a href="<?=Url::to(['default/logout'])?>" class="navbar-link">Logout</a></p>
                </div>
            </nav>
        <?php endif ?>
        <div class="main-container container">
            <?=$content?>
        </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>