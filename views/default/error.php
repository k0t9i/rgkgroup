<?php
use yii\helpers\Html;
$this->title = $name;
?>
<div class="page-header">
    <h3><?=$this->title?></h3>
</div>
<div class="alert alert-danger">
    <?= nl2br(Html::encode($message)) ?>
</div>