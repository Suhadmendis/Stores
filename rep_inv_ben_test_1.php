<?php session_start();
if(!isset($_SESSION["UserName"])){
echo "Invalid Login";
exit();
}
date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Invoice</title>
<style type="text/css">
<!--
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style4 {
	font-size: 18px;
	font-weight: bold;
}
.style5 {
	font-size: 18px;
	font-weight: bold;
}
.style6 {
	font-size: 24px;
	font-weight: bold;
}
.style7 {font-size: 24px}

.style8 {
	font-size: 18px;
	font-weight: bold;
}

.style10 {
	font-size: 18px;
	font-weight: bold;
}
-->

</style>
</head>

<body><center>
<?php 
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
		
		$sql="Select count(*) as mcount from s_salma where REF_NO='".$_GET["invno"]."'";
		$result =$db->RunQuery($sql);
		$row = mysql_fetch_array($result);		
		
		if ($row["mcount"]>1){
			exit("Duplicate Invoice No Detected. Please contact Supervisor.");	
		}
		
		$copy="";
		
		$sql_invpara="SELECT * from invpara where COMCODE='".$_SESSION['company']."'";
		$result_invpara =$db->RunQuery($sql_invpara);
		$row_invpara = mysql_fetch_array($result_invpara);
		
		$sql="Select * from s_salma where REF_NO='".$_GET["invno"]."'";
		
    	$result =$db->RunQuery($sql); 	
		$row = mysql_fetch_array($result);			
        
	//echo $row["CANCELL"];
		if ($row["pirnt_serial"]=="0"){
			
			if ($row["CANCELL"]=="0"){	
				$sql="update s_salma set pirnt_serial='1' where REF_NO='".$_GET["invno"]."'";
    			$result =$db->RunQuery($sql);
			}	else {
				$copy="Cancelled"; 
			}
			
		} else if ($row["pirnt_serial"]>0){
			
			if ($_SESSION['User_Type']=="0"){
				
				if ($row["CANCELL"]=="0"){	
					exit("Cannot Print Twice !!!");
				} else {
					exit("Canceled Invoice !!!");
					
				}	
			} else {
				if ($_SESSION['User_Type']=="1"){
					
					if ($row["CANCELL"]=="0"){	
						$copy="CP";
					} else {
						$copy="Cancelled"; 
					}
					
					$print_serial=$row["pirnt_serial"]+1;
					$sql="update s_salma set pirnt_serial='".$print_serial."' where REF_NO='".$_GET["invno"]."'";
    				$result =$db->RunQuery($sql);	
				}
			}	
			
		} 
	
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);	
		
		$sql2="Select * from s_stomas where CODE='".$row["DEPARTMENT"]."'";
    	$result2 =$db->RunQuery($sql2);	
		$row2 = mysql_fetch_array($result2);
				
		$TXTDEP= $row2["DESCRIPTION"];
		$rtxtinvno= $row["invno"];
		$rtxtordno= $row["ORD_NO"]; 
		
		$sql2="Select * from s_salrep where REPCODE='".$row["SAL_EX"]."'";
    	$result2 =$db->RunQuery($sql2);	
		$row2 = mysql_fetch_array($result2);
		
		
			
			
			
		$rtxtrep = $row2["Name"];
		$rtxtSupCode= $row1["CODE"];
		$rtxtSupName=  $row1["CODE"]." ".$row1["NAME"];
		$txtadd1 = $row1["ADD1"];
		//$txtadd2 = $row1["ADD2"];
		$txtadd2 = $_GET["cus_address2"];
		$txtadd = $row1["ADD1"]."</br>".$row1["ADD2"];
		$rtxtdate=date("Y-m-d", strtotime($row["SDATE"]));
		$rtxttot = $row["GRAND_TOT"];
		
		
		$sql_salrep="Select * from s_salrep where REPCODE=".$row["SAL_EX"];
		$result_salrep =$db->RunQuery($sql_salrep);
		$row_salrep = mysql_fetch_array($result_salrep);
		
		$VAT_per=$row["VAT"];
		
    	
		$sql_para="Select * from invpara  where COMCODE='".$_SESSION['company']."'";
    	$result_para =$db->RunQuery($sql_para);	
		$row_para = mysql_fetch_array($result_para);

		if ($row["VAT"]=="1") {
    		//$txtcusvat= "Customer VAT  " . $row1["vatno"];
			$txtcusvat= "Customer VAT  " . $_GET["vat1"];
    		$txtcomvat= "VAT Reg. " . $row_para["VAT"];
			$RTXTVAT = "VAT ". intval($row["GST"])."%  ";
    		//$RTXVATAMU = $row["BTT"];
    		$txttaxinv = "<b>TAX INVOICE</b>";
    		$txtsubtot = $row["AMOUNT"];
    		$txtsubtotdes= "Sub Total";
		}
		
		if ($row["SVAT"]!="0") {
    		//$txtcusvat= "Customer VAT  " . $row1["vatno"];
			$txtcusvat= "Customer VAT  " . $_GET["vat1"];
    		$txtcomvat= "VAT Reg. " . $row_para["VAT"];
    		$RTXTVAT = "Suspended VAT ".intval($row["GST"])."%  ";
    		//$RTXVATAMU= $row["BTT"];
    		$txttaxinv= "<b>SUSPENDED TAX INVOICE</b>";
    		$txtsubtot= $row["AMOUNT"];
    		$txtsubtotdes = "Net Total";
    
    		$txtoursvat = "SVAT Reg. " . $row_para["svatno"];
    		//$txtcussavat= "Customer SVAT " . $row1["svatno"];
			$txtcussavat= "Customer SVAT " . $_GET["vat2"];
    
		}

	?>
    
