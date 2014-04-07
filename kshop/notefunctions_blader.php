<?php

	class notefunctions_blader {
	
		public static function printNotes($data, $search = false){
			if (count($data) < 1){
				echo 'Er zijn geen producten gevonden.';
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
						self::printNote($note['id']);
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
			foreach($images as $image){
				$primary = $image['bladerfoto'];
			}
			printf('<a href="#">', $note['id']);
			printf('<table class="bladernote">');
			printf('<tr><td class="foto"><img src="%s" alt=" "></td></tr>',$primary);
			printf('<tr><td class="titel">%s</td></tr>', $note['title']);
			printf('</table>');
			printf('</a>');
		}	
	}