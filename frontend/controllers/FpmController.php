<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:45
 */

namespace frontend\controllers;

use common\helpers\ShellHelper;
use common\models\Site;
use common\models\UnixUser;
use frontend\prototypes\ServiceControllerPrototype;

/**
 * Class FpmController
 * @package frontend\controllers
 */
class FpmController extends ServiceControllerPrototype {

    protected function getPath()
    {
        return \Yii::$app->params['fpmConfigPath'];
    }

    protected function getServiceName()
    {
        return 'php5-fpm';
    }

    public function actionReload()
    {
        ShellHelper::execute("service {$this->getServiceName()} reload");
    }

    public function actionCreateConfig($siteId)
    {
        // достанем сайт по id
        $site = Site::findOne($siteId);

        if (!$site instanceof Site) {
            throw new \Exception('Site not found');
        }

        if (!$site->unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        // спарсим данные в шаблон
        $configContent = $this->renderFile("@app/views/{$this->getServiceName()}/config.php", [
            'unixUserName' => $site->unixUser->name,
            'unixUserGroup' => $site->unixUser->name,
            'tmpPath' => \Yii::$app->params['userPath'] . '/' . $site->unixUser->name . UnixUser::TMP_PATH,
            'slowLogPath' => \Yii::$app->params['userPath'] . '/' . $site->unixUser->name . UnixUser::LOG_PATH . '/' . $site->name . '.slow.log',
        ]);

        // запишем данные в конфиг
        $configFile = fopen($this->getPath() . "/{$siteId}.conf", "w");
        fwrite($configFile, $configContent);
        fclose($configFile);

        // проверим есть ли теперь этот сайт
        if (!file_exists($this->getPath() . "/{$siteId}.conf")) {
            throw new \Exception("Can't create {$this->getServiceName()} config");
        }

        return [
            'message' => 'Config created'
        ];
    }
}