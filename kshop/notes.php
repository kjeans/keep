<?php
	
	class notes {
		
		public static function init($reset = false){
			if ($reset || !array_key_exists('producten',              $_SESSION)) $_SESSION['producten'] = array();
			if ($reset || !array_key_exists('winkelwagen_aantal',     $_SESSION)) $_SESSION['winkelwagen_aantal'] = 0;
			if ($reset || !array_key_exists('winkelwagen_totaal',     $_SESSION)) $_SESSION['winkelwagen_totaal'] = 0;
			if ($reset || !array_key_exists('persoon_aanhef',         $_SESSION)) $_SESSION['persoon_aanhef'] = NULL;
			if ($reset || !array_key_exists('persoon_voornaam',       $_SESSION)) $_SESSION['persoon_voornaam'] = NULL;
			if ($reset || !array_key_exists('persoon_tussenvoegsel',  $_SESSION)) $_SESSION['persoon_tussenvoegsel'] = NULL;
			if ($reset || !array_key_exists('persoon_achternaam',     $_SESSION)) $_SESSION['persoon_achternaam'] = NULL;
			if ($reset || !array_key_exists('persoon_email',          $_SESSION)) $_SESSION['persoon_email'] = NULL;
			if ($reset || !array_key_exists('verzend_ophalen',        $_SESSION)) $_SESSION['verzend_ophalen'] = NULL;
			if ($reset || !array_key_exists('adres1_postcode',        $_SESSION)) $_SESSION['adres1_postcode'] = NULL;
			if ($reset || !array_key_exists('adres1_huisnummer',      $_SESSION)) $_SESSION['adres1_huisnummer'] = NULL;
			if ($reset || !array_key_exists('adres1_straat',          $_SESSION)) $_SESSION['adres1_straat'] = NULL;
			if ($reset || !array_key_exists('adres1_plaats',          $_SESSION)) $_SESSION['adres1_plaats'] = NULL;
			if ($reset || !array_key_exists('adres2_postcode',        $_SESSION)) $_SESSION['adres2_postcode'] = NULL;
			if ($reset || !array_key_exists('adres2_huisnummer',      $_SESSION)) $_SESSION['adres2_huisnummer'] = NULL;
			if ($reset || !array_key_exists('adres2_straat',          $_SESSION)) $_SESSION['adres2_straat'] = NULL;
			if ($reset || !array_key_exists('adres2_plaats',          $_SESSION)) $_SESSION['adres2_plaats'] = NULL;
			if ($reset || !array_key_exists('adres_zelfde',           $_SESSION)) $_SESSION['adres_zelfde'] = true;
			if ($reset || !array_key_exists('verzend_methode',        $_SESSION)) $_SESSION['verzend_methode'] = NULL;
			if ($reset || !array_key_exists('betaal_methode',         $_SESSION)) $_SESSION['betaal_methode'] = NULL;
			if ($reset || !array_key_exists('betaal_bank',            $_SESSION)) $_SESSION['betaal_bank'] = NULL;
		}
		
		public static function addProduct($productid, $amount){
			$_SESSION['producten'][$productid] = $amount;
			self::getAllProducts();
			Header('Location: ?');
			Exit(0);
		}
		
		public static function changeProduct($productid, $amount){
			$_SESSION['producten'][$productid] = $amount;
			self::getAllProducts();
			Header('Location: ?');
			Exit(0);
		}
		
		public static function deleteProduct($productid){
			unset($_SESSION['producten'][$productid]);
			self::getAllProducts();
			Header('Location: ?');
			Exit(0);
		}
		
		public static function clear(){
			self::init(true);
		}
		
		public static function getTotals(){
			return Array(
				'count' => $_SESSION['winkelwagen_aantal'],
				'price' => $_SESSION['winkelwagen_totaal'],
			);
		}
		
		public static function getAllProducts(){
			$productids = '';
			$sep = '';
			foreach($_SESSION['producten'] as $productid => $productaantal) {
				$productids .= $sep . $productid;
				$sep = ',';
			}
			// zoekt producten uit database
			$producten = productqueries::queryProductenWinkelwagen($productids);
			// gegevens uit sessie en db samenvoegen
			foreach($_SESSION['producten'] as $productid => $productaantal) {
				foreach ($producten as &$product){
					if ($product['id'] == $productid){
						$product['id']              = (int) $product['id'];
						$product['maxamount']       = (int) $product['maxamount'];
						$product['price']           = (int) $product['price'];
						$product['amount']          = (int) $productaantal;
						$product['totalprice']      = $product['price'] * $product['amount'];
						$product['weight']          = (is_null($product['weight']) ? null : (int) $product['weight']);
						$product['totalweight']     = (is_null($product['weight']) ? null : $product['weight'] * $product['amount']);
						$product['delivery_type']   = (is_null($product['delivery_type']) ? null : (int) $product['delivery_type']);
						$product['image']           = null;
					}
				}
				unset($product);
			}
			// zoek foto op
			foreach ($producten as &$product){
				$imageinfo = productqueries::getProductPictures($product['id'], true);
				if ($imageinfo) $product['image']  = $imageinfo[0]['microfoto'];
			}
			unset($product);
			// bereken subtotaal alle items
			$subtotaal = 0;
			$totaalaantal = 0;
			foreach ($producten as $product) $subtotaal = $subtotaal + $product['totalprice'];
			foreach ($producten as $product) $totaalaantal = $totaalaantal + $product['amount'];
			// totalen opslaan in sessie voor snel hergebruik
			$_SESSION['winkelwagen_totaal'] = $subtotaal;
			$_SESSION['winkelwagen_aantal'] = $totaalaantal;
			
			return Array(
				'producten' => $producten,
				'subtotaal' => $subtotaal,
				'totaalaantal' => $totaalaantal
			);
		}
	
	
	}
