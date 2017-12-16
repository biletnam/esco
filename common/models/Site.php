<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property integer $id
 * @property string $name
 * @property string $db_name
 * @property integer $unix_user_id
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
            [['unix_user_id'], 'integer'],
            [['name', 'db_name'], 'string', 'max' => 255],
            [['name', 'unix_user_id'], 'safe'],
            [['name', 'unix_user_id', 'db_name'], 'required'],
            ['name', function($attribute) {

                //TODO должна быть валидация по символам.

                $isDuplicatesExists = self::find()
                    ->where(['name' => $this->$attribute])
                    ->exists();

                if ($isDuplicatesExists) {
                    $this->addError($attribute, 'Duplicate site name');
                }
            }],
            ['unix_user_id', function($attribute) {

                $isUserExist = UnixUser::find()
                    ->where(['id' => $this->$attribute])
                    ->exists();

                if (!$isUserExist) {
                    $this->addError($attribute, 'Unix user not exists');
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
            'unix_user_id' => 'Client ID',
            'db_name' => 'DB name'
        ];
    }
}
