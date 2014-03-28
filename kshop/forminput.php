<?php
	
	
	class forminput {
	
		public static function textbox($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			else              return $value;
		}
	
		public static function prijsbox($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			$value = preg_replace('#\.#uD', ',', $value);
			if (preg_match('#^(\-?)(\d+)(\,(\d+))?$#uD', $value, $part) === 1) {
				$centen = ((int) $part[2]) * 100;
				if (isset($part[4])) {
					if ($part[4] <= 9) $centen += $part[4] * 10;
					else               $centen += $part[4];
				}
				if (isset($part[1]) && $part[1] == '-') $centen *= -1;
				return $centen;
			}
			else return null;
		}
	
		public static function selectbox($name){
			$value = $_POST[$name];
			if ($value == '') $value = NULL;
			return $value;
		}
	
		public static function kleurbox($name){
			$value = $_POST[$name];
			return $value;
		}
	
		public static function textarea($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			else              return $value;
		}
	
		public static function checkbox($name){
			return array_key_exists($name, $_POST) ? true : false;
		}
		
		public static function numbox($name){
			$value = $_POST[$name];
			$value = (int)$value;
			if ($value <= 0) return null;
			else              return $value;
		}
		
		public static function passwordbox($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			else              return $value;
		}
	
	}