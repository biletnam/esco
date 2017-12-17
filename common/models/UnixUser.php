<?php

namespace common\models;

use common\components\hub\Hub;
use common\helpers\ShellHelper;
use Yii;

/**
 * This is the model class for table "unix_user".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $db_user
 * @property string $db_pass
 * @property string $db_host
 * @property string $name
 * @property string $home_path
 */
class UnixUser extends \yii\db\ActiveRecord
{
    const SITES_PATH = '/sites';
    const SYSTEM_PATH = '/system';
    const TMP_PATH = '/system/tmp';
    const LOG_PATH = '/system/log';
    const SESSION_PATH = '/system/session';
    const BACKUPS_PATH = '/system/backups';
    const BACKUPS_FILES_PATH = '/system/backups/files';
    const BACKUPS_DB_PATH = '/system/backups/db';
    const STATS_PATH = '/stats';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unix_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'integer'],
            [['client_id', 'name'], 'required'],
            [['db_user', 'db_pass', 'db_host', 'name', 'home_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * Возвращает список директорий пользователя
     *
     * @param $rootPath
     * @return array
     */
    public static function getUserDirs($rootPath)
    {
        return [
            $rootPath . self::SITES_PATH,
            $rootPath . self::SYSTEM_PATH,
            $rootPath . self::TMP_PATH,
            $rootPath . self::LOG_PATH,
            $rootPath . self::SYSTEM_PATH,
            $rootPath . self::BACKUPS_PATH,
            $rootPath . self::BACKUPS_FILES_PATH,
            $rootPath . self::BACKUPS_DB_PATH,
            $rootPath . self::STATS_PATH
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'db_user' => 'Db User',
            'db_pass' => 'Db Pass',
            'db_host' => 'Db Host',
            'name' => 'Name',
            'home_path' => 'Home Path',
        ];
    }
}
