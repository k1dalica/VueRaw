<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;
	
	if($method == "GET") {
		$comments = Comments::all();
		$data = $OK;
		$data['data'] = $comments;
	}

	if($method == "POST") {
		$id = $params[0];
		$token = Input::get('token');
		if(Token::check($token)) {
			$state = Input::get('state');
			if(!empty($state) && ($state == '1' || $state == '2')) {
				$db->update('comments', 'id', $id, ['approved' => $state]);
				$data = $OK;
			} else {
				$data['msg'] = "Param state is missing !";
			}
		} else {
			$data['msg'] = "Permission denied. Invalid token !";
		}
	}

	echo json_encode($data);