<table width="1000"  border="0">
  <tr>
    <td height="50" colspan="3"><span class="style4"><?php //echo $row_para["COMPANY"]; ?></span><br />
   <span class=""> <?php 
   if ($_GET["vat"]=="true"){
   		//echo "TAX INVOICE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row_invpara["VAT"];
	} 
	
	 if ($_GET["svat"]=="true"){
		//echo "SUSPENDED TAX INVOICE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row_invpara["VAT"];
	} 	
	?></span>
    </td>
    <td colspan="4" align="center"><table width="500" border="0">
      <tr>
          <?php 
              echo "<td width=\"402\"><span class=\"\"></span></td>";
          ?>
        
      </tr>
      <tr>
        <td><span class="style8"><?php //echo $row_para["TELE"]; ?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="44" colspan="3" align="right"><span class=""><u></u></span></td>
    <td width="55" height="44" align="center">&nbsp;</td>
    <td width="171" align="left">&nbsp;</td>
    <td width="80" align="right">&nbsp;</td>
    <td width="186">&nbsp;</td>
  </tr>
  <tr>
    <td height="110" colspan="3" valign="top"><table border="0" bordercolor="#000000" cellpadding="0" cellspacing="0"><tr><td width="428"><table width="500" border="0" >
        <tr>
          <td width="91"><span class="style4">&nbsp;</span></td>
          <td width="8">&nbsp;</td>
          <td width="443"><span class="style4"><?php  echo $rtxtSupName;  ?></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><span class="style4"><?php  echo $txtadd1;  ?></span></td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
          <td><span class="style4"><?php  echo $txtadd2;  ?></span></td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
          <td><?php
         if (($_GET["vat"]=="true")  || ($_GET["svat"]=="true"))  {
		  	echo $_GET["vat1"]." ".$_GET["vat2"];
		  }
		  ?></td>
        </tr>
    </table></td></tr></table></td>
    <td colspan="4" valign="top"><table border="0" bordercolor="#000000" cellpadding="0" cellspacing="0"><tr><td><table width="500" border="0">
      <tr>
          <td width="108"><span class="">&nbsp;</span></td>
        <td width="9">&nbsp;</td>
        <td width="146"><span class="style4"><?php echo $row["use_name"]; ?></span></td>
        <td width="82"><span class="style4">&nbsp;</span></td>
        <td width="12">&nbsp;</td>
        <td width="201"><span class="style4"><?php echo $row["REF_NO"]; ?><span class="style4"></td>
      </tr>
      <tr>
        <td width="108"><span class="">&nbsp;</span></td>
        <td width="9">&nbsp;</td>
        <td width="146"><span class="style4"><?php echo $row_salrep["Name"]; ?></span></td>
        <td width="82"><span class="">&nbsp;</span></td>
        <td width="12">&nbsp;</td>
        <td width="201"><span class="style4"><?php echo $row["SDATE"]; ?></span></td>
      </tr>
      <tr>
        <td height="21"><span class="">&nbsp;</span></td>
        <td>&nbsp;</td>
        <td><span class="style4"><?php echo $row["ORD_NO"]; ?></span></td>
        <td><span class="style4">&nbsp;</span></td>
        <td>&nbsp;</td>
        <td><span class="style4"><?php echo date("Y-m-d H:i:s");?></span></td>
      </tr>
      
      
    </table></td></tr></table>
    <span class="">    </span></td>
  </tr>
