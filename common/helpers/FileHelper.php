<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 17.12.2017
 * Time: 18:11
 */

namespace common\helpers;


class FileHelper
{
    /**
     * Получает файл по URL. TODO Возможно лучше использовать wget и писать сразу в файл
     *
     * @param $url
     * @param $saveTo
     */
    public static function getFileFromUrl($url, $saveTo)
    {
        $result = ShellHelper::execute("wget {$url} -O {$saveTo}");
        var_dump($result);
        exit;
//        $headers = [];
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_URL,$url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        $data = curl_exec($ch);
//        curl_close($ch);
//
//        $archive = fopen($saveTo, "w");
//        fwrite($archive, $data);
//        fclose($archive);
    }
}