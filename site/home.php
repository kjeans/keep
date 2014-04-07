<?php

require '../kshop/include.php';

	Layout::drawHeader();
	Layout::openCanvasAndSidebar('home');
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	$regel1 = notequeries::queryHomeNotes('1=1', 'notes.datetime DESC'); // nieuwste items
	/*
	for($i = 1; $i <=8; $i++){
		printf('<div class="bladernote">');
		printf('<a href="#">');
		printf('<div class="naam">Hallo</div>');
		printf('<div class="omschrijving">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.
		Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus.
		Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci.
		</div>');
		printf('</a>');
		printf('</div>');
	}
	*/
	Layout::closeCanvas();
	Layout::drawFooter();