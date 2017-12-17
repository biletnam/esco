<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:29
 */
namespace frontend\prototypes;

use common\helpers\ShellHelper;

/**
 * Class ServiceControllerPrototype
 * @package frontend\prototypes
 */
abstract class ServiceControllerPrototype extends RestControllerPrototype
{
    public $modelClass = '';

    /**
     * Возвращает путь до папки с конфигами
     *
     * @return string
     */
    abstract protected function getPath();

    /**
     * Возвращает путь до шаблона конфига
     *
     * @return string
     */
    abstract protected function getTemplate();

    /**
     * Отдает имя сервиса
     *
     * @return string
     */
    abstract protected function getServiceName();

    /**
     * Останавливает сервис
     */
    public function stopService()
    {
        ShellHelper::execute("service {$this->getServiceName()} stop");
    }

    /**
     * Запускает сервис
     */
    public function startService()
    {
        ShellHelper::execute("service {$this->getServiceName()} start");
    }

    /**
     * Создает конфиг
     *
     * @param $siteId
     * @throws \Exception
     */
    abstract public function actionCreateConfig($siteId);

    /**
     * Удаляет конфиг
     *
     * @param $siteId
     * @return array
     * @throws \Exception
     */
    public function actionRemoveConfig($siteId)
    {
        // проверяем наличие файла конфигурации
        if (file_exists($this->getPath() . "/{$siteId}.conf")) {
            // удалим его
            ShellHelper::rm($this->getPath() . "/{$siteId}.conf");
        }

        // проверим удалился ли конфиг
        if (file_exists($this->getPath() . "/{$siteId}.conf")) {
            throw new \Exception("Can't remove {$this->getServiceName()} config");
        }

        return [
            'message' => "{$this->getServiceName()} config removed"
        ];
    }

    /**
     * Перестроение конфига
     *
     * @param $siteId
     * @return bool
     */
    public function actionRebuildConfig($siteId)
    {
        // удаляем файл конфигурации
        $this->actionRemoveConfig($siteId);

        // воссоздаем его заново
        return $this->actionCreateConfig($siteId);
    }

    /**
     * Перезапускает сервис
     */
    public function actionReloadConfig()
    {
        $this->stopService();
        $this->startService();
    }
}