<?php

namespace frontend\controllers;
use common\exceptions\RestException;
use common\models\Site;
use yii\base\Exception;
use yii\web\HttpException;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends RestController
{
    public $modelClass = 'common\models\Site';

    /**
     * Скачивает архив с файлами, создает директорию, распаковывает файлы в директорию
     *
     * @param $url
     * @param $siteId
     * @return RestException
     */
    public function actionSetFiles($url, $siteId)
    {
        $site = Site::findOne(['id' => $siteId]);

        if (!$site instanceof Site) {
            return new RestException([
                'message' => 'Site not found',
                'status' => 'error'
            ]);
        }
        
    }

    /**
     * Скачивает db.sql, создает нового пользователя БД и распаковывает туда базу
     */
    public function actionSetDb($url, $siteId)
    {

    }
}