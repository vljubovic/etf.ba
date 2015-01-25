<?PHP
	header('Content-Type: application/json');
	ob_start();
	session_start();
	if ($_SESSION['user']['logged'] == "true") 
		echo '{ "success" : true, "user" : { "uid" : "'.$_SESSION['user']['uid'].'" , "role" : "'.$_SESSION['user']['type'].'" , "nick" : "'.$_SESSION['user']['nickname'].'" , "hlogin" : "'.$_SESSION['user']['hlogin'].'"  , "token" : "'.$_SESSION['user']['sessionid'].'", "mail" : "'.$_SESSION['user']['nickname'].'" } }'; 
	else {
		if (isset($_COOKIE['token']) && strlen ( $_COOKIE['token'])>1) {
			include ('auth.php');
			login($_COOKIE['uid'],$_COOKIE['token']);
		} else {
			echo '{ "success" : false }'; 
		}
 	}
		  
?>