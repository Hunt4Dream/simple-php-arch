<?php

/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 2016/3/4
 * Time: 14:25
 */
class UserInfoService
{
    public function queryAll() {
        $sql = "select * from user_info";
        return CURD::getInstance()->queryAll($sql, 'UserInfo');
    }
}