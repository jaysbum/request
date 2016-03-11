<?php
require_once '../classes/request.php';
$rq = new request();
$id = isset($_GET['id']) ? $_GET['id'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
$from = isset($_GET['from']) ? $_GET['from'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : "1";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$count = isset($_GET['count']) ? $_GET['count'] : "";
$price = isset($_GET['price']) ? $_GET['price'] : "";

if(($rq->getTotal() + (($price * $quantity) - ($price * $_SESSION['cart_items'][$id]))) > $_SESSION['budget1']){
	if($from == "cart"){
		header('Location: cart.php?action=overLimit'); 
	}else{
		header('Location: dashboard.php?action=overLimit'); 
	}
}else{
	$_SESSION['cart_items'][$id] = $quantity;
	if($from == "cart"){
		header('Location: cart.php?action=updated&page='.$page.'&id=' . $id .'&name=' . $name .'&quantity=' . $quantity . '&count=' . $count . '&price=' . $price);
	}else if($from == "list"){
		header('Location: dashboard.php?action=updated&page='.$page.'&id=' . $id .'&name=' . $name .'&quantity=' . $quantity . '&count=' . $count . '&price=' . $price);	
	}
}
?>