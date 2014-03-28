<?php

	require "../kshop/include.php";
	
	Layout::drawHeader();
	Layout::openCanvasAndSidebar();
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	$editid = array_key_exists('edit', $_GET) ? (int) $_GET['edit'] : null;
	$deleteid = array_key_exists('delete', $_GET) ? (int) $_GET['delete'] : 0;
	$subtractid = array_key_exists('subtract', $_GET) ? (int) $_GET['subtract'] : 0;
	$createnew = array_key_exists('new', $_GET) ? true : false;
	
	$showlist = true;
	$editdata = false;
	
	beheerFunctionsNotitie::process_updates($editid);
	
	if ($editid > 0){
		$editdata = beheerQueries::getProduct($editid);
	}
	
	if ($editdata){
		beheerFunctionsProduct::showProductForm($editid, $editdata);
		$showlist = false;
	}
	elseif ($createnew){
		beheerFunctionsProduct::showProductForm();
		$showlist = false;
	}
	elseif ($deleteid > 0){
		beheerQueries::deleteProduct($deleteid);
	}
	elseif ($subtractid > 0){
		beheerQueries::subtractProductAmount($subtractid);
	}
	
	
	
	if ($showlist){
		$producten = beheerQueries::getAllProduct();
		beheerFunctionsProduct::showProductList($producten);
	}
	
	
	
	Layout::closeCanvas();
	Layout::drawFooter();
	

	