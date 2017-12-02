<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 02.12.2017
 * Time: 19:58
 */

namespace common\helpers;

/**
 * Реализация консольных команд
 * Для пользователя esco должны быть в visudo все реализуемые команды
 *
 * Class ShellHelper
 * @package common\helpers
 */
class ShellHelper
{

    /**
     * Реализация chmod
     *
     * @param $dir
     * @param $mod
     */
    public static function chmod($dir, $mod)
    {
        //TODO validate mod
        if (file_exists($dir)) {
            exec("sudo chmod -R $mod $dir");
        }
        //TODO answer?
    }

    /**
     * Реализация chown
     *
     * @param $dir
     * @param $group
     * @param $owner
     */
    public static function chown($dir, $group, $owner)
    {
        if (file_exists($dir)) {
            exec("sudo chown -R $group:$owner $dir");
        }
    }

    /**
     * Реализация создания папки
     *
     * @param $dir
     */
    public static function mkdir($dir)
    {
        exec("sudo mkdir $dir");
    }

    /**
     * Реализация копирования
     *
     * @param $fromFile
     * @param $toFile
     */
    public static function cp($fromFile, $toFile)
    {
        if (file_exists($fromFile)) {
            exec("sudo $fromFile $toFile");
        }
    }

    /**
     * Реализация удаления
     *
     * @param $dir
     */
    public static function rm($dir)
    {
        if (file_exists($dir)) {
            exec("sudo rm -rf $dir");
        }
    }

    /**
     * Создание пользователя
     *
     * @param $name
     * @param $group
     */
    public static function userAdd($name, $group)
    {
        self::groupAdd($group);

        exec('sudo useradd -m -d ' . \Yii::$app->params['userPath'] . '/'. $name . ' -c "' . $name . '" -g ' . $group);
    }

    /**
     * Удаление пользователя
     *
     * @param $name
     */
    public static function userDelete($name)
    {
        //TODO ползователь должен удаляться вместе с группой и со своей папкой
        exec("userdel -r $name");
        self::groupDelete($name);
    }

    /**
     * Создать группу
     *
     * @param $name
     */
    public static function groupAdd($name)
    {
        // TODO проверить что такой группы еще нет
        exec("groupadd $name");
    }

    /**
     * Удалить группу
     *
     * @param $group
     */
    public static function groupDelete($group)
    {
        exec("groupdel $group");
    }

}