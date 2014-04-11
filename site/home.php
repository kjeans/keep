<?php

require '../kshop/include.php';

	Layout::drawHeader();
	Layout::openCanvasAndSidebar('home');
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	
	
	$regel1 = notequeries::queryHomeNotes('notes.datetime DESC'); // nieuwste notes
	
	
		printf('<h2>Nieuwste notities</h2>');
		notefunctions_blader::printNotes($regel1, true);
	Layout::closeCanvas();
	Layout::drawFooter();