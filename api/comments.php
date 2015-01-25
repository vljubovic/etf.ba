<?PHP 
	header('Content-Type: application/json');
	
	if ($_GET['rid']!= '') {
		include('db.php');
		$sql="SELECT subject,message,administartor,update_time,nickname,fk_user,fk_resource,sh_box_nickname,r.id rid FROM resource r, resource_post rp, user u WHERE rp.id=r.fk_resource_items and deleted=0 and u.id=r.fk_user and fk_resource=:resid order by rp.id";
		$sth1 = $db->prepare($sql);

		$sth1->execute(array(':resid'=> $_GET['rid']));
		$a = $sth1->fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($a);
	}

?>