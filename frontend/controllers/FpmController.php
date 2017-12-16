<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:45
 */

namespace frontend\controllers;

use frontend\prototypes\ServiceControllerPrototype;

class FpmController extends ServiceControllerPrototype {

    protected function getPath()
    {
        return '/var/esco/fpm';
    }

    protected function getTemplate()
    {

    }

    protected function getServiceName()
    {
        return 'php-fpm';
    }
}