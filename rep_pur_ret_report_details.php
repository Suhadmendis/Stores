
<?php
/* if($_SESSION["login"]!="True")
  {
  header('Location:./index.php');
  } */




/* if($_SESSION["login"]!="True")
  {
  header('Location:./index.php');
  } */




require_once("config.inc.php");
require_once("DBConnector.php");

$sql = "delete FROM TMP_EDU_FILTER";
$db = new DBConnector();
$result = $db->RunQuery($sql);

$sql = "delete FROM	TMP_QUALI_FILTER";
$db = new DBConnector();
$result = $db->RunQuery($sql);
?>	





<script language="JavaScript" src="js/pur_ord.js"></script>
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
    var win = null;
    function NewWindow(mypage, myname, w, h, scroll, pos) {
        if (pos == "random") {
            LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
            TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
        }
        if (pos == "center") {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
        }
        else if ((pos != "center" && pos != "random") || pos == null) {
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
    window.onload = function() {
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

</label>

<style type="text/css">
    <!--
    .style1 {font-weight: bold}
    -->
</style>
<script type="text/javascript">
    function load_calader(tar) {
        new JsDatePick({
            useMode: 2,
            target: tar,
            dateFormat: "%Y-%m-%d"

        });

    }

</script>
<fieldset>
    <legend>
        <div class="text_forheader">Purchase Return Report</div>
    </legend>             

    <form id="form1" name="form1" action="report_pur_ret_details.php" target="_blank" method="get">
        <table border="0">



            <tr>

                <td></td> 
                <td></td>
                <td></td> 
                <td></td>
                <td></td> 
                <td></td>
            </tr>


            <tr>

                <td><input type="text" disabled="disabled" value="From" class="label_purchase"></td> 
                <td><input type="text"  onfocus="load_calader('DT1');" class="text_purchase3" id="DT1" name="DT1" globalnumber="334"></td>
                <td><input type="text" disabled="disabled" value="To" class="label_purchase"></td> 
                <td><input type="text"  onfocus="load_calader('DT2');" class="text_purchase3" id="DT2" name="DT2" globalnumber="334"></td>
                <td></td> 
                <td></td>
            </tr>





            <tr>
                <td colspan= '3' align="left"><input type="submit" class="btn_purchase1" value="View" id="button" name="button"></td>

                <td></td>
                <td></td> 
                <td></td>
            </tr>
        </table>


</fieldset>
</form>        



