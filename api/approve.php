<?PHP 
	include('db.php');
	
	$id= $_REQUEST['id'];
	
	$sql = "select id, count(*) cnt from user where approve_id=:id";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':id'=>$id));
	$r = $sth1->fetch(PDO::FETCH_ASSOC);
	
	if ($r['cnt'] != 1) { echo 'Verifikacijski ID nije validan'; exit; }

	$uid = $r['id'];
	
	$sql ="update user set approved=1,approve_id='',super_approved=1 where approve_id=:id";
	$sth1 = $db->prepare($sql);
	$sth1->execute(array(':id'=>$id));
			
	echo '<script> window.location = "http://etf.ba"; </script>';

?>