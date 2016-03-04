<?php

  class Logger {

  	private $logClazz = null;
  	const LOG_INFO = "info";

  	public static function getLogger($clazz) {
  		return new Logger($clazz);
  	}
  	private function __construct($clazz) {
  		$this->logClazz = $clazz;
  	}
  	public function log($msg, $level = self::LOG_INFO ) {
  		echo date('y-m-d h:i:s', time()),$level, 'the class of', $this->logClazz,  $msg, PHP_EOL;
  	}
  	public function logEnter($functionName) {
  		echo date('y-m-d h:i:s', time()),'======================enter ',$functionName, '===================', PHP_EOL;
  	}
  	public function logEnd($functionName) {
  		echo date('y-m-d h:i:s', time()),'======================leave ',$functionName, '===================', PHP_EOL;
  	}
  	public function logOperTime($diffTime) {
  		echo date('y-m-d h:i:s', time()),'======================the cost of time:', $diffTime * 1000, ' ms=========================', PHP_EOL;
   	}
  }