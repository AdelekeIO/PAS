<?php require_once "includes/session.php" ?>
<?php require_once "includes/connection.php" ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php 
		$message="";
	if (isset($_POST['submit']) && (isset($_POST['opt1'])||isset($_POST['opt2']))) {

		$query="SELECT id FROM questions";
		$result=mysql_query($query);
		comfirm_query($result);
		$num_rows=mysql_num_rows($result);

		
		
		$qtotalpoint=0;
		for ($count=1; $count <=$num_rows ; $count++) { 
			$optionsname="opt";
			$optionsname.=$count;
			$qtotalpoint+=intval($_POST[$optionsname]);
			echo "Total point ->{$qtotalpoint}<br/>";

		}


		$query="SELECT * FROM appraisal_list WHERE employee_id={$_GET['staff']}";
		$result=mysql_query($query);
		comfirm_query($result);
		$result_set1=mysql_fetch_array($result);
	
			echo "appraised_by is : {$result_set1['appraised_by']}<br/>";
			$emp_names_mark="";
		if (empty($result_set1['appraised_by'])||$result_set1['appraised_by']=="") {
			$emp_names_mark=$_SESSION['username'];
			$emp_names_mark.="_".$qtotalpoint;
		}elseif(!empty($result_set1)){
			$emp_names_mark=strval($result_set1['appraised_by']);
			$emp_names_mark.=", ".$_SESSION['username'];
			$emp_names_mark.="_".$qtotalpoint;
		}
			$staff_count=$result_set1['staff_count']+1;
			$qtotalpoint=$result_set1['total_mark']+$qtotalpoint;
			$qtotalpoint_avrg=($qtotalpoint/$staff_count);
				
		
		$query2="UPDATE appraisal_list SET
				staff_count={$staff_count},
				total_mark={$qtotalpoint} ,
				total_mark_avrg={$qtotalpoint_avrg} ,
				appraised_by='{$emp_names_mark}' 
				WHERE employee_id={$_GET['staff']}" ;
		$result2=mysql_query($query2);
		comfirm_query($result2);
		if (mysql_affected_rows()==1) {
			# Succed
			redirect_to("employee_view.php?sapid={$_GET['staff']}");
			echo "Employee is appraised succesfully.";
		}
		
	// echo "Outside Loop ->{$qtotalpoint}";


	}else{$message="No option has been selected by you.";}
 ?>
	<?php require_once "includes/header.php"; ?>


	<table align="center"class="skeleton">
		<tr>
			<td class="navigation">
				<li>
					<ul>
					<a href="logout.php" >Logout</a>
					</ul>
					
			
				</li>
			</td>
			<td class="content">
				<div>
					<h2>Appraisal - 2017/2018 </h2>

				</div>

				<?php 
								$result=mysql_query("SELECT * FROM employees WHERE id=".$_GET['staff']);
								comfirm_query($result);
								while ($resultSet=mysql_fetch_array($result)) {
								$full_name=$resultSet['surname']." ".$resultSet['firstname']." ".$resultSet['lastname'];
								$dept=$resultSet['Dept'];
								$position=$resultSet['position'];
								}
				 ?>
				 <!-- <div style="float: right;margin-left: 30em;"><span><h2> APP  </h2></span></div> -->

				<div>
					<table>
						<tr>
							<td><b>Employee Name : </b></td>
							<td>
								<?php echo($full_name); ?>
							</td>

						</tr>
						<tr>
							<td><b>Department : </b></td>
							<td><?php echo($dept); ?></td>
						</tr>
						<tr>
							<td><b>Position : </b></td>
							<td><?php echo($position); ?></td>
						</tr>
					</table>
						
						 
						
					

				</div>

				<p><?php if (empty($message)) {
					echo "Carefully answer the below questions.";
				}elseif(!empty($message)){echo $message;} ?></p>
				<?php 
				
					$query="SELECT * FROM (
					SELECT * FROM  questions  WHERE  1 ORDER BY RAND()  LIMIT 40
					) q
					ORDER BY id";
					$result=mysql_query($query);
					comfirm_query($result);
					
				 ?>
				<center><div>
				<div id="questionPane" >
					
					<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" style="hight:30%;overflow-y:auto">
						<?php
						 $name=$_GET['staff'];
						 // echo "{$name}";
						 ?>

						 	<ol >

						 	
						 <?php 
						 $question_num=0;
						 $ques=array();
						 $rand=array();
						 $options=array();
								 while ($questions=mysql_fetch_array($result)){
									$question_num+=1;
										$ques[$question_num]=$questions['question'];
										//Search online on how to apply random to mysql db values.

										// $rand=array_rand($ques,1)
										// $options[$question_num];

									$output= "<li style=\"list-style-type:decimal\">".($questions['question'])."
										<div id=\"option\">
										<input type=\"radio\" name=\"opt".$question_num."\" value=\"1\"/>".htmlentities($questions['option_1'])."
										<input type=\"radio\" name=\"opt".$question_num."\" value=\"2\"/>".htmlentities($questions['option_2'])."
										<input type=\"radio\" name=\"opt".$question_num."\" value=\"3\"/>".htmlentities($questions['option_3'])."<br/>
										<input type=\"radio\" name=\"opt".$question_num."\" value=\"4\"/>".htmlentities($questions['option_4'])."
										<input type=\"radio\" name=\"opt".$question_num."\" value=\"5\"/>".htmlentities($questions['option_5'])."
										</div>
										</li><hr/>";
									

										if ($question_num<=20) {
												echo $output;
											 }	
										
													
								}

								// echo $ques[1];
								
								// echo ":-".count($ques)."<br/>";
								// $a=1;
								// while ($a<=10) {
									
								// 	$a++;
								// 	echo ":-".($ques[array_rand($ques,1)])."<br/>";

								// }
								

						  ?>
						</ol>
						<center>
						<input type="submit" style="width:20em" name="submit" value="SUBMIT"/>&nbsp;
						</center>
					</form>

				</div>	
				</div></center>
			
				
				</div>
			</td>
		</tr>
		
	</table>

	<?php require("includes/footer.php"); ?>
