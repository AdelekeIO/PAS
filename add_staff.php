<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	include "includes/form_functions.php";
	if (empty($_GET['form']) || $_GET['form']==null) {
		$_GET['form']=0;
	}
	if (isset($_GET['set'])) {
		$id=$_GET['aid'];
		$sname=$_GET['asname'];
		$message=set_unset($id,$sname,true,false);
	}elseif(isset($_GET['unset'])){
		$id=$_GET['aid'];
		$sname=$_GET['asname'];
		$message=set_unset($id,$sname,false,true);	
	}

	//START FORM PROCEssING
	if ($_GET['form']==1) {
		
	if (isset($_POST['submit'])) {

			
		//initialize an array to hold our errors
					$errors=array();

					//perform validations on the form data

					$required_fields=array('surname','firstname','lastname','position',);
					$errors=array_merge($errors,check_required_fields($required_fields));

					$fields_with_lengths=array('surname'=>30,'firstname'=>30,'lastname'=>30,'position'=>30);
					$errors=array_merge($errors,check_max_field_lenghts($fields_with_lengths));	
					//clean up the form data before putting it in the database
					
					$surname=trim(mysql_prep($_POST['surname']));
					$firstname=trim(mysql_prep($_POST['firstname']));
					$lastname=trim(mysql_prep($_POST['lastname']));
					$position=trim(mysql_prep($_POST['position']));
					$gender=trim(mysql_prep($_POST['gender']));
					$marital_status=trim(mysql_prep($_POST['marital_status']));
					$day=trim(mysql_prep($_POST['day']));
					$month=trim(mysql_prep($_POST['month']));
					$year=trim(mysql_prep($_POST['year']));
					$dob=$year."-".$month."-".$day;
					$dept=trim(mysql_prep($_POST['dept']));


						// echo "visible is:".$visible;
					//Database sibmission only proceeds if there were NO errors.

					if (empty($errors)) {
						$query="INSERT INTO employees (
							surname, firstname,lastname,gender,dob,marital_status,position,Dept
							)VALUES(
							'{$surname}',
							'{$firstname}',
							'{$lastname}',
							'{$gender}',
							'{$dob}',
							'{$marital_status}',
							'{$position}',
							'{$dept}'
							)";
					
						$result=mysql_query($query,$connection);
						if (mysql_affected_rows()==1) {
							//successful
							$message="The user was successfully registerd.<br/>";
							// $message.="Create login details for the employee <a href=\"add_staff.php?form=2&usernme={$surname}\">here.</a>";
							// redirect_to("add_staff.php?form=2&username={$surname}");
							}else{
							//failed
							$message="The user could not be created.";
							$message.="<br/>".mysql_error(); 
						}


					} else {
							if (count($errors)==1) {
								$message="There was 1 error in the form.";

							}else{
								$message="There were ".count($errors)." errors in the form.";
							}
					//END OF PROCESSING
			}

				
						
	}else{//Form has not been submitted
					$surname="";
					$firstname="";
					$lastname="";
					$position="";
					$gender="";
					$marital_status="";
					$day="";
					$month="";
					$year="";
					$dob="";
					$dept="";

	}

}elseif ($_GET['form']==2) {
	if (isset($_POST['submit'])) {
					
					$errors=array();
					$required_fields=array('username','password','usertype');
					$errors=array_merge($errors,check_required_fields($required_fields));

					$fields_with_lengths=array('username'=>30,'password'=>30,'usertype'=>30);
					$errors=array_merge($errors,check_max_field_lenghts($fields_with_lengths));	
					
					$username=trim(mysql_prep($_POST['username']));
					$password=trim(mysql_prep($_POST['password']));
					$hashed_password=sha1($password);
					$usertype=trim(mysql_prep($_POST['usertype']));
					
						if (empty($errors)) {
						$query="INSERT INTO logins (
							username,hashed_password,userType
							)VALUES(
							'{$username}',
							'{$hashed_password}',
							'{$usertype}'
							)";
					
						$result=mysql_query($query,$connection);
						if (mysql_affected_rows()==1) {
							//successful
							$message="User login was successfully created.";
									$_GET['form']=0;
							}else{
							//failed
							$message="The user login could not be created.";
							$message.="<br/>".mysql_error(); 
						}


					} else {
							if (count($errors)==1) {
								$message="There was 1 error in the form.";

							}else{
								$message="There were ".count($errors)." errors in the form.";
							}
					//END OF PROCESSING
			}

				
						
	}else{//Form has not been submitted
				$username="";
				$password="";
				$usertype="";
	}

}else{}

 ?>		
 
