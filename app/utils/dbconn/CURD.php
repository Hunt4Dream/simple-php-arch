<?php

/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 2016/3/3
 * Time: 15:25
 */
class CURD {
    private $conn;
    //单次提交的sql数量
    private static $count = 1000;

    public function __set($name, $value) {
        $this->$name = $value;
    }
    public function __get($name) {
       return $this->$name;
    }
    private static $one = null;
    public static function getInstance() {
        if( empty(self::$one)) {
            self::$one = new CURD();
        }
        return self::$one;
    }
    public function queryFirst($sql, $domain) {
        if( ( !isset($sql)) || empty(trim($sql)) || (!isset($domain))) {
            return null;
        }
        $result = mysqli_query($this->conn, $sql);
        $allInfo = null;
        if( $result && ( $result->num_rows > 0 ) ) {
           $allInfo = (new $domain())->bindParam($result->fetch_array());
        }
        $result->free_result();
        return $allInfo;
    }
    public function queryAll($sql, $domain) {
        if( ( !isset($sql)) || empty(trim($sql)) || (!isset($domain))) {
            return null;
        }
        $result = mysqli_query($this->conn, $sql);
        $allInfo = array();
        if( $result && ( $result->num_rows > 0 ) ) {
            while( $row = $result->fetch_array()) {
                array_push($allInfo, (new $domain())->bindParam($row));
            }
        }
        $result->free_result();
        return $allInfo;
    }
    public function insertOne($sql) {
        if( ( !isset($sql)) || empty($sql) ) {
            return false;
        }
        mysqli_begin_transaction($this->conn);
        $result = mysqli_query($this->conn, $sql);
        if( $result ) {
            mysqli_commit($this->conn);
            return true;
        }
        mysqli_rollback($this->conn);
        return false;
    }
    public function insertMulti($array) {
        if( ( !isset($array)) ) {
            return false;
        }
        $num = 0;
        $result = true;
        $total = count($array);
        foreach($array as $value) {
            $flag = ( ++$num % self::$count == 0 ) || ( $total - $num  < self::$count );
            if(  $flag  ) {
                mysqli_begin_transaction($this->conn);
            }
            $result &= mysqli_query($this->conn, $value);
            if( $flag  ) {
                if( $result ) {
                    mysqli_commit($this->conn);
                }
                mysqli_rollback($this->conn);
            }
        }
        return $result;
    }
    public function updateOne($sql) {
        return $this->insertOne($sql);
    }
    public function updateMulti($array) {
        return $this->insertMulti($array);
    }
    public function deleteOne($sql) {
        return $this->insertOne($sql);
    }
    public function deleteMulti($array) {
        return $this->insertMulti($array);
    }
}