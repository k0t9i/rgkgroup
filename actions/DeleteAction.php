<?php

namespace app\actions;

/**
 * Class DeleteAction
 */
class DeleteAction extends Action
{
    public function run($id, $returnUrl = null)
    {
        $this->getModel($id)->delete();

        return $this->goBack($returnUrl);
    }
}