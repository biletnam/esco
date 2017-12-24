<?php

namespace common\models;

use common\helpers\BackupHelper;
use Yii;

/**
 * This is the model class for table "backup".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $type
 * @property string $date
 * @property string $file
 */
class Backup extends \yii\db\ActiveRecord
{
    /**
     * тип бекапа БД
     */
    const TYPE_DB = 1;

    /**
     * тип бекапа файлы
     */
    const TYPE_FILES = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'type'], 'integer'],
            [['date'], 'safe'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'site_id' => 'Site ID',
            'type' => 'Type',
            'date' => 'Date',
            'file' => 'File',
        ];
    }

    /**
     * Создает бекап БД
     *
     * @param $siteId
     */
    public static function createDbBackup($siteId)
    {
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим есть ли пользователь
        $unixUser = UnixUser::findOne($site->unix_user_id);

        if (!$unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        $backupPath = \Yii::$app->params['userPath'] . '/' . $unixUser->home_path . UnixUser::BACKUPS_DB_PATH;

        if (!file_exists($backupPath)) {
            throw new \Exception('DB backups path not found');
        }

        $backupFile = $backupPath . '/' . $site->name . '_' . date("Y-m-d H:i:s") . '.sql';

        // Поставить задачу в таскменеджер
        return TaskQueue::createTask(BackupHelper::getNamespace() . 'BackupHelper', 'createDbBackup', [
            'dbName' => $site->db_name,
            'file' => $backupFile
        ]);
    }

    /**
     * Создает бекап файлов
     *
     * @param $siteId
     */
    public static function createFilesBackup($siteId)
    {
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим есть ли пользователь
        $unixUser = UnixUser::findOne($site->unix_user_id);

        if (!$unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        $sitePath = \Yii::$app->params['userPath'] . '/' . $unixUser->home_path . UnixUser::SITES_PATH . '/' . $site->name;

        if (!file_exists($sitePath)) {
            throw new \Exception('Site path not found');
        }

        $backupPath = \Yii::$app->params['userPath'] . '/' . $unixUser->home_path . UnixUser::BACKUPS_FILES_PATH;

        if (!file_exists($backupPath)) {
            throw new \Exception('File backups path not found');
        }

        $backupFile = $backupPath . '/' . $site->name . '_' . date("Y-m-d H:i:s") . '.tar.gz';

        // Поставить задачу в таскменеджер
        return TaskQueue::createTask(BackupHelper::getNamespace() . 'BackupHelper', 'createFilesBackup', [
            'path' => $sitePath,
            'file' => $backupFile
        ]);
    }

    /**
     * Разворачивает бекап БД
     *
     * @param $backupId
     */
    public static function restoreDbBackup($backupId)
    {

    }

    /**
     * Разворачивает бекап файлов
     *
     * @param $backupId
     */
    public static function restoreFilesBackup($backupId)
    {

    }
}
