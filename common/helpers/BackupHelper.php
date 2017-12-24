<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 24.12.2017
 * Time: 11:03
 */

namespace common\helpers;

/**
 * Class BackupHelper
 * @package common\helpers
 */
class BackupHelper
{

    public static function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * Создает файл бекапа из указанной директории в указанный файл
     *
     * @param $path
     * @param $file
     */
    public static function createFilesBackup($path, $file)
    {

    }

    /**
     * Создает бекап БД в указанный файл
     *
     * @param $dbName
     * @param $file
     */
    public static function createDbBackup($dbName, $file)
    {

    }

    /**
     * Восстанавливает бекап БД
     *
     * @param $dbName
     * @param $fileName
     */
    public static function restoreDbBackup($dbName, $fileName)
    {

    }

    /**
     * Восстанавливает бекап файлов
     *
     * @param $path
     * @param $fileName
     */
    public static function restoreFileBackup($path, $fileName)
    {

    }
}