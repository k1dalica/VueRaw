<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;
	
	if($method == "GET") {
		
	}

	if($method == "POST") {
		
	}

	if($method == "PUT") {
		
	}

	echo json_encode($data);