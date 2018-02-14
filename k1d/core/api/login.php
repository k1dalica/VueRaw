<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;
	
	if($method == "GET") {
		$token = $params[0];
		if($token != null) {
			$data = Token::check($token);
		} else {
			$data['msg'] = "Param token is missing !";
		}
	}

	if($method == "POST") {
		$username = Input::get('username');
		$pass = Input::get('password');
		if(!empty($username) && !empty($pass)) {
			$data = Acc::login($username, $pass);
		} else {
			if(empty($username))
				$data['msg'] = "Param username is missing !";
			else
				$data['msg'] = "Param password is missing !";
		}
	}

	if($method == "PUT") {
		$token = Input::get('token');
		if(!empty($token)) {
			
			$data = $OK;
		} else {
			$data['msg'] = "Param token is missing !";
		}
	}

	echo json_encode($data);