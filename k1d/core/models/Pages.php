<?php
class Pages {
    private static $_db = null;
    
	public static function get($name) {
		$db = self::db();
		$q = $db->query("SELECT * FROM `pages` WHERE `name` = ?", [$name]);
		if($db->count() > 0) {
			return $q->first();
		}
		return $list;
	}

	private static function db() {
		if(self::$_db==null)
			self::$_db = DB::getInstance();
		return self::$_db;
	}
}
?>