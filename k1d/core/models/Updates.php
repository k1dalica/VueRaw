<?php
class Updates {
	private static $_db = null,
			$per_page = 2;

	public 	$id,
			$number,
			$date,
			$desc,
			$video,
			$images;
			
	public function __construct($c) {
		$this->id = $c->id;
		$this->number = $c->number;
		$this->date = $c->date;
		$this->desc = $c->desc;
		$this->video = $c->video;
		$this->images = $this->getImages();
	}

	public function edit($number, $date, $desc, $video, $list) {
		$db = self::db();
		$db->query("UPDATE `updates` SET `number` = ?, `date` = ?, `desc` = ? WHERE `id` = ?", [$number, $date, $desc, $this->id]);
		if($db->error())
			return false;
		$this->number = $number;
		$this->date = $date;
		$this->desc = $desc;

		if($video != "") {
			$db->update("updates", "id", $this->id, ["video" => $video]);
			$this->video = $video;
		}

		if(count($list) > 0) {
			foreach($list as $img) {
				$q = $db->insert("update_images", [
					"uid" => $this->id,
					"path" => $img
				]);
				$this->images[] = $img;
			}
		}
	}

	private function getImages() {
		$db = self::db();
		$list = [];
		$q = $db->query("SELECT * FROM `update_images` WHERE `uid` = ? ORDER BY `id` DESC", [$this->id]);
		if($db->count() > 0) {
			foreach($q->results() as $res)
				$list[] = $res->path;
		}
		return $list;
	}

	public static function find($id) {
		$db = self::db();
		$q = $db->query("SELECT * FROM `updates` WHERE `id` = ?",[$id]);
		if($db->count() > 0)
			return new Updates($q->first());
		else
			return false;
	}
	
	public static function lastPage() {
		$db = self::db();
		$pages_query = $db->query("SELECT * FROM `updates`");
		$founded = $pages_query->count();
		$pp = self::$per_page;
		return ceil($founded / $pp);
	}

	public static function get($page = 1) {
		$db = self::db();
		$pp = self::$per_page;
		$pages = self::lastPage();
		if($page > $pages)
			$page = 1;
		$start = ($page - 1) * $pp;
		$list = [];
		if($page > $pages)
			return false;
		$q = $db->query("SELECT * FROM `updates` ORDER BY `id` DESC LIMIT $start,$pp");
		if($db->count() > 0) {
			foreach($q->results() as $res)
				$list[] = new Updates($res);
		}
		return $list;
	}

	public static function all() {
		$db = self::db();
		$list = [];
		$q = $db->query("SELECT * FROM `updates` ORDER BY `id` DESC");
		if($db->count() > 0) {
			foreach($q->results() as $res)
				$list[] = new Updates($res);
		}
		return $list;
	}

	public static function add($number, $date, $desc, $video, $list) {
		$db = self::db();
		if(empty($video))
			return ["result" => false, "ERR" => "YouTube Video missing !"];
		if(empty($number) || empty($date) || empty($desc))
			return ["result" => false, "ERR" => "All fields need to be fulfilled !"];
		
		$q = $db->insert("updates", [
			"number" => $number,
			"date" => $date,
			"desc" => nl2br($desc),
			"video" => $video
		]);
		if($db->error())
			return ["result" => false, "ERR" => "There was an unknown error, please try again !"];
		
		$id = $db->lastid();
		if(count($list) > 0) {
			foreach($list as $img) {
				$q = $db->insert("update_images", [
					"uid" => $id,
					"path" => $img
				]);
			}
		}
		
		return ["result" => true, "id" => $id];	
	}

	private static function db() {
		if(self::$_db==null)
			self::$_db = DB::getInstance();
		return self::$_db;
	}
}
?>