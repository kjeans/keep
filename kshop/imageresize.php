<?php

	class imageResize {

		public static function process_upload_resize($fotoid, $fotodir, $originalfile, $imagetype){
			self::process_upload_resize_blader($fotoid, $fotodir, $originalfile, $imagetype, 190, 142, 'b');
			self::process_upload_resize_blader($fotoid, $fotodir, $originalfile, $imagetype, 90, 67, 'm');
			self::process_upload_resize_blader($fotoid, $fotodir, $originalfile, $imagetype, 48, 36, 's');
			self::process_upload_resize_detail($fotoid, $fotodir, $originalfile, $imagetype);
		}

		protected static function process_upload_resize_blader($fotoid, $fotodir, $originalfile, $imagetype, $canvas_w, $canvas_h, $suffix){
			$canvas = @imagecreatetruecolor($canvas_w, $canvas_h);
			$bg_color   = imagecolorallocate($canvas, 255, 255, 255);
			imagefilledrectangle ($canvas, 0,0, $canvas_w-1 , $canvas_h-1 , $bg_color );
			if     ($imagetype === IMAGETYPE_PNG)  $original = imagecreatefrompng($originalfile);
			elseif ($imagetype === IMAGETYPE_JPEG) $original = imagecreatefromjpeg($originalfile);
			$original_w = imagesx($original);
			$original_h = imagesy($original);

			$mod_w = $original_w / $canvas_w;
			$mod_h = $original_h / $canvas_h;
			if     ($mod_w < 1.0 && $mod_h < 1.0) $mod = 1.0;
			elseif ($mod_w < 1.0)                 $mod = $mod_h;
			elseif ($mod_h < 1.0)                 $mod = $mod_w;
			else                                  $mod = ($mod_w > $mod_h ? $mod_w : $mod_h);
			$resize_w = $original_w / $mod;
			$resize_h = $original_h / $mod;
			$margin_w = floor(($canvas_w - $resize_w) / 2);
			$margin_h = floor(($canvas_h - $resize_h) / 2);

			imagecopyresampled 	(
				$canvas,
				$original,
				$margin_w, $margin_h,
				0,0,
				$resize_w,
				$resize_h,
				$original_w, 
				$original_h
			);

			imagepng(
				$canvas, 
				sprintf('%s%d%s.png',$fotodir, $fotoid, $suffix), 
				6
			);
			imagedestroy($canvas);
		}



		protected static function process_upload_resize_detail($fotoid, $fotodir, $originalfile, $imagetype){
			$canvas_h = 300;
			$canvas_w = 360;
			//ini_set('gd.jpeg_ignore_warning', 1);
			$canvas = @imagecreatetruecolor($canvas_w, $canvas_h);
			$bg_color   = imagecolorallocate($canvas, 255, 255, 255);
			//imagecolortransparent($canvas, $bg_color);
			imagefilledrectangle ($canvas, 0,0, $canvas_w-1 , $canvas_h-1 , $bg_color );
			if     ($imagetype === IMAGETYPE_PNG)  $original = imagecreatefrompng($originalfile);
			elseif ($imagetype === IMAGETYPE_JPEG) $original = imagecreatefromjpeg($originalfile);
			$original_w = imagesx($original);
			$original_h = imagesy($original);

			$watermark = imagecreatefrompng('./images/logo/watermerk.png');
			$watermark_w = imagesx($watermark);
			$watermark_h = imagesy($watermark);


			$mod_w = $original_w / $canvas_w;
			$mod_h = $original_h / $canvas_h;
			if     ($mod_w < 1.0 && $mod_h < 1.0) $mod = 1.0;
			elseif ($mod_w < 1.0)                 $mod = $mod_h;
			elseif ($mod_h < 1.0)                 $mod = $mod_w;
			else                                  $mod = ($mod_w > $mod_h ? $mod_w : $mod_h);
			$resize_w = $original_w / $mod;
			$resize_h = $original_h / $mod;
			$margin_w = floor(($canvas_w - $resize_w) / 2);
			$margin_h = floor(($canvas_h - $resize_h) / 2);
			$watermark_x = $canvas_w-1-$watermark_w-10;
			$watermark_y = $canvas_h-1-$watermark_h-10;

			imagecopyresampled 	(
				$canvas,
				$original,
				$margin_w, $margin_h,
				0,0,
				$resize_w,
				$resize_h,
				$original_w, 
				$original_h
			);

			imagecopy 	(
				$canvas,
				$watermark,
				$watermark_x, $watermark_y,
				0,0,
				$watermark_w,
				$watermark_h
			);	

			//imagealphablending($canvas, false);
			//imagesavealpha($canvas, true);

			imagepng(
				$canvas, 
				sprintf('%s%dd.png',$fotodir, $fotoid), 
				6
			);
			imagedestroy($canvas);
		}



	}