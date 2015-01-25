<?PHP
	include("db.php");	// get configuration :S

	$id= $_REQUEST['id'];
	
	$sql="select institution_email, count(*) cnt from user where approve_id=:id";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':id' => $id));
	$a = $sth1->fetch(PDO::FETCH_ASSOC);

	if ($a['cnt']==0) { echo 'Ne postoji taj ID'; exit; }

	$gid=md5(generatePassword(6,1));
	$pass= sha1($gid);
	
	$sql = "update user set password=:pass where approve_id=:appid";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':pass' => $pass, ':appid' => $_REQUEST['id']));

	
	$subject = "ETF.ba password reset";
	$body = "Pozdrav,  || vas novi password je: ".$gid;
	$headers = 'From: ETF.ba Studentski portal <noreply@etf.ba>' . "\r\n";
	
	if (mail($a['institution_email'], $subject, $body,$headers)) {
		 echo '<script>alert("Provjerite vas email dobili ste novi password"); window.location = "http://etf.ba/#/login";</script>';
	} else {
		
		 echo '{"success" : false}';
	}

?>