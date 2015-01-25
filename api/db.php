<?PHP
	$host = "localhost";
	$username = "";
	$pass = "";
	$dbase = "naziv_baze";
	
	try {  
		$db = new PDO("mysql:host=$host;dbname=$dbase", $username, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	}  catch(PDOException $e) {  
		echo $e->getMessage();  
	}  		
  

  	// Generise password odredjene duzine bolje rijesiti preko UUID() no otom potom :)
	function generatePassword($length=6,$level=2){

		   list($usec, $sec) = explode(' ', microtime());
		   srand((float) $sec + ((float) $usec * 100000));

		   $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
		   $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		   $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

		   $password  = "";
		   $counter   = 0;

		   while ($counter < $length) {
			 $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);

			 if (!strstr($password, $actChar)) {
				$password .= $actChar;
				$counter++;
			 }
		   }

		   return $password;
	}

?>
