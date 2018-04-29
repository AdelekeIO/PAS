<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

	<?php require_once "includes/header.php"; ?>


	<table align="center" class="skeleton">
		<tr>
			<td class="navigation">
				<li>
					<ul>
					<a href="logout.php">Logout</a>
					</ul>
					<?php 
					if ($_SESSION['userType']=="Admin") {
						echo "<ul><a href=\"admin_page.php\">Back to main menu</a></ul>";
					} 
					?>
				</li>
			</td>
			<td class="content">
			
						<?php 
							if (isset($_GET['staff'])) {
								echo("<div class=\"details\" >");
								
							$query="SELECT * FROM employees WHERE id=".$_GET['staff'];
							$result=mysql_query($query);
							$Dname=mysql_fetch_array($result);
							$fullname=$Dname['surname']." ".$Dname['firstname']." ".$Dname['lastname'];
							$Dob=$Dname['dob'];
							$position=$Dname['position'];
							$LastApprslDate;
							echo "FULL NAME: ".$fullname."<br/>";
							echo("POSITION: ".$position."<br/>");
							echo("DOB: ".$Dob);
							echo "<br/><br/>";
							echo "<center style=\"background-color:green\">";
									echo "<a href=\"appraisal_page.php?staff={$_GET['staff']}\">[APPRAISE]</a>";
								echo "<center>";
							echo("</div>");
							}

						 ?>

					

				<?php 
				if (isset($_GET['login'])) {
					# code...
				?>
				<div>
					<h2>List of Employee to be Apparaised</h2>
				</div>
				<p>Kindly click on the employee name for appraisal, <?php echo $_SESSION['username']; ?></p>
					<div>
						<ul>
							<?php 
									$result=queryApprslList($_SESSION['user_id'],$_SESSION['username']);
								if (mysql_num_rows($result)>0) {
									 															
								while ($result_set=mysql_fetch_array($result)) {
									$query="SELECT * FROM employees WHERE id=".$result_set['employee_id'];

									$result2=mysql_query($query,$connection);
									$names=mysql_fetch_array($result2);
										echo "<li >
										<a class=\"tooltip\" href=\"employee_view.php?login={$_SESSION['user_id']}&staff={$names['id']}\">";
										echo "{$names['surname']} {$names['firstname']}";
										echo "<span class=\"tooltiptext\">
										{$names['surname']} {$names['firstname']} <br/>
										{$names['position']} <br/>
										{$names['dob']}</span>";
										echo "</a>";

										echo "</li>";
									
								}
							}else{
								echo "<i>You have already appraised all neccessary employees..</i>";
								// echo "string";
							}
							 ?>
					
						</ul>
					</div>
					<br/>
					
						<?php } else {
							if (isset($_GET['sapid'])) {
						 ?>
					<div>

						<h2>Appraised employee</h2>
						<p></p>
						
						<?php 

						//	After aprraisal
						//App Returns here to show message successful and and remaining list.
						$msg="";
						
							$query="SELECT * FROM employees WHERE id=".$_GET['sapid'];

									$result3=mysql_query($query,$connection);
									$aname=mysql_fetch_array($result3);
							echo "<ul>	<li>{$aname['surname']} {$aname['firstname']} is successfuly appraised.</li></ul>";
							

							$result=queryApprslList($_SESSION['user_id'],$_SESSION['username']);
							if (mysql_num_rows($result)>0) {
								echo "<br/><hr/><br/>";
									echo "<div>Here is the remaining list..</div>";											
								while ($result_set=mysql_fetch_array($result)) {
									$query="SELECT * FROM employees WHERE id=".$result_set['employee_id'];

									$result2=mysql_query($query,$connection);
									$names=mysql_fetch_array($result2);
									
									echo "<ul><li><a href=\"appraisal_page.php?staff={$names['id']}\">{$names['surname']} {$names['firstname']}</a></li></ul>";
									
								}
							}else{
								echo "<i>You have already appraised all neccessary employees..</i>";
								// echo "string";
							}

						}
						// echo $msg;
						}
						?>
						
					</div>
					

			</td>
		</tr>
		
	</table>

<?php require ("includes/footer.php"); ?>