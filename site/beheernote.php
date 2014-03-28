<?php

	require "../kshop/include.php";
	
	Layout::drawHeader();
	Layout::openCanvasAndSidebar('add');
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	$editid = array_key_exists('edit', $_GET) ? (int) $_GET['edit'] : null;
	$deleteid = array_key_exists('delete', $_GET) ? (int) $_GET['delete'] : 0;
	$subtractid = array_key_exists('subtract', $_GET) ? (int) $_GET['subtract'] : 0;
	$createnew = array_key_exists('new', $_GET) ? true : false;
	
	$createnew = true;
	$editdata = false;
	
	beheerFunctionsNote::process_updates($editid);
	
	if ($editid > 0){
		$editdata = beheerQueries::getNote($editid);
	}
	
	if ($editdata){
		beheerFunctionsNote::showNoteForm($editid, $editdata);
	}
	elseif ($createnew){
		beheerFunctionsNote::showNoteForm();
	}
	elseif ($deleteid > 0){
		beheerQueries::deleteNote($deleteid);
	}	
	
	Layout::closeCanvas();
	Layout::drawFooter();
	

	