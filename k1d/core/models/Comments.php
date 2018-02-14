<?php
class Comments {
	private static $_db = null;

	public 	$id,
			$name,
			$date,
			$text,
			$ip,
			$mycomment,
			$approved,
			$likes,
			$iplikes,
			$iliked;
			
	public function __construct($c) {
		$this->id = $c->id;
		$this->name = $c->name;
		$this->date = date_format(new DateTime($c->date), 'F j, Y');
		$this->text = $c->text;
		$this->ip = $c->ip;
		$this->approved = $c->approved;
		$this->likes = $this->countLikes();
		$this->iplikes = $this->getLikes();
		$this->mycomment = ($c->ip == IP::get()) ? true : false;
		$this->iliked = (in_array(IP::get(), $this->getLikes())) ? true : false;
	}

	private function getLikes() {
		$db = self::db();
		$q = $db->query("SELECT * FROM `comment_likes` WHERE `cid` = ?", [$this->id]);
		$list = [];
		foreach($q->results() as $res)
			$list[] = $res->ip;
		return $list;
	}

	private function countLikes() {
		$db = self::db();
		$q = $db->query("SELECT DISTINCT ip FROM `comment_likes` WHERE `cid` = ?", [$this->id]);
		return $db->count();
	}

	public static function get($v = 1) {
		$db = self::db();
		$list = [];
		$q = $db->query("SELECT * FROM `comments` WHERE `approved` = ?", [$v]);
		if($db->count() > 0) {
			foreach($q->results() as $res)
				$list[] = new Comments($res);
		}
		return $list;
	}

	public static function all() {
		$db = self::db();
		$list = [];
		$q = $db->query("SELECT * FROM `comments`");
		if($db->count() > 0) {
			foreach($q->results() as $res)
				$list[] = new Updates($res);
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