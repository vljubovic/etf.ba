<?PHP
	include("db.php");	// get configuration :S

	$email= $_REQUEST['email'];
	
	$sql="select institution_email,id,approved, count(*) cnt from user where institution_email=:email";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':email' => $email));
	$a = $sth1->fetch(PDO::FETCH_ASSOC);

	if ($a['cnt']==0) { echo '{"success" : "Ne postoji"}'; exit; }

	$gid=md5(generatePassword(16,2));
	
	$sql = "update user set approve_id=:gid where id=:uid";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':gid' => $gid, ':uid' => $a['id']));

	
	$subject = "ETF.ba password reset";
	$body = "Pozdrav,  ||  Trazili ste da resetujete vas ETF.ba account  ||  Posjetite: http://etf.ba/api/reset/$gid kako bi ste resetovali vas password";
	$headers = 'From: ETF.ba Studentski portal <noreply@etf.ba>' . "\r\n";
	
	if (mail($a['institution_email'], $subject, $body,$headers)) {
		 echo '{"success" : true }';
	} else {
		 echo '{"success" : false}';
	}

?>