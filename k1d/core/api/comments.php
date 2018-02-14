<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;
	
	if($method == "GET") {
		$comments = Comments::get();
		$data = $OK;
		$data['data'] = $comments;
	}

	if($method == "POST") {
		$name = Input::get('name');
		$text = Input::get('text');
		if(empty($name) || empty($text)) {
			if(empty($name))
				$data['msg'] = "Param name is missing !";
			else
				$data['msg'] = "Param text is missing !";
		} else {
			if(!empty($name) && strlen($name) < 40) {
				if(!empty($text)) {
					$date = date('Y-m-d H:i:s');
					$text = nl2br($text);
					$IP = IP::get();
					$q = $db->insert("comments", [
						'name' => $name,
						'date' => $date,
						'text' => $text,
						'ip' => $IP,
						'approved' => '0'
					]);
					$cid = $db->lastid();
					if(!$db->error()) {
						$data = $OK;
						$data['data'] = [
							"date" => date_format(new DateTime($date), 'F j, Y'),
							"name" => $name,
							"text" => $text
						];
					}
				} else {
					$data['msg'] = "Text field can't be empty !";
				}
			} else {
				$data['msg'] = "Name must be be between 1 and 40 characters !";
			}
		}
	}

	if($method  == "PUT") {
		parse_str(file_get_contents("php://input"), $data);
		$id = intval($data['id']);
		$like = $data['like'];
		
		if(empty($id) || empty($like)) {
			if(empty($id))
				$data['msg'] = "Param id is missing !";
			else
				$data['msg'] = "Param like is missing ! expecting [true/false]";
		} else {
			if($like == "true") {
				$q = $db->insert("comment_likes", [
					'cid' => $id,
					'ip' => IP::get()
				]);
			} else {
				$q = $db->query("DELETE FROM `comment_likes` WHERE `cid` = ? AND `ip` = ?", [$id, IP::get()] );	
			}
			$data = $OK;
		}
	}

	echo json_encode($data);