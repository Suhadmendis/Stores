<?php  ini_set('session.gc_maxlifetime', 30*60*60*60);
 session_start();
	
	
	$UserName=$_GET["UserName"];
	$Password=$_GET["Password"];
	$Command=$_GET["Command"];
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
if($Command=="CheckUsers")

	{	
	
	
	//$connection = mysql_connect("localhost","root", "");
	//$db = "login";
	//mysql_select_db($db, $connection) or die( "Could not open $db database");

	
					//$UserName = mysql_real_escape_string($UserName);
				//	$Password = mysql_real_escape_string($Password);
					
					
					
				
					
					
					
					//$sql="SELECT * FROM user_mast WHERE user_name =  '".$UserName."' AND user_pass =  '".md5($Password)."' ";
					$sql="SELECT * FROM user_mast WHERE user_name =  '".$_GET["un"]."'";
					
					$result =$db->RunQuery($sql);
									
					if($row = mysql_fetch_array($result))
					{	
						$sql1="SELECT * FROM invpara";
						$result1 =$db->RunQuery($sql1);
						$row1 = mysql_fetch_array($result1);
						if ($row1["flag"]=="BEN"){
							$_SESSION['company']="BEN";
						} else 	if ($row1["flag"]=="TRAD"){
							$_SESSION['company']="THT";
						}
						//$_SESSION['company']="THT";
						$sessionId = session_id(  );
						$_SESSION['sessionId']=session_id(  );
						session_regenerate_id();
						$ip=$_SERVER['REMOTE_ADDR'];
						$_SESSION['UserName']=$UserName;
						$_SESSION["CURRENT_USER"] = $UserName;
						$_SESSION['User_Type']=$row['user_level'];
						
						$sql_master= "select * from invpara";
    					$result_master =$db->RunQuery($sql_master);
						$row_master = mysql_fetch_array($result_master);
						if ($row_master["master_dev"]=="0"){
							$_SESSION['dev']=$row['dev'];
						} else {
							$_SESSION['dev']=0;
						}	
						
						$sql_rsuser= "select * from userpermission where username='" .$UserName. "'";
    					$result_rsuser =$db->RunQuery($sql_rsuser);
						if($row_rsuser = mysql_fetch_array($result_rsuser)){
    
          					if (is_null($row_rsuser["SAL_EX"])==false) {
          						$_SESSION["CURRENT_REP"] = $row_rsuser["SAL_EX"];
          					} else {
          						$_SESSION["CURRENT_REP"] = "";
          					}
           					$Devcheck = 0;
           				}
		   					
						
						//if (($_SERVER['REMOTE_ADDR']=="113.59.211.14") or ($_SERVER['REMOTE_ADDR']=="112.135.77.202") or ($_SERVER['REMOTE_ADDR']=="112.135.99.115") or ($_SERVER['REMOTE_ADDR']=="112.135.50.185")){
						
					//	if (($_SERVER['REMOTE_ADDR']=="113.59.211.14") or ($_SERVER['REMOTE_ADDR']=="112.135.77.202") or ($_SERVER['REMOTE_ADDR']=="112.135.99.115") or ($_SERVER['REMOTE_ADDR']=="112.135.50.185") or ($_SERVER['REMOTE_ADDR']=="123.231.123.183")or ($_SERVER['REMOTE_ADDR']=="112.135.198.134") or ($_SERVER['REMOTE_ADDR']=="123.231.44.126") or ($_SERVER['REMOTE_ADDR']=="220.247.234.138")or ($_SERVER['REMOTE_ADDR']=="123.231.44.125")){
						
							echo "ok";
				//		} else {
				//			echo "Invalied Connection";
				//		}	
						
						
						$time_now=mktime(date('h')+5,date('i')+30,date('s'));
						$time=date('h:i:s',$time_now);
						$today = date('Y-m-d');
						
						$sql1="Insert into loging(Name,User_Type,Date,Logon_Time,Sessioan_Id,ip) values ('".$UserName."','".$row['User_Type']."','".$today."','".$time."','".$_SESSION['sessionId']."','".$ip."')";
						$result1 =$db->RunQuery($sql1);
												
						
						
					}	
					
					
					
					
	}

			
			
			

else if($Command=="logout")
	{
		
		
	//$connection = mysql_connect("localhost","weldb", "uY4xjyHNur7JYNGj");
	//$db = "welfare1";
	//mysql_select_db($db, $connection) or die( "Could not open $db database");
		
		
		
		//$_SESSION['int_User_ID']=$int_User_ID;
		echo $_SESSION['sessionId'];
		
		$time_now=mktime(date('h')+5,date('i')+30,date('s'));
		$time=date('h:i:s',$time_now);
		$today = date('Y-m-d');
		
		
		$sql="UPDATE loging
			  SET Logout_Time='".$time."'
			  WHERE Sessioan_Id='".$_SESSION['sessionId']."'";
			  
			 
			  $result =$db->RunQuery($sql);
			
			
			  $sqlDelete="Delete FROM active_users
			  where Sessioan_Id='".$_SESSION['sessionId']."'";
			  $resultDelete =$db->RunQuery($sqlDelete);
			  
			 
			
		session_unset();
		session_destroy();
			
} else if($Command=="setdiv"){
	
	session_destroy();
	$_SESSION['UserName']="";
	$_SESSION["CURRENT_USER"] = "";
	$_SESSION['User_Type']="";
	$_SESSION['dev']="";
							

	if ($_GET["activ"]=="true"){
		$_SESSION["master_dev"]=1;
		
	} else {
		$_SESSION["master_dev"]=0;
	}	

	$sql_rsuser= "update invpara set master_dev='".$_SESSION["master_dev"]."'";
    $result_rsuser =$db->RunQuery($sql_rsuser);
echo "UserName-".$_SESSION['UserName'];
echo "dev-".$_SESSION['dev'];
}





?>