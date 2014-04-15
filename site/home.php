<?php

require '../kshop/include.php';

	Layout::drawHeader();
	Layout::openCanvasAndSidebar('home');
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	$regel1 = notequeries::queryHomeNotes('notes.datetime DESC'); // nieuwste notes
	$regel2 = notequeries::queryPriveNotes('notes.datetime DESC'); // nieuwste prive notes
	$regel3 = notequeries::queryZakelijkNotes('notes.datetime DESC'); // nieuwste zakelijke notes
	$regel4 = notequeries::queryRemindNotes('notes.datetime DESC'); // nieuwste herinnering notes
	$regel5 = notequeries::queryArchivedNotes('notes.datetime DESC'); // nieuwste herinnering notes
	
		if($site = 'home.php'){
			printf('<h2>Nieuwste notities</h2>');
			notefunctions_blader::printNotes($regel1, true);
		}
		/*
		elseif($note['type'] = 'prive' && ){
			printf('<h2>Prive notities</h2>');
			notefunctions_blader::printNotes($regel2, true);
		}
		elseif($note['type'] = 'zakelijk'){
			printf('<h2>Zakelijke notities</h2>');
			notefunctions_blader::printNotes($regel3, true);
		}
		elseif($note['reminder'] == 1){
			printf('<h2>Notities met herinnering</h2>');
			notefunctions_blader::printNotes($regel4, true);
		}
		elseif($note['archived'] == 1){
			printf('<h2>Gearchiveerde notities</h2>');
			notefunctions_blader::printNotes($regel5, true);
		}
		*/
	Layout::closeCanvas();
	Layout::drawFooter();