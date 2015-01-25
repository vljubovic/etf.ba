<?PHP
	header('Content-Type: application/json');
	//////////////////////////////////
	//          SLACK
	// Slack upakuje username i password tako da ga je jako tesko(ovo moram jos jednom promisliti do nemoguce za sada:)) probiti  rainbow tablom
	//////////////////////////////////
	function getSlak($username, $password) {
		$md5hash=sha1("GITHUB".$username."GITHUB".$password."GITHUB");
		return $md5hash;
	}

	function registerSession($a,$user, $role) { 
			$ip = getenv ("REMOTE_ADDR");

			$_SESSION['user'] = array("ip" => $ip,
					"nickname" => htmlentities($a[nickname],ENT_QUOTES,'UTF-8'),
					"username" => htmlentities($_REQUEST['username']),
					"firstname" => htmlentities($a[firstname],ENT_QUOTES,'UTF-8'),
					"lastname" => htmlentities($a[lastname],ENT_QUOTES,'UTF-8'), 
					"uid" => $a[id], 
					"hlogin" => $a['sh_box_nickname']."@etf.ba", 
					"logged" => "true", 
					"type" => $role, 
					"supergroup" => $a["fk_supergroup"], 
					"habermode" => $a['sh_box_moderator'], 
					"zid"=>htmlentities($a['zamgerid'],ENT_QUOTES,'UTF-8'), 
					"sessionid" => $a['password'], 
					"sh_box_nickname" => $a['sh_box_nickname']
			);

			$expires = time() + (1000 * 60 * 60 * 24 * 7);
			$sh_nickname = htmlentities($a['sh_box_nickname'],ENT_QUOTES,'UTF-8');
			$isHaberMod = intval($a['sh_box_moderator']);
	}


	function login($user,$password) {
		include("db.php");	
		$sql="SELECT id, password, zamgerid,firstname,lastname,nickname,index_number,administartor,sh_box_moderator,sh_box_nickname,secondary_email,fk_supergroup FROM user WHERE username=:username and approved=1";
		$sth1 = $db->prepare($sql);
		$sth1->execute(array(':username' => $user));
		$a = $sth1->fetch(PDO::FETCH_ASSOC);

		$role = 'user';
		if ($a['administartor'] =='1') $role='admin';
		if ($a['sh_box_moderator'] =='1') $role='moderator';

		$a['type']=	$role;

		$nick = $a['sh_box_nickname'];
		
		if(getSlak($password) == $a['password'] || $password == $a['password'])
		{
			echo '{"success":true, "user" : {'. 
					'"uid":"'.$a['id'].'", '.  
					'"role":"'.$role.'", '.
					'"nick":"'.$nick.'", '.
					'"hlogin":"'.$nick.'@etf.ba", '.
					'"token":"'.$a['password'].'" }'.
				 '}';
			registerSession($a,$user,$role);

			exit;

		}	else {
			echo '{"success":false}';
			exit;
		}
	}

	ob_start();
	session_start();

	if (isset($_REQUEST['username'])) {
		$user = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		login($user,$password);
	}


?>