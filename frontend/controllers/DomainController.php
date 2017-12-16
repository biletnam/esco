<?php

namespace frontend\controllers;
use frontend\prototypes\RestControllerPrototype;

/**
 * Class DomainController
 * @package frontend\controllers
 */
class DomainController extends RestControllerPrototype
{
    public $modelClass = 'common\models\Domain';
}