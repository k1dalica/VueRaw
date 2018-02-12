<?php
class Token {
	public static function check($token) {
		$db = DB::getInstance();
		$now = time();
		$q = $db->query("SELECT * FROM `session` WHERE `token` = ? AND `expires` > ?", [$token, $now]);
		return ($q->count() > 0) ? true : false;
	}
}
?>