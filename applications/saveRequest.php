<?php
	require_once '../classes/request.php';
	require_once '../classes/mysql.php';
	$rq = new request();
	$db = new MysqliDb ('localhost', 'u247008393_reg', '0960ydi', 'u247008393_reg');
	if($_SERVER['REQUEST_METHOD'] == 'POST' && count($_SESSION['cart_items'])>0){
	    foreach($_SESSION['cart_items'] as $id=>$value){
	        $data = array(
		    		'item_id' => $id,
		    		'budget_id' => $_SESSION['budget_id'],
		    		'quantity' => $value,
		    		'budget' => $_POST['budgetSelect'],
		    		'create_at' => date("Y-m-d H:i:s")  
	        );
	        $id = $db->insert ('request_items', $data);
	    	}
	    	($_POST['budgetSelect'] == 1)?$_SESSION['budget1_exist'] = true:$_SESSION['budget2_exist'] = true;
	    	unset($_SESSION['cart_items']);
	    	header("Location:dashboard.php?action=saved");
    }
