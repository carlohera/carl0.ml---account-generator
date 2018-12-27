<?php
	include "database.php";
	class auth extends database{
		public function __construct(){
			$this->connect();
			session_start();
		}
		public function getGeoCountry($theip){
			$ip = $theip;
			$details = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
			return $details->country; // -> "Mountain View"
		}
		public function login($license){
			$query = $this->db->prepare("SELECT * FROM `users` WHERE `license` = :license");
			$query->execute(array("license"=>self::sanitize($license)));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if($result){
				$query = $this->db->prepare("SELECT * FROM `bans` WHERE `license` = :license");
				$query->execute(array("license"=>self::sanitize($license)));
				$result_1 = $query->fetch(PDO::FETCH_ASSOC);
				if($result_1){
					/*if has something in ban table*/
					if($result_1['banType'] == "Perma"){
						return "perma-banned";
					}else if($result_1['banType'] == "Temp"){
						$timeLeft = $result_1['unbanDate'];
						if(strtotime($timeLeft) < strtotime(date('d-m-Y h:i:s'))){
							/*if time is up*/
							$query = $this->db->prepare("DELETE FROM `bans` WHERE `license` = :license");
							$query->execute(array("license"=>self::sanitize($license)));

							$_SESSION['id'] = $result['id'];
							$this->update("users", array("latestIP"=>$_SERVER['HTTP_CF_CONNECTING_IP']), "id", $_SESSION['id']);
							$this->insert_query("menulogs", array("type"=>"Site", "version"=>"n/a", "license"=>self::sanitize($license), "psid"=>"n/a", "ip"=>$_SERVER['HTTP_CF_CONNECTING_IP'], "country"=>$this->getGeoCountry($_SERVER['HTTP_CF_CONNECTING_IP'])));
							return "success";
						}else{
							return "temp-banned";
						}
					}
				}else{
					$_SESSION['id'] = $result['id'];
					$this->update("users", array("latestIP"=>$_SERVER['HTTP_CF_CONNECTING_IP']), "id", $_SESSION['id']);
					$this->insert_query("menulogs", array("type"=>"Site", "version"=>"n/a", "license"=>self::sanitize($license), "psid"=>"n/a", "ip"=>$_SERVER['HTTP_CF_CONNECTING_IP'], "country"=>$this->getGeoCountry($_SERVER['HTTP_CF_CONNECTING_IP'])));
					return "success";
				}
			}else{
				return "no-exist";
			}
		}
		public function login2($username, $email){
			$query = $this->db->prepare("SELECT * FROM `users` WHERE `username` = :username");
			$query->execute(array("username"=>self::sanitize($username)));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if($result){
				return "already-exists";
			}else{
				$this->update("users", array("username"=>self::sanitize($username), "email"=>self::sanitize($email)), "id", $_SESSION['id']);
				return "success";
			}
		}
		public function forgotLicense($email){
			if(!empty($email)){
				$query = $this->db->prepare("SELECT * FROM `users` WHERE `email` = :email");
				$query->execute(array("email"=>self::sanitize($email)));
				$result = $query->fetch(PDO::FETCH_ASSOC);
				if($result){
					$subject = "Forgotten License";
					$txt = "Hello, "."".$result['username'].". Your license key is: "."".$result['license']."."."\r\n"."Thanks for using Vendetta!";
					$headers = "From: Vendetta@vendettasprx.net";
					mail($result['email'],$subject,$txt,$headers);
					return "success";
				}else{
					return "no-exist";
				}
			}else{
				return "no-exist";
			}
		}
	}