<?php

	 class db {

		protected static $connection;

		public static function connect() {
			self::$connection = mysqli_connect('localhost','root');
			mysqli_set_charset(self::$connection, 'UTF8');
			mysqli_select_db(self::$connection, 'keep');
		}

		public static function getConn() {
			return self::$connection;
		}
	 }

	 db::connect();