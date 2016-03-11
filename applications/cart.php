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
	$_SESSION['page'] = "cart";
	$rq = new request();
	$db = new MysqliDb ('localhost', 'u247008393_reg', '0960ydi', 'u247008393_reg');
	if(count($_SESSION['cart_items'])>0){
    $ids = "";
    //$v = array();
    foreach($_SESSION['cart_items'] as $id=>$value){
        $ids = $ids . $id . ",";
        //$v = explode("&", $value);
        //echo $value;
    		}
    //var_dump($v);
    $ids = rtrim($ids, ',');
    $sqlStr = "SELECT * from list_items where id in (".$ids.")";
    $items = $db->rawQuery($sqlStr);
    }
    $data = array('items' => $items,'action' => $action,'id' => $id,'name' => $name,'page' => $page,'price' => $price, 'quantity' => $quantity, 'count' => $count,'allTotal' => $rq->getTotal());
	echo $rq->loadPage('../views','cart.twig')->render($data);