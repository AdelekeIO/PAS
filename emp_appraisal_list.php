<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

	<?php require_once "includes/header.php"; ?>


	<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<li>
					<ul>
					<a href="logout.php">Logout</a>
					</ul>
				</li>
			</td>
			<td class="content">
				<div>
					<h2>Admin page</h2>
				</div>
				<p>Welcome to Administrative menu, <?php echo $_SESSION['username']; ?></p>
					<div>
						<ul>
							<li>
								<a href="content.php">Manage Appraisal Record</a>
							</li><li>
								<a href="add_staff.php">View/Create Staff Details</a>
							</li>
							<li>
								<a href="logout.php">Logout</a>
							</li>
						</ul>
					</div>
			</td>
		</tr>
		
	</table>

