<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 14:37
 */
namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\web\Response;

class RestController extends ActiveController
{
    public function behaviors()
    {
        $urlData = parse_url(\Yii::$app->request->getUrl());

        if (isset($urlData['query'])) {
            parse_str($urlData['query'], $queryParams);
            \Yii::$app->request->bodyParams = $queryParams;
        }
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }
}