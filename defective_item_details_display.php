
<?php 
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	

						 
	require_once("config.inc.php");
	require_once("DBConnector.php");
						
	$sql = "delete FROM TMP_EDU_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
						
	$sql = "delete FROM	TMP_QUALI_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
?>	

						 
	



<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

<script language="javascript" src="cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" src="cal_conf2.js"></script>
<script language="javascript" type="text/javascript">
<!--
/****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
****************************************************/
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>

<script type="text/javascript">
function openWin()
{
myWindow=window.open('serach_inv.php','','width=200,height=100');
myWindow.focus();

}
</script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dte_dor",
			dateFormat:"%Y-%m-%d"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
</script>

</label>
         <form name="form1" id="form1">  
<fieldset>
                                                	<legend>
  <div class="text_forheader">Defective Details</div>
                                               	 </legend>             

                                                 <a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
                                                 <input type="text" disabled="disabled" name="txt_fno" id="txt_fno" value="" class="text_purchase2" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
                                                 </a>
           
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="DGRN No" disabled="disabled"/></td>
    <td width="10%" colspan="2"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
    <?php
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	

	
	
		$txtrefno=$_GET["txtrefno"];
		
		$sqlrsdef="select * from s_deftrn where REFNO='".trim($_GET["txtrefno"])."'";
		//echo $sqlrsdef;
		$resultrsdef =$db->RunQuery($sqlrsdef);
		if ($rowrsdef = mysql_fetch_array($resultrsdef)){
			$table_col1=$rowrsdef["STK_NO"];
			$dtdate=$rowrsdef['SDATE'];
			$txtbat=$rowrsdef['BAT_NO'];
			$cl_no=$rowrsdef["cl_no"];
			
			
			$sql_cl="Select * from c_clamas where cl_no = '".$rowrsdef["cl_no"]."'";
			$result_cl =$db->RunQuery($sql_cl);
			if ($row_cl = mysql_fetch_array($result_cl)){
				$_SESSION["txt_fno"]=$row_cl["refno"];
				$cl_refno=$row_cl["refno"];
				
			}  else {
				$cl_refno="";
			}
		
			if (is_null($rowrsdef["arno"])==false){
				$cmbShip=$rowrsdef['arno'];
			} else {
				$cmbShip="";
			}
			
			if (is_null($rowrsdef["c_code"])==false){
			 	$txt_cuscode=$rowrsdef['c_code'];
			} else {
				$txt_cuscode="";
			}	
			
			$sqlcus="select * from vendor where CODE='".trim($rowrsdef['c_code'])."'";
			$resultcus =$db->RunQuery($sqlcus);
			if ($rowcus = mysql_fetch_array($resultcus)){
				$txt_cusname=$rowcus['NAME'];
				if (is_null($rowcus["ADD1"])==false) { 
					$txtadd = $rowcus["ADD1"]." ".$rowcus["ADD2"];
					//$ResponseXML .= "<txtadd><![CDATA[".$txtadd."]]></txtadd>";
				}
				if ((is_null($rowcus["vatno"])==false) and ($rowcus["vatno"] != ""))
				{
            		$vatgroup="1"; 
            		$VATNO = $rowcus["vatno"];
        		} else {
            		$vatgroup="0"; 
        		}
					
			}
			
			
			$txtcl_no=$rowrsdef['CLAM_NO'];
				
			if (is_null($rowrsdef['STK_NO'])==false){
				$sql="SELECT * FROM s_mas WHERE STK_NO='".$rowrsdef['STK_NO']."'";
				$result =$db->RunQuery($sql);
				if ($row = mysql_fetch_array($result)){
					if (is_null($row["DESCRIPT"])==false) {	$table_col2=$row["DESCRIPT"]; }
					if (is_null($row["PART_NO"])==false) {	$table_col3=$row["PART_NO"]; }
        		}
			}
   
    		if (is_null($rowrsdef['REsult'])==false){  
				$Cmbres=$rowrsdef['REsult'];  
			}
				
			if (is_null($rowrsdef['Remarks'])==false){  
				$txtremark=$rowrsdef['Remarks'];  
			}
    		
				
			$table_col4=$rowrsdef["AMOUNT"];
			$table_col5=1;
			$table_col6=$rowrsdef["dis"];
    			
			
			$AMOUNT=str_replace(",", "", $rowrsdef['AMOUNT']);	
			
			if (is_null($rowrsdef['ref_per'])==false){  
				$sql_df_frm="Select * from c_clamas where DGRN_NO = '".$_GET["txtrefno"]."' or DGRN_NO2 = '".$_GET["txtrefno"]."' or DGRN_NO3 = '".$_GET["txtrefno"]."' ";
				$result_df_frm =$db->RunQuery($sql_df_frm);
					
				$sql_rcbal="select * from c_bal where REFNO = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
      				$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;
      		     	$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal["AMOUNT"], 2, ".", ",")."]]></txt_net>";  
						
					$table_col9=number_format($row_rcbal["AMOUNT"], 2, ".", ",");
					$tmp = ($row_rcbal["AMOUNT"]/$rowrsdef['ref_per'])*100;
					$table_col7=$tmp;
					//echo $row_rcbal["AMOUNT"]."/".$rowrsdef['ref_per']."/".$rowrsdef['dis'];
					$tmp=(($row_rcbal["AMOUNT"] / $rowrsdef['ref_per']) ) / (100 - $rowrsdef['dis']) * 10000;
					//echo $tmp;
					$table_col4=number_format($tmp, 2, ".", ",");
					$table_col8=$rowrsdef['ref_per'];
					$old="false";
				} else {
					$old="true";
				}	
           
            	if ($old=="true"){
					$ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>"; 
					$_SESSION["txt_fno"]="OLD" ;
           			$table_col8 = $rowrsdef['ref_per'];
					$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal["AMOUNT"], 2, ".", ",")."]]></txt_net>"; 
            		$table_col9 = number_format($row_rcbal["AMOUNT"], 2, ".", ",");
            		$table_col7 =($row_rcbal["AMOUNT"]/$table_col8)*100; 
            		$table_col4 =(($row_rcbal["AMOUNT"]/$table_col8)*100)/(100 - $rowrsdef['dis']);  
				}
			} else {
					
        		$sql_df_frm="Select * from c_clamas where DGRN_NO = '".$_GET["txtrefno"]."'";
				//echo $sql_df_frm;
				$result_df_frm =$db->RunQuery($sql_df_frm);
					
					
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				//echo $sql_rcbal;
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
					$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;	  
      		 	 	$ResponseXML .= "<txt_net><![CDATA[".number_format($AMOUNT, 2, ".", ",")."]]></txt_net>";  
						
					
					
					$table_col9=number_format($row_rcbal["AMOUNT"], 2, ".", ",");
					$tmp = ($row_rcbal["AMOUNT"]/$rowrsdef['ref_per'])*100;
					$table_col7=$tmp;
					$tmp=(($row_rcbal["AMOUNT"] / $rowrsdef['ref_per']) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
					$table_col8=$rowrsdef['ref_per'];
					$old="false";
				} else {
   					$old="true";
				}	
       				
				$sql_df_frm="Select * from c_clamas where DGRN_NO2 = '".$_GET["txtrefno"]."'";
				$result_df_frm =$db->RunQuery($sql_df_frm);
       				
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
					$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;
      		 	 	$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal["AMOUNT"], 2, ".", ",")."]]></txt_net>";  
						
					$table_col9=number_format($row_rcbal["AMOUNT"], 2, ".", ",");
					$tmp = ($row_rcbal["AMOUNT"]/$row_df_frm['add_ref1'])*100;
					$table_col7=$tmp;
					$tmp=(($row_rcbal["AMOUNT"] / $row_df_frm['add_ref1']) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
					$table_col8=$row_df_frm['add_ref1'];
					$old="false";
				} else {
					if ($old=="false"){
						$old="false";
					} else {
						$old="true";
					}
				}	
        			
				$sql_df_frm="Select * from c_clamas where DGRN_NO3 = '".$_GET["txtrefno"]."'";
				$result_df_frm =$db->RunQuery($sql_df_frm);
       				
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
					
				if ($row_df_frm = mysql_fetch_array($result_df_frm)){
					$ResponseXML .= "<txt_fno><![CDATA[".$row_df_frm['refno']."]]></txt_fno>";
					$_SESSION["txt_fno"]=$row_df_frm['refno'] ;	  
      		 	 	$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal["AMOUNT"], 2, ".", ",")."]]></txt_net>";  
						
					$table_col9=number_format($row_rcbal["AMOUNT"], 2, ".", ",");
						
					$tmp = ($row_rcbal["AMOUNT"]/$row_df_frm['add_ref2'])*100;
					$table_col7=$tmp;
						
					$tmp=(($row_rcbal["AMOUNT"] / $row_df_frm['add_ref2']) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
						
					$table_col8=$row_df_frm['add_ref2'];
					$old="false";
				} else {
					if ($old=="false"){
						$old="false";
					} else {
						$old="true";
					}
				}	
        			
				$sql_rcbal="select * from c_bal where refno = '".$_GET["txtrefno"]."'";
				$result_rcbal =$db->RunQuery($sql_rcbal);
				$row_rcbal = mysql_fetch_array($result_rcbal);
				if ($old=="true"){
					$ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>";
					$_SESSION["txt_fno"]="OLD" ;
					$table_col8=100;
					$ResponseXML .= "<txt_net><![CDATA[".number_format($row_rcbal["AMOUNT"], 2, ".", ",")."]]></txt_net>";  
					$table_col9=number_format($row_rcbal["AMOUNT"], 2, ".", ",");
						
					$tmp = ($row_rcbal["AMOUNT"]/$table_col8)*100;
					$table_col7=$tmp;
						
					$tmp=(($row_rcbal["AMOUNT"] / $table_col8) * 100) / (100 - $rowrsdef['dis']) * 100;
					$table_col4=number_format($tmp, 2, ".", ",");
				}
			}
				
			if (is_null($rowrsdef["DEP"])==false){
    			$sql_rst2="select * from s_stomas where CODE='".$rowrsdef["DEP"]."'";
				$result_rst2 =$db->RunQuery($sql_rst2);
				if ($row_rst2 = mysql_fetch_array($result_rst2)){
					$dep=$rowrsdef["DEP"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row_rst2["DESCRIPTION"];
					$ResponseXML .= "<com_dep><![CDATA[".$dep."]]></com_dep>";
				}
    		}
				
			if (is_null($rowrsdef["SAL_EX"])==false){
    			$sql_rst1="select * from s_salrep where REPCODE='".$rowrsdef["SAL_EX"]."'";
				$result_rst1 =$db->RunQuery($sql_rst1);
				if ($row_rst1 = mysql_fetch_array($result_rst1)){
					$dep=str_split($rowrsdef["SAL_EX"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 6).$row_rst1["Name"];
					$ResponseXML .= "<Com_rep><![CDATA[".$dep."]]></Com_rep>";
				}
    		}
		} else {
			
			$sql_rsdgrn="Select * from  c_clamas where refno = '".$_SESSION["txt_fno"]."'";
			//echo $sql_rsdgrn;
			$result_rsdgrn =$db->RunQuery($sql_rsdgrn);
			if ($row_rsdgrn = mysql_fetch_array($result_rsdgrn)){
				$table_col1=$row_rsdgrn["stk_no"];
				if (is_null($row_rsdgrn["ag_code"])==false){ $txt_cuscode=$row_rsdgrn["ag_code"]; }
				if (is_null($row_rsdgrn["ag_name"])==false){ $txt_cusname=$row_rsdgrn["ag_name"]; }
					
				$sql_cus="select * from vendor where CODE='".trim($row_rsdgrn["ag_code"])."'";
				$result_cus =$db->RunQuery($sql_cus);
				if ($row_cus = mysql_fetch_array($result_cus)){
					$txt_cusname=$row_cus["NAME"];
						 
				 	if (is_null($row_cus["ADD1"])==false){ 
						$txtadd=$row_cus["ADD1"]." ".$row_cus["ADD2"];
						$txtadd=$txtadd;
					}
						
					if ((is_null($row_cus["vatno"])==false) and ($row_cus["vatno"] != ""))
					{
            			$vatgroup="1";
            			$VATNO = $row_cus["vatno"];
        			} else {
            			$vatgroup="0";
        			}
							
				}
					
				if (is_null($row_rsdgrn["agadd"])==false){ $txtadd=$row_rsdgrn["agadd"]; }
				if (is_null($row_rsdgrn["seri_no"])==false){ $txtbat=$row_rsdgrn["seri_no"]; }
					
				$txtcl_no="";
				if (is_null($row_rsdgrn["cl_no"])==false){ 
					$txtcl_no=$row_rsdgrn["cl_no"];
				}
				if (is_null($row_rsdgrn["rem_per"])==false){ 
					$txtcl_no=$txtcl_no."  ".$row_rsdgrn["rem_per"];
				}
				$txtcl_no=$txtcl_no;
					
				$txtremark="";
				if (is_null($row_rsdgrn["tc_ob"])==false){ 
					$txtremark=$row_rsdgrn["tc_ob"];
				}
				if (is_null($row_rsdgrn["Mn_ob"])==false){ 
					$txtremark=$txtremark." (".$row_rsdgrn["Mn_ob"].")";
				}
				
				
					
				if (is_null($row_rsdgrn["des"])==false){ $table_col2 = $row_rsdgrn["des"]; }
				if (is_null($row_rsdgrn["patt"])==false){ $table_col3 = $row_rsdgrn["patt"]; }
					
				
				$sql_rst="SELECT * FROM s_mas WHERE STK_NO='".$row_rsdgrn["stk_no"]."'";
				$result_rst =$db->RunQuery($sql_rst);
				if ($row_rst = mysql_fetch_array($result_rst)){	
					if (is_null($row_rst["SELLING"])==false){ $table_col4 = $row_rst["SELLING"]; }
				}
				
				$sql_rst="Select ref_no, dis_per from viewinv where cus_code = '".trim($row_rsdgrn["ag_code"])."' and stk_no = '".trim($row_rsdgrn["stk_no"])."' and cancel_m = '0' order by sdate desc";
				
				$result_rst =$db->RunQuery($sql_rst);
				if ($row_rst = mysql_fetch_array($result_rst)){	
					
					$sql_CH_DIS="Select Incen_per from  s_crnfrmtrn where inv_no = '" . trim($rst["REF_NO"]) . "'";
					$result_CH_DIS =$db->RunQuery($sql_CH_DIS);
					if ($row_CH_DIS = mysql_fetch_array($result_CH_DIS)){
						$add_dis=$row_CH_DIS["Incen_per"];
					} else {
						$add_dis=0;
					}	
					$table_col6=$row_rst["dis_per"] + $add_dis;
				}	
				
				$table_col5=1;	
       			
				if ($row_rsdgrn["Refund"]=="Recommended"){
					$Cmbres="DEFECT"; 
				}
				
				if (($row_rsdgrn["Refund"]=="Recommended") and ($row_rsdgrn["Commercialy"]!="0")){
					$Cmbres="COMMERCIAL CLAIM"; 
				}
				
				if (($row_rsdgrn["Refund"]=="Not Recommended") and ($row_rsdgrn["Commercialy"]!="0")){
					$Cmbres="COMMERCIAL CLAIM"; 
				}
				
				if (($row_rsdgrn["DGRN_NO"]=="0") and ($row_rsdgrn["rem_per"]>0)){
					$table_col8=$row_rsdgrn["rem_per"];
				}
				
				if (($row_rsdgrn["DGRN_NO2"]=="0") and ($row_rsdgrn["rem_per1"]>0)){
					$table_col8=$row_rsdgrn["rem_per1"];
				}
				
				if (($row_rsdgrn["DGRN_NO3"]=="0") and ($row_rsdgrn["rem_per2"]>0)){
					$table_col8=$row_rsdgrn["rem_per2"];
				}
				
        	}
		}	
	
	
	$sql_rscbal="select * from c_bal where REFNO='".trim($_GET["txtrefno"])."'";
	$result_rscbal =$db->RunQuery($sql_rscbal);
	if ($row_rscbal = mysql_fetch_array($result_rscbal)){	
		if (is_null($row_rscbal["RNO"])==false){ $ResponseXML .= "<txtrno><![CDATA[".$row_rscbal["RNO"]."]]></txtrno>"; }
	}			
	
	
	
							
			
					$itemno=$table_col1;		
					$item_name=$table_col2;
					$partno=$table_col3;
					$rate=$table_col4;
					$qty=$table_col5;
					$discou=$table_col6;
					
					$refund=$table_col8;
					
             	
					//$table_col7 = $table_col4 * $table_col5 - $table_col4 * $table_col5 * $table_col6 * 0.01;
					//echo $table_col7;
					
					
					//$table_col9 = $table_col9 + ($table_col7 * $table_col8 * 0.01);
					
					$total=$table_col9;	
					$txt_net=$table_col9;	
					
					$sql_crnma="select * from s_crnma where REF_NO = '".$_GET["txtrefno"]."'";
					$result_crnma =$db->RunQuery($sql_crnma);
					$row_crnma = mysql_fetch_array($result_crnma);
					
					$table_col4=str_replace(",", "", $table_col4);
					$table_col6=str_replace(",", "", $table_col6);
					$table_col8=str_replace(",", "", $table_col8);
					
					$subtot=$table_col4-($table_col4*$table_col6/100);
					$tot=$subtot*$table_col8/100;
					$ResponseXML .= "<subtot><![CDATA[".number_format($subtot, 2, ".", ",")."]]></subtot>";		
					$ResponseXML .= "<subtot><![CDATA[".number_format($tot, 2, ".", ",")."]]></subtot>";	
	
	
	
			
			
	
	
   
	?>
       <a href="search_defective.php?stname=dgrn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
       <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a>
      <input type="text" disabled="disabled" name="txtrefno" id="txtrefno" class="text_purchase2" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');" value="<?php echo $txtrefno; ?>"  />
      <a href="search_defective.php?stname=dgrn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td width="10%"><a href="search_claim_list.php?stname=DGRN" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" />
    </a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%">
      <input type="text" size="20" name="dtdate" id="dtdate" value="<?php echo $dtdate; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="com_dep" id="com_dep" value="<?php echo $row["DEPARTMENT"]; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input type="text" disabled="disabled" name="txtrno" id="txtrno" value="" class="text_purchase2" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase1" name="txt_cuscode" id="txt_cuscode" value="<?php echo $txt_cuscode; ?>"/>
      <input type="text" disabled="disabled"  class="text_purchase2" id="txt_cusname" name="txt_cusname" value="<?php echo $txt_cusname; ?>" />
      <a href="" onClick="NewWindow('serach_customer.php?stname=defective_item','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td><input type="text"  class="label_purchase" value="Batry No" disabled/></td>
    <td><input type="text" size="15" name="txtbat" id="txtbat" value="<?php $txtbat; ?>" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Cost Center" disabled="disabled"/></td>
    <td><select name="com_costcent" id="com_costcent" onkeypress="keyset('searchitem',event);" class="text_purchase3"  >
     
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase3"  disabled="disabled" id="txtadd" name="txtadd" value="<?php echo $txtadd; ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text" size="5" name="Cmbres" id="Cmbres" value="<?php echo $Cmbres; ?>" onblur="keyset('discount2',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Remarks" disabled="disabled"/></td>
    <td width="10%" colspan="2"><input type="text" size="20" name="txtremark" id="txtremark" disabled="disabled" value="<?php echo $txtremark; ?>" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td bgcolor="#00CCCC"><label>
    <?php
	if ($vatgroup=="1"){
      echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"  onkeypress=\"keyset('discount1',event);\" checked />";
	} else {
	  echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"  onkeypress=\"keyset('discount1',event);\"  />";
	} 
	?> 
      VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
    <?php
	if ($vatgroup=="0"){
      echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\" checked  onkeypress=\"keyset('discount1',event);\" />";
	 } else {
	 	echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\"  onkeypress=\"keyset('discount1',event);\" />";
	 } 
	 ?>
      Non VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="svat" id="vatgroup_2"  onkeypress="keyset('discount1',event);" />
      SVAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="evat" id="vatgroup_3"  onkeypress="keyset('discount1',event);" />
      EVAT Invoice</label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><input type="text" size="20" name="Com_rep" id="Com_rep" disabled="disabled" onkeypress="keyset('vat2',event);" class="text_purchase3" value="<?php echo $row["SAL_EX"]; ?>"/></td>
    <td width="10%">&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Claim No" disabled="disabled"/></td>
    <td><input type="text" size="5" name="txtcl_no" id="txtcl_no" value="<?php echo $txtcl_no; ?>" onblur="keyset('discount2',event);" class="text_purchase3"/></td>
    <td><input type="text" size="5" name="txtcl_no2" id="txtcl_no2" value="<?php echo $row1["REsult"]; ?>" onblur="keyset('discount2',event);" class="text_purchase"/></td>
    <td><input type="text"  class="label_purchase" value="Shipment" disabled="disabled"/></td>
    <td><input type="text"  class="text_purchase3" value="<?php echo $row1["arno"]; ?>" disabled="disabled"/></td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Defective Item Details</div></legend>            
            
  <table width="84%" border="0">
  <tr>
    <td width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Item" disabled/>
    </span></td>
    <td  width="20%"><span class="style1">
      <input type="text"  class="label_purchase" value="Description" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Part No" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Rate" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Qty" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled/>
    </span></td>
     <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Refund" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Total" disabled/>
    </span></td>
    <td  width="10%">&nbsp;</td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
    <div id="test"><font color="#FFFFFF">
        <input type="text"  class="text_purchase3" name="itemno" id="itemno" size="10" disabled="disabled" value="<?php echo $itemno; ?>"  onkeypress="keyset('itemd',event);"     />
    </font></div>  </font></td>
    <td><font color="#FFFFFF">
    <?php
		$sql_stkno="select * from s_mas where STK_NO='".$row1["STK_NO"]."'";
			//echo $sql1;
	$result_stkno =$db->RunQuery($sql_stkno);
	$row_stkno = mysql_fetch_array($result_stkno);
	?>
      <input type="text"  class="text_purchase6" size="40" id="item_name" name="item_name" disabled="disabled" onkeypress="keyset('rate',event);" value="<?php echo $item_name; ?>" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="partno" id="partno"  disabled="disabled" class="text_purchase3" value="<?php echo $partno; ?>" onkeypress="keyset('qty',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="rate" id="rate" value="<?php echo $rate; ?>" onblur="calc1();" class="text_purchase3" disabled="disabled"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="qty" id="qty" value="<?php echo $qty; ?>" disabled="disabled" class="text_purchase3" onkeypress="keyset('subtotal',event);"/><input type="hidden" size="15" name="discount" id="discount" value="" disabled class="txtbox" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="discou" id="discou" value="<?php echo $discou; ?>" class="text_purchase3"  onblur="settotal();"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="subtot" id="subtot" value="<?php echo $subtot; ?>" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="refund" id="refund" value="<?php echo $refund; ?>" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="total" id="total" value="<?php echo $total; ?>" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    </tr>
  <tr>
	<td colspan="6">
    <div class="CSSTableGenerator" id="itemdetails" ></div>                                                 		</td>
                                                		</tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="txt_net" id="txt_net" value="<?php echo $total; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">