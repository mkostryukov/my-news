<?php


namespace app\modules\notifications\traits;

use app\modules\notifications\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 */
trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return \Yii::$app->getModule('notifications');
    }
}