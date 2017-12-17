<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:45
 */

namespace frontend\controllers;

use common\helpers\ShellHelper;
use frontend\prototypes\ServiceControllerPrototype;

class FpmController extends ServiceControllerPrototype {

    protected function getPath()
    {
        return \Yii::$app->params['fpmConfigPath'];
    }

    protected function getTemplate()
    {

    }

    protected function getServiceName()
    {
        return 'php5-fpm';
    }

    public function actionReloadConfig()
    {
        ShellHelper::execute("service {$this->getServiceName()} reload");
    }
}