<?php session_start(); 

						
if ($_SESSION["dev"]!=""){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Administration Panel</title>
<link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-ie.css" /><![endif]-->
<script src="js/user.js"></script> 
</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		<!--[if !IE]>start head<![endif]-->
		<div id="head">
			
			<!--[if !IE]>start logo and user details<![endif]-->
			<div id="logo_user_details">
				<h1 id="logo"><img src="img/logo-lg.png" alt="img" width="150" height="80" />	 </h1>
                
                <div class="tyrename"> <?php
				/*	if ($_SESSION['company']=="BEN"){
						echo "Benedictsons (Pvt) Ltd.";
					} else if ($_SESSION['company']=="THT"){
						echo "Tyre House Trading (Pvt) Ltd.";
					}*/
					//echo $_SESSION['company'];	
				?> </div>
              
							<!--[if !IE]>start user details<![endif]--><!--[if !IE]>end user details<![endif]-->
				
				
				
			</div>
			
			<!--[if !IE]>end logo end user details<![endif]-->
			
			
			
			<!--[if !IE]>start menus_wrapper<![endif]-->
			<?php
				include('menu_index.php');
			?>
			<!--[if !IE]>end menus_wrapper<![endif]-->
			
			
			
		</div>
		<!--[if !IE]>end head<![endif]-->
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			<?php
            	include('connection.php');
	
		$sqltmp="select * from invpara";
		$resulttmp=mysql_query($sqltmp, $dbinv);
		$rowtmp = mysql_fetch_array($resulttmp);
			
//		  echo "<label>";
//			if ($rowtmp["form_loc"]=="1"){
//				echo "<input type=\"radio\" name=\"radio\" id=\"rd_lock\" value=\"rd_lock\" checked=\"checked\" onclick=\"set_check();\"/> Lock</br></br>";
//				echo "<input type=\"radio\" name=\"radio\" id=\"rd_unlock\" value=\"rd_unlock\"  onclick=\"set_check();\"/> Un Lock</br>";
//			} else {
//				echo "<input type=\"radio\" name=\"radio\" id=\"rd_lock\" value=\"rd_lock\" onclick=\"set_check();\"/> Lock</br></br>";
//				echo "<input type=\"radio\" name=\"radio\" id=\"rd_unlock\" value=\"rd_unlock\"  checked=\"checked\" onclick=\"set_check();\"/> Un Lock</br>";
//			}
                if ($_SESSION["UserName"] == "malabe"){
			if ($rowtmp["block_c"]=="1"){
				echo "<input type=\"radio\" name=\"radio\" id=\"rd_lock\" value=\"rd_lock\" checked=\"checked\" onclick=\"set_check('1');\"/> Lock</br></br>";
				echo "<input type=\"radio\" name=\"radio\" id=\"rd_unlock\" value=\"rd_unlock\"  onclick=\"set_check('0');\"/> Un Lock</br>";
			} else {
				echo "<input type=\"radio\" name=\"radio\" id=\"rd_lock\" value=\"rd_lock\" onclick=\"set_check('1');\"/> Lock</br></br>";
				echo "<input type=\"radio\" name=\"radio\" id=\"rd_unlock\" value=\"rd_unlock\"  checked=\"checked\" onclick=\"set_check('0');\"/> Un Lock</br>";
			}	
				
                }			
                          ?>
            
		
		  <!--[if !IE]>start page<![endif]-->
		  <!--[if !IE]>end page<![endif]-->
		  <!--[if !IE]>start sidebar<![endif]-->
		  <!--[if !IE]>end sidebar<![endif]-->
	  </div>
	  <!--[if !IE]>end content<![endif]-->
		
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
	
	<!--[if !IE]>start footer<![endif]-->
	<div id="footer">
	</div>
	<!--[if !IE]>end footer<![endif]-->
	
</body>
</html>
<?php
mysql_close();
} else {
        mysql_close();
	echo "Invalied User !!!"; 
}
?>