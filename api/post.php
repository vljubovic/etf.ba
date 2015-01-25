<?PHP 
	ob_start();
	session_start();

if ($_SESSION['user']['logged'] == "true") {
	
	include('db.php');

	$uid = $_SESSION['user']['uid'];

	$post = $_REQUEST['post'];

	if (strlen($post) < 4) {
		echo '{"success":false, "error" : "Tekst je prekratak - bar 3 karaktera"}';
		exit;
	}

	$sql="insert into  resource (fk_user,fk_group,fk_resource_items,type,creation_time,deleted,hot,visible) values (:uid,0,0,'social',now(),0,0,0)";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':uid'=>$uid));
	$iid =$db->lastInsertId();

	$sql="insert into resource_social (message,update_time,fk_resource) values (:post,now(),:lastid)";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':post'=>$post, ':lastid' => $iid));
	

	$sql="update resource set fk_resource_items=:resource where id=:iid";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':iid'=>$iid, ':resource' => $db->lastInsertId() ));

	echo '{ "success": true , "fk_resource" : ' . $iid . '}';
	

}


?>