<?php
class Subscribers {
	private static $_db = null;

	public 	$id,
			$email,
			$seen;
			
	public function __construct($c) {
		$this->id = $c->id;
		$this->email = $c->email;
		$this->seen = $c->seen;
	}

	public static function get() {
		$db = self::db();
		$list = [];
		$q = $db->query("SELECT * FROM `newsletter` ORDER BY `id` DESC");
		if($db->count() > 0) {
			foreach($q->results() as $res)
				$list[] = new Subscribers($res);
		}
		return $list;
	}

	public static function updateseen() {
		$db = self::db();
		$q = $db->update('newsletter', 'seen', '0',[
			'seen' => '1'
		]);
	}

	public static function send($subject, $msg) {
		$list = self::get();
		$emails = [];
		foreach($list as $e){
			$emails[] = $e->email;
		}
		$to = implode(", ", $emails);
		$msg = nl2br($msg);
		$email = "office@infstudio.com";
		
		$headers = "From: {$email}" . "\r\n" .
		"Reply-To: $email" . "\r\n" .
		"Content-Type: text/html; charset=utf-8\r\n";
		
		ini_set("SMTP","mail.reikonkarate.com");
		ini_set('smtp_port', 587);
		ini_set('sendmail_from', $email);
		
		return (mail($to, $subject, $msg, $headers)) ? true : false;
	}

	private static function db() {
		if(self::$_db==null)
			self::$_db = DB::getInstance();
		return self::$_db;
	}
}
?>