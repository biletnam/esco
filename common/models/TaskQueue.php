<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_queue".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $raw_task
 * @property string $entity
 * @property string $action
 * @property integer $status
 * @property string $created_at
 */
class TaskQueue extends \yii\db\ActiveRecord
{

    const STATUS_CREATED = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_ERROR = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'status'], 'integer'],
            [['raw_task', 'entity', 'action'], 'string'],
            [['created_at'], 'safe'],
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
            'raw_task' => 'Raw Task',
            'entity' => 'Entity',
            'action' => 'Action',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
