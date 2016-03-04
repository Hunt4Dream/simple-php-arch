<?php
class Connection {
	private static $conn;

	private $adapter = null;
	private $host = null;
	private $username = null;
	private $password = null;
	private $dbname = null;
	private $charset = null;

	private static $dbConn = null;

	private static $logger = null;
	public static function getInstance($dbInfo) {
		if( ( !isset($dbConn) ) || ( !isset($conn) ) ) {
			unset($conn);
			self::$logger = Logger::getLogger("Logger");
			$conn = new Connection($dbInfo);
		}
		return $conn;
	}
	private function __construct($dbInfo) {
		if( isset($dbInfo) && is_array($dbInfo) ) {
			foreach ($this as $key => &$value) {
				if( array_key_exists( $key, $dbInfo)) {
					$tmp = &$dbInfo[$key];
					if( isset($tmp) && ( !empty(trim($tmp)) ) ) {
						$value = $tmp;
					}
				}
			}
		}
		$this->dbConnect();
	}
	private function dbConnect() {
		self::$logger->logEnter(__METHOD__);
		$startTime = microtime(true);
		if( ! strcasecmp($this->adapter, "Mysql") ) {
			self::$dbConn = mysqli_connect($this->host, $this->username, $this->password);
			if( ! isset(self::$dbConn) ) {
				return false;
			}
			if( !mysqli_set_charset(self::$dbConn, $this->charset) ) {
				return false;
			}
			if( !mysqli_select_db(self::$dbConn, $this->dbname)) {
				return false;
			}
		}
		$endTime = microtime(true);
		self::$logger->logOperTime($endTime - $startTime);
		self::$logger->logEnd(__METHOD__);
	}
	public function dbClose() {
		self::$logger->logEnter(__METHOD__);
		$startTime = microtime(true);
		if( isset(self::$dbConn)) {
			mysqli_close(self::$dbConn);
		}
		$endTime = microtime(true);
		self::$logger->logOperTime($endTime - $startTime);
		self::$logger->logEnd(__METHOD__);
	}
	public function getConn() {
		return self::$dbConn;
	}
}