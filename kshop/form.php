<?php
	
	
	class form{
	
		public static function textbox($name, $class, $value){
			if (is_null($value)){ 
				$value = ''; 
			}
			$html  = '<input type="text"';
			$html .= sprintf(' name="%s"', $name);
			$html .= sprintf(' class="%s"', $class);	
			$html .= sprintf(' value="%s"', htmlentities($value, ENT_QUOTES, 'UTF-8'));
			$html .= '>';
			return $html;
		}
		
		public static function prijsbox($name, $class, $value, $id=null){
			if (is_null($value)){ 
				$value = ''; 
			}
			else{
				$value = number_format ($value / 100, 2, ',', '');
			}
			$html  = '&euro; <input type="text"';
			$html .= sprintf(' name="%s"', $name);
			if ($id)
			$html .= sprintf(' id="%s"', $id);
			$html .= sprintf(' class="prijsbox %s"', $class);	
			$html .= sprintf(' value="%s"', htmlentities($value, ENT_QUOTES, 'UTF-8'));
			$html .= '>';
			return $html;
		}
		
		public static function selectbox($name, $class, $value, $options, $nullOption=false){
			$html  = '<select ';
			$html .= sprintf(' name="%s"', $name);
			$html .= sprintf(' class="%s"', $class);	
			$html .= '>';
			if ($nullOption){
				$html .= '<option';
				$html .= sprintf(' value=""');
				if(is_null($value)){
					$html .= ' selected="selected"';
				}
				$html .= '>';
				$html .= htmlentities($nullOption, ENT_QUOTES, 'UTF-8');
				$html .= '</option>';
			}
			
			$html .= '</select>';
			
			return $html;
		}
		
		public static function kleurbox($name, $class, $value, $options){
			$html  = '<input type="hidden"';
			$html .= sprintf(' id="%s"', $name);
			$html .= sprintf(' name="%s"', $name);
			$html .= sprintf(' value="%s"', htmlentities($value, ENT_QUOTES, 'UTF-8'));
			$html .= '>';
			$html .= '<select';
			$html .= sprintf(' id="%s"', $name);
			$html .= sprintf(' class="kleurbox %s"', $class);	
			$html .= '>';
			foreach ($options as $option){
				$html .= '<option';
				$html .= sprintf(' data-imagesrc="%s"', htmlentities($option['image'], ENT_QUOTES, 'UTF-8'));
				//$html .= sprintf(' data-description="&nbsp;"', htmlentities($option['label'], ENT_QUOTES));
				$html .= sprintf(' value="%s"', htmlentities($option['code'], ENT_QUOTES, 'UTF-8'));
				if($value == $option['code']){
					$html .= ' selected="selected"';
				}
				$html .= '>';
				$html .= htmlentities($option['label'], ENT_QUOTES, 'UTF-8');
				$html .= '</option>';
			}
			$html .= '</select>';
			
			return $html;
		}
		
		public static function textarea($name, $class, $value){
			if (is_null($value)){ 
				$value = ''; 
			}
			$html  = '<textarea';
			$html .= sprintf(' name="%s"', $name);	
			$html .= sprintf(' class="textarea %s"', $class);	
			$html .= '>';
			$html .= htmlentities($value, ENT_QUOTES, 'UTF-8');
			$html .= '</textarea>';
			return $html;
		}
	
		public static function checkbox($name, $class, $value){
			$html  = '<input type="checkbox"';
			$html .= sprintf(' name="%s"', $name);
			$html .= sprintf(' class="checkbox %s"', $class);	
			$html .= sprintf(' value="1"');
			if ($value){
				$html .= sprintf(' checked="checked"');
			}
			$html .= '>';
			return $html;
		}
		
		public static function numbox($name, $class, $value){
			if (!is_null($value)) $value = (int) $value;
			if (is_null($value) || $value <= 0){ 
				$value = ''; 
			}
			$html  = '<input type="text"';
			$html .= sprintf(' name="%s"', $name);
			$html .= sprintf(' class="numbox %s"', $class);	
			$html .= sprintf(' value="%s"', htmlentities($value, ENT_QUOTES, 'UTF-8'));
			$html .= '>';
			return $html;
		}
		
		public static function submit($label, $class){
			$html  = '<input type="submit"';
			$html .= sprintf(' name="%s"', 'submit');
			$html .= sprintf(' value="%s"', $label);
			$html .= sprintf(' class="%s"', $class);
			$html .= '>';
			return $html;
		}
		
		public static function linkButton($label, $class, $href){
			$html  = sprintf('<a href="%s"', $href);
			$html .= sprintf(' class="fakebutton %s"', $class);
			$html .= '>' . $label . '</a>';
			return $html;
		}
	
		public static function uploadbox($name, $class){
			$html  = '<input type="file"';
			$html .= sprintf(' name="%s"', $name);
			$html .= sprintf(' class="%s"', $class);	
			$html .= '>';
			return $html;
		}
		
		public static function passwordbox($name, $class){
			$html  = '<input type="password" value=""';
			$html .= sprintf(' name="%s"', $name);
			$html .= sprintf(' class="%s"', $class);
			$html .= '>';
			return $html;
		}
	}