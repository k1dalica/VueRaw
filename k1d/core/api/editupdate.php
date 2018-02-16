<?php
	$db = DB::getInstance();
	$method = $_SERVER['REQUEST_METHOD'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;

	if($method == "POST") {
        $token = Input::get('token');
		$number = Input::get('number');
        $date = Input::get('date');
        $desc = Input::get('desc');
        $video = Input::get('video');
        $delete = Input::get('delete');
        if($token != '' && $number != '' && $date != '' && $desc != '' && $video != '') {
            if(Token::check($token)) {
                $id = $params[0];
                if(empty($id)) {
                    $data['msg'] = "Param id is missing !";
                } else {
                    $update = Updates::find($id);
                    if($update !== false) {
						if($delete != "") {
                            $imgs = explode(";", $delete);
                            $s = "'" . implode("', '", $imgs) . "'";
                            foreach($imgs as $img) {
                                Image::delete($img);
                            }
                            $db->query("DELETE FROM `update_images` WHERE `uid` = ? AND `path` in ($s)", [$id]);
                        }

                        $list = [];
						for($i=0;$i<20;$i++) {
							$image = Input::get('upload-'.$i);
							if($image != "") {
								$list[] = Image::upload($image);
							} else {
								break;
							}
                        }

                        $update->edit($number, $date, $desc, $video, $list);
                        $data = $OK;
                        $data['data'] = Updates::find($id);
                    } else {
                        $data['msg'] = "Update with id ".$id." not found !";
                    }
                }
            } else {
                $data['msg'] = "Permission denied. Invalid token !";
            }
        } else {
            $data['msg'] = "One or more params are missing !";
        }
    }
    
    echo json_encode($data);
?>