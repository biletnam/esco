<?php

namespace frontend\controllers;
use common\exceptions\RestException;
use common\helpers\ShellHelper;
use common\models\Site;
use common\models\UnixUser;
use frontend\prototypes\RestControllerPrototype;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends RestControllerPrototype
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

        // проверим есть ли сайт
        if (!$site instanceof Site) {
            return new RestException([
                'message' => 'Site not found',
                'status' => 'error'
            ]);
        }


    }

    /**
     * Скачивает db.sql и распаковывает туда базу
     *
     * @param $url
     * @param $siteId
     */
    public function actionSetDb($url, $siteId)
    {

    }

    /**
     * Создает директорию для сайта
     *
     * @param $siteId
     */
    public function actionCreateDirs($siteId)
    {
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        $unixUser = UnixUser::findOne($site->unix_user_id);

        if (!$unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        $sitePath = \Yii::$app->params['userPath'] . '/' . $unixUser->home_path . '/' . UnixUser::SITES_PATH . '/' . $site->name;

        ShellHelper::mkdir($sitePath);

        if (!file_exists($sitePath)) {
            throw new \Exception("Can't create site path");
        }

        return [
            'message' => 'Site directories created'
        ];
    }
}