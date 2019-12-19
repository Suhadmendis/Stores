<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print DGRN</title>
<style type="text/css">
<!--
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style4 {
	font-size: 24px;
	
}

body {
	color: #000000;
	font-size: 17px;
}
-->
</style>
</head>

<body><center>
<?php 
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	        
	$txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
	
	$txt_net=str_replace(",", "", $_GET["txt_net"]);	

	$sql_invpara="Select * from invpara where COMCODE='".$_SESSION['company']."'";
    $result_invpara =$db->RunQuery($sql_invpara);	
	$row_invpara = mysql_fetch_array($result_invpara);
 
 
 	$sql_sql="SELECT * from viewdef where REFNO= '" . trim($_GET["txtrefno"]) . "'";
//	echo $sql_sql;
        $result_sql =$db->RunQuery($sql_sql);	
	$row_rsPrInv = mysql_fetch_array($result_sql);
	
	/*$sql_c_clamas="SELECT * from c_clamas where cl_no= '" . trim($row_rsPrInv["cl_no"]) . "'";
	$result_c_clamas =$db->RunQuery($sql_c_clamas);	
	$row_c_clamas = mysql_fetch_array($result_c_clamas);*/
	
	$rtxtDocdate= date("Y-m-d", strtotime($_GET["dtdate"]));

	$rtxtRefNo= trim($_GET["txtrefno"]);
	$rtxtComName = $row_invpara["COMPANY"];
	$rtxtcomadd1= $row_invpara["ADD1"];
	$rtxtComAdd2 =$row_invpara["ADD2"] . ", " . $row_invpara["ADD3"];
	$rtxtCusCode =$_GET["txt_cuscode"];
	$rtxtamo =number_format($txt_net, 2, ".", ",");
	
	if (is_null($row_rsPrInv["Ref_per"])==false) {
    	$rtxrefund = trim($row_rsPrInv["Ref_per"]);
	} else {
    	$sql_df_frm="Select * from c_clamas where DGRN_NO = '" . trim($_GET["txtrefno"]) . "'";
//        echo $sql_df_frm;
    	$result_df_frm =$db->RunQuery($sql_df_frm);	
		if ($row_df_frm = mysql_fetch_array($result_df_frm)){
	    	$rtxrefund = trim($row_df_frm["rem_per"]);
        	if (trim($row_df_frm["rem_per"]) == "") { $rtxrefund= 100; }
        	$old = false;
    	} else {
        	$old = true;
    	}
		
		$sql_df_frm="Select * from c_clamas where DGRN_NO2 = '" . trim($_GET["txtrefno"]) . "'";
    	$result_df_frm =$db->RunQuery($sql_df_frm);	
		if ($row_df_frm = mysql_fetch_array($result_df_frm)){
	    	$rtxrefund = trim($row_df_frm["add_ref1"]);
        	if (trim($row_df_frm["rem_per"]) == "") { $rtxrefund= 100; }
        	$old = false;
    	} else {
        	$old = true;
    	}
    	
    
    	$sql_df_frm="Select * from c_clamas where DGRN_NO2 = '" . trim($_GET["txtrefno"]) . "'";
    	$result_df_frm =$db->RunQuery($sql_df_frm);	
		if ($row_df_frm = mysql_fetch_array($result_df_frm)){
        	$rtxrefund= trim($row_df_frm["add_ref1"]);
        	$old = false;
    	} else {
        	if ($old == false) {
            	$old = false;
        	} else {
            	$old = true;
        	}
    	}
    
    	
		$sql_df_frm="Select * from c_clamas where DGRN_NO3 = '" . trim($_GET["txtrefno"]) . "'";
    	$result_df_frm =$db->RunQuery($sql_df_frm);	
		if ($row_df_frm = mysql_fetch_array($result_df_frm)){
	    	$rtxrefund = trim($row_df_frm["add_ref2"]);
        	$old = false;
    	} else {
        	if ($old == false) {
            	$old = false;
        	} else {
            	$old = true;
        	}
    	}
    
    	if ($old == true) { $rtxrefund = 100; }
	}
	
	$rtxrefund="";
	//$sql_df_frm="Select * from c_clamas where cl_no = '" . trim($row_rsPrInv["cl_no"]) . "'";
	$sql_df_frm="Select * from c_clamas where dgrn_no = '" . trim($_GET["txtrefno"]) . "'";
    $result_df_frm =$db->RunQuery($sql_df_frm);	
	if ($row_df_frm = mysql_fetch_array($result_df_frm)){
		$remin=number_format($row_df_frm["remin1"], 2, ".", "");
		$origin=number_format($row_df_frm["origin1"], 2, ".", "");
		$rtxrefund=number_format($row_df_frm["remin1"], 0, "", "")."/".number_format($row_df_frm["origin1"], 0, "", "");
	}
	
	if ($_GET["vatgroup_0"] == "vat") {
    	$rtxtamo = $txt_net / 1.11;
    	$Rtxamou = ((($txt_net / $rtxrefund) * 100) / (100 - $row_rsPrInv["dis"]) * 100) / 1.11;
    	$RTXVAT = ($txt_net / 1.11) * 11 / 100;
    	$RTXTOT = ($txt_net / 1.11) + (($txt_net / 1.11) * 11 / 100);
    	//$rtxvatno= VATNO;
	} else {
    	$rtxtamo = $txt_net;
		IF (rtxrefund != 0) {
			$Rtxamou = (($txt_net / $rtxrefund) * 100) / (100 - $row_rsPrInv["dis"]) * 100;
		} else {
			$Rtxamou = $txt_net/ (100 - $row_rsPrInv["dis"]) * 100;
		}
    	
    	
	}

	$rtxtCusname = $_GET["txt_cusname"];
	$rtxadd = $_GET["txtadd"];
	$rtxtdep = $_GET["com_dep"];
	$rtxtrep =$_GET["Com_rep"];
    	
		

		
	?>
    
