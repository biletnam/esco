<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:45
 */

namespace frontend\controllers;

use frontend\prototypes\ServiceControllerPrototype;

class NginxController extends ServiceControllerPrototype {

    protected function getPath()
    {
        return '/var/esco/nginx';
    }

    protected function getTemplate()
    {

    }

    protected function getServiceName()
    {
        return 'nginx';
    }

    public function actionStopService()
    {
        // тестируем валидность конфига
        exec("sudo " . $this->getServiceName() . " -t 2>&1", $output);

        //TODO останавливаем если все норм
        parent::actionStopService();
    }
}