<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 14:37
 */
namespace frontend\prototypes;

use yii\rest\ActiveController;
use yii\web\Response;

class RestControllerPrototype extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }
}