<?php include("includes/header.php"); ?>
		<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<br/>
				<li class="<?php if ($_GET['form']==1) {
					echo("selected");
				} ?>">
					<a href="add_staff.php?form=1">Add employee Details</a>
				</li>
				<li class="<?php if ($_GET['form']==2) {
					echo("selected");
				} ?>">
					<a href="add_staff.php?form=2">Create Login</a>
				</li>
				<!-- <li>
					<a href="add_staff.php?form=2">Create Login Details</a>
				</li> -->
				<br/>
				<li>
				<a href="admin_page.php">Return to menu</a>
				<br/>
				</td>
				
				<td class="content">
					<h2>
						<?php 
						$page_header="View/Create Staff Details";
							$formValue=$_GET['form'];
							if ($formValue==1) {
								$page_header="Add Employee Details";
							}elseif ($formValue==2) {

								$page_header="Create Login Details";
							}
							echo($page_header);
						 ?>
						
					</h2>
					<?php if (!isset($message) AND isset($_GET['username'])) {
						echo "Fill the password filed and select the user type.";
					} ?>
					<?php if (!empty($message)) {
						echo "<p class=\"message\">".$message."</p>";
							}
					 ?>

					 <?php if (!empty($errors)) {
					 	display_errors($errors);
					 		} 
					 ?>
					 <form action="<?php  $_SERVER['PHP_SELF']; ?>" method="post">
					 	<table  class="form">
					 	<?php 
					 	// $formValue=$_GET['form'];

					 	if ($_GET['form']==1) {
					 		
					 		include"form_page.php";
					 		fetch_page_form($formValue);
					 	}else{
					 		include"form_page.php";
					 		if ($_GET['form']==2) {
					 			fetch_page_form($formValue);
					 		}
					 	} 
					 	?>
					 	</table border="7" style="border-left:dotted">
					 </form>
					 <br/>
					 <hr/>
					 <table>
					 	<form>
					 	<tr >
					 		<th>S/N</th>
					 		<th>Surname</th>
					 		<th>Firstname</th>
					 		<th>Lastname</th>
					 		<th>Gender</th>
					 		<th>DOB</th>
					 		<th>Marrital Status</th>
					 		<th>Position</th>
					 		<th>Set for Appraisal</th>
					 		<th> &nbsp;</th>
					 	</tr>

					 <?php 
					 	$query="SELECT * FROM employees ORDER BY isset_for_Appraisal DESC";
					 	$result=mysql_query($query,$connection);
					 	comfirm_query($result);
					 	// $serialno=mysql_num_rows($result);
					 	$serialno=0;
					 	// echo "Count is: ".$count;
					 	
					 	
					 	
					 		while ($table=mysql_fetch_array($result)) {
					 			$serialno++;
					 			$output="";
					 			$output.="<tr>";
					 			$output.="<td>".$serialno."</td>";
					 			$output.="<td>".$table['surname']."</td>";
					 			$output.="<td>".$table['firstname']."</td>";
					 			$output.="<td>".$table['lastname']."</td>";
					 			$output.="<td>".$table['gender']."</td>";
					 			$output.="<td>".$table['dob']."</td>";
					 			$output.="<td>".$table['marital_status']."</td>";
					 			$output.="<td>".$table['position']."</td>";
					 			if ($table['isset_for_Appraisal']=="Yes") {
					 				$output.= "<td ><a style=\"color:green\" href=\"{$_SERVER["PHP_SELF"]}?aid=".urlencode($table['id'])."&asname=".$table['surname']."&unset=true"."\"
					 				>[Unset]</a></td>";
					 			}elseif($table['isset_for_Appraisal']=="" || $table['isset_for_Appraisal']=="NO"){
					 			$output.="<td><a title=\"Appraise\"href=\"{$_SERVER["PHP_SELF"]}?aid=".urlencode($table['id'])."&asname=".$table['surname']."&set=true"."\">Set</a></td>";
					 			}
					 			$output.="<td><a title=\"edit\" href=\"delete_subject.php?id=".urlencode($table['id'])."&sname=".$table['surname']."\" onclick=\"return confirm('Are you sure ?');\">Delete</a></td>";
					 			$output.="</tr>";
					 			$output.="";
					 			echo $output;
					 			}	
					 			
					 	
					  ?>
					  </form>
					  </table>
				</td>
			</tr>	


		</table>
	
	<?php require("includes/footer.php"); ?>
