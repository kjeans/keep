<?php

	class beheerFunctionsProduct{
	
		public static function showProductList($producten){
			printf('<form method="POST" action="?">');
			printf('<input type="hidden" name="changevisibility" value="1">');
			echo '<table class="beheerlijst">';
			echo '<tr>';
			printf('<th title="Zichtbaar">Zi</th>');
			printf('<th>ID</th>');
			printf('<th>Naam</th>');
			printf('<th>Aantal</th>');		
			printf('<th>Update</th>');
			printf('<th>Delete</th>');			
			echo '</tr>';
			if($producten) foreach($producten as $product){
				echo '<tr>';
				printf('<td>%s</td>', form::checkbox('show_' . $product['id'], '', $product['visible']));
				printf('<td>%d</td>', $product['id']);
				printf('<td>%s</td>', $product['name']);
				printf('<td><a href="?subtract=%d" onclick="return confirm(\'Weet u zeker dat u 1 van deze producten heeft verkocht ?\')">%d</a></td>', $product['id'], $product['amount']);
				printf('<td><a href="?edit=%d">Bewerken</a></td>', $product['id']);
				printf('<td><a href="?delete=%d" onclick="return confirm(\'Weet u zeker dat u dit product wilt verwijderen ?\')">Verwijderen</a></td>', $product['id']);				
				echo '</tr>';
			}
			echo '<tr>';
			printf('<td colspan="4">%s</td>', form::submit('Zichtbaarheid opslaan',''));
			printf('<td><a href="?new=1">Nieuw</a></td>');
			printf('<td>&nbsp;</td>');		
			echo '</tr>';
			echo '</table>';
			echo '</form>';
		}		
		
		protected static function getDefaults() {
			return array (
				'id' => NULL,
				'name' => '',
				'price' => NULL,
				'price_old' => NULL,
				'size' => NULL,
				'brand' => NULL,
				'description' => NULL,
				'color' => 'gemengd',
				'gender' => NULL,
				'age' => NULL,
				'keywords' => NULL,
				'marktplaats_url' => NULL,
				'dimension' => NULL,
				'weight' => NULL,
				'delivery_type' => '1',
				'amount' => '1',
				'allow_trade' => '1',
				'allow_bid' => '0',
				'min_bid' => NULL,
				'visible' => 1
			);
		}
		
		public static function process_updates($productid){
			if(empty($_POST)) return;
			if ((int)$_POST['changevisibility'] > 0){
				$producten = beheerQueries::getAllProduct();
				$hide = array();
				$show = array();
				foreach ($producten as $product){
					if ($product['visible']){
						if (!forminput::checkbox('show_' . $product['id'])) $hide[] = $product['id'];
					} else {
						if (forminput::checkbox('show_' . $product['id'])) $show[] = $product['id'];
					}
				}
				beheerQueries::updateProductVisibility($show, true);
				beheerQueries::updateProductVisibility($hide, false);
				Header('Location: ?');
				return;
			}	
			$newmode = is_null($productid);
			$productdata = self::getDefaults();
			$productdata['name'] 			= forminput::textbox('naam');
			if (!is_null($productdata['name'])) $productdata['name'] = strtocamel($productdata['name']);
			$productdata['size']			= forminput::textbox('maat');
			$productdata['price'] 			= forminput::prijsbox('prijs');
			$productdata['price_old'] 		= forminput::prijsbox('oudprijs');
			$productdata['brand'] 			= forminput::textbox('merk');
			if (!is_null($productdata['brand'])) $productdata['brand'] = strtocamel($productdata['brand']);
			$productdata['description'] 	= forminput::textarea('omschrijving');
			$productdata['keywords']		= tags_clean(forminput::textbox('tags'));
			$productdata['color'] 			= forminput::kleurbox('kleur');
			$productdata['gender'] 			= forminput::selectbox('sexe');
			$productdata['age'] 			= forminput::selectbox('leeftijd');
			$productdata['marktplaats_url'] = forminput::textbox('marktplaats');
			$productdata['dimension'] 		= forminput::textbox('afmetingen');
			$productdata['weight'] 			= forminput::numbox('gewicht');
			$productdata['delivery_type'] 	= forminput::selectbox('bezorgtype');
			$productdata['amount'] 			= forminput::numbox('aantal');
			$productdata['allow_trade']		= forminput::checkbox('ruilen');
			$productdata['allow_bid'] 		= forminput::checkbox('bieden');
			$productdata['min_bid'] 		= forminput::prijsbox('bod');
			$productdata['visible'] 		= forminput::checkbox('zichtbaar');
			if(is_null($productid)) {
				$productid = beheerQueries::createProduct($productdata);
			}
			else{
				beheerQueries::updateProduct($productid, $productdata);
			}
			self::process_uploads($productid);
			$categorien = beheerQueries::getAllCategorie();
			if (!$newmode && !is_null($productid)) {
				beheerQueries::deleteProductCategorieLinks($productid);
			}
			foreach($categorien as $categorie){
				if (forminput::checkbox('categorie_' . $categorie['id'])) {
					beheerQueries::createProductCategorieLink($productid, $categorie['id']);
				}
			}
			if (!$newmode && !is_null($productid)) {
				$pictures = beheerQueries::getProductPicture($productid);
				foreach($pictures as $picture){
					if (forminput::checkbox('fotoverwijder_' . $picture['id'])) {
						beheerQueries::deleteProductPicture($productid, $picture['id']);
					}
				}
			}
			if (!is_null($productid)) {
				//Header('Location: ?edit=' . $productid);
				Header('Location: ?');
			}
			
		}
		
		protected static function process_uploads($productid = null){
			if(empty($_FILES)) return;
			$fotodir = fotopath();
			$extension = 'dat';
			$maxsize = 10 * 1024 * 1024; // 10mb
			foreach ($_FILES as $veldnaam => $leeg) {
				if(array_key_exists($veldnaam,$_FILES)){
					if((int) $_FILES[$veldnaam]['error'] == 0) {
						if((int) $_FILES[$veldnaam]['size'] > 0) {
							if((int) $_FILES[$veldnaam]['size'] <= $maxsize) {
								$fileinfo = getimagesize($_FILES[$veldnaam]['tmp_name']);
								if ($fileinfo[2] === IMAGETYPE_PNG || $fileinfo[2] === IMAGETYPE_JPEG) {
									if     ($fileinfo[2] === IMAGETYPE_PNG)  $extension = 'png';
									elseif ($fileinfo[2] === IMAGETYPE_JPEG) $extension = 'jpg';
									$fotoid = beheerQueries::createProductImage($productid, $_FILES[$veldnaam]['name'], $extension);
									if(!is_null($fotoid)){
										$orifile = sprintf('%s%do.%s', $fotodir, $fotoid, $extension);
										move_uploaded_file(
											$_FILES[$veldnaam]['tmp_name'], 
											$orifile
										);
										imageResize::process_upload_resize($fotoid, $fotodir, $orifile, $fileinfo[2]);
									} else echo 'Foto kon niet in de db worden opgeslagen.';
								} else echo 'wat moet ik huiermee, geef jpg/png';
							} else echo 'Bestand te groot(mb).';
						} else echo 'Leeg bestand.';
					} elseif ($_FILES[$veldnaam]['error'] !== UPLOAD_ERR_NO_FILE) echo 'Fout bij uploaden bestand.' . $_FILES[$veldnaam]['error'];
				} //else echo 'Geen foto geüpload.';
			}
		}
		
		
		
		
		
		
		public static function showProductForm($productid = null, $productdata = null){
			if(is_null($productid)) {
				$productdata = self::getDefaults();
				$uri = '?new=1';
			} else {
				$uri = '?edit=' . $productid;
			}
			printf('<form method="POST" action="%s" enctype="multipart/form-data">', $uri);
			echo '<table class="beheerlijst">';
			echo '<tr>';
			printf('<th>Naam:</th>');
			printf('<td>%s</td>', form::textbox('naam', '', $productdata['name']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Prijs:</th>');
			printf('<td>van %s voor %s</td>', form::prijsbox('oudprijs','', ($productdata['price_old'])), form::prijsbox('prijs','', ($productdata['price'])));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Maat:</th>');
			printf('<td>%s</td>', form::textbox('maat','', $productdata['size']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Merk:</th>');
			printf('<td>%s</td>', form::textbox('merk','', $productdata['brand']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Aantal:</th>');
			printf('<td>%s</td>', form::numbox('aantal','', $productdata['amount']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Omschrijving:</th>');
			printf('<td>%s</td>', form::textarea('omschrijving','', $productdata['description']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Tags:</th>');
			printf('<td>%s</td>', form::textbox('tags', '', $productdata['keywords']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Kleur:</th>');
			printf('<td>%s</td>', form::kleurbox('kleur','', $productdata['color'], getColors()));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Geslacht:</th>');
			printf('<td>%s</td>', form::selectbox('sexe','', $productdata['gender'], getGenders(true), '(Onbekend)'));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Leeftijd:</th>');
			printf('<td>%s</td>', form::selectbox('leeftijd','', $productdata['age'], getAgeOptions(true), '(Onbekend)'));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Marktplaats url:</th>');
			printf('<td>%s</td>', form::textbox('marktplaats','', $productdata['marktplaats_url']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Afmetingen:</th>');
			printf('<td>%s</td>', form::textbox('afmetingen','', $productdata['dimension']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Gewicht:</th>');
			printf('<td>%s</td>', form::numbox('gewicht','', $productdata['weight']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Bezorgtype:</th>');
			printf('<td>%s</td>', form::selectbox('bezorgtype','', $productdata['delivery_type'], prijssysteem::getDeliverytypeLijst()));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Ruilen:</th>');
			printf('<td>%s</td>', form::checkbox('ruilen','', $productdata['allow_trade']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Bieden:</th>');
			printf('<td>%s %s</td>', form::checkbox('bieden','', $productdata['allow_bid']), form::prijsbox('bod','', ($productdata['min_bid'])));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Foto:</th>');
			printf('<td>%s</td>',self::getPicture($productid));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Categorie:</th>');
			printf('<td>%s</td>',self::getCategorie($productid));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Zichtbaarheid:</th>');
			printf('<td>%s</td>', form::checkbox('zichtbaar','', $productdata['visible']));
			echo '</tr>';
			echo '</table>';
			printf('<div class="formbutton">%s</div>', form::submit('Opslaan',''));
			echo '</form>';
		}
		
		protected static function getPicture($productid=null){
			$html = '';
			for ($i = 1; $i <= 10; $i++)
			$html .= form::uploadbox('fotonew' . $i,'') . '<br>';
			$pictures = beheerQueries::getProductPicture($productid);
			foreach($pictures as $picture){
				$html .= '<div class="beheerfoto">';
				$html .= sprintf('<img src="%s">', fotourl($picture['id'], 'm'));
				$html .= form::checkbox('fotoverwijder_' . $picture['id'],'',false);
				$html .= '</div>';
			}
			$html .= '<br class="clear">';
			return $html;
		}
		
		protected static function getCategorie($productid=null){
			$categorien = beheerQueries::getAllCategorie();
			$categorieExist = array();
			
			if(!is_null ($productid)){
				$categorieExist = beheerQueries::getExistCategorie($productid);
			}
			
			
			$html = '';
			foreach($categorien as $categorie){
				$html .= sprintf('%s%s %s<br>', 
				($categorie['parent'] == 1?'':'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'),
				form::checkbox('categorie_' . $categorie['id'], '', in_array($categorie['id'], $categorieExist)), 
				htmlentities($categorie['name'], ENT_QUOTES, 'UTF-8')
				);
				
				
			}
			$html .= '<div class="helplink"><a href="beheercategorie.php?new=1" target="_blank">Klik hier om een nieuwe categorie toe te voegen</a></div>';
			return $html;
		}	
	}