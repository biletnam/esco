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

class RestException extends ErrorHandler {

    public $message = null;

    public $status = null;

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

        $response->data = $this->convertExceptionToArray($exception);
        $response->setStatusCode($exception->statusCode);

        $response->send();
    }

    /**
     * @param \Error|\Exception $exception
     * @return array
     */
    protected function convertExceptionToArray($exception)
    {
        var_dump($exception);
        exit;
        return [
            'meta'=>
                [
                    'status'=>'error',
                    'errors'=>[
                        ['message'=>$exception->getName(),'code'=>$exception->statusCode]
                    ]
                ]
        ];
    }

}