<table width="922" height="474" border="0">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" align="center"><span class="style4">Defective Goods Return Note</span></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" align="center">    <span class="style2"><?php echo $rtxtComName; ?></span></td>
    <td width="191">&nbsp;</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="center"><span class="style2"><?php echo $rtxtcomadd1; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="center"><span class="style2" ><?php echo $rtxtComAdd2; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="109" height="21">Customer :-</td>
    <td width="103"><span class="style2"><?php echo $rtxtCusCode; ?></span></td>
    
    <?php
		$txt_cusname=str_replace("~", "&", $_GET["txt_cusname"]); 
	?>
    <td colspan="3"><?php echo $txt_cusname; ?></td>
    <td width="92">No</td>
    <td><?php echo $rtxtRefNo; ?></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td height="21" colspan="4"><?php echo $rtxadd; ?></td>
    <td>Date</td>
    <td><?php echo $rtxtDocdate; ?></td>
  </tr>
  
  <tr>
    <td height="21">Invoice No:</td>
    <td height="21" colspan="4"><?php echo $_GET["refInv"];?></td>
    <td>Claim No</td>
    <td><span class="style2"><?php echo $row_rsPrInv["CLAM_NO"]; ?></span></td>
  </tr>
  <tr>
    <td height="21">Department</td>
    <td height="21" colspan="2"><?php 
		$sqltmp="Select * from s_stomas where CODE='".$rtxtdep."'";
    	$resulttmp =$db->RunQuery($sqltmp);	
		$rowtmp = mysql_fetch_array($resulttmp);
				
		
	echo $rowtmp["DESCRIPTION"]; ?></td>
    <td width="124">Sales Rep</td>
    <td width="264"><?php 
		$sqltmp="Select * from s_salrep where REPCODE='".$rtxtrep."'";
    	$resulttmp =$db->RunQuery($sqltmp);	
		$rowtmp = mysql_fetch_array($resulttmp);
	echo $rowtmp["Name"]; ?></td>
    <td>Serial No</td>
    <td><?php echo $row_rsPrInv["BAT_NO"]; ?></td>
  </tr>
  
  
  <tr>
    <td height="89" colspan="7">
    <table width="904" border="0" cellspacing="0">
    <!--  <tr  bgcolor="#999999">
        <td width="130" height="23"><span class="style1">STK No</span></td>
        <td width="295"><span class="style1">Description</span></td>
        <td width="158"><span class="style1">Rate</span></td>
        <td width="135"><span class="style1">Quantity</span></td>
        <td width="152"><span class="style1">Sub Total</span></td>
        </tr> -->
     
      
     
    </table>
    <table cellpadding="0" cellspacing="0" border="1">
    <tr><td>
    <table><tr>
          <td align="center" width="100"><strong>Item Code</strong></td>
          <td align="center" width="400"><strong>Description</strong></td>
          <td align="center" width="200"><strong>Part No</strong></td>
          <td align="center" width="100"><strong>Rate</strong></td>
          <td align="center" width="150"><strong>Qty</strong></td>
          <td align="center" width="100"><strong>Discount</strong></td>
          <td align="center" width="50"><strong>Total</strong></td>
          <td align="center" width="50"><strong>Appr</strong></td>
          <td align="center" width="150" ><strong>Refund Value</strong></td>
        </tr></table>
      </td></tr>
      <tr><td>  
      <table width="900" border="0">
        <?php
        $itemAmount = $row_rsPrInv["AMOUNT"];
        if (($_GET["vatmethod"] == "vat")||($_GET["vatmethod"] == "svat")){
            $sqlvat="Select vatrate from invpara";
            $resultvat = $db->RunQuery($sqlvat);	
            $rowvat = mysql_fetch_array($resultvat);
            $vatrate = $rowvat["vatrate"];
            $itemAmount = $row_rsPrInv["AMOUNT"] / (1 + ($vatrate / 100));
            $vatAmount = $rtxtamo*$vatrate/(100+$vatrate);
            $totVal = $rtxtamo;
            $rtxtamo = $rtxtamo / (1 + ($vatrate / 100));
        }
        ?>
        <tr>
          <td width="100"><?php echo $row_rsPrInv["STK_NO"]; ?></td>
          <td width="400" ><?php echo $row_rsPrInv["DESCRIPT"]; ?></td>
          <td align="center" width="200"><?php echo $row_rsPrInv["PART_NO"]; ?></td>
          <td align="center" width="100"><?php echo number_format($itemAmount, 2, ".", ","); ?></td>
          <td align="right" width="150"><?php echo $row_rsPrInv["qty"]; ?></td>
          <td align="right" width="100"><?php echo $row_rsPrInv["dis"]; ?></td>
          <td  align="right" width="100"><?php echo $origin; ?></td>
          <td  align="right" width="100"><?php echo $remin; ?></td>
          <td  align="right" width="150"><?php echo number_format($rtxtamo, 2, ".", ","); ?></td>
        </tr>
        <?php if (($_GET["vatmethod"] == "vat")||($_GET["vatmethod"] == "svat")){?>  
        <tr>
          <td width="100"></td>
          <td width="400" ></td>
          <td align="center" width="200"></td>
          <td align="center" width="100"></td>
          <td align="right" width="150"><?php echo $_GET["vatmethod"] . " $vatrate %"; ?></td>
          <td align="right" width="100"></td>
          <td  align="right" width="100"></td>
          <td  align="right" width="100"></td>
          <td  align="right" width="150"><?php echo number_format($vatAmount, 2, ".", ","); ?></td>
        </tr>
        <tr>
          <td width="100"></td>
          <td width="400" ></td>
          <td align="center" width="200"></td>
          <td align="center" width="100"></td>
          <td align="right" width="150">Total Value</td>
          <td align="right" width="100"></td>
          <td  align="right" width="100"></td>
          <td  align="right" width="100"></td>
          <td  align="right" width="150"><?php echo number_format($totVal, 2, ".", ","); ?></td>
        </tr>
        <?php }?>
      </table>
    </td>
    </tr></table>  
      <table width="900" border="0">
        <tr>
          <td width="252" colspan="2" scope="col"><b><?php echo $row_rsPrInv["REsult"]." &nbsp;&nbsp;"; 
		  if ($row_rsPrInv["approve_md_wd"]=="MD"){
		  	echo "(Approved By MD)";
		  } else if ($row_rsPrInv["approve_md_wd"]=="WD"){
		  	echo "(Approved By WD)";
		  }
		  ?></b></td>
          <td width="265" scope="col">&nbsp;</td>
        </tr>
        <tr>
          <td width="252">&nbsp;</td>
          <td width="369">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><?php echo $row_rsPrInv["Remarks"]; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><b><?php echo $_GET["status"];?></b></td>
        </tr>
        <tr>
          <td>__________________</td>
          <td align="center">________________</td>
          <td>___________________</td>
        </tr>
        <tr>
          <td>Prepared By</td>
          <td align="center">Checked By</td>
          <td>Authorized By</td>
        </tr>
      </table>
    <p>&nbsp;</p></td>
  </tr>
  <tr><td colspan="7">&nbsp;</td>
  </tr>
</table>
</body>
</html>
