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
			array('code' => 'wit',     'label' => 'Wit'),
			array('code' => 'rood',    'label' => 'Rood'),
			array('code' => 'groen',   'label' => 'Groen'),
			array('code' => 'blauw',   'label' => 'Blauw'),
			array('code' => 'geel',    'label' => 'Geel'),
			array('code' => 'oranje',  'label' => 'Oranje'),
			array('code' => 'paars',   'label' => 'Paars'),
			array('code' => 'roze',    'label' => 'Roze'),
		);
		return $data;
	}
	
	function getTypes(){
		$data = array(
			array('code' => 'prive', 	'label' => 'Prive'),
			array('code' => 'zakelijk', 'label' => 'Zakelijk'), 
		);
	}
	