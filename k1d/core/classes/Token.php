<?php
class Token {
	public static function generate($id) {
		$db = DB::getInstance();
		$now = time() + (30 * 60 * 1000);
		$charset = "asdfghjklzxcvbnmqwertyuiopASDFGHJKLZXCVBNMQWERTYUIOP0123456789";
		$token = substr(str_shuffle($charset), 0, 50);
		$db->insert('session', [
			"uid" => $id,
			"token" => $token,
			"expires" => $now
		]);
		return $token;
	}

	public static function check($token) {
		$db = DB::getInstance();
		$now = time();
		$q = $db->query("SELECT * FROM `session` WHERE `token` = ? AND `expires` > ?", [$token, $now]);
		return ($q->count() > 0) ? true : false;
	}
}
?>