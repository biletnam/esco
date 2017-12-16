<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 16.12.2017
 * Time: 18:59
 */

namespace console\controllers;


use common\helpers\ShellHelper;
use common\models\TaskQueue;
use yii\console\Controller;

class TaskController extends Controller
{
    /**
     * Запуск задачи
     * Будет запускаться из консоли и выполнять конкретную задачу. Запуски будет инициализировать консольный контроллер.
     *
     *
     * @param $id
     * @throws \Exception
     */
    public function actionExecuteOne($id)
    {
        $task = TaskQueue::findOne($id);

        if (!$task instanceof TaskQueue) {
            throw new \Exception('Task not found');
        }

        if ($task->status !== TaskQueue::STATUS_CREATED) {
            throw new \Exception('Wrong task status');
        }

        try {
            if (!class_exists($task->entity)) {
                throw new \Exception('Task entity not found');
            }
            $object = new $task->className();
            if (!method_exists($object, $task->action)) {
                throw new \Exception('Task action not found');
            }
            $action = $task->action;
            $result = $object->$action();
        } catch (\Exception $e) {
            $task->status = TaskQueue::STATUS_ERROR;
            $task->save();
        }
    }

    /**
     * Запуск демона который будет запускать задачи
     * Вызывается из крона ежеминутно
     */
    public function actionExecute()
    {
        while (true) {
            $task = TaskQueue::find()
                ->where(['status' => TaskQueue::STATUS_CREATED])
                ->orderBy('id')
                ->one();

            if (!$task instanceof TaskQueue) {
                // нет задач для выполнения. Гасим процесс
                break;
            }

            // есть задача. Создаем новый FPM
            ShellHelper::execute("php task/execute-one {$task->id}");
        }
    }
}