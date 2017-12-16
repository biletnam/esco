<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:29
 */
namespace frontend\prototypes;

use yii\web\HttpException;

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
     * Создает конфиг
     *
     * @param $siteId
     * @return array
     */
    public function actionCreateConfig($siteId)
    {
        // достанем сайт по id
        // спарсим данные в шаблон
        // запишем данные в конфиг
        // файл назвать по id сайта
    }

    /**
     * Удаляет конфиг
     *
     * @param $siteId
     * @return array
     */
    public function actionRemoveConfig($siteId)
    {
        // проверяем наличие файла конфигурации
        // удалим его
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
     * Останавливает сервис
     */
    public function actionStopService()
    {
        $output = null;
        exec("sudo service " . $this->getServiceName() . " start 2>&1", $output);
    }

    /**
     * Запускает сервис
     */
    public function actionStartService()
    {
        $output = null;
        exec("sudo service " . $this->getServiceName() . " stop 2>&1", $output);
    }
}