<?php
class Acc {
	public static function tokenUpdate($token) {
		$db = DB::getInstance();
		$time = time() + (60 * 60);
		$q = $db->update('session', 'token', $token, [
			'expires' => $time
		]);
	}

	public static function userFromToken($token) {
		$db = DB::getInstance();
		$now = time();
		$q = $db->query("SELECT uid AS id, expires, b.username FROM `session` AS a INNER JOIN users AS b ON a.uid = b.id WHERE `token` = ? AND `expires` > ?", [$token, $now]);
		if($q->count() == 0)
			return ["status" => false, "msg" => "Invalid user token !"];
		$res = $q->first();

		return [
			"status" => true,
			"expire" => $res->expires,
			"user" => [
				"id" => $res->id,
				"username" => $res->username
			]
		];
	}

	public static function login($ue, $pw) {
		$db = DB::getInstance();
		
		$q = $db->query("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?", [$ue, md5($pw)]);
		if($q->count() == 0) {
			return array("status" => false, "msg" => "Wrong username/password combination !");
		}
		$user = $q->first();
		$token = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(50/strlen($x)) )),1,50);
		$time = time() + (60 * 60);

		$db->delete('session',['uid', '=', $user->id]);

		$db->insert('session', [
			"uid" => $user->id,
			"token" => $token,
			"expires" => $time
		]);

		return [
			"status" => true,
			"token" => $token,
			"expire" => $time,
			"user" => [
				"id" => $user->id,
				"username" => $user->username
			]
		];
	}	
}