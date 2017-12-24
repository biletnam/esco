<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 03.12.2017
 * Time: 17:44
 */
namespace common\exceptions;

use yii\web\ErrorHandler;
use yii\web\Response;

/**
 * Class RestException
 * @package common\exceptions
 */
class RestException extends ErrorHandler {

    /**
     * @param \Error|\Exception $exception
     */
    protected function renderException($exception)
    {
        if (\Yii::$app->has('response')) {
            $response = \Yii::$app->getResponse();
        } else {
            $response = new Response();
        }

        $response->data = [
            'status' => 'error',
            'data' => [
                'message' => $exception->getMessage()
            ]
        ];

        $response->send();
    }
}
