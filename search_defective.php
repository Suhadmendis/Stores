<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />



<title>Search Customer</title>

<link rel="stylesheet" href="css/table_min.css" type="text/css"/>
<script language="JavaScript" src="js/defective.js"></script>
<style type="text/css">

	/* START CSS NEEDED ONLY IN DEMO */
	html{
		height:100%;
	}
	
	
	#mainContainer{
		width:700px;
		margin:0 auto;
		text-align:left;
		height:100%;
		background-color:#FFF;
		border-left:3px double #000;
		border-right:3px double #000;
	}
	#formContent{
		padding:5px;
	}
	/* END CSS ONLY NEEDED IN DEMO */
	
	
	/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-size:0.9em;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:0.9em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#317082;
		color:#FFF;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
	
	form{
		display:inline;
	}

	#article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
    </style>
	

</head>

<body>

 <table width="864" border="0">
 
<tr>					
						<?php 
	  				$stname = $_GET["stname"];
					?>
                             <td width="212"  background="images/headingbg.gif" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list_d('$stname')"; ?>"/></td>
    <td width="345"  background="images/headingbg.gif" ><input type="text" size="30" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list_d('$stname')"; ?>"/></td>
    <td width="293"  background="images/headingbg.gif" >&nbsp;</td>
</tr>  </table>    
<div class="CSSTableGenerator" id="filt_table">  <table width="735" border="0" class=\"form-matrix-table\">
                            <tr>
                              <td width="100"  background="images/headingbg.gif" ><font color="#FFFFFF">REF No</font></td>
                              <td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">BAT No</font></td>
                               <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Claim No</font></td>
                               <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Date</font></td>
   </tr>
                            <?php 
							
							require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
							
							//$sql="select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn where REFNO like '" & txtcode.Text & "%' and CANCELL='0' ORDER BY REFNO"
							//$sql="SELECT * FROM s_crnma where CANCELL='0' order by REF_NO desc";
                                                        if ($_SESSION['COMCODE'] != "C"){
                                                            $sql="select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn where company = '".$_SESSION['COMCODE']."' ORDER BY SDATE desc limit 50";
                                                        }else{
                                                            $sql="select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn ORDER BY SDATE desc limit 50";
                                                        }
							
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
					
							echo "<tr>               
                              <td onclick=\"defect_d('".$row['REFNO']."');\">".$row['REFNO']."</a></td>
                              <td onclick=\"defect_d('".$row['REFNO']."');\">".$row['BAT_NO']."</a></td>
                              <td onclick=\"defect_d('".$row['REFNO']."');\">".$row['CLAM_NO']."</a></td>
							  <td onclick=\"defect_d('".$row['REFNO']."');\">".$row['SDATE']."</a></td>
                            </tr>";
							}
							  ?>
                    </table>
                </div>

</body>
</html>
