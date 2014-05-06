<?php
	include_once "database.php";

	class Bladermenu {

		public static function drawBladermenu() {

			printf('<div class="sidebarleft">');
			printf( '<ul>');
			printf( '<li><span><a href="#calendar.php">Kalender</a></span></li>');
			printf( '<li><span><a href="home.php?archived=1">Archief</a></span></li>');
			printf( '<li><span><a href="home.php?type=prive">Privé</a></span></li>');
			printf( '<li><span><a href="home.php?type=zakelijk">Zakelijk</a></span></li>');
			printf( '<li><span><a href="#?id=4">Foto, video en bijlagen</a></span></li>');
			printf( '<li><span><a href="#contactlist.php">Contactpersonen</a></span></li>');	
			printf( '<li class="emptylast"><span><a href="#" onclick="return false;">&nbsp;</a></span></li>');
			printf('	<input type="search" placeholder="Persoon zoeken"/>');
			printf( '</ul>');
			printf( '</div>');
		}

	}
