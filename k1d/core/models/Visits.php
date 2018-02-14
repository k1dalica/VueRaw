<?php
class Visits { 
	private static $_db = null;

	public static function getInstance() {
		if(!isset(self::$_instance))
			self::$_instance = new Visits();
		return self::$_instance;
	}

	public static function get() {
		$db = self::db();
		$q = $db->query("SELECT DISTINCT `ip` FROM `visits`");
		return $q->count();
	}

	public static function add() {
		$db = self::db();
		$ip = IP::get();
		$path = (isset($_GET['url'])) ? $_GET['url'] : "/";
		$now = date('Y-m-d H:i:s');
		$db->insert("visits",[
			"ip" => $ip,
			"path" => $path,
			"time" => $now
		]);
	}

	private static function db() {
		if(self::$_db==null)
			self::$_db = DB::getInstance();
		return self::$_db;
	}
}