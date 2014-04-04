<?php

	class beheerQueries{

		public static function prepareNote($notedata){			
			return $notedata;
		}

		public static function createNote($notedata){
			$notedata = self::prepareNote($notedata);
			$noteid = null;
			if ($query = db::getConn()->prepare('INSERT INTO notes (title, description, `type`, archived, reminder,tags, color,`date`,`time`,`datetime`) VALUES (?,?,?,?,?,?,?,?,?,NOW())')){
				mysqli_stmt_bind_param($query, 
					'sssiissss',
					$notedata['title'],
					$notedata['description'],
					$notedata['type'],
					$notedata['archived'],	
					$notedata['reminder'],
					$notedata['tags'], 	
					$notedata['color'], 	
					$notedata['date'], 					
					$notedata['time']
/*			
					$notedata['creator_id'],
					$notedata['extraperson'], 	
*/
				);
				$query->execute();
				$noteid = $query->insert_id;
				$query->close();
			}
			return $noteid;
		}

		public static function updateNote($noteid, $notedata){
			$notedata = self::prepareNote($notedata);			
			if ($query = db::getConn()->prepare('UPDATE notes SET title=?, description=?, `type`=?, archived=?,reminder=?,tags=?, color=?, `date`=?, `time`=?, `datetime`=NOW() WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'sssiissss',
					$notedata['title'],
					$notedata['description'],
					$notedata['type'], 			
					$notedata['archived'], 		
					$notedata['reminder'],	
/*					
					$notedata['extraperson'], 	
	*/
					$notedata['tags'], 	
					$notedata['color'], 	
					$notedata['date'], 					
					$notedata['time'],
					$noteid
				);
				$query->execute();
				$query->close();
			}
		}

		public static function deleteNote($noteid){
			$fotos = self::getNotePicture($noteid);
			foreach ($fotos as $foto){
				self::deleteNotePicture($noteid, $foto['id']);
			}
			if ($query = db::getConn()->prepare('DELETE FROM notes WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$noteid
				);
				$query->execute();
				$query->close();
			}
		}

		public static function getNote($noteid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM notes WHERE id = %d", $noteid));
			$data = false;
			if (mysqli_num_rows($result) == 1) while($query = mysqli_fetch_assoc($result)){
				$data = $query;
			}
			return $data;
		}

		public static function getAllNote(){
			$result = mysqli_query(db::getConn(), "SELECT * FROM notes");
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}


		public static function getNotePicture($noteid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM file WHERE note_id = %d ORDER BY id ASC", $noteid));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}


		public static function deleteNotePicture($noteid, $fotoid){
			if ($query = db::getConn()->prepare('DELETE FROM file WHERE note_id=? and id = ?')) {
				mysqli_stmt_bind_param($query, 
					'ii',
					$noteid,
					$fotoid
				);
				$query->execute();
				$query->close();
				foreach (array('png', 'jpg') as $ext) {
					foreach (array('o', 'b', 'd', 'm') as $code) {
						@unlink(fotopath() . $fotoid . $code . '.' . $ext);
					}
				}
			}	
		}

		public static function createNoteImage($noteid, $filename = null, $extension = null){
			$fotoid = null;
			if ($query = db::getConn()->prepare('INSERT INTO file (note_id, filename, extension) VALUES (?, ?, ?)')) {
				mysqli_stmt_bind_param($query, 
					'iss',
					$noteid,
					$filename,
					$extension
				);
				$query->execute();
				$fotoid = $query->insert_id;
				$query->close();
			}
			return $fotoid;
		}

	}