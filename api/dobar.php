<?PHP
	ob_start();
	session_start();
	
	include ("db.php");
	if ($_SESSION['sesija']['logged'] == "true" ) {
		$uid =$_SESSION['user']['uid'];

		$rid= intval($_REQUEST['did']);

		$sql = "SELECT count(id) cnt from dobar where fk_resource=:rid and fk_user=:user";
		$sth1 = $db->prepare($sql);
		$sth1->execute(array(':user' => $uid, ':rid'=> $rid));
		$a = $sth1->fetch(PDO::FETCH_ASSOC);

		if ($a['cnt']>0) { echo '{"success" : false}'; exit; }
		
		$sql ="insert into dobar (fk_user, fk_resource) values (:user,:rid)";
		$sth1 = $db->prepare($sql);
		$sth1->execute(array(':user' => $uid, ':rid'=> $rid));
		
		echo '{"success" : true}';

	} else echo '{"success" : false }';

?>