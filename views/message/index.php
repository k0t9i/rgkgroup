<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Messages'
?>
<div class="page-header">
    <h3><?=$this->title?></h3>
</div>

<?php Pjax::begin(['timeout' => 20000]); ?>
    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'panel-body'
        ],
        'itemView' => function($model) use ($returnUrl){
            return $this->render('_message_item', [
                'model' => $model,
                'returnUrl' => $returnUrl
            ]);
        }
    ])?>
<?php Pjax::end() ?>
