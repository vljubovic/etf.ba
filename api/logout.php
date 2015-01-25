<?PHP
	ob_start();
	session_start();
	
	$_SESSION['user']['logged']="false";
	$_SESSION['user']['uid']="";
	$_SESSION['user']=0;
	session_destroy();
	
	$_COOKIE['uid']= '';
	$_COOKIE['token']= '';
	unset($_COOKIE['uid']);
    unset($_COOKIE['token']);
    setcookie ("uid", "", time() - 3600);
    setcookie ("token", "", time() - 3600);

?>