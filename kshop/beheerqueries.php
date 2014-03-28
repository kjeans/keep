<?php

	class beheerQueries{
	
	
		public static function createNote($notedata){
			$noteid = null;
			if ($query = db::getConn()->prepare('INSERT INTO note (name,size,price,price_old,brand,description,keywords,color,gender,age,marktplaats_url,dimension,weight,delivery_type,amount, allow_trade, allow_bid,min_bid, visible, c_date, m_date) VALUES (?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NOW(), NOW() )')) {
				mysqli_stmt_bind_param($query, 
					'ssiissssssssiiiiiii',
					$notedata['name'],
					$notedata['size'],
					$notedata['price'], 			
					$notedata['price_old'], 		
					$notedata['brand'],	
					$notedata['description'], 	
					$notedata['keywords'], 	
					$notedata['color'], 	
					$notedata['gender'], 	
					$notedata['age'], 					
					$notedata['marktplaats_url'], 
					$notedata['dimension'], 		
					$notedata['weight'], 			
					$notedata['delivery_type'], 	
					$notedata['amount'], 		
					$notedata['allow_trade'], 		
					$notedata['allow_bid'], 		
					$notedata['min_bid'],
					$notedata['visible']
				);
				$query->execute();
				$noteid = $query->insert_id;
				$query->close();
			}
			return $noteid;
		}
		
		public static function updateNote($noteid, $notedata)
			if ($query = db::getConn()->prepare('UPDATE note SET name=?, size=?, price=?,price_old=?,brand=?,description=?,keywords=?,color=?, gender=?, age=?, marktplaats_url=?,dimension=?,weight=?,delivery_type=?,amount=?, allow_trade=?, allow_bid=?,min_bid=?, visible=?, m_date=NOW() WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'ssiissssssssiiiiiiii',
					$notedata['name'],
					$notedata['size'],
					$notedata['price'], 			
					$notedata['price_old'], 		
					$notedata['brand'],	
					$notedata['description'], 	
					$notedata['keywords'], 	
					$notedata['color'], 	
					$notedata['gender'], 	
					$notedata['age'], 	
					$notedata['marktplaats_url'], 
					$notedata['dimension'], 		
					$notedata['weight'], 			
					$notedata['delivery_type'], 	
					$notedata['amount'], 		
					$notedata['allow_trade'], 	
					$notedata['allow_bid'], 		
					$notedata['min_bid'], 
					$notedata['visible'], 	
					$noteid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function subtractNoteAmount($noteid){
			if ($query = db::getConn()->prepare('UPDATE note SET amount=IF(amount>1,amount-1,amount), visible=IF(amount>1,visible,0) WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$noteid
				);
				$query->execute();
				$query->close();
			}
		}
		
		
		public static function createCategorie($categoriedata){
			$categorieid = null;
			if ($query = db::getConn()->prepare('INSERT INTO notegroep (name,offset,parent_id, filter_color, filter_price, filter_brand, filter_gender, filter_age,filter_size, filter_share) VALUES (?, ?, ?, ?,?,?,?,?,?,?)')) {
				mysqli_stmt_bind_param($query, 
					'siiiiiiiii',
					$categoriedata['name'],
					$categoriedata['offset'],
					$categoriedata['parent_id'],
					$categoriedata['filter_color'],
					$categoriedata['filter_price'],
					$categoriedata['filter_brand'],
					$categoriedata['filter_gender'],
					$categoriedata['filter_age'],
					$categoriedata['filter_size'],
					$categoriedata['filter_share']
				);
				$query->execute();
				$categorieid = $query->insert_id;
				$query->close();
			}
			return $categorieid;
		}
		
		public static function updateCategorie($categorieid, $categoriedata){
			if ($query = db::getConn()->prepare('UPDATE notegroep SET name=?, offset=?, parent_id=?, filter_color=?, filter_price=?, filter_brand=?, filter_gender=?, filter_age=?,filter_size=?, filter_share=? WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'siiiiiiiiii',
					$categoriedata['name'],
					$categoriedata['offset'],
					$categoriedata['parent_id'],
					$categoriedata['filter_color'],
					$categoriedata['filter_price'],
					$categoriedata['filter_brand'],
					$categoriedata['filter_gender'],
					$categoriedata['filter_age'],
					$categoriedata['filter_size'],
					$categoriedata['filter_share'],
					$categorieid
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
			if ($query = db::getConn()->prepare('DELETE FROM note WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$noteid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function deleteCategorie($categorieid){
			if ($query = db::getConn()->prepare('DELETE FROM notegroep WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$categorieid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function getNote($noteid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM note WHERE id = %d", $noteid));
			$data = false;
			if (mysqli_num_rows($result) == 1) while($query = mysqli_fetch_assoc($result)){
				$data = $query;
			}
			return $data;
		}
		
		public static function getCategorie($categorieid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM notegroep WHERE id = %d", $categorieid));
			$data = false;
			if (mysqli_num_rows($result) == 1) while($query = mysqli_fetch_assoc($result)){
				$data = $query;
			}
			return $data;
		}
		
		public static function getAllNote(){
			$result = mysqli_query(db::getConn(), "SELECT * FROM note");
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
				
		public static function getNotePicture($noteid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM image WHERE note_id = %d ORDER BY id ASC", $noteid));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
		public static function getAllCategorie(){
			$result = mysqli_query(db::getConn(), "(	
							SELECT id, name, `offset`, id as parentid, 1 as parent, `offset` as parentoffset, name as fullname FROM notegroep		
							WHERE parent_id is null
						)
						UNION ALL
						(
							SELECT c.id, c.name, c.`offset`, c.parent_id as parentid, 0 as parent, p.`offset` as parentoffset, concat(p.name, ': ', c.name) as fullname
							FROM notegroep as c		
							INNER JOIN notegroep as p on c.parent_id = p.id 
							WHERE c.parent_id is not null	and p.parent_id is null	
						)
						ORDER BY parentoffset DESC, parentid ASC, parent DESC, `offset` DESC, id ASC");
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		public static function getExistCategorie($noteid){
			$data = array();
			$groepid = null;
			if ($query = db::getConn()->prepare('SELECT notegroep_id FROM note_notegroep WHERE note_id = ?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$noteid
				);
				$query->execute();
				$query->bind_result($groepid);
				while($query->fetch()){
					$data[]=$groepid;
				}				
				$query->close();
			}
			return $data;
		}
		
		public static function deleteNotePicture($noteid, $fotoid){
			if ($query = db::getConn()->prepare('DELETE FROM image WHERE note_id=? and id = ?')) {
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
		
		public static function deleteNoteCategorieLinks($noteid){
			if ($query = db::getConn()->prepare('DELETE FROM note_notegroep WHERE note_id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$noteid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function updateNoteVisibility($ids, $show = true){
			if ($query = db::getConn()->prepare(sprintf('UPDATE note SET visible = %d WHERE id IN (%s)', 
				($show ? 1 : 0),
				implode(',', $ids)
			))) {
				$query->execute();
				$query->close();
			}
		}
	
	
		public static function createNoteCategorieLink($noteid, $groepid){
			if ($query = db::getConn()->prepare('INSERT INTO note_notegroep (note_id, notegroep_id) VALUES (?, ?)')) {
				mysqli_stmt_bind_param($query, 
					'ii',
					$noteid,
					$groepid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function createNoteImage($noteid, $filename = null, $extension = null){
			$fotoid = null;
			if ($query = db::getConn()->prepare('INSERT INTO image (note_id, filename, extension) VALUES (?, ?, ?)')) {
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