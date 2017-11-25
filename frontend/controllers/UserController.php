<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 14:37
 */
namespace frontend\controllers;


use frontend\prototypes\RestControllerPrototype;

class UserController extends RestControllerPrototype
{
    public $modelClass = 'common\models\User';
}