<?php require_once "includes\connection.php" ?>
<?php 
	$result=mysql_query("SELECT COUNT(id) FROM questions") or die("ERROR :".mysql_error());
 	$value= mysql_fetch_array($result);
 	echo $value[0];
 ?>