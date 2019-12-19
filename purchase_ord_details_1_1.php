<?php
require_once("connectioni.php");

$_SESSION["insert"] = 0;
$_SESSION["update"] = 0;
?>	






<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>



<script language="javascript" type="text/javascript">
<!--
    /****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
     ****************************************************/
    var win = null;
    function NewWindow(mypage, myname, w, h, scroll, pos) {
        if (pos == "random") {
            LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
            TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
        }
        if (pos == "center") {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
        } else if ((pos != "center" && pos != "random") || pos == null) {
            LeftPosition = 0;
            TopPosition = 20
        }
        settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
        win = window.open(mypage, myname, settings);
    }
// -->
</script>

<script type="text/javascript">
    function openWin()
    {
        myWindow = window.open('serach_inv.php', '', 'width=200,height=100');
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

<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "dte_dor",
            dateFormat: "%Y-%m-%d"
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
        <div class="text_forheader">Enter Order Requisition</div>
    </legend>             

    <form name="form1" id="form1">            
        <table width="100%" border="0"  class=\"form-matrix-table\">
            <tr>
                <td width="10%"><input type="text"  class="label_purchase" value="Order No" disabled="disabled"/></td>
                <td width="10%"><input type="text" name="invno" id="invno" value="" class="text_purchase3" onkeypress="keyset('searchcust', event);"   onblur="purord_ind('ord');"  /></td>
                <td width="10%"><a href="search_purord_1_1.php?stname=ord" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');return false" onfocus="this.blur()">
                        <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
                    </a></td>
                <td width="10%"><input type="text"  class="label_purchase" value="Required Date" disabled="disabled"/></td>
                <td width="10%"><input type="text" size="20" name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('invdate');" class="text_purchase3"/></td>
                <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');return false" onfocus="this.blur()"></a></td>
                <td width="10%"><input type="text"  class="label_purchase" value="Schedule Date" disabled="disabled"/></td>
                <td width="10%"><input type="text" size="20" name="dte_shedule" id="dte_shedule" value="" class="text_purchase3"/>
                    <script type="text/javascript">
                        window.onload = function () {
                            new JsDatePick({
                                useMode: 2,
                                target: "dte_shedule",
                                dateFormat: "%Y-%m-%d"
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
                </td>
                <td width="10%">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="visibility: hidden;"><input type="text"  class="label_purchase" value="Supplier" disabled/></td>
                <td colspan="3" style="visibility: hidden;"><input type="text" class="text_purchase1" name="supplier_code" id="supplier_code" onblur="suppno_ind('purord');" onkeypress="keyset('salesrep', event);"/>
                    <input type="text" disabled="disabled"  class="text_purchase2" id="supplier_name" name="supplier_name" />
                    <a href="" onClick="NewWindow('serach_supplier.php?stname=purord', 'mywin', '800', '700', 'yes', 'center');return false" onFocus="this.blur()">
                        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
                    </a></td>
                <td><input type="text"  class="label_purchase" value="LC No" disabled/></td>
                <td><input type="text" size="15" name="lc_no" id="lc_no" value=""  class="text_purchase3" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="visibility: hidden;"><input type="text"  class="label_purchase" value="Address" disabled/></td>
                <td colspan="2" style="visibility: hidden;"><input type="text"  class="text_purchase4"  disabled="disabled" id="address" name="address" /></td>
                <td>&nbsp;</td>
                <td style="visibility: hidden;"><input type="text"  class="label_purchase" value="PI No" disabled="disabled"/></td>
                <td style="visibility: hidden;"><input type="text" size="15" name="pi_no" id="pi_no" value=""  class="text_purchase3" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><label>
                        <input type="text"  class="label_purchase" value="Department" disabled="disabled"/>
                    </label></td>
                <td><label>
                        <select name="department" id="department" onkeypress="keyset('brand', event);" onchange="setord();" class="text_purchase3">
                            <?php
                            $sql = "select * from s_stomas order by CODE";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row["CODE"] . "'>" . $row["CODE"] . " " . $row["DESCRIPTION"] . "</option>";
                            }
                            ?>
                        </select>
                    </label></td>
                <td><label></label></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
                <td><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor', event);" onchange="setord();" class="text_purchase3">
                        <?php
                        $sql = "select * from s_salrep where cancel='1' order by REPCODE";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                        }
                        ?>
                    </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="hidden"  class="label_purchase" value="Brand" disabled="disabled"/></td>
                <td style="visibility: hidden"><select name="brand" id="brand" onkeypress="keyset('searchitem', event);" class="text_purchase3"  onchange="assignbrandsession();">
                        <?php
                        $sql = "select * from brand_mas order by barnd_name";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                        }
                        ?>
                    </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Remark" disabled="disabled"/></td>
                <td colspan="2"><input type="text"  class="text_purchase4"  id="remarks" name="remarks" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="visibility:hidden;">
                <td bgcolor="#00CCCC"><label>
                        <input type="radio" name="vatgroup" value="vat" id="vatgroup_0" onchange="setMinus()"/>
                    VAT Invoice</label></td>
                <td bgcolor="#00CCCC"><label>
                        <input type="radio" name="vatgroup" value="non" id="vatgroup_1" checked="" onchange="setMinus()"/>
                    Non VAT Invoice</label></td>
                <td bgcolor="#00CCCC"><label>
                    <input type="radio" name="vatgroup" value="svat" id="vatgroup_2" onchange="setMinus()"/>
                    SVAT Invoice</label></td>
                <td>&nbsp;</td>
            </tr>            
        </table>


        <br/>   
        <fieldset>               

            <legend><div class="text_forheader">Item Details</div></legend>            

            <table width="84%" border="0">
                <tr>
                    <td width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Code" disabled/>
                        </span></td>
                    <td  width="40%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Description" disabled/>
                        </span></td>
                    <td  width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Part No" disabled/>
                        </span></td>
                    <td  width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Qty" disabled/>
                        </span></td>
                        <td  width="10%"><span class="style1">
                            <input type="text"  class="label_purchase" value="Cost" disabled/>
                        </span></td>
                </tr>
                <tr>
                    <td><font color="#FFFFFF">
                        <div id="test"><font color="#FFFFFF">
                            <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="10"  onkeypress="keyset('qty', event);"/>
                            </font></div>  </font></td>
                    <td><font color="#FFFFFF">
                        <input type="text"  class="text_purchase6" size="40" id="itemd" name="itemd" onkeypress="keyset('rate', event);" />
                        </font><!--<a href="serach_item_purord.php" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');return false" onFocus="this.blur()"><input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" ></a>--></td>
                    <td><font color="#FFFFFF">
                        <input type="text" size="15" name="partno" id="partno" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty', event);"/>
                        </font></td>
                    <td><font color="#FFFFFF">
                        <input type="text" size="15" name="qty" id="qty" value="" class="text_purchase3"  onKeyPress="keyset('cost', event);"/>
                        </font></td>
                    <td><font color="#FFFFFF">
                        <input type="text" size="15" name="cost" id="cost" value="0" class="text_purchase3"  onKeyPress="keyset('additem_tmp', event);"/>
                        </font></td>
                    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onClick="add_tmp();" class="btn_purchase1"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="CSSTableGenerator" id="itemdetails" >
                            <table>
                                <tr>
                                    <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
                                    <td width="40%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                                    <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Part No</font></td>
                                    <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
                                </tr>
                            </table>   </div>                                                 		</td>
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
                    <td colspan="2" rowspan="5"><div id="storgrid"></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>


    </form>        

</fieldset>    




<script>
new_inv();
</script>                
