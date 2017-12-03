<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property integer $id
 * @property string $name
 * @property integer $client_id
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name', 'client_id'], 'safe'],
            [['name', 'client_id'], 'required'],
            ['name', function($attribute) {

                //TODO должна быть валидация по символам.

                $countDuplicates = self::find()
                    ->where(['name' => $this->$attribute])
                    ->exists();

                if ($countDuplicates) {
                    $this->addError($attribute, 'Duplicate site name');
                }
            }]
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
            'client_id' => 'Client ID',
        ];
    }
}
