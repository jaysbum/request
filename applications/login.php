<?php
	//error_reporting(0);
	require_once '../classes/request.php';
	require_once '../classes/mysql.php';
	$rq = new request();
	$db = new MysqliDb ('localhost', 'u247008393_reg', '0960ydi', 'u247008393_reg');
	$units = $db->get('units');
	$data = array('units' => $units);
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$db->where ('id', $_POST["loginUser"]);
		$db->where ('password', $_POST["txtPassword"]);
		$results = $db->getOne ('units');
		if($db->count > 0){
			$_SESSION["unit_id"] = $results["id"];
			$_SESSION["unit_name"] = $results["name"];
			$db->where ('unit_id', $results["id"]);
			$db->where ('year', 60);
			$budget = $db->getOne ('budgets');
			$sqlStr = "SELECT distinct(budget) as distinct_budget from request_items where budget_id = ". $results["id"];
			$rows = $db->rawQuery($sqlStr);
			$_SESSION['budget1_exist'] = false;
			$_SESSION['budget2_exist'] = false;
			foreach($rows as $r){
				($r['distinct_budget'] == 1)?$_SESSION['budget1_exist'] = true:'';
				($r['distinct_budget'] == 2)?$_SESSION['budget2_exist'] = true:'';
			}
			$_SESSION['budget_id'] = $budget["id"];
			$_SESSION["budget1"] = $budget["budget1"];
			$_SESSION["budget2"] = $budget["budget2"];
			header("Location: dashboard.php");
		}
	}
	
	echo $rq->loadPage('../views','login.twig')->render($data);