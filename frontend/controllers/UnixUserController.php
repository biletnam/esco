<?php

namespace frontend\controllers;
use common\helpers\ShellHelper;
use common\models\UnixUser;
use frontend\prototypes\RestControllerPrototype;

/**
 * Class UnixUserController
 * @package frontend\controllers
 */
class UnixUserController extends RestControllerPrototype
{
    public $modelClass = 'common\models\UnixUser';

    /**
     * Создает пользователя на сервере
     *
     * @param $userId
     */
    public function actionCreate($userId)
    {
        $unixUser = UnixUser::findOne($userId);

        if (!$unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }
        // создать пользователя

        // создать директории
        $dirs = UnixUser::getUserDirs(\Yii::$app->params['userPath'] . '/' . $unixUser->home_path);

        foreach ($dirs as $dir) {
            ShellHelper::mkdir($dir);

            if (!file_exists($dir)) {
                throw new \Exception("Can't create directory {$dir}");
            }
        }
    }

    /**
     * Создает пользователя БД
     *
     * @param $userId
     */
    public function actionDbUserCreate($userId)
    {

    }
}