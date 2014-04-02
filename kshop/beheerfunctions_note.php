<?php

	class beheerFunctionsNote{
	
	public static function showNoteList($notes){
			printf('<form method="POST" action="?">');
			echo '<table class="beheerlijst">';
			echo '<tr>';
			printf('<th>Titel</th>');
			printf('<th>Omschrijving</th>');		
			printf('<th>Update</th>');
			printf('<th>Delete</th>');			
			echo '</tr>';
			if($notes) foreach($notes as $note){
				echo '<tr>';
				printf('<td>%d</td>', $note['id']);
				printf('<td>%s</td>', $note['title']);
				printf('<td><a href="?subtract=%d" onclick="return confirm(\'Weet u zeker dat u 1 van deze notes heeft verkocht ?\')">%d</a></td>', $note['id'], $note['amount']);
				printf('<td><a href="?edit=%d">Bewerken</a></td>', $note['id']);
				printf('<td><a href="?delete=%d" onclick="return confirm(\'Weet u zeker dat u dit note wilt verwijderen ?\')">Verwijderen</a></td>', $note['id']);				
				echo '</tr>';
			}
			echo '<tr>';
			printf('<td><a href="?new=1">Nieuw</a></td>');
			printf('<td>&nbsp;</td>');		
			echo '</tr>';
			echo '</table>';
			echo '</form>';
		}

		protected static function getDefaults() {
			return array (
				'id' => NULL,
				'title' => '',
				'description' => NULL,
				'type' => NULL,
				'archived' => NULL,
				'reminder' => NULL,
				'creator_id' => NULL,
				'extraperson' => NULL,
				'tags' => NULL,
				'color' => NULL,
				'date' => NULL,
				'time' => NULL
			);
		}

		public static function process_updates($noteid){
			if(empty($_POST)) return;

			$newmode = is_null($noteid);
			$notedata = self::getDefaults();
			$notedata['title'] 			= forminput::textbox('titel');
			if (!is_null($notedata['title'])) $notedata['title'] = strtocamel($notedata['title']);
			$notedata['description']	= forminput::textarea('omschrijving');
			$notedata['type'] 			= forminput::selectbox('soort');
			$notedata['archived'] 		= forminput::checkbox('archiveren');
			$notedata['reminder'] 		= forminput::checkbox('herinnering');
			$notedata['extraperson']	= forminput::textbox('extrapersoon');
			$notedata['tags'] 			= tags_clean(forminput::textbox('keywords'));
			$notedata['color'] 			= forminput::kleurbox('kleur');
			$notedata['date'] 			= forminput::textbox('datum');
			$notedata['time'] 			= forminput::textbox('tijd');
			if(is_null($noteid)) {
				$noteid = beheerQueries::createNote($notedata);
			}
			else{
				beheerQueries::updateNote($noteid, $notedata);
			}
			self::process_uploads($noteid);

			if (!$newmode && !is_null($noteid)) {
				$pictures = beheerQueries::getNotePicture($noteid);
				foreach($pictures as $picture){
					if (forminput::checkbox('fotoverwijder_' . $picture['id'])) {
						beheerQueries::deleteNotePicture($noteid, $picture['id']);
					}
				}
			}
			if (!is_null($noteid)) {
				Header('Location: ?');
			}

		}

		protected static function process_uploads($noteid = null){
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
									$fotoid = beheerQueries::createNoteImage($noteid, $_FILES[$veldnaam]['name'], $extension);
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






		public static function showNoteForm($noteid = null, $notedata = null){
			if(is_null($noteid)) {
				$notedata = self::getDefaults();
				$uri = '?new=1';
			} else {
				$uri = '?edit=' . $noteid;
			}
			printf('<form method="POST" action="%s" enctype="multipart/form-data">', $uri);
			echo '<table class="beheerlijst">';
			echo '<tr>';
			printf('<th>Titel:</th>');
			printf('<td>%s</td>', form::textbox('titel', '', $notedata['title']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Omschrijving:</th>');
			printf('<td>%s</td>', form::textarea('omschrijving','', $notedata['description']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Prive of zakelijk:</th>');
			printf('<td>%s</td>', form::selectbox('soort','', $notedata['type'], getTypes(true)));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Archiveren:</th>');
			printf('<td>%s</td>', form::checkbox('archiveren','', $notedata['archived']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Herinnering:</th>');
			printf('<td>%s</td>', form::checkbox('herinnering','', $notedata['reminder']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Extrapersoon:</th>');
			printf('<td>%s</td>', form::textbox('extrapersoon','', $notedata['extraperson']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Tags:</th>');
			printf('<td>%s</td>', form::textbox('keywords','', $notedata['tags']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Datum:</th>');
			printf('<td>%s</td>', form::textbox('datum','', $notedata['date']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Tijd:</th>');
			printf('<td>%s</td>', form::textbox('tijd','', $notedata['time']));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Kleur:</th>');
			printf('<td>%s</td>', form::kleurbox('kleur','', $notedata['color'], getColors(true)));
			echo '</tr>';
			echo '<tr>';
			printf('<th>Foto:</th>');
			printf('<td>%s</td>',self::getPicture($noteid));
			echo '</tr>';
			echo '</table>';
			//printf('<div class="formbutton"%s</div>', form::cancel('Annuleren',''));
			printf('<div class="formbutton">%s</div>', form::submit('Opslaan',''));
			echo '</form>';
		}

		protected static function getPicture($noteid=null){
			$html = '';
			for ($i = 1; $i <= 1; $i++)
			$html .= form::uploadbox('fotonew' . $i,'') . '<br>';
			$pictures = beheerQueries::getnotePicture($noteid);
			foreach($pictures as $picture){
				$html .= '<div class="beheerfoto">';
				$html .= sprintf('<img src="%s">', fotourl($picture['id'], 'm'));
				$html .= form::checkbox('fotoverwijder_' . $picture['id'],'',false);
				$html .= '</div>';
			}
			$html .= '<br class="clear">';
			return $html;
		}
	}