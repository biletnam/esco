<?php

namespace frontend\controllers;
use common\exceptions\RestException;
use common\helpers\FileHelper;
use common\helpers\ShellHelper;
use common\models\Backup;
use common\models\Site;
use common\models\UnixUser;
use frontend\prototypes\RestControllerPrototype;
use yii\httpclient\Client;

/**
 * Class BackupController
 * @package frontend\controllers
 */
class BackupController extends RestControllerPrototype
{
    public $modelClass = 'common\models\Backup';

    /**
     * Создает бекап
     *
     * @param $siteId
     * @param $typeId
     * @throws \Exception
     */
    public function actionCreate($siteId, $typeId)
    {
        if ($typeId === Backup::TYPE_DB) {
            Backup::createDbBackup($siteId, $typeId);
        } elseif ($typeId === Backup::TYPE_FILES) {
            Backup::createFilesBackup($siteId, $typeId);
        } else {
            throw new \Exception('Invalid backup type');
        }
    }

    /**
     * Восстановить бекап
     *
     * @param $backupId
     */
    public function actionRestore($backupId)
    {

    }
}