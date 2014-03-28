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
			printf('<a href="addnote.php?id=1" onclick="false"><img src="images/noteplus1.png"></a>');
			
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
	