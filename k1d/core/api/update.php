<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;
	
	if($method == "GET") {
        $id = $params[0];
        if(empty($id)) {
            $data['msg'] = "Param id is missing !";
        } else {
            $update = Updates::find($id);
            
            if($update == false) {
                $data = $ERR;
                $data['msg'] = "Update with id ".$id." not found !";
            } else {
                $data['data'] = $update;
            }
        }
	}

	if($method == "POST") {
        $token = Input::get('token');
		$number = Input::get('number');
        $date = Input::get('date');
        $desc = Input::get('desc');
        $video = Input::get('video');
        if(empty($token) || empty($number) || empty($date) || empty($desc) || empty($vide)) {
            $data['msg'] = "One or more params are missing !";
        } else {
            if(Token::check($token)) {
                $list = [];
                if(!empty(Input::get('images')['name'][0])) {
                    foreach(Input::get('images')['name'] as $key => $name) {
                        $tmp = Input::get('images')['tmp_name'][$key];
                        if(!empty($name)) {
                            $charset = "asdfghjklzxcvbnmqwertyuiopASDFGHJKLZXCVBNMQWERTYUIOP0123456789";
                            $prefix = substr(str_shuffle($charset), 0, 20);
                            $extension = explode(".", $name);
                            $extension = end($extension);
                            $location = "uploads/". $prefix .".".$extension;
                            if(move_uploaded_file($tmp, $location)) {
                                $list[] = "/".$location;
                            }
                        }
                    }
                }
                $res = Updates::add($number, $date, $desc, $video, $list);
            } else {
                $data['msg'] = "Permission denied. Invalid token !";
            }
        }
	}

	if($method == "PUT") {
        $token = Input::get('token');
        if(Token::check($token)) {

        } else {
            $data['msg'] = "Permission denied. Invalid token !";
        }
    }
    
    if($method == "DELETE") {
        $token = Input::get('token');
		if(Token::check($token)) {
            $id = $params[0];
            if(empty($id)) {
                $data['msg'] = "Param id is missing !";
            } else {

            }
        } else {
            $data['msg'] = "Permission denied. Invalid token !";
        }
	}
    
    echo json_encode($data);
?>