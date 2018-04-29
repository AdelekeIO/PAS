<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

	<?php require_once "includes/header.php"; ?>


	<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<div>
						<ul>
							<li>
								<a href="admin_page.php?login=<?php echo $_SESSION['user_id']; ?>">Back to main menu</a>
							</li>
						<!-- 	<li>
								<a href="add_staff.php">View/Create Staff Details</a>
							</li>
							<li>
								<a href="add_question.php">Add Appraisal Questions</a>
							</li>
							<li>
								<a href="logout.php">Logout</a>
							</li> -->
						</ul>
				</div>
			</td>
			<td class="content">
				<div>
					<h2>View Appraisal Record</h2>
				</div>
				<p>Welcome to Administrative menu, <?php echo $_SESSION['username']; ?></p>
					<div class="appraise">
					<table  style="font-size:17px;vertical-align:middle;border: 2px solid black;" border="1" cellpadding="3" >

						<thead>
						<tr >
						<th>Full Name</th>
						<th>Total Mark</th>
						<th>Grade</th>
						<th>Decision</th>
						<th>Appraised By</th>
						</tr>
						</thead>
						<?php 
							$query="SELECT employees.surname AS sname,employees.firstname AS fname, appraisal_list.total_mark AS tmark,
									appraisal_list.total_mark_avrg AS average_mark, appraisal_list.appraised_by AS appraised_by
									FROM employees
									INNER JOIN appraisal_list
									ON employees.id = appraisal_list.employee_id
									ORDER BY appraisal_list.total_mark DESC";
							$result=mysql_query($query,$connection);
							
								comfirm_query($result); 
							
							
						 ?>
						 <?php 
						 	
						  ?>

						
							<?php 


								while ($rows= mysql_fetch_array($result)) {
									echo "<tr>";
									echo "<td>{$rows['sname']} {$rows['fname']}</td>";
									echo "<td>{$rows['average_mark']}</td>";
									echo "<td>".get_grade($rows['average_mark'])."</td>";
									echo "<td>".get_comment($rows['average_mark'])."</td>";
									echo "<td>{$rows['appraised_by']}</td>";
									echo "</tr>";
								}
							 ?>
							
						
					</table>
					</div>
			</td>
		</tr>
		
	</table>

