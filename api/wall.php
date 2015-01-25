<?PHP
	header('Content-Type: application/json');

	include 'db.php';

	$prev = intval($_REQUEST['page']);
	$much=17;
	$next = $prev +$much;

	$qString = "SELECT fk_user,type,creation_time,firstname,lastname, fk_resource_items ,sh_box_moderator ,administartor , r.id 'rid', u.id 'uid', UNIX_TIMESTAMP(creation_time) 'tmstmp' FROM resource r, user u WHERE  u.id=fk_user and (type='social' OR type='file' OR type='event' or type='article') and r.visible=0 and r.deleted=0 
			order by r.creation_time desc limit ".$prev.",".$much;

	$sth = $db->prepare($qString);
	$sth->execute();

	$num=1;
	echo '[';
	while ($row1 = $sth->fetch(PDO::FETCH_ASSOC))
	{
		$sqla ="select * from resource_".$row1['type']." where id=".$row1['fk_resource_items'];
		$sth1 = $db->prepare($sqla);
		$sth1->execute();
		$result = $sth1->fetch(PDO::FETCH_ASSOC);

		//broj dobar
		$sthDobar = $db->prepare("SELECT count(id) 'cid' from dobar where fk_resource=".$row1['rid']);
		$sthDobar->execute();
		$nmr = $sthDobar->fetch(PDO::FETCH_ASSOC);
		$result['dobar'] = $nmr['cid'];
			
		// Broj odgovora
		$sthReply = $db->prepare("SELECT count(*) 'cnt' FROM resource r, resource_post rp WHERE type='post' and rp.id=r.fk_resource_items and deleted=0 and fk_resource=".$row1['rid']);
		$sthReply->execute();
		$nmr = $sthReply->fetch(PDO::FETCH_ASSOC);
		$result['replies'] = $nmr['cnt'];
		

		$result['type'] = $row1['type'];
		$result['uid'] = $row1['fk_user'];
		$result['firstname'] = $row1['firstname'];
		$result['lastname'] = $row1['lastname'];
		$result['sh_box_moderator'] = $row1['sh_box_moderator'];
		$result['administartor'] = $row1['administartor'];
		$result['tmstmp'] = $row1['tmstmp'];
		echo json_encode($result);
		//echo json_encode($row1);
		if ($num != $sth->rowCount())
			echo ', ';
		$num++;
	}
	echo ']';

?>