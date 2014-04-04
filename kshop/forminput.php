<?php


	class forminput {

		public static function textbox($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			else              return $value;
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

		public static function passwordbox($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			else              return $value;
		}
		
		public static function datebox($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			else              return $value;
		}
		
		public static function timebox($name){
			$value = $_POST[$name];
			$value = trim($value);
			if ($value == '') return null;
			else              return $value;
		}
		

	}