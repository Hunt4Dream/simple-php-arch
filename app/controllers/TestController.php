<?php

/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 2016/3/3
 * Time: 20:53
 */
class TestController
{
    private static $userInfoService;
    public function indexAction() {
        self::$userInfoService = new UserInfoService();
        echo "hello world", PHP_EOL;
        $res = self::$userInfoService->queryAll();
        foreach($res as &$value) {
            echo $value.PHP_EOL;
        }
        unset($value);
    }
}