<?php session_start();
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

						 
	



<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>


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
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Order Details</div>
                                               	 </legend>    
                                                 
   <?php
   include_once("connection.php");
   
   
   $sql = mysql_query("Select * from s_salma where REF_NO='".$_GET["refno"]."'") or die(mysql_error());
   $row = mysql_fetch_array($sql);
   	
   
   ?>                                                       

   <input type="hidden" name="cmd_print" id="cmd_print" value="1" />
<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    
    <?php  
		if ($row['TYPE']=="CR"){
			echo "<td width=\"10%\" bgcolor=\"#00CCCC\"><label><input type=\"radio\" name=\"paymethod\" value=\"credit\" id=\"paymethod_0\" checked=\"checked\" />
      Credit</label></td>";
	  echo "<td width=\"10%\"  bgcolor=\"#00CCCC\"><label>
      <input type=\"radio\" name=\"paymethod\" value=\"cash\" id=\"paymethod_1\" />
      Cash</label></td>";
		} else if ($row['TYPE']=="CA"){
			echo "<td width=\"10%\" bgcolor=\"#00CCCC\"><label><input type=\"radio\" name=\"paymethod\" value=\"credit\" id=\"paymethod_0\"  />
      Credit</label></td>";
			echo "<td width=\"10%\"  bgcolor=\"#00CCCC\"><label>
      <input type=\"radio\" name=\"paymethod\" value=\"cash\" id=\"paymethod_1\" checked=\"checked\"/>
      Cash</label></td>";
		}
	?>
      
    
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Sales Order No" disabled="disabled"/></td>
    <td width="10%"><input type="text" disabled="disabled" name="salesord1" id="salesord1" value="<?php echo $row['ORD_NO']; ?>" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />     </td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="invdate" id="invdate" value="<?php echo $row['SDATE']; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input type="hidden" name="hiddencount" id="hiddencount" /></td>
    <td><input type="text"  class="label_purchase" value="Delivery Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="deli_date" id="deli_date" value="<?php echo $row['deli_date']; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase" name="invno" id="invno" value="<?php echo $_GET["refno"]; ?>"/>
      <a href="serach_inv.php?stname=inv_mast" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="hidden" name="txtdono" id="txtdono" />
      </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text"  class="text_purchase1" name="firstname_hidden" id="firstname_hidden" disabled="disabled"   value="<?php echo $row['C_CODE']; ?>"/>
    <?php
	
		$sqlcustomer = mysql_query("Select * from vendor where CODE='".$row['C_CODE']."'") or die(mysql_error());
		$rowcustomer = mysql_fetch_array($sqlcustomer);
	?>				
					
      <input type="text" disabled="disabled"  class="text_purchase2" id="firstname" name="firstname" value="<?php echo $row['CUS_NAME']; ?>" /></td>
    <td><input type="text"  class="label_purchase" value="Credit Limit" disabled/></td>
    <td><input type="text" size="15" name="creditlimit" id="creditlimit" value="0" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Balance" disabled="disabled"/></td>
    <td><input type="text" size="15" name="balance" id="balance" disabled="disabled" value="0" onkeypress="keyset('department',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <?php 
	
	if (trim($row['C_ADD1'])!=""){
	 	$address=$row['C_ADD1'];
	} else {	
		$address=$rowcustomer['ADD1']." ".$rowcustomer['ADD2'];
	}	
	?>	
    <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="cus_address" name="cus_address" value="<?php echo $address; ?>" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Department" disabled/></td>
    <?php 
		$sqldep = mysql_query("Select * from s_stomas where CODE='".$row['DEPARTMENT']."'") or die(mysql_error());
		$rowdep = mysql_fetch_array($sqldep);
		$department=$rowdep["CODE"]." ".$rowdep["DESCRIPTION"];
	
	?>
    <td><input type="text" disabled="disabled"  class="text_purchase2" id="department" name="department" value="<?php echo $department; ?>" /> </td>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><input type="text" disabled="disabled"  class="text_purchase2" id="brand" name="brand" value="<?php echo $row['Brand']; ?>" />   </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
    <td><input type="text" size="20" name="vat1" id="vat1" disabled="disabled" value="<?php echo $rowcustomer['vatno']; ?>" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td><input type="text" size="20" name="vat2" id="vat2" disabled="disabled" value="<?php echo $rowcustomer['svatno']; ?>" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td bgcolor="#00CCCC"><label>
    <?php
		if (trim($row['VAT'])=="1"){
      		echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"  checked=\"checked\" />VAT Invoice</label></td><td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\"  /> Non VAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"svat\" id=\"vatgroup_2\" />SVAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"evat\" id=\"vatgroup_3\"  />EVAT Invoice</label>";
			
		} else 	if ($row['SVAT']>0){
		
      		echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"   />VAT Invoice</label></td><td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\"  /> Non VAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"svat\" id=\"vatgroup_2\" checked=\"checked\" />SVAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"evat\" id=\"vatgroup_3\"  />EVAT Invoice</label>";
		
		} else 	{
		
      		echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"   />VAT Invoice</label></td><td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\" checked=\"checked\" /> Non VAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"svat\" id=\"vatgroup_2\" />SVAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
			echo "<input type=\"radio\" name=\"vatgroup\" value=\"evat\" id=\"vatgroup_3\"  />EVAT Invoice</label>";
		}		
      
    ?>
     </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
     <?php 
		$sqldep = mysql_query("Select * from s_salrep where REPCODE='".$row['SAL_EX']."'") or die(mysql_error());
		$rowdep = mysql_fetch_array($sqldep);
		$salrep=$rowdep["REPCODE"]." ".$rowdep["Name"];
	
	?>
    <td><input type="text" disabled="disabled"  class="text_purchase2" id="salesrep" name="salesrep" value="<?php echo $salrep; ?>" /></td>
    <td><input type="text"  class="label_purchase" value="Discount 1" disabled="disabled"/></td>
    <td><input type="text" size="5" name="discount_org1" id="discount_org1" value="<?php echo $row['DIS']; ?>" onkeypress="keyset('discount2',event);" onblur="calc1_table_discount1();" class="text_purchase" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Discount 2" disabled="disabled"/></td>
    <td><input type="text" size="5" name="discount_org2" id="discount_org2" value="<?php echo $row['DIS1']; ?>" onkeypress="keyset('itemd_hidden',event);" onblur="calc1_table_discount1();" class="text_purchase"/></td>
    <td><input type="text"  class="label_purchase" value="Discount 3" disabled="disabled"/></td>
    <td><input type="text" size="5" name="discount_org3" id="discount_org3" value="<?php echo $row['DIS2']; ?>" onkeypress="keyset('itemd_hidden',event);" onblur="calc1_table_discount1();" class="text_purchase"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input id="dte_dor" name="dte_dor" type="hidden"  value="" class="text_purchase3" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
    <input type="hidden" name="item_count" id="item_count" value="0" />
  <table width="84%" border="0">
  <tr>
    <td width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Code" disabled/>
    </span></td>
    <td  width="40%"><span class="style1">
      <input type="text"  class="label_purchase" value="Description" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Rate" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Qty" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td  width="10%">&nbsp;</td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
    <div id="test"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="10" onkeypress="keyset('qty',event);" onblur="itno_ind();"   />
    </font></div>  </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase6" size="40" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="rate" id="rate" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
      <input type="hidden" name="part_no" id="part_no" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="qty" id="qty" value="" onblur="calc1();" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="discountper" id="discountper" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('subtotal',event);"/><input type="hidden" size="15" name="discount" id="discount" value="" disabled class="txtbox" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="subtotal" id="subtotal" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td colspan="6">
    <div class="CSSTableGenerator" id="itemdetails" >
    <?php
	
	echo "<table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				
				
				$sql_data = mysql_query("Select * from s_invo where REF_NO='".$_GET["refno"]."'") or die(mysql_error());
				while($row1 = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from s_mas where STK_NO='".$row['STK_NO']."' and BRAND_NAME='".$brand."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
							
							
					
				
					$subtot=(floatval($row1['PRICE'])*floatval($row1['QTY']))-floatval($row1['DIS_rs']);
					//echo $subtot;
					
					
						
			
			 	echo "<tr>
                            <td onClick=\"disp_qty('".$row1['STK_NO']."');\">".$row1['STK_NO']."</a></td>
  							 <td onClick=\"disp_qty('".$row1['STK_NO']."');\">".$row1['DESCRIPT']."</a></td>
							 <td onClick=\"disp_qty('".$row1['STK_NO']."');\">".number_format($row1['PRICE'], 2, ".", ",")."</a></td>
							 <td onClick=\"disp_qty('".$row1['STK_NO']."');\">".$row1['QTY']."</a></td>
							 <td onClick=\"disp_qty('".$row1['STK_NO']."');\">".number_format($row1['DIS_per'], 2, ".", ",")."</td>
							 <td onClick=\"disp_qty('".$row1['STK_NO']."');\">".number_format($subtot, 2, ".", ",")."</a></td>
							
							 
                            </tr>";
							
							
            					
				}
			
			    echo "   </table>";
	
	?>
  </div>                                                 		</td>
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
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Stock Level" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="5" name="stklevel" id="stklevel" value="" class="text_purchase1"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="subtot" id="subtot" value="<?php echo $row['AMOUNT']; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Credit Period" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="5" name="credper" id="credper" value=""  class="text_purchase1"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="<?php echo $row['DISCOU']; ?>" disabled="disabled"  class="text_purchase3" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="tax" id="tax" value="<?php echo $row['VAT_VAL']; ?>"  class="text_purchase3"  disabled="disabled" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" rowspan="5"><div id="storgrid"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Invoice Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="invtot"  id="invtot" value="<?php echo $row['GRAND_TOT']; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
    </tr>
</table>
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">