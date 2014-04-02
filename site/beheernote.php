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
	
	$showlist = true;
	$editdata = false;
	
	beheerFunctionsNote::process_updates($editid);
	
	if ($editid > 0){
		$editdata = beheerQueries::getNote($editid);
	}
	
	if ($editdata){
		beheerFunctionsNote::showNoteForm($editid, $editdata);
		$showlist = false;
	}
	elseif ($createnew){
		beheerFunctionsNote::showNoteForm();
		$showlist = false;
	}
	elseif ($deleteid > 0){
		beheerQueries::deleteNote($deleteid);
	}
	elseif ($subtractid > 0){
		beheerQueries::subtractNoteAmount($subtractid);
	}
	
	
	
	if ($showlist){
		$notes = beheerQueries::getAllNote();
		beheerFunctionsNote::showNoteList($notes);
	}
	
	Layout::closeCanvas();
	Layout::drawFooter();
	

	