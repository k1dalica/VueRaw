<?php
	session_start();
	header('Content-Type: application/json');
	
	require_once '../core/config.php';
	require_once '../classes/Config.php';
	require_once '../classes/DB.php';
	require_once '../classes/Session.php';
	require_once '../classes/IP.php';
	require_once '../classes/Acc.php';
	require_once '../core/models/Updates.php';

	$db = DB::getInstance();
	$a = $_POST['action'];

	$OK = ['status' => true];
	$ERR = ['status' => false];
	$data = $ERR;

	$logged = Acc::loggedin();
	
	if($a=="savePage" && $logged) {
		$page = $_POST['page'];
		$text = $_POST['text'];
		$db->update('pages', 'name', $page, ['text' => $text]);
		$data = $OK;
	}

	if($a=="approveComment" && $logged) {
		$id = $_POST['id'];
		$db->update('comments', 'id', $id, ['approved' => '1']);
		$data = $OK;
	}

	if($a=="dontApproveComment" && $logged) {
		$id = $_POST['id'];
		$db->update('comments', 'id', $id, ['approved' => '2']);
		$data = $OK;
	}

	if($a=="deleteUpdateImage" && $logged) {
		$img = $_POST['img'];
		$db->delete("update_images",['path', '=', $img]);
		if(!$db->error()) {
			unlink("..".$img);
			$data = $OK;
		} else {
			$data = $ERR;
		}
		
	}

	if($a=="deleteUpdate" && $logged) {
		$id = $_POST['id'];
		$q = $db->query("SELECT * FROM `update_images` WHERE `uid` = ?", [$id]);
		if($db->count() > 0)
			foreach($q->results() as $res)
				unlink("..".$res->path);
		$q = $db->delete("update_images",["uid", "=", $id]);
		$q = $db->delete("updates",["id","=",$id]);
		$data = $OK;
	}	

	echo json_encode($data);