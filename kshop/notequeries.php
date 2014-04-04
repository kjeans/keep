<?php

	class notequeries {
	
		public static function queryCategorieProducten($categorie, $extraWhere='1=1', $sort = '1'){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT product.*, productgroep.name as productgroepnaam, %d  as productgroepid1, productgroep.id as productgroepid2 FROM product
				LEFT JOIN product_productgroep 
				ON product.id = product_productgroep.product_id
				LEFT JOIN productgroep 
				ON product_productgroep.productgroep_id = productgroep.id
				WHERE (productgroep.id = %d OR productgroep.id IN (SELECT id FROM productgroep WHERE parent_id = %d))
				AND product.visible = 1
				AND %s
				GROUP BY product.id
				ORDER BY %s
			", $categorie, $categorie, $categorie, $extraWhere, $sort));
			
			$data = array();
			
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
	
		public static function querySearchProducten($ids){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT product.*, productgroep.name as productgroepnaam, productgroep.id  as productgroepid1, productgroep.id as productgroepid2 FROM product
				LEFT JOIN product_productgroep 
				ON product.id = product_productgroep.product_id
				LEFT JOIN productgroep 
				ON product_productgroep.productgroep_id = productgroep.id
				WHERE product.visible = 1
				AND product.id IN (%s)
				GROUP BY product.id
				ORDER BY product.name ASC
			", $ids));
			
			$data = array();
			
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
	
		public static function queryProductenWinkelwagen($productids){
			if ($productids === '') return array();
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT id, name, price, size, weight, delivery_type, amount as maxamount
				FROM product WHERE id IN (%s) AND visible > 0
				ORDER BY m_date ASC
			", $productids));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}

		public static function queryProductInfo($productid){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT * FROM product
				WHERE id = %d		
				",$productid));
			if (mysqli_num_rows($result) !== 1){
				return false;
			} else {
				return mysqli_fetch_assoc($result);
			}
		}

		public static function queryProductCategorieInfo($productid, $catid){
			$result = mysqli_query(db::getConn(), sprintf("
				SELECT g.id, g.parent_id, g.name,
				IF(g.parent_id is null , null, (SELECT name FROM productgroep y WHERE y.id = g.parent_id)) AS parentname
				FROM product p
				LEFT JOIN product_productgroep x ON p.id = x.product_id
				LEFT JOIN productgroep g ON g.id = x.productgroep_id
				WHERE p.id = %d
				ORDER BY 
				(g.id = %d) DESC,
				id ASC
				LIMIT 1
				",$productid, $catid));
			if (mysqli_num_rows($result) !== 1){
				return false;
			} else {
				return mysqli_fetch_assoc($result);
			}
		}
	
	
		public static function queryCategorieInformatie($categorieid){
			$result = mysqli_query(db::getConn(), sprintf("
	            SELECT *, 
				IF(parent_id is null , filter_share, (SELECT filter_share FROM productgroep x WHERE x.id = p.parent_id)) AS sharefilter,
				IF(parent_id is null , null, (SELECT name FROM productgroep x WHERE x.id = p.parent_id)) AS parentname
				FROM productgroep p
				WHERE id = %d		
				",$categorieid));
			if (mysqli_num_rows($result) !== 1){
				return false;
			} else {
				return mysqli_fetch_assoc($result);
			}
		}

		public static function queryMerklijst($cat1, $cat2){
			$result = mysqli_query(db::getConn(), sprintf("
				SELECT DISTINCT brand, sha1(brand) as brandcode FROM product p
				LEFT JOIN product_productgroep x ON p.id = x.product_id
				LEFT JOIN productgroep g ON x.productgroep_id = g.id
				WHERE (g.id = %d OR g.parent_id = %d)
				AND brand IS NOT NULL
				",$cat1, $cat1));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
		
		public static function queryMatenlijst($cat1, $cat2){
			$result = mysqli_query(db::getConn(), sprintf("
				SELECT DISTINCT size, sha1(size) as sizecode FROM product p
				LEFT JOIN product_productgroep x ON p.id = x.product_id
				LEFT JOIN productgroep g ON x.productgroep_id = g.id
				WHERE (g.id = %d OR g.parent_id = %d)
				AND size IS NOT NULL
				",$cat2, $cat2));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
		public static function getNotePictures($noteid, $onlyone = false){
			$result = mysqli_query(db::getConn(), sprintf("
				SELECT id, 
				       CONCAT('noteimages/', id, 'b.png') as bladerfoto,
				       CONCAT('noteimages/', id, 'd.png') as detailfoto,
				       CONCAT('noteimages/', id, 'm.png') as microfoto,
				       CONCAT('noteimages/', id, 's.png') as searchfoto,
				       CONCAT('noteimages/', id, 'o.', extension) as origineelfoto
				  FROM image 
				 WHERE note_id = %d 
				 ORDER BY id ASC
				 %s
			", $productid, 
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
				LIMIT 4
			", $order));
			$data = array();
			if (mysqli_num_rows($result) > 0) while($query = mysqli_fetch_assoc($result)){
				$data[] = $query;
			}
			return $data;
		}
		
	}