<?php
	//error_reporting(0);
	require_once '../classes/request.php';
	require_once '../classes/mysql.php';
	$err = isset($_GET['err']) ? $_GET['err'] : "";
	$rq = new request();
	$db = new MysqliDb ('localhost', 'u247008393_reg', '0960ydi', 'u247008393_reg');
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$db->where ('id', $_SESSION["unit_id"]);
		$db->where ('password', $_POST["oldPass"]);
		$results = $db->getOne ('units');
		if($db->count > 0){
			if(strlen($_POST["newPass"]) < 6 || !ctype_alnum($_POST["newPass"])){
				header("Location:changePassword.php?err=tooshort");
			}else{
				if($_POST["newPass"] != $_POST["confirmPass"]){
					header("Location:changePassword.php?err=notmatch");
				}else{
					$data = Array (
					    'password' => $_POST["newPass"],
					    'last_update' => date("Y-m-d H:i:s")
					);
					$db->where ('id', $_SESSION["unit_id"]);
					if ($db->update ('units', $data))
					    header("Location:changePassword.php?err=success");
					else
					    header("Location:changePassword.php?err=database");
				}
			}
		}else{
			header("Location:changePassword.php?err=oldpass");
			//$err = "oldpass";
		}
	}
	$data = array('err' => $err);
	echo $rq->loadPage('../views','changePassword.twig')->render($data);