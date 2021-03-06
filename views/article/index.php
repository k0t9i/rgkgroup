<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\ActionColumn;

$this->title = 'Articles'
?>
<div class="page-header">
    <h3><?=$this->title?></h3>
</div>
<div class="panel-body">
    <a href="<?=Url::to(['create', 'returnUrl' => $returnUrl])?>" class="btn btn-primary">Create article</a>
</div>
<?php Pjax::begin(['timeout' => 20000]); ?>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'class' => 'panel-body'
    ],
    'tableOptions' => [
        'class' => 'table'
    ],
    'columns' => [
        [
            'class' => \yii\grid\SerialColumn::className()
        ],
        'title',
        [
            'attribute' => 'createdAt',
            'format' => 'datetime',
            'headerOptions' => [
                'style' => 'width:200px;'
            ]
        ],
        [
            'attribute' => 'updatedAt',
            'format' => 'datetime',
            'headerOptions' => [
                'style' => 'width:200px;'
            ]
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update}{delete}',
            'contentOptions' => [
                'class' => 'action-column'
            ],
            'visibleButtons' => [
                'update' => Yii::$app->user->can('article.update'),
                'delete' => Yii::$app->user->can('article.delete')
            ],
            'headerOptions' => [
                'style' => 'width:100px;'
            ],
            'urlCreator' => function ($action, $model, $key) use ($returnUrl) {
                $params = is_array($key) ? $key : ['id' => (string) $key];
                $params[0] = $this->context ? $this->context->id . '/' . $action : $action;
                $params['returnUrl'] = $returnUrl;

                return Url::toRoute($params);
            }
        ]
    ]
])?>
<?php Pjax::end(); ?>
