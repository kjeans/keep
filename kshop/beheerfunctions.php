<?php

	class beheerFunctionsNotitie {
	
		public static function shownotitieList($notities){
			echo '<table class="beheerlijst">';
			echo '<tr>';
			printf('<th>ID</th>');
			printf('<th>Naam</th>');
			printf('<th>Update</th>');
			printf('<th>Delete</th>');			
			echo '</tr>';
			if($notities) foreach($notities as $notitie){
				echo '<tr>';
				printf('<td>%d</td>', $notitie['id']);
				printf('<td>%s</td>', $notitie['fullname']);
				printf('<td><a href="?edit=%d">Bewerken</a></td>', $notitie['id']);
				printf('<td><a href="?delete=%d" onclick="return confirm(\'Weet u zeker dat u deze notitie wilt verwijderen ?\')">Verwijderen</a></td>', $notitie['id']);			
				echo '</tr>';
			}
			echo '<tr>';
			printf('<td>&nbsp;</td>');
			printf('<td>&nbsp;</td>');
			printf('<td><a href="?new=1">Nieuw</a></td>');
			printf('<td>&nbsp;</td>');			
			echo '</tr>';
			
			echo '</table>';
		}		
		
		protected static function getDefaults() {
			return array ( 
				'id'            => NULL,
				'name'          => '',
				'offset'        => 10000,
				'parent_id'     => null,
				'filter_color'  => 0,
				'filter_price'  => 1,
				'filter_brand'  => 1,
				'filter_gender' => 0,
				'filter_age'    => 0,
				'filter_size'   => 0,
				'filter_share'  => 0,
			);
		}
		
		public static function process_updates($notitieid){
			if(empty($_POST)) return;
			$newmode = is_null($notitieid);
			$notitiedata = self::getDefaults();
			$notitiedata['name'] 			= forminput::textbox('naam');
			$notitiedata['offset'] 			= forminput::numbox('offset');
			$notitiedata['parent_id'] 		= forminput::selectbox('parent');
			$notitiedata['filter_color'] 	= forminput::checkbox('filterkleur');
			$notitiedata['filter_price'] 	= forminput::checkbox('filterprijs');
			$notitiedata['filter_brand'] 	= forminput::checkbox('filtermerk');
			$notitiedata['filter_gender'] 	= forminput::checkbox('filtersexe');
			$notitiedata['filter_age'] 		= forminput::checkbox('filterleeftijd');
			$notitiedata['filter_size'] 	= forminput::checkbox('filtermaat');
			$notitiedata['filter_share'] 	= forminput::checkbox('filterdelen');
			$notitiedata['parent_id'] 		= ($notitiedata['parent_id'] == 0 ? null : $notitiedata['parent_id']);
			if(is_null($notitieid)) {
				$notitieid = beheerQueries::createnotitie($notitiedata);
			}
			else{
				beheerQueries::updatenotitie($notitieid, $notitiedata);
			}
			if (!is_null($notitieid)) {
				Header('Location: ?');
			}
		}
		
		
		
		
		
		
		public static function showProductForm($notitieid = null, $notitiedata = null){
			if(is_null($notitieid)) {
				$notitiedata = self::getDefaults();
				$uri = '?new=1';
			} else {
				$uri = '?edit=' . $notitieid;
			}
			printf('<form method="POST" action="%s">', $uri);
			echo '<table class="beheerlijst">';
			echo '<tr>';
			printf('<th>Naam:</th>');
			printf('<td>%s</td>', form::textbox('naam', '', $notitiedata['name']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Offset:</th>');
			printf('<td>%s</td>', form::numbox('offset', '', $notitiedata['offset']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Parent:</th>');
			printf('<td>%s</td>', form::selectbox('parent','', $notitiedata['parent_id'], self::getParentnotitie()));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Kleurfilter:</th>');
			printf('<td>%s</td>', form::checkbox('filterkleur','', $notitiedata['filter_color']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Prijsfilter:</th>');
			printf('<td>%s</td>', form::checkbox('filterprijs','', $notitiedata['filter_price']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Merkfilter:</th>');
			printf('<td>%s</td>', form::checkbox('filtermerk','', $notitiedata['filter_brand']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Sexefilter:</th>');
			printf('<td>%s</td>', form::checkbox('filtersexe','', $notitiedata['filter_gender']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Leeftijdfilter:</th>');
			printf('<td>%s</td>', form::checkbox('filterleeftijd','', $notitiedata['filter_age']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Maatfilter:</th>');
			printf('<td>%s</td>', form::checkbox('filtermaat','', $notitiedata['filter_size']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Filter onthouden:</th>');
			printf('<td>%s</td>', form::checkbox('filterdelen','', $notitiedata['filter_share']));
			echo '</tr>';
			echo '</table>';
			printf('<div class="formbutton">%s</div>', form::submit('Opslaan',''));
			echo '</form>';
		}
		
		protected static function getParentnotitie(){
			$notities = beheerQueries::getAllnotitie();
			$options = Array(0 => '(Geen)');
			foreach($notities as $notitie){
				if ($notitie['parent'] == 1)
				$options[$notitie['id']] = $notitie['name'];
			}
			return $options;
		}	
		
	}