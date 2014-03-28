<?php

	class Layout {
	
public static function drawFooter() {

printf('		</div>');
printf('		<div class="footer">');
printf('			<p>&copy; Copyright 2014 | Kate Schirm &amp; Adem K</p>');
printf('		</div>');
printf('	</body>');
printf('</html>');

		}
	
public static function drawHeader() {

printf('			<!DOCTYPE html>');
printf('<html>');
printf('	<head>');
printf('		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">');
printf('		<title>Keep in Touch</title>');
printf('		<link rel="stylesheet" type="text/css" href="style.css">');		
?>
<script>	

</script>	
<?php
printf('	</head>');
printf('<body>');

printf('<div class="outside">');
printf('<div class="header">');
printf('	<ul class="content">');
printf('		<li class="img"><a href="home.php">Keep in Touch!</a></li>');
printf('		<li class="circle" title="Notitie toevoegen"><a href="addnote.php"><img src="images/noteplus1.png"></a></li>');
printf('		<li><a href="#">Meest recent</a></li>');
printf('		<li><a href="#">Herinnering</a></li>');
printf('		<li><a href="#">Afgerond</a></li>');
printf('		<li>');
printf('		<select>');
printf('			<option value="1">Contactpersoon oplopend</option>');
printf('			<option value="2">Contactpersoon aflopend</option>');
printf('		</select>');
printf('		</li>');
printf('		<li><input type="search" placeholder="Zoeken in notities"></li>');
printf('	</ul>');
printf('</div>');			
}
		
		public static function openCanvasAndSidebar($pageclass) {
			printf('<table class="all %s">', $pageclass);
			echo '<tr>';
			echo '<td class="sidebar">';
		}
		
		public static function closeSidebar() {
			echo '</td>';
			echo '<td class="canvasO">';
			echo '<div class="canvas">';
		}
		
		public static function closeCanvas() {
			echo '</div>';
			echo '&nbsp;';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
		}
	}