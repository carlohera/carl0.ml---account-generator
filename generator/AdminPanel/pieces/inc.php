<?php
	session_start();
	ob_start();
	
	$display = new display();
	$user = new user();
	
	DEFINE("host", "localhost");
	DEFINE("username", "generator");
	DEFINE("password", "password");
	DEFINE("database", "generator");
	
	$sql = new mysqli(host, username, password, database);
	
	function __destruct()
	{
		ob_clean();
	}
	
	class settings
	{
		public static function website($data)
		{
			global $sql;
			
			$website = mysqli_query($sql, 'SELECT * FROM merchant LIMIT 1');
			$fwebsite = mysqli_fetch_array($website);
			
			return $fwebsite[$data];
		}
	}
	
	class display {
		public static function success($msg)
		{
			echo('<div class="alert alert-success role="alert" style="text-align: center;">'.$msg.'</div>');
		}
		public static function error($msg)
		{
			echo('<div class="alert alert-danger role="alert" style="text-align: center;">'.$msg.'</div>');
		}
	}
	
	class user {
		function IsLogged()
		{
			global $sql;
			
			/* If session exists. */
			
			if(!isset($_SESSION['auth'])){
				header('Location: signin.php');
				exit();
			}
			
			/* Additional check.If session is null or user does not exists. */
			
			if(isset($_SESSION['auth'])) {
				if(is_numeric($_SESSION['auth']) && !empty($_SESSION['auth'])) {
					$query = mysqli_query($sql, 'SELECT UserName FROM users WHERE UserID = "'.$_SESSION['auth'].'"');
					
					if(mysqli_num_rows($query) == 0) {
						unset($_SESSION['auth']);
						header('Location: signin.php');
						exit();
					}
				}
			}
		}
		
		function IsBanned()
		{
			$banned = $this->GetData('UserBanned');
			
			if($banned == 1) {
				header('Location: ./index.php');
				exit();
			}
		}
		
		function IsAdmin()
		{
			if($this->GetData('UserAdmin') == 0) {
				header('Location: ./index.php');
				exit();
			}
		}
		
		function HasMembership()
		{
			if($this->GetData('UserMembership') == 0) {
				header('Location: ./purchase.php');
				exit();
			}
		}
		
		function GetData($data)
		{
			global $sql;
			
			if(isset($_SESSION['auth'])) {
				$id = $_SESSION['auth'];
				
				if(is_numeric($id)) {
					$query = mysqli_query($sql, 'SELECT '.$data.' FROM users WHERE UserID = "'.$id.'"');
					$row = mysqli_fetch_array($query);
					return $row[$data];
				}
			}
		}
	}