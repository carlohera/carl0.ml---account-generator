<?php
	include "database.php";
	include "emoji.php";
	class user extends database{
		public function __construct(){
			$this->connect();
			session_start();
		}
		public function generateRandomString() {
            $length = rand(4, 4);
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return strtoupper($randomString);
        }
		public function getGeoCountry($theip){
			$ip = $theip;
			$details = json_decode(file_get_contents("https://ip-api.com/json/{$ip}"));
			return $details->country; // -> "Mountain View"
		}
		public function navigation(){
			echo '
				<li>
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard/Chat</span></a>
                </li>
                <li>
                    <a href="suggestion.php"><i class="fa fa-bug"></i> <span class="nav-label">Suggestions/Bugs</span></a>
                </li>
                <li>
                    <a href="my-profile.php"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a>
                </li>
                <li>
                    <a href="referral.php"><i class="fa fa-users"></i> <span class="nav-label">Referrals</span></a>
                </li>
                <li>
                    <a href="downloads.php"><i class="fa fa-download"></i> <span class="nav-label">Downloads</span></a>
                </li>
			';
			if($this->isAdmin())
			{
				echo '
					<li>
                		<a href="#"><i class="fa fa-wheelchair"></i> <span class="nav-label">Admin</span> <span class="fa arrow"></span></a>
	                    <ul class="nav nav-second-rank">
	                        <li><a href="admin.users.php"><i class="fa fa-users"></i> <span class="nav-label">Manage Users</span></a></li>
	                    </ul>
	                </li>
	            ';
			}
		}
		public function getAdminSparkle($heck){
			if($this->getFromTable("rank", "users", "id", $heck) == "5"){
				return "background: url(https://i.imgur.com/7F70N.gif);";
			}else{
				return "";
			}
		}
		public function admin_getColour($id){
			$sel = $this->getFromTable("*", "bans", "license", $this->getFromTable("license", "users", "id", $id));
			if($sel){
				return "background-color: #ffdddd;";
			}else{
				if($this->getFromTable("rank", "users", "id", $id) == "5" || $this->getFromTable("rank", "users", "id", $id) == "5"){
					return "background: url(https://i.imgur.com/7F70N.gif); background-color: #ccffcc;";
				}else{
					return "background-color: #ccffcc;";
				}
			}
		}
		public function rgb2hex($rgb)
		{
			return '#' . sprintf('%02x', $rgb['r']) . sprintf('%02x', $rgb['g']) . sprintf('%02x', $rgb['b']);
		}
		public function getMenuSettingStatus($value){
			$query = $this->db->prepare("SELECT * FROM `menu_settings` WHERE `userid` = :id");
			$query->execute(array("id"=>$_SESSION['id']));
			$res = $query->fetch(PDO::FETCH_ASSOC);
			if($res[$value] == "1"){
				return "checked";
			}else{
				return "";
			}
		}
		public function getMenuSettingColor($rgb){
			$query = $this->db->prepare("SELECT * FROM `menu_settings` WHERE `userid` = :id");
			$query->execute(array("id"=>$_SESSION['id']));
			$res = $query->fetch(PDO::FETCH_ASSOC);
			return $res[$rgb];
		}
		static function loggedIn(){
			if(!$_SESSION['id']){
				header('Location: order.php');
			}
		}
		public function isAdmin(){
			$rank = $this->select("rank", "users", "id", $_SESSION['id'])[0][0];
			if($rank == "5"){
				return true;
			}else{
				return false;
			}
		}
		public function isModerator(){
			$rank = $this->select("rank", "users", "id", $_SESSION['id'])[0][0];
			if($rank == "4"){
				return true;
			}else{
				return false;
			}
		}
		public function checkPicture(){
			$query = $this->db->prepare("SELECT * FROM `users` WHERE `id` = :id");
			$query->execute(array("id"=>$_SESSION['id']));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if($result['picture'] == ""){
				$this->update("users", array("picture"=>"https://pre00.deviantart.net/70ed/th/pre/f/2015/125/7/e/gta_v_gold_logo_by_eduard2009-d8s8tfk.png"), "id", $_SESSION['id']);
			}
		}
		public function referalIdCheck(){
			$query = $this->db->prepare("SELECT * FROM `refids` WHERE `userid` = :id");
			$query->execute(array("id"=>$_SESSION['id']));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if(!$result){
				$toInsert = $this->generateRandomString().$this->generateRandomString();
				$this->insert_query("refids", array("userid"=>$_SESSION['id'], "refid"=>$toInsert));
			}
		}
		public function menuSettingCheck(){
			$query = $this->db->prepare("SELECT * FROM `menu_settings` WHERE `userid` = :id");
	        $query->execute(array("id"=>$_SESSION['id']));
	        $res1 = $query->fetch(PDO::FETCH_ASSOC);
	        if(!$res1){
	            $this->insert_query("menu_settings", array("userid"=>$_SESSION['id'], "red"=>"255","green"=>"0","blue"=>"103"));
	        }
		}
		public function rankCheck(){
			$query = $this->db->prepare("SELECT * FROM `users` WHERE `id` = :id");
			$query->execute(array("id"=>$_SESSION['id']));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if($result['rank'] == ""){
				$this->update("users", array("rank"=>"User"), "id", $_SESSION['id']);
			}
		}
		public function hasUserandEmail(){
			$query = $this->db->prepare("SELECT * FROM `users` WHERE `id` = :id");
			$query->execute(array("id"=>$_SESSION['id']));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if($result['username'] == "" || $result['username'] == "Customer"){
				header("Location: login2.php");
			}
		}
		public function redeemLicenseKey(){
			$query = $this->db->prepare("SELECT * FROM `refids` WHERE `userid` = :id");
			$query->execute(array("id"=>$_SESSION['id']));
			$res = $query->fetch(PDO::FETCH_ASSOC);
			if($res){
				if($res['currentAmount'] > 4){
					$license = $this->generateRandomString()."-".$this->generateRandomString()."-".$this->generateRandomString();
					$this->update("refids", array("currentAmount"=>$res['currentAmount'] - 5, "totalAmount"=>$res['totalAmount'] + 5), "userid", $_SESSION['id']);
					$this->insert_query("users", array("license"=>$license));
					$this->insert_query("redeemedLicenses", array("userid"=>$_SESSION['id'],"license"=>$license));
				}
			}
		}
		public function isBanned(){
			$q = $this->db->prepare("SELECT * FROM `bans` WHERE `license` = :license");
			$q->execute(array("license"=>$this->getFromTable("license", "users", "id", $_SESSION['id'])));
			$res = $q->fetch(PDO::FETCH_ASSOC);
			if($res){
				unset($_SESSION['id']);
				session_destroy();
				header('Location: banned.php');
			}
		}
		public function getFromTable($what, $table, $where, $equals){
			return $this->select($what, $table, $where, $equals)[0][0];
		}
		public function getSuggestionRatings($suggestionID, $type){
			if($type == "like"){
				$query = $this->db->prepare("SELECT SUM(`like`) FROM `suggestions_ratings` WHERE `suggestionID` = :id");
				$query->execute(array("id"=>$suggestionID));
				$res = $query->fetchColumn(0);
				if($res){
					return $res;
				}
			}else{
				$query = $this->db->prepare("SELECT SUM(`dislike`) FROM `suggestions_ratings` WHERE `suggestionID` = :id");
				$query->execute(array("id"=>$suggestionID));
				$res = $query->fetchColumn(0);
				if($res){
					return $res;
				}
			}
		}
		public function spam(){
			if($_SESSION['amnt']>10){
				$this->update("users",array("shoutboxBanned"=>"1"),"id",$_SESSION['id']);
				return false;
			}else{
				if($_SESSION['time'] < time()){
					$_SESSION['time'] = time() + 3;
					return true;
				}else{
					$_SESSION['amnt']++;
					return false;
				}
			}
		}
		public function sendShout($message){
			if($this->getFromTable("shoutboxBanned", "users", "id", $_SESSION['id']) == 0)
			{
				if($this->spam())
				{
					$exp = explode(" ", $message);
					$username = sprintf("%s %s %s %s %s", $exp[2],$exp[3],$exp[4],$exp[5],$exp[6]);
					switch($exp[0])
					{
						case "/command":
							if($this->getFromTable("rank", "users", "id", $_SESSION['id']) == "5" || $this->getFromTable("rank", "users", "id", $_SESSION['id']) == "4"){
								switch($exp[1]){
									case "delete":
										$q = $this->db->prepare("DELETE FROM `shoutbox` WHERE `id` = :id");
										$q->execute(array("id"=>$exp[2]));
									break;
									case "clean":
										$this->delete_all("shoutbox");
										$toInput = sprintf("%s cleaned the shoutbox.", $this->getFromTable("username", "users", "id", $_SESSION['id']));
										$this->insert_query("shoutbox", array("userid"=>"1337","message"=>$toInput));
									break;
									case "sban": 
										$this->update("users", array("shoutboxBanned"=>"1"), "username", $username);

										$toInput = sprintf("%s shoutbox banned %s from the shoutbox.", $this->getFromTable("username", "users", "id", $_SESSION['id']), $username);
										$this->insert_query("shoutbox", array("userid"=>"2","message"=>$toInput));
									break;
									case "suban": 
										$this->update("users", array("shoutboxBanned"=>"0"), "username", $username);

										$toInput = sprintf("%s shoutbox unbanned %s from the shoutbox.", $this->getFromTable("username", "users", "id", $_SESSION['id']), $username);
										$this->insert_query("shoutbox", array("userid"=>"1337","message"=>$toInput));
									break;
									case "mban24":
										$date = strtotime("+1 day");
										$this->insert_query("bans", array("license"=>$this->getFromTable("license", "users", "username", $username), "banType"=>"Temp", "banReason"=>"An admin banned you via the Shoutbox, so no official reason was given.", "unbanDate"=>date('d-m-Y h:i',$date)));	

										$toInput = sprintf("%s banned %s from the menu/site for 24 hours", $this->getFromTable("username", "users", "id", $_SESSION['id']), $username);
										$this->insert_query("shoutbox", array("userid"=>"1337","message"=>$toInput));
									break;
									case "mpban": 
										$date = strtotime("+100000 days");
										$this->insert_query("bans", array("license"=>$this->getFromTable("license", "users", "username", $username), "banType"=>"Perma", "banReason"=>"An admin banned you via the Shoutbox, so no official reason was given.", "unbanDate"=>date('d-m-Y h:i',$date)));	

										$toInput = sprintf("%s banned %s from the menu/site permanently", $this->getFromTable("username", "users", "id", $_SESSION['id']), $username);
										$this->insert_query("shoutbox", array("userid"=>"1337","message"=>$toInput));
									break;
									case "uban": 
										$q = $this->db->prepare("DELETE FROM `bans` WHERE `license` = :license");
										$q->execute(array("license"=>$this->getFromTable("license", "users", "username", $username)));

										$toInput = sprintf("%s dropped %s's permanent ban.", $this->getFromTable("username", "users", "id", $_SESSION['id']), $username);
										$this->insert_query("shoutbox", array("userid"=>"1337","message"=>$toInput));
									break;
									case "gift": 
										$special = sprintf("%s %s %s %s %s",$exp[3],$exp[4],$exp[5],$exp[6],$exp[7]);
										$this->update("users", array("credits"=>$this->getFromTable("credits", "users", "username", $special) + $exp[2]), "username", $special);

										$toInput = sprintf("%s gifted %s %s credits (They now have %s credits).", $this->getFromTable("username", "users", "id", $_SESSION['id']), $special, $exp[2], $this->getFromTable("credits", "users", "username", $special));
										$this->insert_query("shoutbox", array("userid"=>"1337","message"=>$toInput));
									break;
								}
							}else{
							    $toInput = sprintf("%s Tried To Access An Admin Command", $this->getFromTable("username", "users", "id", $_SESSION['id']));
								$this->insert_query("shoutbox", array("userid"=>$_SESSION['id'],"message"=>$toInput));
							}
						break;
						default: 
							$this->insert_query("shoutbox", array("userid"=>$_SESSION['id'],"message"=>self::sanitize($message)));
						break;
					}
					return "done";
				}
				else
				{
					return "spam";
				}
			}
			else
			{
				return "banned";
			}
		}
		public function getLatestMenuLogins(){
			$query = $this->db->prepare("SELECT * FROM `menulogs` WHERE `type` = :type ORDER BY `date` DESC LIMIT 5");
			$query->execute(array("type"=>"Menu"));
			$res = $query->fetchAll();
			foreach($res as $row){
				echo '
					<tr>
	                    <td>'.date('d-m-Y h:i', strtotime($row['date'])).'</td>
	                    <td>'.$this->getFromTable("username", "users", "license", $row['license']).'</td>
	                    <td>'.$row['version'].'</td>
	                    <td>'.$this->getFromTable("menuLogins", "users", "license", $row['license']).'</td>
	                </tr>
				';
			}
		}
		public function getShoutboxShouts(){
			$query = $this->db->prepare("SELECT * FROM `shoutbox` ORDER BY `time` DESC LIMIT 30");
			$query->execute();
			$res = $query->fetchAll();
			foreach($res as $row){
				$username = $this->getFromTable("username", "users", "id", $row['userid']);
				$profile_img = $this->getFromTable("profile_img", "users", "id", $row['userid']);
				$message = $row['message'];

				if(date('d-m-Y') == date('d-m-Y',strtotime($row['time']))){
					$time = date('H:i',strtotime($row['time']));
				}else{
					$time = date('d-m-Y H:i',strtotime($row['time']));
				}
				if($this->getFromTable("rank", "users", "id", $_SESSION['id']) == "5" || $this->getFromTable("rank", "users", "id", $_SESSION['id']) == "4"){
					switch($this->getFromTable("rank", "users", "id", $row['userid'])){
						case "5":
							echo '
								<div>
									<small style="style="font-weight:bold;	color: #F33;  	text-shadow: 0px 1px 0px #000;">
									<img src="'.$profile_img.'" class="img-circle" style="max-height: 30px; max-width: 30px;">
									</small>
									<a style="font-weight:bold;	color: #F33;  	text-shadow: 0px 1px 0px #000; background: url(https://i.imgur.com/7F70N.gif; " target="_blank" href="my-profile.php?id='.$row['userid'].'">
								
										<b>♔ '.$username.'</b>
									</a>
									<span style="padding-right: 2px;"> : </span>
								<b>	'.emoticons($message).'</b>
								</div>
							';break;
						case "4":
							echo '
								<div>
									<small style="font-weight:bold;	color:#D0EA07;text-shadow: 0px 0px 5px #000;">
									<img src="'.$profile_img.'" class="img-circle" style="max-height: 30px; max-width: 30px;">
									</small>&nbsp;
							<span style="font-weight:bold; color:#D0EA07;text-shadow: 0px 0px 5px #000; target="_blank" href="my-profile.php?id='.$row['userid'].'">
								
									<b>	'.$username.'</b>
									</a>
									<span style="padding-right: 2px;"> : </span>
									<b>'.emoticons($message).'</b>
								</div>
							';break;
						default: 
							echo '
								<div>
									<small style="font-weight:bold;color:#EB8B1F;text-shadow: 1px 1px 10px #EB8B1F;">
									<img src="'.$profile_img.'" class="img-circle" style="max-height: 30px; max-width: 30px;">
									</small>
									<a style="font-weight:bold;color:#EB8B1F;text-shadow: 1px 1px 10px #EB8B1F;" target="_blank" href="my-profile.php?id='.$row['userid'].'">
									<span class="fa fa-trophy  faa-burst animated-hover" style="padding-left: 3px; padding-right: 3px"></span>
									<b>	'.$username.'</b>
									</a>
									<span style="padding-right: 2px;"> : </span>
									<b>'.emoticons($message).'</b>
								</div>
							';break;
					}
				}
				else
				{
					switch($this->getFromTable("rank", "users", "id", $row['userid'])){
						case "5":
							echo '
								<div>
									<small style="color: #AEAEAE; padding: 2px 1px 2px 0px;">
									<img src="'.$profile_img.'" class="img-circle" style="max-height: 30px; max-width: 30px;">
									</small>
									<a style="color: #00BDFF; " target="_blank" href="my-profile.php?id='.$row['userid'].'">
									<span class="fa fa-star-o  faa-spin animated-hover" style="padding-left: 3px; padding-right: 3px"></span>
										'.$username.'
									</a>
									<span style="padding-right: 2px;"> : </span>
									'.emoticons($message).'
								</div>
							';break;
						case "4":
							echo '
								<div>
									<small style="color: #AEAEAE; padding: 2px 1px 2px 0px;">
									<img src="'.$profile_img.'" class="img-circle" style="max-height: 30px; max-width: 30px;">
									</small>
									<b><a style="color: #0000ff;" target="_blank" href="my-profile.php?id='.$row['userid'].'"></b>
									<span class="fa fa-shield" style="padding-left: 3px; padding-right: 3px"></span>
										'.$username.'
									</a>
									<span style="padding-right: 2px;"> : </span>
									'.emoticons($message).'
								</div>
							';break;
						default: 
							echo '
								<div>
									<small style="color: #AEAEAE; padding: 2px 1px 2px 0px;">
									<img src="'.$profile_img.'" class="img-circle" style="max-height: 30px; max-width: 30px;">
									</small>
									<a style="color: #1FFF00;" target="_blank" href="my-profile.php?id='.$row['userid'].'">
									<span class="fa fa-trophy  faa-burst animated-hover" style="padding-left: 3px; padding-right: 3px"></span>
										'.$username.'
									</a>
									<span style="padding-right: 2px;"> : </span>
									'.emoticons($message).'
								</div>
							';break;
					}
				}
			}
		}
	}