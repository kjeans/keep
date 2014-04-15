<?php

	class notequeries {
	
		
		public static function querySearchNotes($ids){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT notes.* FROM notes
				WHERE notes.id IN (%s)
				ORDER BY notes.title ASC
			", $ids));
			$data = array();
			
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
	
		

		public static function queryNoteInfo($noteid){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT * FROM notes
				WHERE id = %d		
				",$noteid));
			if (mysqli_num_rows($result) !== 1){
				return false;
			} else {
				return mysqli_fetch_assoc($result);
			}
		}
				
		public static function getNotePictures($noteid, $onlyone = false){
			$result = mysqli_query(db::getConn(), sprintf("
				SELECT id, 
				       CONCAT('noteimages/', id, 'b.png') as bladerfoto,
				       CONCAT('noteimages/', id, 'd.png') as detailfoto,
				       CONCAT('noteimages/', id, 'm.png') as microfoto,
				       CONCAT('noteimages/', id, 's.png') as searchfoto,
				       CONCAT('noteimages/', id, 'o.', extension) as origineelfoto
				  FROM file 
				 WHERE note_id = %d 
				 ORDER BY id ASC
				 %s
			", $noteid, 
			($onlyone ? 'LIMIT 0,1' : '')
			));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
		
		/*********************************************************************************
		home
		*********************************************************************************/
		
	
		public static function queryHomeNotes($order){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT * FROM notes
				ORDER BY %s
				LIMIT 8
			",$order));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
		
		/*********************************************************************************
		prive en zakelijk
		*********************************************************************************/
		
		
		public static function queryPriveNotes($order){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT * FROM notes
				WHERE type = 'prive'
				ORDER BY %s
				LIMIT 8
			", $order));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
		public static function queryZakelijkNotes($order){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT * FROM notes
				WHERE type = 'zakelijk'
				ORDER BY %s
				LIMIT 8
			", $order));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
	}