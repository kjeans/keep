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
			foreach($images as $image){
				$primary = $image['bladerfoto'];
			}
			
			printf('<a href="beheernote.php?edit=%d">', $note['id']);
			printf('<table class="bladernote %s">', $note['color']);
			if($note['reminder'] == 1 && $note['favorite'] == 1){
				printf('<tr><td class="titel %s">%s <img src="../site/images/reminderon.png"><img src="../site/images/favoriteon.png"></td></tr>',  $note['color'], $note['title']);			
			}
			elseif($note['reminder'] == 1 && $note['favorite'] == 0){
				printf('<tr><td class="titel %s">%s <img src="../site/images/reminderon.png"><img src="../site/images/favoriteoff.png"></td></tr>',  $note['color'], $note['title']);			
			}
			elseif($note['reminder'] == 0 && $note['favorite'] == 1){
				printf('<tr><td class="titel %s">%s<img src="../site/images/favoriteon.png"></td></tr>',  $note['color'], $note['title']);			
			}
			elseif($note['reminder'] == 0 && $note['favorite'] == 0){
				printf('<tr><td class="titel %s">%s <img src="../site/images/favoriteoff.png"></td></tr>',  $note['color'], $note['title']);	
			}
			printf('<tr><td class="omschrijving">%s</td></tr>', ($note['description']));
			if (!is_null($primary)){
				printf('<tr><td class="foto"><img src="%s" alt=" "></td></tr>',$primary);
			}
			printf('<tr><td class="tags">%s</td></tr>', tags($note['tags']));
			printf('</table>');
			printf('</a>');
		}	
	}