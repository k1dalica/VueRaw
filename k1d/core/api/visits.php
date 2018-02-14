<?php
	$method = $_SERVER['REQUEST_METHOD'];
	$db = DB::getInstance();

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;
	
	if($method == "GET") {
		$c = Visits::get();
		$data = $OK;
		$data['data'] = $c;
	}

	if($method == "POST") {
		Visits::add();
		$c = Visits::get();
		$data = $OK;
		$data['data'] = $c;
	}

	echo json_encode($data);