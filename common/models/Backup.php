<?php

namespace common\models;

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
     * @param $type
     */
    public static function createDbBackup($siteId, $type)
    {

    }

    /**
     * Создает бекап файлов
     *
     * @param $siteId
     * @param $type
     */
    public static function createFilesBackup($siteId, $type)
    {

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
