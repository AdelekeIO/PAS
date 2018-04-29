

<?php 
/**
*This file is going to contain all needed functions..
*/
function count_numss($start,$end){
	$count=array();
	for ($start; $start <= $end ; $start++) { 
		$count[]=$start;
	}
	return $count;
}
 
function count_nums($start,$end){
	$count=array();
	for ($start; $start <= $end ; $start++) { 
		$count[]="<option>{$start}</option>";
	}
	return $count;
}
function mysql_prep($value)
{
	$magic_quotes_active=get_magic_quotes_gpc();
	$new_enough_php=function_exists("mysql_real_escape_string");// i.e: PHP >= v4.3.0

	if ($new_enough_php) {//PHP v4.3.0 of higher
		//undo any magic quote effects so mysql_real_escape_string can do the work
		$value=mysql_real_escape_string($value);

	}else{//before PHP v4.3.0
		//if magic quotes aren't already  on them add slashes manually
		if (!$magic_quotes_active) {
			$value=addslashes($value);
			//if magic quotes are active, then the slashes aready exist
		}
	}return $value;
}

// require "connection.php";
function redirect_to($location=NULL)
{
	if ($location!=NULL) {
		header("Location: {$location}");
		exit();
	}

}



function comfirm_query($result_set)
{
		if (!$result_set) {
			die("Database query failed".mysql_error());
 		}

}


function get_all_subjects($public) {
	global $connection;
			$SQL_query="SELECT * FROM subject ";
			if ($public==true) {
			$SQL_query.="WHERE visible='1'";
			}
			$SQL_query.="ORDER BY position ASC";
			$subject_set=mysql_query($SQL_query, $connection);
			comfirm_query($subject_set);
			return $subject_set;
}
 
 function get_pages_for_subject($subject_id,$public)
{
				global $connection;
				$SQL_query="SELECT * FROM pages WHERE ";
				$SQL_query.="	subject_id= {$subject_id} ";
				if ($public) {
				$SQL_query.="AND visible='1' ";	
				}
				
				$SQL_query.="ORDER BY position ASC";
				$page_set=mysql_query($SQL_query, $connection);
				comfirm_query($page_set);
				return $page_set;
}



function get_emp_by_id($subject_id)
{
global $connection;

$SQL_query="SELECT * ";
$SQL_query.="FROM employees ";
$SQL_query.="WHERE id={$subject_id} ";
$SQL_query.="LIMIT 1";
$result_set=mysql_query($SQL_query , $connection);

comfirm_query($result_set);
$subject=mysql_fetch_array($result_set);

// REMEMBER:
// if no rows are returned, fetch array will returne false 
if ($subject!=mysql_fetch_array($result_set)) {
return $subject;
}else{
	return NULL;
}


}

function get_pages_by_id($sel_page)
{
	global$connection;
	
$SQL_query="SELECT * ";
$SQL_query.="FROM pages ";
$SQL_query.="WHERE id={$sel_page} ";
$SQL_query.="LIMIT 1";


$result_set=mysql_query($SQL_query);

comfirm_query($result_set);

$page=mysql_fetch_array($result_set);

// REMEMBER:
// if no rowa are returned, fetch array will returne false 
if ($page!=mysql_fetch_array($result_set)) {
// echo("Selected page is:".$page[2]."<br/>");
return $page;

}else{
	return NULL;
}
}

function get_default_page($subject_id){
	//Get all visible pages
	$page_set=get_pages_for_subject($subject_id,true);
	if($first_page=mysql_fetch_array($page_set)){
			return $first_page;
		} else {
			return NULL;
		}
}

function find_selected_page()
{

global $sel_subject;
global $sel_page;
global $sel_sub;
global $sel_pg;

if (isset($_GET['subj'])) {
	
	$sel_subject=get_subject_by_id($_GET['subj']);
	$sel_page=get_default_page($sel_subject['id']);
}elseif (isset($_GET['page'])) {
	$sel_page="";
	$sel_page=get_pages_by_id($_GET['page']) ;
	// $sel_pg=$_GET['page'];
	// echo("Here".$sel_page[2]);
}else{
	$sel_page="";
	$sel_subject="";
}
// $sel_subject=get_subject_by_id($sel_subj);
// $selt_page=get_pages_by_id($sel_page) ;
}

