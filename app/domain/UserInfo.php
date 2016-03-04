<?php

/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 2016/3/3
 * Time: 13:37
 */
class UserInfo
{
    private $id;
    private $name;
    private $sex;
    private $question;
    private $date_created;
    private $last_updated;
    private $version;
    private $del_flag;

    public function bindParam($array) {
        if( is_array($array)) {
            foreach($this as $key => &$value ) {
                if( array_key_exists($key, $array)) {
                    $value = $array[$key];
//                    echo $key, '==>',$this->$key, '==>', $array[$key], ' ', PHP_EOL;
                }
            }
        }
        return $this;
   }
    public function __set($name, $value) {
        $this->$name = $value;
    }
    public function __get($name) {
        return $this->$name;
    }

    public function __toString() {
        $res = '[ ';
        foreach($this as $key => &$value) {
            $res .= $key.':'.$value.', ';
        }
        unset($value);
        $res = substr( $res, 0, strlen($res) - 2 ).' ]';
        //$res = implode(',', explode(', ', $res));
        return $res;
    }
}