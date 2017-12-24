<?php

namespace frontend\controllers;

use common\models\Backup;
use frontend\prototypes\RestControllerPrototype;

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

        if (!$result) {
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
     * @return array
     * @throws \Exception
     */
    public function actionRestore($backupId)
    {
        // проверим наличие бекапа
        $backup = Backup::findOne($backupId);

        if (!$backup instanceof Backup) {
            throw new \Exception('Backup not found');
        }

        // пытаемся восстановить бекап
        if ($backup->type === Backup::TYPE_DB) {
            $result = Backup::restoreDbBackup($backup->id);
        } elseif ($backup->type === Backup::TYPE_FILES) {
            $result = Backup::restoreFilesBackup($backup->id);
        } else {
            throw new \Exception('Invalid backup type');
        }

        if (!$result) {
            throw new \Exception('Can\'t create task');
        }

        return [
            'message' => 'Task created',
            'taskId' => $result
        ];
    }
}