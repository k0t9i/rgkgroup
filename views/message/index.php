<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\grid\ActionColumn;

$this->title = 'Messages'
?>
<div class="page-header">
    <h3><?=$this->title?></h3>
</div>
<?=\yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => 'panel-body'
    ],
    'itemView' => '_message_item'
])?>