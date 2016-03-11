<?php
	error_reporting(0);
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	$id = isset($_GET['id']) ? $_GET['id'] : "1";
	$name = isset($_GET['name']) ? $_GET['name'] : "";
	$page = isset($_GET['page']) ? $_GET['page'] : "1";
	$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
	$count = isset($_GET['count']) ? $_GET['count'] : "";
	$price = isset($_GET['price']) ? $_GET['price'] : "";
	
	require_once '../classes/request.php';
	require_once '../classes/mysql.php';
	(!isset($_SESSION['unit_id']))?header("Location:login.php"):"";
	$_SESSION['page'] = "list";
	$rq = new request();
	$db = new MysqliDb ('localhost', 'u247008393_reg', '0960ydi', 'u247008393_reg');
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$sqlStr = "name like '%". $_POST['txtSearch'] ."%'";
		$db->where ($sqlStr);
		$items = $db->arraybuilder()->paginate("list_items", $page);
	}else{
		$items = $db->arraybuilder()->paginate("list_items", $page);
	}
	$data = array('items' => $items,'action' => $action,'id' => $id,'name' => $name,'page' => $page,'price' => $price, 'quantity' => $quantity, 'count' => $count, 'totalPages' => $db->totalPages, 'total' => $rq->getTotal());
	echo $rq->loadPage('../views','listItem.twig')->render($data);