<?PHP
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: *");
	include("../db.php");	// get configuration :
	//where type=".intval($_GET['id'])." 
	$sql="SELECT nickname FROM funynickname ORDER BY RAND() LIMIT 1";
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$rando = rand(1, 100);
	$sql="INSERT INTO haberlog (nick,ip,forwrd,time) values ('".$row['nickname'].$rando."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_X_FORWARDED_FOR']."',now())" ;
	mysql_query($sql);
	
	echo "ǂ".$row['nickname'].$rando;
?>
