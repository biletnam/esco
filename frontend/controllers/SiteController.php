<?php

namespace frontend\controllers;
use common\helpers\BackupHelper;
use common\helpers\FileHelper;
use common\helpers\ShellHelper;
use common\models\Site;
use common\models\TaskQueue;
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
     * Скачивает архив с файлами
     *
     * @param $url
     * @param $siteId
     * @return array
     * @throws \Exception
     */
    public function actionDownloadArchive($url, $siteId)
    {
        $site = Site::findOne(['id' => $siteId]);

        // проверим есть ли сайт
        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        // проверим есть ли tmp директория
        $tmpPath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . UnixUser::TMP_PATH;

        if (!file_exists($tmpPath)) {
            throw new \Exception('Tmp directory not found');
        }

        $tmpFile =  $tmpPath . '/' . time() . '_' . rand(0,999) . '.tar.gz';

        // Поставить задачу в таскменеджер
        $result = TaskQueue::createTask(FileHelper::getNamespace() . 'FileHelper', 'getFileFromUrl', [
            'url' => $url,
            'saveTo' => $tmpFile
        ]);

        if (!$result) {
            throw new \Exception('Can\'t create task');
        }

        return [
            'message' => 'Task created',
            'taskId' => $result
        ];
    }

    /**
     * Импортирует файлы из архива в директорию сайта
     *
     * @param $file
     * @param $siteId
     * @return array
     * @throws \Exception
     */
    public function actionImportFiles($file, $siteId)
    {
        $site = Site::findOne(['id' => $siteId]);

        // проверим есть ли сайт
        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим есть ли файл
        if (!file_exists($file)) {
            throw new \Exception('File not exists');
        }

        // проверим есть ли пользователь
        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        // проверим есть ли директория сайта
        $sitePath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . UnixUser::SITES_PATH . '/' . $site->name;

        if (!file_exists($sitePath)) {
            throw new \Exception('Site directory not found');
        }

        // TODO почистить директорию наверное

        // Поставить задачу в таскменеджер
        $result = TaskQueue::createTask(BackupHelper::getNamespace() . 'BackupHelper', 'restoreFileBackup', [
            'path' => $sitePath,
            'fileName' => $file
        ]);

        if (!$result) {
            throw new \Exception('Can\'t create task');
        }

        return [
            'message' => 'Task created',
            'taskId' => $result
        ];
    }

    /**
     * Ставит задачу на скачивание БД в таскменеджер
     *
     * @param $url
     * @param $siteId
     * @return array
     * @throws \Exception
     */
    public function actionDownloadDb($url, $siteId)
    {
        $site = Site::findOne(['id' => $siteId]);

        // проверим есть ли сайт
        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        // проверим есть ли tmp директория
        $tmpPath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . UnixUser::TMP_PATH;

        if (!file_exists($tmpPath)) {
            throw new \Exception('Tmp directory not found');
        }

        $tmpFile = $tmpPath . '/' . time() . '_' . rand(0,999) . '.sql';

        // Поставить задачу в таскменеджер
        $result = TaskQueue::createTask(FileHelper::getNamespace() . 'FileHelper', 'getFileFromUrl', [
            'url' => $url,
            'saveTo' => $tmpFile
        ]);

        if (!$result) {
            throw new \Exception('Can\'t create task');
        }

        return [
            'message' => 'Task created',
            'taskId' => $result
        ];
    }

    /**
     * Импортирует в БД файл
     *
     * @param $file
     * @param $siteId
     * @return array
     * @throws \Exception
     */
    public function actionImportDb($file, $siteId)
    {
        $site = Site::findOne(['id' => $siteId]);

        // проверим есть ли сайт
        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим есть ли файл
        if (!file_exists($file)) {
            throw new \Exception('File not exists');
        }

        // TODO создать БД

        // Поставить задачу в таскменеджер
        $result = TaskQueue::createTask(BackupHelper::getNamespace() . 'BackupHelper', 'restoreDbBackup', [
            'dbName' => $site->db_name,
            'fileName' => $file
        ]);

        if (!$result) {
            throw new \Exception('Can\'t create task');
        }

        return [
            'message' => 'Task created',
            'taskId' => $result
        ];
    }

    /**
     * Создает директорию для сайта
     *
     * @param $siteId
     * @return array
     * @throws \Exception
     */
    public function actionCreateDirs($siteId)
    {
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        $sitePath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . '/' . UnixUser::SITES_PATH . '/' . $site->name;

        ShellHelper::mkdir($sitePath);

        if (!file_exists($sitePath)) {
            throw new \Exception("Can't create site path");
        }

        return [
            'message' => 'Site directories created'
        ];
    }

    /**
     * Удаление директории сайта
     *
     * @param $siteId
     * @return array
     * @throws \Exception
     */
    public function actionRemoveDirs($siteId)
    {
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        $sitePath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . '/' . UnixUser::SITES_PATH . '/' . $site->name;

        ShellHelper::rm($sitePath);

        if (file_exists($sitePath)) {
            throw new \Exception("Can't remove site path");
        }

        return [
            'message' => 'Site directories removed'
        ];
    }
}