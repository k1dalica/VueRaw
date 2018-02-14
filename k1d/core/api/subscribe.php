<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;

	if($method == "POST") {
		$email = Input::get('email');
		if(!empty($email)) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$data = $OK;
				$q = $db->query("SELECT * FROM `newsletter` WHERE `email` = ?", [$email]);
				if($q->count() == 0) {
					$q = $db->insert("newsletter", [
						'email' => $email,
						'seen' => '0'
					]);
					$data['msg'] = "Thank you for subscribing to our newsletter !";
				} else {
					$data['msg'] = "You are already subscribed to our newsletter !";
				}
			} else {
				$data['msg'] = "Invalid email address !"; 
			}
		} else {
			$data['msg'] = "Param email is missing !";
		}
	}

	echo json_encode($data);