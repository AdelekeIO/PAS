<?php
function fetch_page_form($formValue){

if ($formValue==1) {
	?>
	
					 		<tr>
					 			<td>Surname:</td>
					 			<td>
					 				<input type="text" name="surname" maxlenght="30" 
					 				value="<?php if (!empty($_POST['surname'])) {
					 					echo $_POST['surname'];
					 				} ?>" />
					 			</td>
					 		
					 			<td>Firstname:</td>
					 			<td>
					 				<input type="text" name="firstname" maxlenght="30" value="<?php if (!empty($_POST['firstname'])) {
					 					echo $_POST['firstname'];
					 				} ?>">
					 			</td>

					 		</tr>
					 		<tr>
					 			<td>
					 				Lastname:
					 			</td>
					 			<td>
					 				<input type="text" name="lastname" maxlenght="30" value="<?php if (!empty($_POST['lastname'])) {
					 					echo $_POST['lastname'];
					 				} ?>" />
					 			</td>

					 		</tr>
					 		<tr>
								<td>Gender:</td>
								<td>
								<select name="gender" value="">
									  <option>Male</option>
									  <option>Female</option>
								</select>
					 			
					 			</td>
					 			<?php $gender=""; ?>
					 			<td>Marraige Status:</td>
								<td>
								<select name="marital_status" value="">
									  <option <?php if ($gender=='Male'){echo "selected";} ?>>Single</option>
									  <option <?php if ($gender=='Male'){echo "selected";} ?>>Married</option>
								</select>
					 			
					 			</td>
					 			
					 		</tr>
					 		<tr>
					 			<td>
					 				Position:
					 			</td>
					 			<td>
					 				<input type="text" name="position" maxlenght="30" value="<?php if (!empty($_POST['position'])) {
					 					echo $_POST['position'];
					 				} ?>" />
					 			</td>

					 			<td><label>Depatment:</label></td>
					 			<td>
					 				<select name="dept">
					 					<option>Admin</option>
					 					<option>Driver</option>
					 					<option>Security</option>
					 					<option>Cleaner</option>
					 					<option>Vendor</option>
					 				</select>
					 				
					 			</td>


					 		</tr>
					 		<tr>
					 			<td>DOB:</td>
								<td>
									<span>
								<select name="day" value="<?php echo htmlentities($day); ?>">
									<?php 
										$days=count_nums(1,31);
										
										foreach ($days as $day) {
											echo  $day;
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
					 			<td colspan="3">
					 				<input type="submit" name="submit" value="Register"/>
					 			</td>

					 		</tr>
					 	
	<?php
}elseif ($formValue==2) {
	?>

					 		<tr>
					 			<td>Username:</td>
					 			<td>
					 				<input type="text" name="username" maxlenght="30" value="<?php  ?>" />
					 			</td>
					 		</tr>
					 			<tr>
					 			<td>
					 				Password:
					 			</td>
					 			<td>
					 				<input type="password" name="password" maxlenght="30" value="<?php  ?>" />
					 			</td>
					 		</tr>
					 		<tr>
					 			<td>
					 				User Type:
					 			</td>
					 			<td>
					 			<select name="usertype" value="">
									  <option>Manager</option>
									  <option>Admin</option>
									  <option>H.R</option>
									  <option>Supervisor</option>
								</select>
								</td>
					 		</tr>
					 		<tr>
					 			<td colspan="2"><input type="submit" name="submit" value="Crerate user"/>
					 			</td>
					 		</tr>
					 		
					 	
	<?php
}

}
?>
					 	
					 