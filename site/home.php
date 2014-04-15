<?php

require '../kshop/include.php';

	Layout::drawHeader();
	Layout::openCanvasAndSidebar('home');
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	$regel1 = notequeries::queryHomeNotes('notes.datetime DESC'); // nieuwste notes
	$regel2 = notequeries::queryPriveNotes('notes.datetime DESC'); // nieuwste prive notes
	$regel3 = notequeries::queryZakelijkNotes('notes.datetime DESC'); // nieuwste zakelijke notes
	
			printf('<h2>Nieuwste notities</h2>');
			notefunctions_blader::printNotes($regel1, true);
		/*
		elseif($note['type'] = 'prive'){
			printf('<h2>Prive notities</h2>');
			notefunctions_blader::printNotes($regel2, true);
		}
		elseif($note['type'] = 'zakelijk'){
			printf('<h2>Zakelijke notities</h2>');
			notefunctions_blader::printNotes($regel3, true);
		}*/
	Layout::closeCanvas();
	Layout::drawFooter();