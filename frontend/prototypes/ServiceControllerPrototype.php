<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:29
 */
namespace frontend\prototypes;

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
     * @return bool
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
     * @return bool
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
     */
    public function actionRebuildConfig($siteId)
    {
        // удаляем файл конфигурации
        // воссоздаем его заново
    }

    /**
     * Останавливает сервис
     */
    public function actionStopService()
    {

    }

    /**
     * Запускает сервис
     */
    public function actionStartService()
    {

    }
}