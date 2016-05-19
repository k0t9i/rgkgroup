<?php

namespace app\actions;

/**
 * Class CreateAction
 */
class CreateAction extends UpdateAction
{
    public function run($id = null, $returnUrl = null)
    {
        return $this->processForm(null, $returnUrl);
    }
}