<?php

	function nullstringtrim($value) {
		$value = preg_replace('#[^a-zA-Z0-9]#uD', '', (string) $value);
		if (!$value) $value = null;
		return $value;
	}

	function is_sha1($value){
		return preg_match('#^[a-z0-9]{40}$#uD', $value) === 1;
	}

	function tags($tagsstring) {
		$keywords = preg_split ('#(,| )#uD',$tagsstring, -1, PREG_SPLIT_NO_EMPTY);
		if (empty($keywords)) return '-';
		$html = '';
		foreach ($keywords as $keyword){
			$html .= sprintf('<a href="search.php?searchquery=%s" class="hashtag">#%s</a> ', htmlentities($keyword, ENT_QUOTES, 'UTF-8' ), htmlentities($keyword, ENT_QUOTES, 'UTF-8' ));
		}
		return $html;
	}

	function strtocamel($string) {
		if ($string === strtoupper($string)) return ucwords(strtolower($string));
		else return ucwords($string);
	}

	function tags_clean($tagsstring) {
		if (is_null($tagsstring)) return null;
		$keywords = preg_split ('#(,| )#uD', strtolower($tagsstring), -1, PREG_SPLIT_NO_EMPTY);
		$tags = '';
		$sep  = '';
		if (!empty($keywords)) foreach ($keywords as $keyword){
			$tags .= $sep . $keyword;
			$sep   = ' ';
		}
		return $tags ? $tags : null;
	}

	function fotourl($fotoid, $fotocode){
		return sprintf('noteimages/%d%s.png',$fotoid, $fotocode);
	}

	function fotopath(){
		return './noteimages/';
	}
	
	function getColors(){
		$data = array(
			array('code' => 'wit',     'label' => 'Wit',     'image' => 'images/kleur/wit.png'),
			array('code' => 'rood',    'label' => 'Rood',    'image' => 'images/kleur/rood.png'),
			array('code' => 'groen',   'label' => 'Groen',   'image' => 'images/kleur/groen.png'),
			array('code' => 'blauw',   'label' => 'Blauw',   'image' => 'images/kleur/blauw.png'),
			array('code' => 'geel',    'label' => 'Geel',    'image' => 'images/kleur/geel.png'),
			array('code' => 'oranje',  'label' => 'Oranje',  'image' => 'images/kleur/oranje.png'),
			array('code' => 'paars',   'label' => 'Paars',   'image' => 'images/kleur/paars.png'),
			array('code' => 'roze',    'label' => 'Roze',    'image' => 'images/kleur/roze.png'),
		);
		return $data;
	}
	
	
	function getTypes($forSelectBox=false){
		$data = array(
			array('code' => 'prive', 	'label' => 'Prive', 'image' => 'images/private.png'),
			array('code' => 'zakelijk', 'label' => 'Zakelijk', 'image' => 'images/business.png'),
		);
		if (!$forSelectBox) return $data;
		$options = array();
		foreach($data as $entry) if (!is_null($entry['code'])) $options[$entry['code']] = $entry['label'];
		return $options;
	}