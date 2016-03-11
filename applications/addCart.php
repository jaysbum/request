<?php
//session_start();
require_once '../classes/request.php';
$rq = new request();
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
$page = isset($_GET['page']) ? $_GET['page'] : "1";
$count = isset($_GET['count']) ? $_GET['count'] : "";
$price = isset($_GET['price']) ? $_GET['price'] : "";
/*
 * check if the 'cart' session array was created
 * if it is NOT, create the 'cart' session array
 */
if(!isset($_SESSION['cart_items'])){
    $_SESSION['cart_items'] = array();
}
 
// check if the item is in the array, if it is, do not add
if( ($rq->getTotal() + ($price * $quantity)) > $_SESSION['budget1'] ){
    // redirect to product list and tell the user it was added to cart
    header('Location: dashboard.php?action=overLimit&page=' . $page);
}
 
// else, add the item to the array
else{
    $_SESSION['cart_items'][$id]=$quantity;
    // redirect to product list and tell the user it was added to cart
    header('Location: dashboard.php?action=added&id=' . $id . '&name=' . $name . '&page=' . $page . '&quantity=' . $quantity . '&count=' . $count . '&price=' . $price);
}
?>