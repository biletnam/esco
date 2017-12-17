<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.11.17
 * Time: 17:45
 */

namespace frontend\controllers;

use common\helpers\ShellHelper;
use common\models\Domain;
use common\models\Site;
use common\models\UnixUser;
use frontend\prototypes\ServiceControllerPrototype;
use yii\helpers\ArrayHelper;

class FpmController extends ServiceControllerPrototype {

    protected function getPath()
    {
        return \Yii::$app->params['fpmConfigPath'];
    }

    protected function getTemplate()
    {

    }

    protected function getServiceName()
    {
        return 'php5-fpm';
    }

    public function actionReloadConfig()
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

        // получим домены
        $domains = Domain::find()
            ->where(['site_id' => $siteId])
            ->asArray()
            ->all();

        $domains = ArrayHelper::getColumn($domains, 'name');

        // получим unix пользователя
        $unixUser = UnixUser::findOne($site->unix_user_id);

        if (!$unixUser instanceof UnixUser) {
            throw new \Exception('Unix user not found');
        }

        // спарсим данные в шаблон
        $configContent = $this->renderFile("@app/views/{$this->getServiceName()}/config.php", [
            'unixUserName' => $unixUser->name,
            'unixUserGroup' => $unixUser->name,
            'tmpPath' => \Yii::$app->params['userPath'] . '/' . $unixUser->name . UnixUser::TMP_PATH,
            'slowLogPath' => \Yii::$app->params['userPath'] . '/' . $unixUser->name . UnixUser::LOG_PATH . '/' . $site->name . '.slow.log',
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