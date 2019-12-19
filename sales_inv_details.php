<?php session_start();
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

date_default_timezone_set('Asia/Colombo'); 


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
<script type="text/javascript">
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
		});
		
	}

</script>

</label>
          
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {
	font-size: 24px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Order Details</div>
                                               	 </legend>             

<form name="form1" id="form1"> <input type="hidden" name="cmd_new" id="cmd_new" value="1" />
    <input type="hidden" name="cmd_save" id="cmd_save" value="0"/>
    <input type="hidden" name="cmd_cancel" id="cmd_cancel" value="0"/>
    <input type="hidden" name="cmd_print" id="cmd_print" value="0"/>
     
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%" bgcolor="#00CCCC"><label>
            <input type="radio" name="paymethod" value="credit" id="paymethod_0" <?php if($_SESSION["company"]!="R") echo "checked=\"checked\""; ?> onclick="setCash();"/>
      Credit</label></td>
    <td width="10%"  bgcolor="#00CCCC"><label>
            <input type="radio" name="paymethod" value="cash" id="paymethod_1" <?php if($_SESSION["company"]=="R") echo "checked=\"checked\""; ?> onclick="setCash(<?php echo "'".$_SESSION["company"]."'";?>);"/>
      Cash</label></td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Sales Order No/AD No" disabled="disabled"/></td>
    <td width="10%"><input type="text" name="salesord1" id="salesord1" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);"   />     </td>
    <td width="10%">
            <a href="" onClick="NewWindow('serach_customer_1.php?stname=setInvoiceOrd','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a>
      <input type="hidden" name="ordno" id="ordno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);"   />
      <!--<input type="button" name="searchinv2" onclick="load_ad_lst();" id="searchinv2" value="AD" class="btn_purchase1" /></td>-->
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('invdate');" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input id="dte_dor" name="dte_dor" type="hidden"  value="" class="text_purchase3" /></td>
    <td><input type="hidden" name="hiddencount" id="hiddencount" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="D/A No" disabled="disabled"/></td>
    <td><input type="hidden" name="txtad" id="txtad" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);"   />
      <input type="hidden" name="txtreturn" id="txtreturn" value="0" class="text_purchase3" disabled="disabled" onkeypress="keyset('searchcust',event);"   />
      <input type="text" name="da_no" id="da_no" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);"   /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Vehicle No" disabled="disabled"/></td>
    <td><input type="text" name="vehino" id="vehino" class="text_purchase3" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled/></td>
    <td colspan="3"><input type="text"  class="text_purchase" name="invno" id="invno" disabled="disabled"/>
      <a href="serach_inv.php?stname=inv_mast" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase" />
      <input type="hidden" name="txtdono" id="txtdono" />
      </a></td>
    <td><input type="hidden" name="over60" id="over60" disabled="disabled" class="text_purchase3"/><div class="style2" id="cancelid"></div>    </td>
    <td><input type="hidden" name="Result" id="Result" disabled="disabled" class="text_purchase3"/></td>
    <td><input type="hidden"  class="label_purchase" value="Balance With Tmp Limit" disabled="disabled"/></td>
    <td><input type="hidden" name="crebal" id="crebal" class="text_purchase3" disabled="disabled"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text"  class="text_purchase1" disabled="disabled" name="firstname_hidden" id="firstname_hidden" onblur="custno_ind('')" onkeypress="keyset('department',event);"/>
      <input type="text" class="text_purchase2" id="firstname" name="firstname" />
      <a href="" onClick="NewWindow('serach_customer.php?stname=setInvoice','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td><input type="hidden"  class="label_purchase" value="Credit Limit" disabled/></td>
    <td><input type="hidden" size="15" name="creditlimit" id="creditlimit" value="0" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
    <td><input type="hidden"  class="label_purchase" value="Balance" disabled="disabled"/></td>
    <td><input type="hidden" size="15" name="balance" id="balance" disabled="disabled" value="0" onkeypress="keyset('department',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address1" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Department" disabled/></td>
    <td><select name="department" id="department" onkeypress="keyset('brand',event);" class="text_purchase3" >
      <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="hidden"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td style="visibility: hidden;"><select name="brand" id="brand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onblur="setord();">
    		<option value=''></option>
      <?php
																	$sql="select  barnd_name from brand_mas order by barnd_name";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address2" disabled="disabled"/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  id="cus_address2" name="cus_address2" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
    <td><input type="text" size="20" name="vat1" id="vat1" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td><input type="text" size="20" name="vat2" id="vat2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td bgcolor="#00CCCC"><label>
            <input type="radio" name="vatgroup" value="vat" id="vatgroup_0"  onclick="calc1_table_discount1();" <?php if(($_SESSION["COMCODE"]=="C")||($_SESSION["COMCODE"]=="B")) echo "disabled";?>/>
      VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="non" id="vatgroup_1"  onclick="calc1_table_discount1();" <?php if(($_SESSION["COMCODE"]=="C")||($_SESSION["COMCODE"]=="B")) echo "disabled";?>/>
      Non VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="svat" id="vatgroup_2"  onclick="calc1_table_discount1();" <?php if(($_SESSION["COMCODE"]=="C")||($_SESSION["COMCODE"]=="B")) echo "disabled";?>/>
      SVAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="evat" id="vatgroup_3"  onclick="calc1_table_discount1();" <?php if(($_SESSION["COMCODE"]=="C")||($_SESSION["COMCODE"]=="B")) echo "disabled";?>/>
      EVAT Invoice</label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onblur="setord();" class="text_purchase3">
      <?php
																	$sql="select * from s_salrep where cancel='1' order by REPCODE";
																	
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
																		$tmprepcode=("00".$row["REPCODE"]); 
																		$lenth=strlen($tmprepcode);
																		$repcode=substr($tmprepcode, $lenth-2);
                        												echo "<option value='".$repcode."'>".$repcode." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="checkbox" id="isHideAdt" name="isHideAdt" <?php if ($_SESSION["User_Type"] != "1"){echo "disabled=''";} ?> />Hide Additional</td>    
    <td><input type="hidden"  class="label_purchase" value="Discount 1" disabled="disabled"/></td>
    <td><input type="hidden" size="5" name="discount_org1" id="discount_org1" value="0" onkeypress="keyset('discount_org2',event);" onblur="calc1_table_discount1();" class="text_purchase"/></td>
    <td><input type="hidden"  class="label_purchase" value="Discount 2" disabled="disabled"/></td>
    <td><input type="hidden" size="5" name="discount_org2" id="discount_org2" value="0" onkeypress="keyset('discount_org3',event);" onblur="calc1_table_discount1();" class="text_purchase"/></td>
    <td><input type="hidden"  class="label_purchase" value="Discount 3" disabled="disabled"/></td>
    <td><input type="hidden" size="5" name="discount_org3" id="discount_org3" value="0" onkeypress="keyset('searchitem',event);" onblur="calc1_table_discount1();" class="text_purchase"/></td>
  </tr>
  </table>

  
  
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
    <input type="hidden" name="item_count" id="item_count" value="0" />
  <table width="100%" border="0">
  <tr>
    <td width="5%"><span class="style1">
      <input type="text"  class="label_purchase" value="Code" disabled/>
    </span></td>
    <td  width="1%">&nbsp;</td>
    <td  width="39%"><span class="style1">
      <input type="text"  class="label_purchase" value="Description" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text" id="rate_name" name="rate_name"  class="label_purchase" value="Rate" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text" id="rate_name2" name="rate_name2"  class="label_purchase" value="Rate With VAT" disabled="disabled"/>
    </span></td>
    <td  width="5%"><span class="style1">
      <input type="text"  class="label_purchase" value="Qty" disabled/>
    </span></td>
    <td  width="4%"><span class="style1">
      <input type="text"  class="label_purchase" value="Discount1" disabled="disabled"/>
    </span></td>
    <td  width="4%"><span class="style1">
      <input type="text"  class="label_purchase" value="Discount2" disabled="disabled"/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Total Discount" disabled="disabled"/>
    </span></td>
    <td  width="14%"><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td  width="4%">&nbsp;</td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
    <div id="test"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="5" onkeypress="keyset('qty',event);" onblur="itno_ind();"   />
    </font></div>  </font></td>
    <td><a href="serach_item.php" onclick="NewWindow(this.href,'mywin','1000','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" />
    </a></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
    </font><a href="serach_item.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="rate" id="rate" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
      <input type="hidden" name="part_no" id="part_no" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" name="actual_selling" id="actual_selling" class="text_purchase3" onblur="calc1_table_ind();"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="10" name="qty" id="qty" value="" onblur="calc1_table_ind();" class="text_purchase3" onkeypress="keyset('discountperrow1',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="10" name="discountperrow1" id="discountperrow1" value="" class="text_purchase3" onkeypress="keyset('discountperrow2',event);" onblur="calc1_table_ind();"/>
      <input type="hidden" size="10" name="discountrow1" id="discountrow1" value="" disabled="disabled" class="txtbox" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="10" name="discountperrow2" id="discountperrow2" value="" class="text_purchase3" onkeypress="keyset('additem_tmp',event);" onblur="calc1_table_ind();"/><input type="hidden" size="15" name="discountrow2" id="discountrow2" value="" disabled class="txtbox" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="10" name="discountper" id="discountper" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('subtotal',event);"/>
      <input type="hidden" size="15" name="discount" id="discount" value="" disabled="disabled" class="txtbox" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="subtotal" id="subtotal" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onClick="add_tmp();" class="btn_purchase1"></td>
    </tr>
  <tr>
	<td colspan="10">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="10%"   background="" ><font color="#FFFFFF">Code</font></td>
                              											<td width="40%"  background=""><font color="#FFFFFF">Description</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Rate</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Qty</font></td>
                                                                        <td width="10%"  background=""><font color="#FFFFFF">Discount</font></td>
                                                                        <td width="10%"  background=""><font color="#FFFFFF">Sub Total</font></td>
                           											</tr>
		  </table>   </div>                                                 		</td>
	</tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td><input type="text" size="5" name="stklevel" id="stklevel" value="" class="text_purchase1"/></td>
    <td><input type="hidden" size="5" name="stk_vali" id="stk_vali" value="0" class="text_purchase1"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td>&nbsp;</td>
    <td><input type="text" size="15" name="subtot" id="subtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Credit Period" disabled="disabled"/>
    </span></td>
    <td>&nbsp;</td>
    <td><input type="text" size="5" name="credper" id="credper" value=""  class="text_purchase1"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td>&nbsp;</td>
    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="0" disabled="disabled"  class="text_purchase3" /></td>
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
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
    </span></td>
    <td>&nbsp;</td>
    <td><input type="text" size="15" name="tax" id="tax" value="0"  class="text_purchase3"  disabled="disabled" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="5"><div id="storgrid"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Invoice Total" disabled="disabled"/>
    </span></td>
    <td>&nbsp;</td>
    <td><input type="text" size="15" name="invtot"  id="invtot" value="0" disabled="disabled" class="text_purchase3"/></td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Note" disabled="disabled"/></td>
    <td colspan="4"><input type="text"  class="text_purchase4" value="" id="note" name="note" maxlength="50"/>
  </tr>
  <tr>
    <td>&nbsp;</td>
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