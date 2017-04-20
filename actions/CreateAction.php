<?php

namespace app\actions;

/**
 * Class CreateAction
 *
 * @package app\actions
 */
class CreateAction extends UpdateAction
{
    /**
     * Run action
     *
     * @param null $id
     * @param null $returnUrl
     * @return array|string
     */
    public function run($id = null, $returnUrl = null)
    {
        return $this->processForm(null, $returnUrl);
    }
}
