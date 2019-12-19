
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
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
		});
		
	}

</script>

<style type="text/css">
<!--
.INV {color: #ff0000}

.CNT_INC {color: #0033FF}

.GRN {color: #00CC00}

.DGRN {color: #660033}
-->
</style>

</label>
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Sales Register Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td><select name="com_dep" id="com_dep" onkeypress="keyset('brand',event);" class="text_purchase3" disabled="disabled">
    		<option value='All'>All</option>
      <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="checkbox" name="chkcus" id="chkcus" />
      Customer</td>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td><input type="text" size="20" class="text_purchase3" name="txt_cuscode" id="txt_cuscode" onblur="custno_ind('');" onkeypress="keyset('department',event);"/></td>
    <td colspan="2">
      <input type="text" disabled="disabled"  class="text_purchase3" id="txt_cusname" name="txt_cusname" />
  </td>
    <td><a href="" onclick="NewWindow('serach_customer.php?stname=sal_reg','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" />
    </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td width="10%"><select name="Com_rep" id="Com_rep" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
    <option value='All'>All</option>
      <?php
																	$sql="select * from s_salrep where cancel='1' and REPCODE='".$_SESSION["sal_ex"]."' order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td width="10%"> <a href="search_grn.php?stname=grn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date From" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m")."-01"; ?>" onfocus="load_calader('dtfrom');" class="text_purchase3" disabled="disabled"/></td>
    <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      
    </a></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Date To" disabled="disabled"/></td>
    <td><input type="text" size="20" name="dtto" id="dtto" onfocus="load_calader('dtto');" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
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
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
  <table width="84%" border="0">
  
  
  <tr>
	<td colspan="6">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="10%"   background="" ><font color="#FFFFFF">Date</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Invoice No</font></td>
                              											<td width="40%"  background=""><font color="#FFFFFF">Customer</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Rep</font></td>
                                                                        <td width="10%"  background=""><font color="#FFFFFF">Total Pay</font></td>
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
  </tr>
  <tr>
    <td colspan="6"><table width="818" border="0">
      <tr>
        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Sales Total" disabled="disabled"/></th>
        <th width="120" scope="col"><input type="text" size="20" name="invtot" id="invtot"  value="" class="text_purchase3"/></th>
        <th width="167" scope="col"><input type="text"  class="label_purchase" value="Return Total" disabled="disabled"/></th>
        <th width="120" scope="col"><input type="text" size="20" name="rettot" id="rettot"  value="" class="text_purchase3"/></th>
        <th width="183" scope="col"><input type="text"  class="label_purchase" value="Paid Total" disabled="disabled"/></th>
        <th width="240" scope="col"><input type="text" size="20" name="paidtot" id="paidtot"  value="" class="text_purchase3"/></th>
      </tr>
    </table></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="40%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
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