<?php

namespace frontend\controllers;
use common\exceptions\RestException;
use common\helpers\BackupHelper;
use common\helpers\FileHelper;
use common\helpers\ShellHelper;
use common\models\Backup;
use common\models\Site;
use common\models\TaskQueue;
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
            $result = Backup::createDbBackup($siteId);
        } elseif ($typeId === Backup::TYPE_FILES) {
            $result = Backup::createFilesBackup($siteId);
        } else {
            throw new \Exception('Invalid backup type');
        }

        if (!file_exists($result)) {
            throw new \Exception('Can\'t create task');
        }

        return [
            'message' => 'Task created',
            'taskId' => $result
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