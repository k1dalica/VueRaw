<?php
class Acc {
	public static function login($ue, $pw) {
		$db = DB::getInstance();
		
		if(!self::user_exists($ue)) {
			return array("status" => false, "msg" => "User not found !");
		}

		$q = $db->query("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?", [$ue, md5($pw)]);
		if($q->count() == 0) {
			return array("status" => false, "msg" => "Wrong password !");
		}
		$id = $q->first()->id;
		return array("status" => true, "id" => $id);
	}

	public static function user_exists($e) {
		$db = DB::getInstance();
		
		$q = $db->query("SELECT * FROM `users` WHERE `username` = ? OR `id` = ?", [$e, $e]);
		return ($q->count() > 0) ? true : false;
	}
}