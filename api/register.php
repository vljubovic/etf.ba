<?PHP
	header('Content-Type: application/json');

	include("db.php");	// get configuration :S


	$user= $_REQUEST['name'];
	$password= $_REQUEST['password'];
	$email = $_REQUEST['email'];
	$aemail = $_REQUEST['altemail'];
	$institution_email_regex="/^([a-z])+([0-9])+\@etf.unsa.ba/";
	
	if (strlen($user)<3 || strlen($password)<3 || strlen($aemail)<4 || strlen($email)<4){
		echo  '{"success": false , "error": "Input too short"}';
		exit;
	}
		
	if (!preg_match('/^[a-z\d_]{3,20}$/i', $user)){
		echo  '{"success": false , "error": "Username nije u dobrom formatu"}';
		exit;
	}
		
	if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $aemail)){
		echo  '{"success": false , "error": "Alternativni email nije u dobrom formatu"}';
		exit;
	}
		
	// Ako neko vec postoji sa fakultetskim email-om
	$sql="select id from user where institution_email=:email";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':email' => $email));
	if ($sth1->rowCount()>0)	{
		echo  '{"success": false , "error": "Email se vec korsiti"}';
		exit;
	}
	
	// Ako regex nije dobar tj. ako nije fakultetska adresa
	if (!preg_match($institution_email_regex, $email)){
		echo  '{"success": false , "error": "Format fakultetskog emaila nije validan"}';
		exit;
	}

	// Ako neko vec postoji sa tim usernameom
	$sql="select id from user where username=:user OR sh_box_nickname=:user";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':user' => $user));
	if ($sth1->rowCount()>0){
		echo  '{"success": false , "error": "Username se vec koristi"}';
		exit;
	}

	// Kreiraj approve ID koji cemo poslati na email za provjeru
	$approveid=md5(generatePassword(20,3).uniqid());
	

	// Dodati getSlack za password
	$sql="INSERT INTO user (password,institution_email,secondary_email,fk_supergroup,nickname,sh_box_nickname,approve_id,username, firstname, chat_nickname, super_approved ) values (sha1(:password),:email,:aemail,:sgroup,:user,:user,:approveid,:user,:user, :user, 1)";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':user' => $user,
							':email' => $email,
							':password' => $password,
							':sgroup' => 1,
							':approveid' => $approveid,
							':aemail' => $aemail));
	$id =$db->lastInsertId();

	// posalji email 
	$subject = "ETF.ba verfikacija registracije";
	$headers = 'From: Studentski portal <ebagro@etf.ba>' . "\r\n";
	$body = "Pozdrav,  ||  Kako bi verifikovali vas etf.ba account  ||  Vas username je: $user  ||  Kliknite ovdje: http://etf.ba/api/approve/$approveid";
	
	if (!mail($email, $subject, $body,$headers)) {
		echo  '{"success": false , "error": "Ne mogu da posaljem verifikacijski email"}';
		$sql="delete from user where id=:id";
		$sth1 = $db->prepare($sql);
		$sth1->execute();

		exit;
	}

	if (!copy("../avatar/default.png", "../avatar/".$id.".png")) {
		echo  '{"success": false , "error": "Ne mogu da kreiram avatara ali je korisnik registrovan"}';
		exit;
	}

	echo  '{"success": true }';

		
?>