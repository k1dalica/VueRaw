<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;
	
	if($method == "GET") {
		$onPage = Input::get('onPage');
		if(empty($onPage))
			$onPage = $params[0];
		if(filter_var($onPage, FILTER_VALIDATE_INT) === false)
			$onPage = 1;
		$updates = Updates::get($onPage);
		if($updates != false) {
			$data = $OK;
			$data['data'] = $updates;
		}
		$data['lastpage'] = Updates::lastPage() == $onPage ? true : false;
	}

	if($method == "POST") {
		
	}

	if($method == "PUT") {
		
	}

	echo json_encode($data);
?>