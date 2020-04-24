<?php
session_start();
// new filename
$filename = 'pic_'.date('YmdHis') . '.jpeg';

$url = '';
if( move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename) ){
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
	$_SESSION['camera'][count($_SESSION['camera'])+1] = 'capture_picture/upload/'.$filename;
}

// Return image url
echo $url;