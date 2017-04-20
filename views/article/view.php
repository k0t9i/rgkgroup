<?php
$this->title = $model->title;
?>
    <div class="page-header">
        <h3><?=$this->title?></h3>
    </div>
    <div class="panel-body">
        <?=nl2br($model->body)?>
    </div>
<?php