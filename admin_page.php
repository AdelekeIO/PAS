<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

	<?php require_once "includes/header.php"; ?>


	<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<!-- For the navigations links.. -->
			</td>
			<td class="content">
				<div>
					<h2>Admin page</h2>
				</div>
				<p>What would you like to do today, <?php echo $_SESSION['username']; ?></p>
					<div>
						<ul>
							<li>
								<a href="appraisal_rec.php?login=<?php echo $_SESSION['user_id']; ?>">Manage Appraisal Record</a>
							</li>
							<li>
								<a href="add_staff.php?login=<?php echo "{$_SESSION['user_id']}&form=0"; ?>">View/Create Staff Details</a>
							</li>
							<li>
								<a href="add_question.php?login=<?php echo "{$_SESSION['user_id']}&form=0";?>">Add Appraisal Questions</a>
							</li>
							<li>
								<a href="employee_view.php?login=<?php echo $_SESSION['user_id']; ?>">Appraise Employee</a>
							</li>
							<li>
								<a href="logout.php">Logout</a>
							</li>
						</ul>
					</div>
			</td>
		</tr>
		
	</table>

	<?php require("includes/footer.php"); ?>
