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
 * @property Site $site
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
     * @return bool
     * @throws \Exception
     */
    public static function createDbBackup($siteId)
    {
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим есть ли пользователь
        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        $backupPath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . UnixUser::BACKUPS_DB_PATH;

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
     * @return bool
     * @throws \Exception
     */
    public static function createFilesBackup($siteId)
    {
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим есть ли пользователь
        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        $sitePath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . UnixUser::SITES_PATH . '/' . $site->name;

        if (!file_exists($sitePath)) {
            throw new \Exception('Site path not found');
        }

        $backupPath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . UnixUser::BACKUPS_FILES_PATH;

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
     * @return bool
     * @throws \Exception
     */
    public static function restoreDbBackup($backupId)
    {
        // проверим наличие бекапа
        $backup = Backup::findOne($backupId);

        if (!$backup instanceof Backup) {
            throw new \Exception('Backup not found');
        }

        // проверим есть ли сайт
        $site = Site::findOne($backup->site_id);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим есть ли файл бекапа
        if (!file_exists($backup->file)) {
            throw new \Exception('Backup file not found');
        }

        // Поставить задачу в таскменеджер
        return TaskQueue::createTask(BackupHelper::getNamespace() . 'BackupHelper', 'restoreDbBackup', [
            'dbName' => $site->db_name,
            'fileName' => $backup->file
        ]);
    }

    /**
     * Разворачивает бекап файлов
     *
     * @param $backupId
     * @return bool
     * @throws \Exception
     */
    public static function restoreFilesBackup($backupId)
    {
        // проверим наличие бекапа
        $backup = Backup::findOne($backupId);

        if (!$backup instanceof Backup) {
            throw new \Exception('Backup not found');
        }

        // проверим есть ли сайт
        $site = Site::findOne($backup->site_id);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        // проверим unix пользователя
        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        // проверим есть ли файл бекапа
        if (!file_exists($backup->file)) {
            throw new \Exception('Backup file not found');
        }

        $sitePath = \Yii::$app->params['userPath'] . '/' . $site->unixUser->home_path . UnixUser::SITES_PATH . '/' . $site->name;

        if (!file_exists($sitePath)) {
            throw new \Exception('Site path not found');
        }

        // Поставить задачу в таскменеджер
        return TaskQueue::createTask(BackupHelper::getNamespace() . 'BackupHelper', 'restoreFilesBackup', [
            'path' => $sitePath,
            'fileName' => $backup->file
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['id' => 'site_id']);
    }
}
