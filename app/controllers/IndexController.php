<?php

/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 2016/3/4
 * Time: 14:54
 */
class IndexController
{
    public function indexAction() {
        echo __METHOD__.PHP_EOL;
        var_dump(empty($tmp));
        var_dump(isset($tmp));
//        var_dump(is_null($tmp));
//        $tmp;
//        var_dump(empty($tmp));
//        var_dump(isset($tmp));
        $tmp = null;
        var_dump(empty($tmp));
        var_dump(isset($tmp));
        var_dump(is_null($tmp));
        var_dump(empty(trim($tmp)));

        $tmp = "        abdcab ";
        $tmp1 = strrchr($tmp, "ab");
        $tmp = trim(trim($tmp), 'ab');

        echo "result =================>$tmp< < ", $tmp1,">==============";
    }
    public function testInsertAction() {
        $logger = Logger::getLogger('test');
        $startTime = microtime(true);
        CURD::getInstance()->insertMulti($this->productSql());
        $endTime = microtime(true);
        $logger->logEnter(__METHOD__);
        $logger->log('insert sql 10000');
        $logger->logOperTime($endTime - $startTime);
        $logger->logEnd(__METHOD__);
    }
    private function productSql() {
        static $count = 10000;
        for($i = 0; $i < $count; $i ++ ) {
            $sql = "insert into user_info(name, sex, question, date_created, last_updated, version, del_flag) values('test $i', 'man $i','question $i', now(), now(), '$i', 0 )";
            yield $sql;
        }
    }
}