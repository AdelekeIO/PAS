<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once "includes/functions.php" ?>
<?php 
	//  if (logged_in()) {
	// 	redirect_to("staff.php");
	// }
 
  ?>
	<?php 

	include "includes/form_functions.php";

	//START FORM PROCEssING

	if (isset($_POST['submit'])) {
		
		//initialize an array to hold our errors
					$errors=array();

					//perform validations on the form data
					$required_fields=array('username','password');
					$errors=array_merge($errors,check_required_fields($required_fields));

					$fields_with_lengths=array('username'=>30,'password'=>30);
					$errors=array_merge($errors,check_max_field_lenghts($fields_with_lengths));	
					//clean up the form data before putting it in the database
					$username=trim(mysql_prep($_POST['username']));
					$password=trim(mysql_prep($_POST['password']));
					$hashed_password=sha1($password);

						// echo "visible is:".$visible;
					//Database sibmission only proceeds if there were NO errors.

					if (empty($error)) {
						$query="SELECT id,username,userType FROM logins
							WHERE username='{$username}'
							AND hashed_password='{$hashed_password}'
							LIMIT 1";
					
					$result=mysql_query($query,$connection);
						if (mysql_num_rows($result)==1) {
							//successful:User name and passsword authenticated and only one match
							$found_user =mysql_fetch_array($result);
							$_SESSION['user_id']=$found_user['id'];
							$_SESSION['username']=$found_user['username'];
							$userType=$_SESSION['userType']=$found_user['userType'];
				
							if ($found_user['userType']=="Admin") {
								redirect_to("admin_page.php?login={$found_user['id']}");
							}elseif($found_user['userType']=="H.R"|| $userType=="Supervisor"|| $userType=="Manager"){
								redirect_to("employee_view.php?login={$found_user['id']}");
							}else{
								$message="You are not qualified to appraise!";
							}
							
							// $message="The user was successfully vreated.";
							}else{
							//failed:Username and password combo incorrect
							$message="The user name and password combination are incorrect<br/>
										Please make sure your caps lock key is off and try again.";
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
	}else{
	//Form has not been submitted
		if (isset($_GET['logout']) && $_GET['logout']==1) {
			$message="You are now logged out";
		}
		$username="";
		$password="";
	}
 ?>		

	<?php require_once "includes/header.php"; ?>
	<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<!-- <li>
					<ul>
					<a href="">&plus;add new user</a>
					</ul>
				</li> -->
			</td>
			<td class="content">
				<div>
					<h2>Login Page</h2>
				</div>
				<?php if (!empty($message)) {
						echo "<p class=\"message\">".$message."</p>";
							}
					 ?>

					 <?php if (!empty($errors)) {
					 	display_errors($errors);
					 		} 
					 ?>
					<div>
						 <form action="index.php" method="post">
					 	<table>	
					 		<tr>
					 			<td>Username:</td>
					 			<td>
					 				<input type="text" name="username" maxlenght="30" value="<?php echo htmlentities($username); ?>" required="" />
					 			</td>
					 		</tr>
					 			<tr>
					 			<td>
					 				Password:
					 			</td>
					 			<td>
					 				<input type="password" name="password" maxlenght="30" value="<?php echo htmlentities($password); ?>" required=""/>
					 			</td>

					 		</tr>
					 		<tr>
					 			<td colspan="2"><input type="submit" name="submit" value="Login"/>
					 			</td>
					 		</tr>
					 	</table>
					 
					 </form>
					</div>
			</td>
		</tr>
		
	</table>

