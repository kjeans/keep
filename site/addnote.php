<?php
require '../kshop/include.php';
	Layout::drawHeader();
	Layout::openCanvasAndSidebar('home');
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	
	printf('<h1>Nieuwe notitie aanmaken</h1>');
	printf('<div class="makenote">');
	printf('<form method="POST">');
			printf('<div class="headernote">');
			printf('<input type="text" placeholder="Vul hier de titel in">');
			printf('<a href="#"><img src="images/noteplus1.png"></a>');
			printf('</div>');
			printf('<div class="description">');
			printf('<textarea placeholder="Vul hier de omschrijving in"></textarea>');
			printf('</div>');
			printf('<div class="tags">');
			printf('<input type="text" placeholder="Vul hier de tags in">');
			printf('</div>');
			printf('<div class="time">');
			printf('<label>Tijd: </label>');
			printf('<input type="time" placeholder="Vul hier de tijd in">');
			printf('</div>');
			printf('<div class="date">');
			printf('<label>Datum: </label>');
			printf('<input type="date" placeholder="Vul hier de datum in">');
			printf('</div>');
	printf('</form>');
	printf('<input type="submit" value="Annuleren" class="left">');
	printf('<input type="submit" value="Opslaan" class="right">');
	printf('</div>');
	Layout::closeCanvas();
	Layout::drawFooter();
	/*
	<?php

	require "../kshop/include.php";
	Admin::demandAdmin();
	
	Layout::drawHeader();
	Layout::openCanvasAndSidebar('white');
	Bladermenu::drawBladermenu();
	Filtermenu::drawFiltermenu();
	Layout::closeSidebar();
	
	$editid = array_key_exists('edit', $_GET) ? (int) $_GET['edit'] : null;
	$deleteid = array_key_exists('delete', $_GET) ? (int) $_GET['delete'] : 0;
	$createnew = array_key_exists('new', $_GET) ? true : false;
	
	$showlist = true;
	$editdata = false;
	
	beheerFunctionsCategorie::process_updates($editid);
	
	if ($editid > 0){
		$editdata = beheerQueries::getCategorie($editid);
	}
	
	if ($editdata){
		beheerFunctionsCategorie::showProductForm($editid, $editdata);
		$showlist = false;
	}
	elseif ($createnew){
		beheerFunctionsCategorie::showProductForm();
		$showlist = false;
	}
	elseif ($deleteid > 0){
		beheerQueries::deleteCategorie($deleteid);
	}
	
	
	
	if ($showlist){
		$categorien = beheerQueries::getAllCategorie();
		beheerFunctionsCategorie::showCategorieList($categorien);
	}
	
	
	
	Layout::closeCanvas();
	Layout::drawFooter();
	

	*/