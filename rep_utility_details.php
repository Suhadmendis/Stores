
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

						 
	


<script language="JavaScript" src="js/outstand.js"></script>
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
			target:"dte_shedule",
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
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Utility Report</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_utility.php" target="_blank" method="get">
<table width="767" border="0">
  
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Type" disabled="disabled"/></td>
    <td align="left"><select name="cmdtype" id="cmdtype" onkeypress="keyset('dte_dor',event);" onchange="custno('cash_rec_rep');" class="text_purchase3">
      <option value='All'>All</option>
      <option value='Invoice'>Invoice</option>
      <option value='Return Cheque'>Return Cheque</option>
      <option value='Cash'>Cash</option>
     
    </select></td>
    <td><select name="cmdtype1" id="cmdtype1" onkeypress="keyset('dte_dor',event);" onchange="custno('cash_rec_rep');" class="text_purchase3">
      <option value='All'>All</option>
      <option value='GRN'>GRN</option>
      <option value='DGRN'>DGRN</option>
      <option value='Credit Note'>Credit Note</option>
      <option value='Credit Note - SVAT'>Credit Note - SVAT</option>
     
    </select></td>
    <td><select name="cmbdev" id="cmbdev" onkeypress="keyset('dte_dor',event);" onchange="custno('cash_rec_rep');" class="text_purchase3">
    <?php
      if ($_SESSION['dev']=="1"){
	  	echo "<option value='ALL'>ALL</option>
      	<option value='Manual'>Van Sale</option>
      	<option value='Computer'>Office Sale</option>";
	  } else {
	  	echo "<option value='ALL'>ALL</option>";
	  }	
	 ?> 
    </select></td>
  </tr>
  
  <tr>
    <td align="left"><p>
    
        <input type="radio" name="radio"  value="optdaly" id="optdaly" onclick="utility_chk();" />
        Daily
      <label>        </label>
      <br />
    </p></td>
    <td align="left"><input type="radio" name="radio" checked="checked" value="optperiod" id="optperiod" onclick="utility_chk();"/>
      Period</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/>
      <select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onchange="custno('cash_rec_rep');" class="text_purchase3">
      		<option value='All'>All</option>
        <?php
																	$sql="select * from s_salrep where cancel='1' order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
      </select></td>
    <td align="left"><input type="checkbox" name="chkappro" id="chkappro" />
      <input type="text"  class="label_purchase" value="Credit Note To Approval" disabled="disabled"/></td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="145" align="left"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="186" align="left"><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtfrom');" class="text_purchase3" /></td>
    <td width="209" align="left"><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtto');" class="text_purchase3" /></td>
    <td width="209" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          