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
            ['name', function($attribute) {

                //TODO должна быть проверка на формат домена

                // проверим на наличие дупликатов
                $isDuplicatesExists = self::find()
                    ->where(['name' => $this->$attribute])
                    ->exists();

                if ($isDuplicatesExists) {
                    $this->addError($attribute, 'Duplicate domain name');
                }
            }],
            ['site_id', function($attribute) {

                // проверим на наличие сайта
                $siteExist = Site::find()
                    ->where(['id' => $this->$attribute])
                    ->exists();

                if (!$siteExist) {
                    $this->addError($attribute, 'Site not found');
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
            'site_id' => 'Site ID',
            'is_main' => 'Is Main',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        // сбрасываем основной домен для этого сайта
        self::updateAll([
           'is_main' => false
        ], [
            'site_id' => $this->site_id
        ]);

        return parent::beforeSave($insert);
    }
}
