<?php

namespace app\actions;

/**
 * Class DeleteAction
 *
 * @package app\actions
 */
class DeleteAction extends Action
{
    /**
     * Run action
     *
     * @param integer $id
     * @param null|string $returnUrl
     * @return \yii\web\Response
     */
    public function run($id, $returnUrl = null)
    {
        $this->getModel($id)->delete();

        return $this->goBack($returnUrl);
    }
}
