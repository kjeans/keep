<?php

	class beheerQueries{
	
	
		public static function prepareProduct($productdata){
			if(!$productdata['allow_bid']){
				$productdata['min_bid'] = null;
			}
			if(!is_null($productdata['price_old']) && $productdata['price'] > $productdata['price_old']){
				$productdata['price_old'] = null;
			}
			return $productdata;
		}
	
	
		public static function createProduct($productdata){
			$productdata = self::prepareProduct($productdata);
			$productid = null;
			if ($query = db::getConn()->prepare('INSERT INTO product (name,size,price,price_old,brand,description,keywords,color,gender,age,marktplaats_url,dimension,weight,delivery_type,amount, allow_trade, allow_bid,min_bid, visible, c_date, m_date) VALUES (?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NOW(), NOW() )')) {
				mysqli_stmt_bind_param($query, 
					'ssiissssssssiiiiiii',
					$productdata['name'],
					$productdata['size'],
					$productdata['price'], 			
					$productdata['price_old'], 		
					$productdata['brand'],	
					$productdata['description'], 	
					$productdata['keywords'], 	
					$productdata['color'], 	
					$productdata['gender'], 	
					$productdata['age'], 					
					$productdata['marktplaats_url'], 
					$productdata['dimension'], 		
					$productdata['weight'], 			
					$productdata['delivery_type'], 	
					$productdata['amount'], 		
					$productdata['allow_trade'], 		
					$productdata['allow_bid'], 		
					$productdata['min_bid'],
					$productdata['visible']
				);
				$query->execute();
				$productid = $query->insert_id;
				$query->close();
			}
			return $productid;
		}
		
		public static function updateProduct($productid, $productdata){
			$productdata = self::prepareProduct($productdata);
			if ($query = db::getConn()->prepare('UPDATE product SET name=?, size=?, price=?,price_old=?,brand=?,description=?,keywords=?,color=?, gender=?, age=?, marktplaats_url=?,dimension=?,weight=?,delivery_type=?,amount=?, allow_trade=?, allow_bid=?,min_bid=?, visible=?, m_date=NOW() WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'ssiissssssssiiiiiiii',
					$productdata['name'],
					$productdata['size'],
					$productdata['price'], 			
					$productdata['price_old'], 		
					$productdata['brand'],	
					$productdata['description'], 	
					$productdata['keywords'], 	
					$productdata['color'], 	
					$productdata['gender'], 	
					$productdata['age'], 	
					$productdata['marktplaats_url'], 
					$productdata['dimension'], 		
					$productdata['weight'], 			
					$productdata['delivery_type'], 	
					$productdata['amount'], 		
					$productdata['allow_trade'], 	
					$productdata['allow_bid'], 		
					$productdata['min_bid'], 
					$productdata['visible'], 	
					$productid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function subtractProductAmount($productid){
			if ($query = db::getConn()->prepare('UPDATE product SET amount=IF(amount>1,amount-1,amount), visible=IF(amount>1,visible,0) WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$productid
				);
				$query->execute();
				$query->close();
			}
		}
		
		
		public static function createCategorie($categoriedata){
			$categorieid = null;
			if ($query = db::getConn()->prepare('INSERT INTO productgroep (name,offset,parent_id, filter_color, filter_price, filter_brand, filter_gender, filter_age,filter_size, filter_share) VALUES (?, ?, ?, ?,?,?,?,?,?,?)')) {
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
			if ($query = db::getConn()->prepare('UPDATE productgroep SET name=?, offset=?, parent_id=?, filter_color=?, filter_price=?, filter_brand=?, filter_gender=?, filter_age=?,filter_size=?, filter_share=? WHERE id=?')) {
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
		
		
		
		
		
		public static function deleteProduct($productid){
			$fotos = self::getProductPicture($productid);
			foreach ($fotos as $foto){
				self::deleteProductPicture($productid, $foto['id']);
			}
			if ($query = db::getConn()->prepare('DELETE FROM product WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$productid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function deleteCategorie($categorieid){
			if ($query = db::getConn()->prepare('DELETE FROM productgroep WHERE id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$categorieid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function getProduct($productid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM product WHERE id = %d", $productid));
			$data = false;
			if (mysqli_num_rows($result) == 1) while($query = mysqli_fetch_assoc($result)){
				$data = $query;
			}
			return $data;
		}
		
		public static function getCategorie($categorieid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM productgroep WHERE id = %d", $categorieid));
			$data = false;
			if (mysqli_num_rows($result) == 1) while($query = mysqli_fetch_assoc($result)){
				$data = $query;
			}
			return $data;
		}
		
		public static function getAllProduct(){
			$result = mysqli_query(db::getConn(), "SELECT * FROM product");
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
				
		public static function getProductPicture($productid){
			$result = mysqli_query(db::getConn(), sprintf("SELECT * FROM image WHERE product_id = %d ORDER BY id ASC", $productid));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
		public static function getAllCategorie(){
			$result = mysqli_query(db::getConn(), "(	
							SELECT id, name, `offset`, id as parentid, 1 as parent, `offset` as parentoffset, name as fullname FROM productgroep		
							WHERE parent_id is null
						)
						UNION ALL
						(
							SELECT c.id, c.name, c.`offset`, c.parent_id as parentid, 0 as parent, p.`offset` as parentoffset, concat(p.name, ': ', c.name) as fullname
							FROM productgroep as c		
							INNER JOIN productgroep as p on c.parent_id = p.id 
							WHERE c.parent_id is not null	and p.parent_id is null	
						)
						ORDER BY parentoffset DESC, parentid ASC, parent DESC, `offset` DESC, id ASC");
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		public static function getExistCategorie($productid){
			$data = array();
			$groepid = null;
			if ($query = db::getConn()->prepare('SELECT productgroep_id FROM product_productgroep WHERE product_id = ?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$productid
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
		
		public static function deleteProductPicture($productid, $fotoid){
			if ($query = db::getConn()->prepare('DELETE FROM image WHERE product_id=? and id = ?')) {
				mysqli_stmt_bind_param($query, 
					'ii',
					$productid,
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
		
		public static function deleteProductCategorieLinks($productid){
			if ($query = db::getConn()->prepare('DELETE FROM product_productgroep WHERE product_id=?')) {
				mysqli_stmt_bind_param($query, 
					'i',
					$productid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function updateProductVisibility($ids, $show = true){
			if ($query = db::getConn()->prepare(sprintf('UPDATE product SET visible = %d WHERE id IN (%s)', 
				($show ? 1 : 0),
				implode(',', $ids)
			))) {
				$query->execute();
				$query->close();
			}
		}
	
	
		public static function createProductCategorieLink($productid, $groepid){
			if ($query = db::getConn()->prepare('INSERT INTO product_productgroep (product_id, productgroep_id) VALUES (?, ?)')) {
				mysqli_stmt_bind_param($query, 
					'ii',
					$productid,
					$groepid
				);
				$query->execute();
				$query->close();
			}
		}
		
		public static function createProductImage($productid, $filename = null, $extension = null){
			$fotoid = null;
			if ($query = db::getConn()->prepare('INSERT INTO image (product_id, filename, extension) VALUES (?, ?, ?)')) {
				mysqli_stmt_bind_param($query, 
					'iss',
					$productid,
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