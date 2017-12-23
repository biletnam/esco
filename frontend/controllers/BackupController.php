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
     * @return array
     * @throws \Exception
     */
    public function actionCreate($siteId, $typeId)
    {
        if ($typeId === Backup::TYPE_DB) {
            // TODO должен ставить задачу в taskManager
            $file = Backup::createDbBackup($siteId, $typeId);
        } elseif ($typeId === Backup::TYPE_FILES) {
            // TODO должен ставить задачу в taskManager
            $file = Backup::createFilesBackup($siteId, $typeId);
        } else {
            throw new \Exception('Invalid backup type');
        }

        if (!file_exists($file)) {
            throw new \Exception('Can\'t create backup');
        }

        return [
            'message' => 'Backup created'
        ];
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