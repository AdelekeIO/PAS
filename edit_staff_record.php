<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php 
if (isset($_POST['submit'])) {
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



						// echo "visible is:".$visible;
					//Database sibmission only proceeds if there were NO errors.

					if (empty($errors)) {
						$query="UPDATE employees SET
							surname='{$surname}',
							firstname='{$firstname}',
							lastname='{$lastname}',
							gender='{$gender}',
							dob='{$dob}',
							marital_status='{$marital_status}',
							position='{$position}'
							WHERE id={$_GET['id']}";
					
						$result=mysql_query($query,$connection);
						if (mysql_affected_rows()==1) {
							//successful
							$message="The user record was successfully updated.<br/>";
							// $message.="Create login details for the employee <a href=\"add_staff.php?form=2\">here.</a>";
							}else{
							//failed
							$message="The user could not be created.";
							$message.="<br/>".mysql_error(); 
						}
					}
}
 ?>

	<?php require_once "includes/header.php"; ?>



	<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<li>
					<ul>
					<a href="admin_page.php">Return to menu</a>
					</ul>
				</li>
			</td>
			<td class="content">
				<div>
					<h2>Edit Staff Record</h2>
				</div>
				<p> <?php echo $message; ?></p>
					<div>
						<table>
							<form action"edit_staff_record.php" method="post">
						<tr>
							<?php 
								$query="SELECT * FROM employees WHERE id={$_GET['id']} LIMIT 1";
								$result=mysql_query($query,$connection);
					 			comfirm_query($result);
					 			$result_set=mysql_fetch_array($result);
					 			$sname=$result_set['surname'];
					 			$fname=$result_set['firstname'];
					 			$lname=$result_set['lastname'];
					 			$gender=$result_set['gender'];
					 			$position=$result_set['position'];
					 			$DOB=$result_set['dob'];
					 			$marital_status=$result_set['marital_status'];
					 			echo "DOB is : ".strlen($DOB)."<br/>";
					 			echo "substr is :".substr($result_set['dob'], 8) ;
					 			// while ($result_set=mysql_fetch_array($result)) {
					 				
					 			// }

							 ?>
					 			<td>Surname:</td>
					 			<td>
					 				<input type="text" name="surname" maxlenght="30" value="<?php echo htmlentities($sname); ?>" />
					 			</td>
					 		
					 			<td>Firstname:</td>
					 			<td>
					 				<input type="text" name="firstname" maxlenght="30" value="<?php echo htmlentities($fname); ?>">
					 			</td>

					 		</tr>
					 		<tr>
					 			<td>
					 				Lastname:
					 			</td>
					 			<td>
					 				<input type="text" name="lastname" maxlenght="30" value="<?php echo htmlentities($lname); ?>" />
					 			</td>

					 		</tr>
					 		<tr>
								<td>Gender:</td>
								<td>
								<select name="gender" value="<?php //echo htmlentities($gender); ?>">
									  <option <?php if ($gender=='Male'){echo "selected";} ?> value="Male">Male</option>
									  <option <?php if ($gender=='Female'){echo "selected";} ?> value="Female">Female</option>
								</select>
					 			
					 			</td>

					 			<td>Marraige Status:</td>
								<td>
								<select name="marital_status" value="<?php echo htmlentities($marital_status); ?>">
									  <option <?php if ($marital_status=='Single'){echo "selected";} ?>>Single</option>
									  <option <?php if ($marital_status=='Married'){echo "selected";} ?>>Married</option>
								</select>
					 			
					 			</td>
					 			
					 		</tr>
					 		<tr>
					 			<td>
					 				Position:
					 			</td>
					 			<td>
					 				<input type="text" name="position" maxlenght="30" value="<?php echo htmlentities($position); ?>" />
					 			</td>

					 		</tr>
					 		<tr>
					 			<td>DOB:</td>
								<td>
									<span>
								<select name="day" value="<?php //echo htmlentities($day); ?>">

									<?php 
										$days=count_numss(1,31);
										
										foreach ($days as $day) {
											// echo "<option>".$day."</option>";
											$out="<option ";
											if ($day==substr($dob, 8)) {
												$out.="selected=\"selected\" value=\"{$day}\">";
											}else{
											$out.="value=\"{$day}\">";
											}
											$out.=$day."</option>";
											echo $out;
										}
										
									 ?>
								</select>
								<select name="month" value="<?php echo htmlentities($month); ?>">
									  <?php 
									  $months=count_nums(1,12);
										foreach ($months as $month) {
											echo $month;
										}
									   ?>
								</select>	
								<select name="year" value="<?php echo htmlentities($year); ?>">
									  <?php 
									  $years=count_nums(1970, 2017);
										foreach ($years as $year) {
											echo $year;
										}
									   ?>
								</select>
								</span>
								<td/>
					 		</tr>
					 		<tr>
					 			<td colspan="5">
					 				<input type="submit" name="submit" value="Edit Record"/>&nbsp;
					 				<a href="delete_subject.php?id=<?php echo urlencode($result_set['id']); ?>"
					 					onclick="return confirm('Are you sure ?');">Delete</a>
					 			</td>

					 		</tr>
					 		</form>
					 	</table>
					</div>
			</td>
		</tr>
		
	</table>

<?php require "includes/footer.php"; ?>