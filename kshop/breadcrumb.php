<?php

	class breadcrumb {
	
		public static function printBreadcrumbProductDetail($noteid, $notetitle) {
			$bladerlink = 'blader.php?id=%d';
			$detaillink = 'detail.php?id=%d';
			if (!is_null($catinfo['parent_id'])) {
				self::printBreadcrumbBar(sprintf($bladerlink, $catinfo['parent_id']), $catinfo['parentname'], sprintf($bladerlink, $catinfo['id']), $catinfo['name'], sprintf($detaillink, $productid), $productname);
			} else {
				self::printBreadcrumbBar(sprintf($bladerlink, $catinfo['id']), $catinfo['name'], sprintf($detaillink, $productid), $productname);
			}
		}
	
		public static function printBreadcrumbProductBlader($categorieinfo) {
			$link = 'blader.php?id=%d';
			if (!is_null($categorieinfo['parent_id'])) {
				self::printBreadcrumbBar(sprintf($link, $categorieinfo['parent_id']), $categorieinfo['parentname'], sprintf($link, $categorieinfo['id']), $categorieinfo['name']);
			} else {
				self::printBreadcrumbBar(sprintf($link, $categorieinfo['id']), $categorieinfo['name']);
			}
		}
	
		public static function printBreadcrumbHome() {
			self::printBreadcrumbBar();
		}
	
		public static function printBreadcrumbSearch() {
			self::printBreadcrumbBar('#', 'Zoekopdracht');
		}
	
		protected static function printBreadcrumbBar($link1=null, $label1=null, $link2=null, $label2=null, $link3=null, $label3=null) {
			printf('<div class="breadcrumb">');
			printf('<a href="home.php">Home</a>');
			if (!is_null($link1) && !is_null($label1))
			printf(' &gt; <a href="%s">%s</a>', $link1, htmlentities($label1, ENT_QUOTES, 'UTF-8'));
			if (!is_null($link2) && !is_null($label2))
			printf(' &gt; <a href="%s">%s</a>', $link2, htmlentities($label2, ENT_QUOTES, 'UTF-8'));
			if (!is_null($link3) && !is_null($label3))
			printf(' &gt; <a href="%s">%s</a>', $link3, htmlentities($label3, ENT_QUOTES, 'UTF-8'));
			printf('</div>');
			printf('<br class="clear">');
		}
	}