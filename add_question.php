<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

	<?php require_once "includes/header.php"; ?>

<?php 
//Adding Questions for Appraisal
if (isset($_POST['submit'])) {
	echo strlen($_POST['question'])."STR";
	if (isset($_POST['question']) && (strlen(trim($_POST['question']))!=0) && trim($_POST['question'])!="Does he/she") {
		if (eregi("^[a-zA-Z0-9_\.\?]+", $_POST['question'])) {
			$question=mysql_prep(trim($_POST['question']));
		
			$query="INSERT INTO questions (id,question)
				VALUES (NULL,'{$question}')";
				$result=mysql_query($query) or die("ERROR".mysql_error());
				
				if (mysql_affected_rows()==1) {
					// mysql_insert_id();
					$message="Questions is successfully added.";
					$result1=mysql_query("SELECT COUNT(id) FROM questions") or die("ERROR COUNT".mysql_error());
					$value=mysql_fetch_array($result1);
					$message.="<br/>".$value[0]." rows inserted";
					$message.="<br/> Newly inseted question is:".$question;
				}else{
					

				}
		}else{$message="suplly a valid question.";}
		

	}elseif (!isset($_POST['question'])||empty($_POST['question']) || $_POST['question']==" ") {
		$message="Fill the text area with questions..";
	}

	
}
 ?>

	<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<ul>
					<!-- <li><a href="#">View added questions</a></li><br/><br/> -->
					<li><a href="admin_page.php?login=<?php echo urlencode($_SESSION['user_id']); ?>">Return to main menu</a></li>
				</ul>
			</td>
			<td class="content">
				<div>
					<h2>Add Questions</h2>
				</div>

				<p><?php if (!isset($message)) {
					echo "Fill the boxes below and press Add Questions button to supply Appraisal questions.";
				}else{echo "{$message}";} ?></p>
					<div>
						<form action="<?php $PHP_SELF ?>" method="post">

							<table>
								<tr>
									<td>Question:</td>
									<td>
										<textarea name="question" id="fc" value="<?php echo isset($message)?"":ltrim(htmlentities($_POST['question'])); ?>" style="width:60em;height:5em;margin-top:2em;text-align:left">Does he/she </textarea></td>
								</tr>
								<tr>
									<!-- <td>Option 1:</td> -->
									<td><input type="hidden" name="" value="Poor"/></td>	
								</tr>	
								<tr>
									<!-- <td>Option 2:</td> -->
									<td><input type="hidden" name="" value=""/></td>	
								</tr>
								
								<tr>
									<!-- <td>Option 3:</td> -->
									<td><input type="hidden" name="" value=""/></td>	
								</tr>

								<tr>
									<!-- <td>Option 4:</td> -->
									<td><input type="hidden" name="" value=""/></td>	
								</tr>
								<tr>
									<!-- <td>Option 5:</td> -->
									<td><input type="hidden" name="" value=""/></td>	
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" colspan="2" name="submit" value="Add Question"/></td>
								</tr>
							</table>
							<br/>
							
						
							
						</form>


					</div>
			</td>
		</tr>
		
	</table>

	<?php require("includes/footer.php"); ?>