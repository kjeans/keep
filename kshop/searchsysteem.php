<?php

	class searchsysteem {
	
		public static function searchJSON($searchstring) {
			$keywords  = self::translateSearch($searchstring);
			$resultset = self::performSearch($keywords);
			self::displaySearchJSON($resultset);
		}
	
		public static function search($searchstring) {
			$keywords  = self::translateSearch($searchstring);
			$resultset = self::performSearch($keywords);
			self::displaySearchPage($resultset);
		}
	
		public static function translateSearch($searchstring) {
			$words1 = preg_split('#\s+#uD', $searchstring, -1, PREG_SPLIT_NO_EMPTY);
			$words2 = array();
			$blacklist = Array('de','op','ik','in','af','te','een', 'tot', 'van', 'het', 'met', 'aan', 'bij', 'tussen', 'door', 'onder', 'boven');
			foreach($words1 as $word){
				if     (in_array($word, $blacklist)) {}
				elseif (is_numeric($word))           $words2[] = $word;
				elseif (strlen($word) <= 1)          {}
				else                                 $words2[] = $word;
			}
			if (count($words2) > 8)                  $words3 = array_chunk($words2, 8, false)[0];
			else                                     $words3 = $words2;
			return $words3;
		}
	
		public static function performSearch($searchwords) {
			if (empty($searchwords)) return Array();
			$sql  = 'SELECT sub.id, sub.score, notes.title, notes.description FROM '; 
			$sql .= ' ( ';
			$sql .= ' SELECT id, ';
			$lastindex = null;
			//TODO escape speciale karakters in zoekwoorden	
			foreach ($searchwords as $index => $word){
				$word = preg_replace('#[^a-zA-Z0-9\-]#uD', '', $word);
				$sql .= sprintf(" @score%d := (  IF (title LIKE '%%%s%%', 50, 0) + IF (description LIKE '%%%s%%', 50, 0) + IF (color LIKE '%%%s%%', 20, 0) + IF (tags REGEXP '[[:<:]]%s[[:>:]]', 50, 0)  ) as score%d, ",
					$index, $word, $word, $word, $word, $index
				);
				$lastindex = $index;
			}
			$sql .= '@score := 0';
			for ($i = 0; $i <= $lastindex;  $i++) $sql .= sprintf("+ @score%d", $i);
			$sql .= ' as score';
			$sql .= ' FROM notes ';
			$sql .= ' ) sub ';
			$sql .= ' LEFT JOIN notes ON notes.id = sub.id ';
			$sql .= ' WHERE score > 0 ';
			$sql .= ' ORDER BY score DESC, title ASC ';
			$result = mysqli_query(db::getConn(), $sql);
			$data = Array();
			if (mysqli_num_rows($result) >= 1) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			if (!empty($data)) foreach ($data as &$regel) {
				$fotos = notequeries::getNotePictures($regel['id'], true);
				if ($fotos) $regel['foto'] = $fotos[0]['searchfoto'];
			}
			unset($regel);
			// var_export($data);
			return $data;
		}
	
		public static function displaySearchJSON($resultset) {
			echo '[';
			$sep = '';
			if (!empty($resultset)) {
				foreach ($resultset as $notitie) {
					printf($sep . '{
						"value": %s,
						"image": %s,
						"label": %s,
						"tokens": []
					}',
						json_encode($notitie['title']),
						json_encode($notitie['foto']),
						json_encode($notitie['title'])
					); $sep = ',';
				}
			} else {
				printf($sep . '{
					"value": "",
					"label": "Niets gevonden.",
					"tokens": []
				}');
			}
			echo ']';
		}
	
		public static function displaySearchPage($resultset) {
			$ids = '';
			$sep = '';
			$notities = array();
			foreach ($resultset as $note) { $ids .= $sep .$note['id']; $sep = ','; }
			if ($ids) $notities = notequeries::querySearchNotes($ids);
			notefunctions_blader::printNotes($notities, null, true);
		}
	
	
	}