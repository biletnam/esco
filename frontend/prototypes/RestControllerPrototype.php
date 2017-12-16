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
    /**
     * Статус выполнения команды
     *
     * @var string
     */
    private $status = 'success';

    /**
     * Установка статуса
     *
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Получение статуса
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
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

    /**
     * @param string $id
     * @param array $params
     * @return mixed
     */
    public function runAction($id, $params = [])
    {
        try {
            $out['data'] = parent::runAction($id, $params);
        } catch (\Exception $e) {
            $this->setStatus('error');
            $out['data']['message'] = $e->getMessage();
        }

        $out['status'] = $this->status;

        return $out;
    }
}