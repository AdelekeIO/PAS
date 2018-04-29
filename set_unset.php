<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php confirm_logged_in(); ?>

<?php 
if (isset($_GET['aid'])) {
		$id=$_GET['aid'];
		$sname=$_GET['asname'];
		
		$sql1="SELECT *
				FROM `logins`
				WHERE `username` = '{$sname}'";
		$result1=mysql_query($sql1) or die("ERROR 1: ".mysql_error());
		$loginid=mysql_fetch_array($result1);
		$login_id=$loginid['id'];
		$sql="INSERT INTO appraisal_list (employee_id,login_id)
		 VALUES ({$id},{$login_id})";
		$result=mysql_query($sql) or die("ERROR 2: ".mysql_error());
		if (mysql_affected_rows()==1) {
			$message="{$sname} has been successfully included in the appraisal list.";
			$sql2="UPDATE employees SET isset_for_Appraisal='Yes' WHERE id={$id}";
		 mysql_query($sql2) or die("ERROR 3: ".mysql_error());
		 $_GET['aid']=0;$_GET['asname']="";
		 redirect_to("add_staff.php");
		}
		
} ?>
<?php mysql_close($connection); ?>