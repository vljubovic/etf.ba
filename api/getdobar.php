<?PHP
	header('Content-Type: application/json');

	include ("db.php");
	$rid= intval($_REQUEST['did']);

	if ($rid=='') exit;

	$sql = "SELECT u.id uid,firstname FROM `dobar`, user u where fk_user=u.id and fk_resource=:rid";
	$sth1 = $db->prepare($sql);

	$sth1->execute(array(':rid'=> $rid));
	$a = $sth1->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($a);

?>