<?php

/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 2016/3/3
 * Time: 16:24
 */
class FileUtils {
    private static  $allController = array();
    //find all files from dir
    public static function findPathFiles($dir) {
        if( !is_dir($dir)) {
            return null;
        }
        $dirHandle = dir($dir);
        while( $file = $dirHandle->read() ) {
            $path = $dir.DIRECTORY_SEPARATOR.$file;
            if( is_dir( $path ) && (! strcmp($file, '.')) && (! strcmp($file, '..'))) {
                self::findPathFiles($path);
            } else if(is_file($path)) {
                yield $path;
            }
        }
        $dirHandle->close();
    }
    public static function registerDir($dir) {
       static $regDir = array();
       if( array_search($dir, $regDir, true) === false ) {
           array_push($regDir, $dir);
           $allFiles = self::findPathFiles($dir);
           if( is_object($allFiles)) {
               foreach($allFiles as $value) {
                   include $value;
                   $tmp = substr($value, strrpos($value, DIRECTORY_SEPARATOR) + 1 );
                   $objName = substr($tmp, 0, strrpos($tmp, '.php'));
//                   echo "==============class $objName==============";
                   self::singletonController($objName);
               }
//         $tmp = implode( PATH_SEPARATOR, $allFiles);
           } else if( is_string($allFiles) ){
               include $allFiles;
           }
       }
   }
   private static function singletonController($controller) {
//       echo "=====================singletonController===============";
       if( ! class_exists($controller, false)) {
//           echo "=====================Not Found Controller $controller===============";
           return false;
       }
       $reg = "/^[\S]+Controller$/";
//       echo "=================${controller}=================";
       if( preg_match_all($reg, $controller)) {
//           echo "=================controller >>${controller}==============";
           $objName = lcfirst(substr($controller, 0, strlen($controller) - strlen('controller')));
           if( !array_key_exists($objName, self::$allController)) {
              // echo "========Not exist $objName==========";
               self::$allController[$objName] = new $controller();
           }
           return self::$allController[$objName];
       }
   }
    public static function getSingleController($objName) {
        if( array_key_exists($objName, self::$allController)) {
            return self::$allController[$objName];
        }
        return null;
    }
    /**
     * such as: index/index
     * @param $uri
     * @return null
     */
    public static function uriMap($uri) {
      //  echo "====================url $uri==================";
        if( empty($uri)) {
            return null;
        }
        $res = explode('/', $uri);
        if( count($res) !== 2) {
            return null;
        }
        $controller = $res[0];
        $action = $res[1] . 'Action';
       // echo "controller--------->".$controller."-------------->".$action.PHP_EOL;
        $obj = self::getSingleController($controller);
        if( method_exists($obj, $action)) {
            //echo "=========Found Action $controller -> $action============";
            $obj->$action();
            //call_user_func(array($obj, $action));
        } else {
          //  echo "=========Not Found Action============";
        }
    }
}