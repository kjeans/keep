<?php

	class notefunctions_blader {
	
		public static function printNotes($data, $search = false){
			if (count($data) < 1){
				echo 'Er zijn geen notities gevonden.';
			}
			else {
				
				echo '<div class="bladernotities">';
				$lines  = array();
				$done   = false;
				$offset = 0;
				while (!$done) {
					$line = array_slice($data, $offset, 4);
					if (!empty($line)) $lines[] = $line;
					else $done = true;
					$offset += 4;
				}
				//$lines = array_merge($lines, $lines, $lines, $lines, $lines, $lines, $lines, $lines);
				foreach ($lines as $line) {
					printf('<div class="noteregel">');
					foreach ($line as $note){
						self::printNote($note);
					}
					printf('<br class="clear">');
					printf('</div>');
				}
				echo '<br class="clear">';
				echo '</div>';
			}
		}	
	
		protected static function printNote($note){
			$images = notequeries::getNotePictures($note['id'], true);
			$primary  = NULL;
			$char = 20;
			foreach($images as $image){
				$primary = $image['bladerfoto'];
			}
			
			printf('<a href="beheernote.php?edit=%d">', $note['id']);
			printf('<table class="bladernote %s">', $note['color']);
			
			printf('<tr><td class="titel %s">%s', $note['color'], $note['title']);
			if($note['reminder'] == 1){
				printf('<img src="../site/images/reminderon.png">');			
			}
			
			if($note['favorite'] == 1){
				printf('<a onclick="return confirm(\'%s\')" class="favorite"><img src="../site/images/favoriteon.png"></a>', $note['favorite']);	
			}
			elseif($note['favorite'] == 0){
				printf('<a onclick="return confirm(\'%s\')" class="favorite"><img src="../site/images/favoriteoff.png"></a>', $note['favorite']);
			}
			printf('</td></tr>');
			
			printf('<tr><td class="omschrijving"><p>%s</p></td></tr>', ($note['description']));
				
			
			if (!is_null($primary)){
				printf('<tr><td class="foto"><img src="%s" alt=" "></td></tr>',$primary);
			}
			
			
			
			printf('<tr><td>%s</td></tr>', tags($note['tags']));
			printf('<tr><td class="trash"><a href="beheernote.php?delete=%d" onclick="return confirm(\'Weet u zeker dat u dit note wilt verwijderen ?\')" ><img src="../site/images/trash_can.png"></a></td></tr>',$note['id']);
			printf('</table>');
			printf('</a>');
		}	
	}