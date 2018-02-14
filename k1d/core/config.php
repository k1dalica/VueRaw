<?php
$GLOBALS['config'] = array(
	'main' => array(
		'title' => 'Website title',
		'url' => 'http://k1d.local/',
	),
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'raw'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	),
);