<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	include "includes/form_functions.php";

	//START FORM PROCEssING

	if (isset($_POST['submit'])) {

		//initialize an array to hold our errors
					$errors=array();

					//perform validations on the form data
					$required_fields=array('username','password');
					$errors=array_merge($errors,check_required_fields($required_fields));

					$fields_with_lengths=array('menu_name'=>30,'password'=>30);
					$errors=array_merge($errors,check_max_field_lenghts($fields_with_lengths));	
					//clean up the form data before putting it in the database
					$username=trim(mysql_prep($_POST['username']));
					$password=trim(mysql_prep($_POST['password']));
					$hashed_password=sha1($password);

						// echo "visible is:".$visible;
					//Database sibmission only proceeds if there were NO errors.

					if (empty($error)) {
						$query="INSERT INTO users (
							username, hashed_password
							)VALUES(
							'{$username}',
							'{$hashed_password}'
							)";
					
					$result=mysql_query($query,$connection);
						if (mysql_affected_rows()==1) {
							//successful
							$message="The user was successfully vreated.";
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
		$username="";
		$password="";
	}
 ?>		
 
<?php include("includes/header.php"); ?>
		<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<br/>
				<li>
					<a href="add_staff.php">Add employee Details</a>
				</li>
				<li>
					<a href="">Create Login Details</a>
				</li>
				<li>
				<a href="admin_page.php">Return to menu</a>
				<br/>
				</td>
				
				<td class="content">
					<h2>
						Create New User
					</h2>
					<?php if (!empty($message)) {
						echo "<p class=\"message\">".$message."</p>";
							}
					 ?>

					 <?php if (!empty($errors)) {
					 	display_errors($errors);
					 		} 
					 ?>
					 <!-- <form action="new_user.php" method="post">
					 	<table>	
					 		<tr>
					 			<td>Username:</td>
					 			<td>
					 				<input type="text" name="username" maxlenght="30" value="<?php echo htmlentities($username); ?>" />
					 			</td>
					 		</tr>
					 			<tr>
					 			<td>
					 				Password:
					 			</td>
					 			<td>
					 				<input type="password" name="password" maxlenght="30" value="<?php echo htmlentities($password); ?>" />
					 			</td>

					 		</tr>
					 		<tr>
					 			<td colspan="2"><input type="submit" name="submit" value="Crerate user"/>
					 			</td>
					 		</tr>
					 	</table>
					 </form> -->
				</td>
			</tr>	
		</table>	
	<?php require("includes/footer.php"); ?>
