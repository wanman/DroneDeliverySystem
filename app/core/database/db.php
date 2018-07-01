<?php

	class db {

		private static $_db;
		
		private static $local_host = "localhost";
		private static $local_user = "root";
		private static $local_pass = "";
		private static $local_name = "delivery_system";
		
		public static function get_db () {
			try {

				if (!self::$_db) {

					$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			
					$url_host = parse_url($url);

					if ($url_host['host'] == 'localhost') {
						$conn = new PDO("mysql:host=".self::$local_host.";dbname=".self::$local_name."",self::$local_user,self::$local_pass);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					}

					self::$_db = $conn;
					return self::$_db;
				} else {
					return self::$_db;
				}

			} catch(PDOException $e) {
				file_put_contents('../errors/PDOErrors.txt', $e->getMessage(), FILE_APPEND);
			}
		}
		
		public static function insert($table, $arr=array()){
			if (!is_array($arr) || !count($arr)) return false;
		
			$bind = ':'.implode(',:', array_keys($arr));
			$sql  = 'INSERT INTO '.$table.'('.implode(',', array_keys($arr)).') '. 'VALUES ('.$bind.')';
			$stmt =  self::get_db()->prepare($sql);
			$stmt->execute(array_combine(explode(',',$bind), array_values($arr)));

			$last_insert_id = self::get_db()->lastInsertId();	
			
			if ($stmt->rowCount() > 0){
				$response['last_insert_id'] = $last_insert_id;
				$response['success'] = true;
				return $response;
			}
			
			return false;
		}
		
        public static function select_obj($query){
            $stmt =  self::get_db()->prepare("$query");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        
		public static function select_array($query){
            $stmt =  self::get_db()->prepare("$query");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
		     
		public static function update($update_query){
			$stmt =  self::get_db()->prepare("$update_query");
			$stmt->execute();
			
			if ($stmt->rowCount() > 0){
				$response['success'] = true;
				return $response;
			}
			
			return false;
		}

		public static function delete($table){
			$stmt =  self::get_db()->prepare("DELETE FROM $table");
			$stmt->execute();
		}
	}
?>