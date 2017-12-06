<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 03.12.2017
 * Time: 20:16
 */

namespace common\components\hub;

/**
 * Class Hub
 * @package common\components\hub
 */
class Hub
{
    /**
     * Статусы класса
     */
    const STATUS_SUCCESS = 1;
    const STATUS_PROGRESS = 0;

    /**
     * Классы которые будут накатываться
     * @var array
     */
    private $hubClasses = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * Hub constructor.
     * @param $classes
     * @param $data
     */
    public function __construct($classes, $data)
    {
        $this->hubClasses = $classes;
        $this->data = $data;
    }

    /**
     * Защищенный запуск
     */
    public function execute()
    {
        try {
            foreach ($this->hubClasses as &$class) {

                if (class_exists($class['name'])) {
                    $class['object'] = new $class['name'];
                    $class['status'] = self::STATUS_PROGRESS;
                    $class['object']->execute($this->data);
                    $class['status'] = self::STATUS_SUCCESS;
                } else {
                    throw new \Exception('Class not found');
                }
            }
        } catch (\Exception $e) {
            // что то упало, откатываем все что успели успешно накатить
            $this->hubClasses = array_reverse($this->hubClasses);

            foreach ($this->hubClasses as &$class) {
                if ($class['status'] === self::STATUS_PROGRESS) {
                    $class['object']->rollback($this->data);
                }
            }

        }
    }

}