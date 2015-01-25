<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>haber</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script>
		body {
			font-face: verdana;
		}
	</script>
</head>
<body>
<div class="panel panel-default" style="margin-left:20%">
<div class="panel-heading">Ovo je samo arhiva habera i nije uzivo. Da pristupite haberu uzivo <span class="label label-danger">morate se prijaviti</span></div>
<table class="table">

<?PHP
	// NE radi na development verziji treba portati na mysql PDO !
	include("../api/db.php");	// get configuration :
	$sql="SELECT * FROM  `ofMucConversationLog` ORDER BY `ofMucConversationLog`.`logTime` DESC LIMIT 0 , 900";

	$r=mysql_query($sql);

	while ($row=mysql_fetch_array($r)) {
		echo "<tr><td style=\"float:right; width:100px;\"><b><span class=\"label label-primary\">".htmlentities($row['nickname'],ENT_QUOTES,'UTF-8').":</td><td>  ".htmlentities($row['body'],ENT_QUOTES,'UTF-8')."</td></tr>";
	}
?>
    </table>
</div>
</body>
