<?php
printf('<html>');
printf('	<head>');
printf('		<title>Keep in Touch</title>');
printf('		<link href="style.css" rel="stylesheet" type="text/css"/>');
printf('	</head>');
printf('<body>');
printf('<div class="sidebar">');
printf('	<a href="#">Kalender</a>');
printf('	<a href="#">Archief</a>');
printf('	<a href="#">Priv&eacute;</a>');
printf('	<a href="#">Zakelijk</a>');
printf('	<a href="#">Contactpersonen</a>');
printf('	<p class="empty"></p>');
printf('	<input type="search" placeholder="Persoon zoeken"/>');
printf('</div>');
printf('<div class="all">');
printf('<div class="home">');
printf('<a href="#" class="tekst">Meest recent</a>');
printf('<a href="#" class="tekst">Herinnering</a>');
printf('<a href="#" class="tekst">Afgerond</a>');
printf('<select class="sort">');
printf('<option value="datumop" selected="selected">Datum oplopend</option>');
printf('<option value="datumaf" selected="">Datum aflopend</option>');
printf('<option value="contactop" selected="">Contactpersoon oplopend</option>');
printf('<option value="contactaf" selected="">Contactpersoon aflopend</option>');
printf('</select>');
printf('<input type="search" placeholder="Zoeken in notities"/>');
printf('<a href="#"><img src="images/noteplus.png"></a>');
printf('</div>');
printf('');
printf('');
printf('');
	for($i = 1; $i <=8; $i++){
		printf('<a href="#"><table class="bladernote">');
		printf('<tr><td class="naam">Hallo</td></tr>');
		printf('<tr><td class="omschrijving">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.
		Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus.
		Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci.
		</td></tr>');
	printf('</table></a>');
	}

printf('</div>');
printf('</body>');
printf('</html>');