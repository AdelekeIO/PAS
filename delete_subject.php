<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
// if (intval($_GET['subj'])==0) {
// 	redirect_to("content.php");
// }
$count=0;
if (isset($_GET['id'])) {
	$id=mysql_prep($_GET['id']);
	$sname=mysql_prep($_GET['sname']);
	if ($Subject=get_emp_by_id($id)) {
		
		$query1="DELETE FROM employees WHERE id='{$id}' LIMIT 1";
		$query2="DELETE FROM appraisal_list WHERE employee_id={$id} LIMIT 1";
		$query3="DELETE FROM logins WHERE username LIKE '%{$sname}' LIMIT 1";
		
			$result=mysql_query($query1,$connection) or die("ERROR 1: ".mysql_error());
			$count+=mysql_affected_rows();
			$result=mysql_query($query2,$connection) or die("ERROR 1: ".mysql_error());
			$count+=mysql_affected_rows();
			$result=mysql_query($query3,$connection) or die("ERROR 1: ".mysql_error());
			$count+=mysql_affected_rows();
		
		if ($count>=1) {
			redirect_to("add_staff.php");
		}else{
		//..Deletion Failed
		echo "<p> Sebject Deletion Failed";
		echo "<p>".mysql_error()."</p>";
		echo "<a href=\"add_staff.php\">Return to the main page.</a>";
			}
	}else{
		//Subject didn't exist in the database
		redirect_to("add_staff.php");
	}


}

 ?>
<?php mysql_close($connection); ?>