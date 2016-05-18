<?php

namespace app\actions;

class DeleteAction extends Action
{
    public $defaultRedirect = ['index'];

    public function run($id, $returnUrl = null)
    {
        $this->getModel($id)->delete();

        return $this->goBack($returnUrl);
    }
}