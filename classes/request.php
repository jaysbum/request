<?php
	session_start();
	class request {
		function __construct() {
		    require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
		    require_once 'mysql.php';
		}
		function loadPage($folder,$file){
		    Twig_Autoloader::register();
		    $loader = new Twig_Loader_Filesystem($folder);
		    $twig = new Twig_Environment($loader);
			$twig->addExtension(new Twig_Extension_Debug());
		    $twig->addGlobal("session", $_SESSION);
		    $template = $twig->loadTemplate($file);
		    return $template;
		}
		function getTotal(){
			$total = 0;
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
			    foreach($items as $item){
				    $total = $total + ( $item['price'] * $_SESSION['cart_items'][$item['id']] );
			    }
		    }
		    return $total;
		}
	}
	