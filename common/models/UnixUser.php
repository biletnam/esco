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
            $rootPath . '/sites',
            $rootPath . '/system',
            $rootPath . '/system/tmp',
            $rootPath . '/system/session',
            $rootPath . '/system/backups',
            $rootPath . '/system/backups/files',
            $rootPath . '/system/backups/db',
            $rootPath . '/stats'
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

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->db_user = $this->name . '_user';
            $this->db_pass = Yii::$app->security->generateRandomString(9);
            $this->db_host = Yii::$app->params['databaseHost'];
            $this->home_path = Yii::$app->params['userPath'] . '/' . $this->name;
        }
        return parent::beforeSave($insert);
    }
}
