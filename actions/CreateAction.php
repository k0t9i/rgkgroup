<?php

namespace app\actions;

class CreateAction extends UpdateAction
{
    public function run($id = null, $returnUrl = null)
    {
        return $this->processForm(null, $returnUrl);
    }
}