<?php
	include_once "database.php";
	
	class Bladermenu {
	
		public static function drawBladermenu($actieveCategorie=0) {
		
			$categorie = $actieveCategorie;
			$echtecategorie = $categorie;
			 
			printf('<div class="sidebarleft">');
			printf( '<ul>');
			printf( '<li><span><a href="#calendar.php">Kalender</a></span></li>');
			printf( '<li><span><a href="#home.php?id=3">Archief</a></span></li>');
			printf( '<li><span><a href="#home.php?id=1">Privé</a></span></li>');
			printf( '<li><span><a href="#home.php?id=2">Zakelijk</a></span></li>');
			printf( '<li><span><a href="#home.php?id=4">Foto, video en bijlagen</a></span></li>');
			printf( '<li><span><a href="#contactlist.php">Contactpersonen</a></span></li>');			
			printf('	<input type="search" placeholder="Persoon zoeken"/>');
			printf( '<li class="emptylast"><span><a href="#" onclick="return false;">&nbsp;</a></span></li>');
			printf( '</ul>');
			printf( '</div>');
		}
		
	}
	