<?php

namespace frontend\controllers;
use common\exceptions\RestException;
use common\models\Site;
use common\models\TaskQueue;
use yii\base\Exception;
use yii\web\HttpException;

/**
 * Class TaskController
 * @package frontend\controllers
 */
class TaskController extends RestController
{
    /**
     * Отдает статус задачи по ее id
     *
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function actionGetStatus($id)
    {
        $task = TaskQueue::findOne($id);

        if (!$task instanceof TaskQueue) {
            throw new \Exception('Task not found');
        }

        return ['task_status' => $task->status];
    }
}