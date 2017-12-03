<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 03.12.2017
 * Time: 20:16
 */
namespace common\components\hub;

/**
 * Прототип класса хаба
 *
 * Interface HubClassPrototype
 * @package common\components\hub
 */
interface HubClassPrototype {

    /**
     * Установить
     * @return mixed
     */
    public function execute();

    /**
     * Откатить
     * @return mixed
     */
    public function rollback();

}