<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "domain".
 *
 * @property integer $id
 * @property string $name
 * @property integer $site_id
 * @property integer $is_main
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'is_main'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['site_id', 'is_main'], 'safe'],
            [['site_id', 'is_main'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'site_id' => 'Site ID',
            'is_main' => 'Is Main',
        ];
    }
}
