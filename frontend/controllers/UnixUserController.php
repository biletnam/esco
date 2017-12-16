<?php

namespace frontend\controllers;
use frontend\prototypes\RestControllerPrototype;

/**
 * Class UnixUserController
 * @package frontend\controllers
 */
class UnixUserController extends RestControllerPrototype
{
    public $modelClass = 'common\models\UnixUser';
}