</table>
<table width="1000" height="21" border="0" cellspacing="0">
    <!--  <tr  bgcolor="#999999">
        <td width="130" height="23"><span class="style1">STK No</span></td>
        <td width="295"><span class="style1">Description</span></td>
        <td width="158"><span class="style1">Rate</span></td>
        <td width="135"><span class="style1">Quantity</span></td>
        <td width="152"><span class="style1">Sub Total</span></td>
        </tr> -->
  <tr>
      <td width="100" align="left">&nbsp;</td>
    <td width="480" align="left">&nbsp;</td>
    <td width="50" align="right">&nbsp;</td>
    <td width="120" align="right">&nbsp;</td>
    <td width="50" align="right">&nbsp;</td>
     <td width="50" align="right">&nbsp;</td>
    <td width="100" align="right">&nbsp;</td>
  </tr>
  <?php 
	  	$i=1;
		$totsuntot=0;
		
	  	$sql1="Select * from s_invo where REF_NO='".$_GET["invno"]."'";
    	$result1 =$db->RunQuery($sql1); 	
		while ($row1 = mysql_fetch_array($result1)){
			$sql_part="Select * from s_mas where STK_NO='".$row1["STK_NO"]."'";
    		$result_part =$db->RunQuery($sql_part);	
			$row_item = mysql_fetch_array($result_part);
			
			if (($VAT_per=="1") or ($VAT_per=="2")){
				$vatr=100+$row["GST"];
				$PRICE=$row1["PRICE"]/$vatr*100;
			} else {
				$PRICE=$row1["PRICE"];
			}	
			
		 
				
				echo "<tr><td width=100><span class=\"style4\">".$row_item["PART_NO"]."</span></td>
						<td width=500><span   class=\"style4\">".$row_item["BRAND_NAME"]." ".$row_item["STK_NO"]." ".$row_item["DESCRIPT"]."</span></td>
						<td align=\"right\"  width=50><span  class=\"style4\">".number_format($row1["QTY"], 0, ".", ",")."</span></td>
						<td  align=\"right\"  width=100><span  class=\"style4\">".number_format($PRICE, 2, ".", ",")."</span></td>";
						
			
						$discount1=$PRICE*$row1["QTY"]*$row1["DIS_per"]/100;
						$subtot=($PRICE*$row1["QTY"])-$discount1;
				echo "<td align=\"right\"  width=100><span  class=\"style4\">".number_format($subtot, 2, ".", ",")."</span></td>";
			
			
			//}
			echo "</tr>";
			$totsuntot=$totsuntot+$subtot;
			$i=$i+1;
		}	
	  
	  	if ($row["DIS1"] > 0) {
    		$txtspdis= "Special Discount   " . floatval($row["DIS1"]) . " %";
   		}
		
		if ($VAT_per=="1"){
       		$RTXVATAMU = $row["AMOUNT"]*$row["GST"]/100;
		} else {
			$RTXVATAMU="";
		}	
	   
    //	if ($row["VAT"]=="0") {
        	$txtdis2= $totsuntot/100 * $row["DIS1"];
    	//} else {
       // 	$txtdis2= (($totsuntot / (1 + $row["GST"] / 100)) / 100) * $row["DIS1"];
    	//}
		
	  	while ($i<7){
			echo "<tr><td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td></tr>";
			$i=$i+1;
		}
	   ?>
      
     
</table>
<table width="1000" border="0">
    	
 
  <tr>
    <td colspan="4">
    <?php
	if ($_GET["svat"]=="true"){
		echo "Our SVAT No : ".$row_invpara["svatno"];
	}
	?>    </td>
    <td width="105"></td>
    <td width="51">&nbsp;</td>
    <td width="144" align="right"></td>
    <td width="288" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
    <?php
	if ($_GET["svat"]=="true"){
		echo "Your SVAT No : ".$_GET["vat2"];
	}
	?>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="80">&nbsp;</td>
    <td colspan="3"><span class=""><?php //echo $copy; ?></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    <?php
    if ($_GET["vat"]=="true") {
		echo "VAT ". intval($row["GST"])."%"; 
	}
	if ($_GET["svat"]=="true"){
		echo "SVAT ".intval($row["GST"])."%"; 
	}
	
	?>    </td>
    <td align="right"><table width="250" border="0">
      <tr>
        <td width="175" align="right"><?php
    if (($_GET["vat"]=="true") or ($_GET["svat"]=="true")){
		echo $_GET["tax"];
	}
	
	?></td>
        <td width="66">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="98">&nbsp;</td>
    <td width="96">&nbsp;</td>
    <td width="104">&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td align="right">&nbsp;</td>
    <td align="right"><b>
      <span class="">      </span></b>
      <table width="250" border="0">
        <tr>
          <td width="175" align="right"><b><span class="style4">
            <?php if ($rtxttot>0){echo number_format($rtxttot, 2, ".", ",");} ?>
          </span></b></td>
          <td width="62">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td align="right">&nbsp; </td>
    <td align="right"></td>
  </tr>
  <tr>
    <td colspan="4"><?php
		if ($_GET["credper"]!="0"){
			//echo "Credit Period : ".$_GET["credper"]." Days";
		}
	?></td>
    <td>&nbsp;</td>
    <td></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
    
</body>
</html>
