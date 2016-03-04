<?php
   include __DIR__.'/../utils/fileutil/FileUtils.php';
   FileUtils::registerDir(__DIR__.'/../domain');
   FileUtils::registerDir(__DIR__.'/../utils/logger');
   FileUtils::registerDir(__DIR__.'/../utils/dbconn');
   FileUtils::registerDir(__DIR__.'/../services');
   FileUtils::registerDir(__DIR__.'/../controllers');

   $conf = include __DIR__."/config.php";
   $conn = Connection::getInstance($conf['database']);

   $curd = CURD::getInstance();
   $curd->conn = $conn->getConn();

   $url = $_GET['_url'];
   //echo "url === > ". $url.PHP_EOL;
   $url = str_ireplace('.php', '', substr( $url, 1 ));
   $sep1 = strpos( $url, '?');
   $action = $url;
   if( $sep1 > 0 ) {
      $action = substr($url, 0, $action);
   }
   //echo "action === > ". $action.PHP_EOL;
   FileUtils::uriMap($action);
   $conn->dbClose();
























//   if( isset($mysqli)) {
 //     echo "mysqli init success".PHP_EOL;
      //$res = mysqli_query($mysqli, "show databases;");
//      echo mysqli_info($mysqli), PHP_EOL;
      //print_r( mysqli_fetch_fields($res) );
      //echo mysqli_num_fields($res), PHP_EOL;
      //print_r( mysqli_get_connection_stats($mysqli) );

/*      $stmt = mysqli_stmt_init($mysqli);

      if (mysqli_stmt_prepare($stmt,"select name from user_info")) {
         // Bind parameters
         // mysqli_stmt_bind_param($stmt,"s",$city);
        // Execute query
         mysqli_stmt_execute($stmt);
        // Bind result variables
         mysqli_stmt_bind_result($stmt, $district);
        // Fetch value
         mysqli_stmt_fetch($stmt);
         printf("result %s\n", $district);
         // Close statement
         mysqli_stmt_free_result($stmt);
         mysqli_stmt_close($stmt);
      }*/

  //    echo PHP_EOL;
//      echo 'value ==> ',$value, PHP_EOL;
 //     print_r($allInfo);
//   }
 //  $conn->dbClose();
 //  unset($conn);