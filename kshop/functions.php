<?php

	function prijs($eurocent, $showsign=true) {
		return ($showsign ? '&euro; ' : '') . number_format ($eurocent / 100, 2, ',', '');
	}

	function nullstringtrim($value) {
		$value = preg_replace('#[^a-zA-Z0-9]#uD', '', (string) $value);
		if (!$value) $value = null;
		return $value;
	}
	
	function is_sha1($value){
		return preg_match('#^[a-z0-9]{40}$#uD', $value) === 1;
	}
	
	function is_postcode($value){
		return preg_match('#^[1-9][0-9]{3}(\s+)?[A-Za-z]{2}$#uD', $value) === 1;
	}
	
	function is_huisnummer($value){
		return preg_match('#[0-9]#uD', $value) === 1;
	}
	
	function gewicht($gram) {
		return number_format ($gram / 1000, 3, ',', '') . ' kg';
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
		return sprintf('productimages/%d%s.png',$fotoid, $fotocode);
	}
	
	function fotopath(){
		return './productimages/';
	}
	
	function getColors(){
		$data = array(
			array('code' => 'gemengd', 'label' => 'Gemengd', 'image' => 'images/kleur/gemengd.png'),
			array('code' => 'zwart',   'label' => 'Zwart',   'image' => 'images/kleur/zwart.png'),
			array('code' => 'wit',     'label' => 'Wit',     'image' => 'images/kleur/wit.png'),
			array('code' => 'grijs',   'label' => 'Grijs',   'image' => 'images/kleur/grijs.png'),
			array('code' => 'rood',    'label' => 'Rood',    'image' => 'images/kleur/rood.png'),
			array('code' => 'groen',   'label' => 'Groen',   'image' => 'images/kleur/groen.png'),
			array('code' => 'blauw',   'label' => 'Blauw',   'image' => 'images/kleur/blauw.png'),
			array('code' => 'geel',    'label' => 'Geel',    'image' => 'images/kleur/geel.png'),
			array('code' => 'oranje',  'label' => 'Oranje',  'image' => 'images/kleur/oranje.png'),
			array('code' => 'paars',   'label' => 'Paars',   'image' => 'images/kleur/paars.png'),
			array('code' => 'roze',    'label' => 'Roze',    'image' => 'images/kleur/roze.png'),
			array('code' => 'bruin',   'label' => 'Bruin',   'image' => 'images/kleur/bruin.png'),
		);
		return $data;
	}
	
	function getGenders($forSelectBox=false){
		$data = array(
			array('code' => NULL,     'label' => 'Unisex', 'image' => 'images/sexe/unisex.png'),
			array('code' => 'male',   'label' => 'Man',    'image' => 'images/sexe/man.png'),
			array('code' => 'female', 'label' => 'Vrouw',  'image' => 'images/sexe/vrouw.png'),
		);
		if (!$forSelectBox) return $data;
		$options = array();
		foreach($data as $entry) if (!is_null($entry['code'])) $options[$entry['code']] = $entry['label'];
		return $options;
	}
	
	
	function getAgeOptions($forSelectBox=false){
		$data = array(
			array('code' => NULL,       'label' => 'Alle leeftijden', 'image' => 'images/sexe/unisex.png'),
			array('code' => 'adults',   'label' => 'Volwassenen',     'image' => 'images/sexe/unisex.png'),
			array('code' => 'kids',     'label' => 'Kinderen',        'image' => 'images/sexe/kids.png'),
		);
		if (!$forSelectBox) return $data;
		$options = array();
		foreach($data as $entry) if (!is_null($entry['code'])) $options[$entry['code']] = $entry['label'];
		return $options;
	}
	
	
	function getSortOptions($forSelectBox=false){
		$data = array(
			array('code' => NULL,              'label' => 'Nieuwste eerst',            'sql' => 'product.c_date DESC'),
			array('code' => 'prijs',           'label' => 'Prijs (oplopend)',          'sql' => 'product.price ASC'),
			array('code' => 'prijsduur',       'label' => 'Prijs (aflopend)',          'sql' => 'product.price DESC'),
			array('code' => 'titel',           'label' => 'Titel',                     'sql' => 'product.name ASC'),
			array('code' => 'merk',            'label' => 'Merk',                      'sql' => 'product.brand ASC'),
		);
		if (!$forSelectBox) return $data;
		$options = array();
		foreach($data as $entry) if (!is_null($entry['code'])) $options[$entry['code']] = $entry['label'];
		return $options;
	}
	