function navigation($sel_subject, $sel_page,$public=false)
{
	$output=("<ul class=\"subjects\">");
			 
//run and return the result of an SQL query for subjects
				
				$subject_set=get_all_subjects($sel_subj);
 				while ($subject=mysql_fetch_array($subject_set)) {

				 	$output.=("<li");

				 	if ($subject["id"]==$sel_subject['id']) {			 	
				 	 	$output.=" class=\"selected\"";
				 	 }
				 	$output.=("><a href=\"edit_subject.php?subj=".urlencode($subject['id'])."\">
				 		{$subject["menu_name"]}</a></li>");	
				
				 	$page_set=get_pages_for_subject($subject["id"],$public);
				 	$output.="<ul id=\"pages\">";
				 while ($page=mysql_fetch_array($page_set)) {

				 	$output.=("<li");
				 		if ($page["id"]==$sel_page['id']) {			 	
				 	 	$output.=" class=\"selected\"";
				 	 }
				 	$output.= ("><a href=\"content.php?page=".urlencode($page['id'])."\">
				 		{$page["menu_name"]}</a></li>");	
				 }

				 $output.="</ul>";
				 }

				 	

				 
				
				$output.=("</ul>");
				return $output;
}

function public_navigation($sel_subject, $sel_page, $public=true){
				$output=("<ul class=\"subjects\">");
			 
//run and return the result of an SQL query for subjects
				
				$subject_set=get_all_subjects($public=true);
				
				while ($subject=mysql_fetch_array($subject_set)) {
				 	$output.=("<li");

				 		if ($subject["id"]==$sel_subject['id']) {			 	
				 	 	$output.=" class=\"selected\"";
				 	 	}
				 	$output.=("><a href=\"index.php?subj=".urlencode($subject['id'])."\">
				 			{$subject["menu_name"]}</a></li>");	
						if ($subject["id"]==$sel_subject['id']){

					 		$page_set=get_pages_for_subject($subject["id"],$public=true);
					 		$output.="<ul id=\"pages\">";
				 	while ($page=mysql_fetch_array($page_set)) {

				 			$output.=("<li");
				 		if ($page["id"]==$sel_page['id']) {			 	
				 	 	$output.=" class=\"selected\"";
				 	 }
				 	$output.= ("><a href=\"index.php?page=".urlencode($page['id'])."\">
				 		{$page["menu_name"]}</a></li>");	
				 }

				 $output.="</ul>";
				 }
			}
				 	

				 
				
				$output.=("</ul>");
				// echo $output;
				
return $output;
}

//Set or unset an employee for appraisal
function set_unset($id,$sname,$set,$unset){
	
		$sql1="SELECT *
				FROM `logins`
				WHERE `username` = '{$sname}'";
		$result1=mysql_query($sql1) or die("ERROR 1: ".mysql_error());
		$loginid=mysql_fetch_array($result1);
		$login_id=$loginid['id'];
		
			
		if ($set) {
		$sql="INSERT INTO appraisal_list (employee_id,login_id)
		 		VALUES ({$id},{$id})";
		 		
		$result=mysql_query($sql) or die("ERROR 2: ".mysql_error()."--{$id} --> {$login_id} --lg".$loginid['id']);

			if (mysql_affected_rows()==1) {
				$message="{$sname} has been successfully included in the appraisal list.";
				$sql2="UPDATE employees SET isset_for_Appraisal='Yes' WHERE id={$id}";
			 mysql_query($sql2) or die("ERROR 3: ".mysql_error());
			 $_GET['aid']=0;$_GET['asname']="";	
			}else{$message="{$sname} not successfully added to appraisal list.";}
		}elseif($unset){
			$sql="DELETE FROM appraisal_list 
		 		WHERE employee_id='{$id}'";
				$result=mysql_query($sql) or die("ERROR 2B: ".mysql_error());

			if (mysql_affected_rows()==1) {
				$message="{$sname} has been successfully removed from the appraisal list.";
				$sql2="UPDATE employees SET isset_for_Appraisal='NO' WHERE id={$id}";
			 mysql_query($sql2) or die("ERROR 3B: ".mysql_error());
			 $_GET['aid']=0;$_GET['asname']="";	
			}else{$message="{$sname} has not been removed from appraisal list.";}
		}else{$message="";}
		 
		return $message;
		
}


function get_comment($average_mark){

		$markrange=($average_mark/10);
	switch (intval($markrange)) {
		case '1':
		case '2':
		case '3':
			$comment="Termination of Appointment";
			break;
	
		case '4':
			$comment="Can be retained";
			
			break;
		case '5':
		
			$comment="Due for Training";
			break;
		case '6':
			
			$comment="Due For Payrise";
			break;
		case '7':
		case '8':
		case '9':
		case '10':
			
			$comment="Due for promotion";
			break;
			
		default:
			$comment="Not Yet Appraised";
			break;
	}
	return $comment;

}

function get_grade($average_mark){
		$grade=NULL;
		$markrange=($average_mark/10);
	switch (intval($markrange)) {
		case '1':
		case '2':
		case '3':
			$grade="Poor";
			$comment="Termination of Appointment";
			break;
	
		case '4':
			$comment="Can be retained";
			$grade="Fair";
			break;
		case '5':
			$grade="Good";
			$comment="Due for Training";
			break;
		case '6':
			$grade="Very Good";
			$comment="Due For Payrise";
			break;
		case '7':
		case '8':
		case '9':
		case '10':
			$grade="Excellent";
			$comment="Due for promotion";
			break;
			
		default:
			$comment="Not Yet Appraised";
			break;
	}
	return $grade;

}

function queryApprslList($user_id,$username){
	global$connection;
	$query="SELECT employee_id FROM appraisal_list WHERE login_id !={$user_id}
											AND appraised_by NOT LIKE '%{$username}%'";
											
								$result=mysql_query($query);
								comfirm_query($result);	
				return $result;
}

 ?>
