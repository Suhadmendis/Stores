<?php session_start();
?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Defective Report</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:16px;
            }
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                border:1px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:12px;

            }
            td
            {
                font-size:12px;
                border-bottom:thick;
                border-left:none;
                border-right:none;


            }
        </style>
        <style type="text/css">
            <!--
            .style1 {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }
            -->
        </style>
    </head>

    <body>
        <!-- Progress bar holder -->


        <?php
        
        if (($_GET["radio"] == "Option7") || ($_GET["radio"] == "Option9")) {
            //summery(); 
            invrecv();
        }
        if ($_GET["radio"] == "Option10") {
            invRecsAbstract();
        }
        if ($_GET["radio"] == "Option1") {
            invRec();
        }
        if ($_GET["radio"] == "Option2") {
            defrep();
        }
        if ($_GET["radio"] == "Option3") {
            if ($_GET["detailed"] == "on") {
                defall_detailed();
            } else {
                defall();
            }
        }
        if ($_GET["radio"] == "Option4") {
            //summery(); 
            summery2();
        }

        if ($_GET["radio"] == "Option5") {
            //summery(); 
            toapprove();
        }

        if ($_GET["radio"] == "Option6") {
            //summery(); 
            invrecs();
        }

        if ($_GET["radio"] == "Option8") {
            //summery(); 
            invRecrep();
        }

        function summery2() {


            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");



            $sql_invpara = "select * from invpara ";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);



            if ($_SESSION['company'] == "BEN") {
                $TXTHEAD = "BENEDICTSONS (PVT) LTD,. COMPLAINT TYRES/TUBES/ALLOY WHEELS REPORT";
                $rtxsumhead = "Benedictsons (Pvt) Ltd,. Complaint Report Summery";
            } else {
                $TXTHEAD = "TYRE HOUSE TRADING (PVT) LTD,. COMPLAINT TYRES/TUBES/ALLOY WHEELS/BATTERY REPORT";
                $rtxsumhead = "Tyre House Trading (Pvt) Ltd,. Complaint Report Summery";
            }
            $txtdrange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));
            $rtxdaterange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));

            echo "<center><table border=1 width=700 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Brand</b></td>";
            echo "<td colspan=2 ><b>MD</b></td>";
            echo "<td colspan=2><b>WD</b></td>";
            echo "<td colspan=2><b></b></td>";
            echo "<td colspan=2><b>Total</b></td>";
            echo "</tr>";

            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "</tr>";

            $qty_md = 0;
            $amount_md = 0;

            $qty_wd = 0;
            $amount_wd = 0;

            $qty_nill = 0;
            $amount_nill = 0;

            $qty_all = 0;
            $amount_all = 0;

            $sql = "SELECT distinct Brand from viewdef_trn where (SDATE>='" . $_GET["dtfrom"] . "') and  (SDATE<='" . $_GET["dtto"] . "') and REsult='COMMERCIAL CLAIM' and CANCELL='0' order by Brand ";
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {



                $sql_md = "SELECT sum(Expr1/(1+(vatrate/100))) as amt, count(*) as qty from viewdef_trn where (SDATE>='" . $_GET["dtfrom"] . "') and  (SDATE<='" . $_GET["dtto"] . "') and CANCELL='0' and Brand='" . $row["Brand"] . "' and approve_md_wd='MD' and REsult='COMMERCIAL CLAIM'";
                $result_md = $db->RunQuery($sql_md);
                $row_md = mysql_fetch_array($result_md);

                $sql_wd = "SELECT sum(Expr1/(1+(vatrate/100))) as amt, count(*) as qty from viewdef_trn where (SDATE>='" . $_GET["dtfrom"] . "') and  (SDATE<='" . $_GET["dtto"] . "') and CANCELL='0' and Brand='" . $row["Brand"] . "' and approve_md_wd='WD' and REsult='COMMERCIAL CLAIM'";
                $result_wd = $db->RunQuery($sql_wd);
                $row_wd = mysql_fetch_array($result_wd);

                $sql_nill = "SELECT sum(Expr1/(1+(vatrate/100))) as amt, count(*) as qty from viewdef_trn where (SDATE>='" . $_GET["dtfrom"] . "') and  (SDATE<='" . $_GET["dtto"] . "') and CANCELL='0' and Brand='" . $row["Brand"] . "' and (approve_md_wd!='MD' and approve_md_wd!='WD') and REsult='COMMERCIAL CLAIM'";
                $result_nill = $db->RunQuery($sql_nill);
                $row_nill = mysql_fetch_array($result_nill);

                $sql_all = "SELECT sum(Expr1/(1+(vatrate/100))) as amt, count(*) as qty from viewdef_trn where (SDATE>='" . $_GET["dtfrom"] . "') and  (SDATE<='" . $_GET["dtto"] . "') and CANCELL='0' and Brand='" . $row["Brand"] . "' and REsult='COMMERCIAL CLAIM'";
                $result_all = $db->RunQuery($sql_all);
                $row_all = mysql_fetch_array($result_all);

                //echo $row["Brand"]."/".$row_md["amt"]."/".$row_md["qty"]."</br>";
                echo "<tr align=center>";
                echo "<td align=left>" . $row["Brand"] . "</td>";
                echo "<td>" . number_format($row_md["amt"], 2, ".", ",") . "</td>";
                echo "<td>" . $row_md["qty"] . "</td>";
                echo "<td>" . number_format($row_wd["amt"], 2, ".", ",") . "</td>";
                echo "<td>" . $row_wd["qty"] . "</td>";
                echo "<td>" . number_format($row_nill["amt"], 2, ".", ",") . "</td>";
                echo "<td>" . $row_nill["qty"] . "</td>";
                echo "<td>" . number_format($row_all["amt"], 2, ".", ",") . "</td>";
                echo "<td>" . $row_all["qty"] . "</td>";
                echo "</tr>";

                $qty_md = $qty_md + $row_md["qty"];
                $amount_md = $amount_md + $row_md["amt"];

                $qty_wd = $qty_wd + $row_wd["qty"];
                $amount_wd = $amount_wd + $row_wd["amt"];

                $qty_nill = $qty_nill + $row_nill["qty"];
                $amount_nill = $amount_nill + $row_nill["amt"];

                $qty_all = $qty_all + $row_all["qty"];
                $amount_all = $amount_all + $row_all["amt"];
            }

            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td></td>";
            echo "<td align=right><b>" . number_format($amount_md, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($qty_md, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($amount_wd, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($qty_wd, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($amount_nill, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($qty_nill, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($amount_all, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($qty_all, 0, ".", ",") . "</b></td>";
            echo "</tr>";

            echo "</table>";
        }

        function summery() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            if ($_SESSION['company'] == "BEN") {
                $TXTHEAD = "BENEDICTSONS (PVT) LTD,. COMPLAINT TYRES/TUBES/ALLOY WHEELS REPORT";
                $rtxsumhead = "Benedictsons (Pvt) Ltd,. Complaint Report Summery";
            } else {
                $TXTHEAD = "TYRE HOUSE TRADING (PVT) LTD,. COMPLAINT TYRES/TUBES/ALLOY WHEELS/BATTERY REPORT";
                $rtxsumhead = "Tyre House Trading (Pvt) Ltd,. Complaint Report Summery";
            }
            $txtdrange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));
            $rtxdaterange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));


//Dim rst1 As New ADODB.Recordset 'total sum of amount & qty for non recommended claims commercialy approved
//Dim rst2 As New ADODB.Recordset 'total sum of amount & qty for non recommended claims rejected

            $a1 = 0;
            $a2 = 0;
            $a3 = 0;
            $q1 = 0;
            $q2 = 0;
            $q3 = 0;

            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Brand</b></td>";
            echo "<td colspan=2 ><b>WD</b></td>";
            echo "<td colspan=2><b>MD</b></td>";
            echo "<td colspan=2><b>Total</b></td>";
            echo "</tr>";

            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "</tr>";

            $rst1 = "Select distinct brand from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";

            $result_rst1 = $db->RunQuery($rst1);
            while ($row_rst1 = mysql_fetch_array($result_rst1)) {

                $rst_all = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand='" . $row_rst1["brand"] . "' ";

                $rst_wd = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand='" . $row_rst1["brand"] . "' and approve_md_wd='WD'";

                $rst_md = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand='" . $row_rst1["brand"] . "' and approve_md_wd='MD'";


                $result_all = $db->RunQuery($rst_all);
                $row_all = mysql_fetch_array($result_all);
                //echo $rst_wd;
                $result_wd = $db->RunQuery($rst_wd);
                $row_wd = mysql_fetch_array($result_wd);
                //echo $rst_md;
                $result_md = $db->RunQuery($rst_md);
                $row_md = mysql_fetch_array($result_md);

                echo "<tr align=center>";
                echo "<td align=left>" . $row_rst1["brand"] . "</td>";
                echo "<td>" . $row_wd["amount"] . "</td>";
                echo "<td>" . $row_wd["qty"] . "</td>";
                echo "<td>" . $row_md["amount"] . "</td>";
                echo "<td>" . $row_md["qty"] . "</td>";
                echo "<td>" . $row_all["amount"] . "</td>";
                echo "<td>" . $row_all["qty"] . "</td>";
                echo "</tr>";

                $qty_md = $qty_md + $row_wd["qty"];
                $amount_md = $amount_md + $row_wd["amount"];

                $qty_wd = $qty_wd + $row_wd["qty"];
                $amount_wd = $amount_wd + $row_wd["amount"];

                $qty_all = $qty_all + $row_all["qty"];
                $amount_all = $amount_all + $row_all["amount"];
            }



            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td></td>";
            echo "<td align=right><b>" . number_format($amount_wd, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($qty_wd, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($amount_md, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($qty_md, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($amount_all, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($qty_all, 0, ".", ",") . "</b></td>";
            echo "</tr>";

            echo "</table>";
        }

        function invRec() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $sql_invpara = "select * from invpara ";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);


            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT * from viewdef where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' order by STK_NO, c_code ";
                } else {
                    $sql = "SELECT * from viewdef where c_code= '" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' order by STK_NO, c_code ";
                }
            } else {

                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT * from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and  (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' order by STK_NO, c_code ";
                } else {
                    $sql = "SELECT * from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and c_code= '" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' order by STK_NO, c_code ";
                }
            }

            //echo $sql;


            if ($_GET["chkcus"] == "on") {
                $txtcus = $_GET["cusname"];
            }
            $txthead = "Defective Item Report From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To   " . date("Y-m-d", strtotime($_GET["dtto"]));



            /* 	$sql_head="select * from invpara";
              $result_head =$db->RunQuery($sql_head);
              $row_head = mysql_fetch_array($result_head); */

            echo "<center><span class=\"style1\">" . $txthead . "</span></center><br>";


            echo "<center>" . $txtcus . "</center><br>";



            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Stock No</b></td>";
            echo "<td><b>Description</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Dis</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Date</b></td>";
            echo "<td><b>Customer</b></td>";
            echo "</tr>";

            $STK_NO = "";
            $i = 0;
            $result_rsPrInv = $db->RunQuery($sql);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                if ($STK_NO != $row_rsPrInv["STK_NO"]) {
                    if ($i != 0) {
                        echo "<tr align=center>";
                        echo "<td>&nbsp;</td>";
                        echo "<td>&nbsp;</td>";
                        echo "<td align=right><b>" . $qty . "</b></td>";
                        echo "<td align=right><b>" . number_format($dis, 2, ".", ",") . "</b></td>";
                        echo "<td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td>";
                        echo "<td>&nbsp;</td>";
                        echo "<td>&nbsp;</td>";
                        echo "</tr>";

                        $qty = 0;
                        $dis = 0;
                        $AMOUNT = 0;
                    }

                    echo "<tr align=center>";
                    echo "<td align=left>" . $row_rsPrInv["STK_NO"] . "</td>";

                    $sql_mas = "select * from s_mas where STK_NO='" . $row_rsPrInv["STK_NO"] . "'";
                    $result_mas = $db->RunQuery($sql_mas);
                    $row_mas = mysql_fetch_array($result_mas);

                    echo "<td align=left>" . $row_mas["DESCRIPT"] . " " . $row_mas["PART_NO"] . " " . $row_mas["GEN_NO"] . " " . $row_mas["SUBSTITUTE"] . "</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td></td>";
                    echo "</tr>";

                    $STK_NO = $row_rsPrInv["STK_NO"];
                    $i = 1;
                }
                echo "<tr align=center>";
                echo "<td>&nbsp;</td>";
                echo "<td>&nbsp;</td>";
                echo "<td align=right>" . $row_rsPrInv["qty"] . "</td>";
                echo "<td align=right>" . $row_rsPrInv["dis"] . "</td>";
                echo "<td align=right>" . number_format($row_rsPrInv["amodef"], 2, ".", ",") . "</td>";
                echo "<td align=left>" . $row_rsPrInv["SDATE"] . "</td>";
                echo "<td  align=left>" . $row_rsPrInv["c_code"] . "-" . $row_rsPrInv["NAME"] . "</td>";
                echo "</tr>";

                $qty = $qty + $row_rsPrInv["qty"];
                $dis = $dis + $row_rsPrInv["dis"];
                $AMOUNT = $AMOUNT + $row_rsPrInv["amodef"];

                $qtytot = $qtytot + $row_rsPrInv["qty"];
                $distot = $distot + $row_rsPrInv["dis"];
                $AMOUNTtot = $AMOUNTtot + $row_rsPrInv["amodef"];

                //  Call PrintRep(m_Report, 57)
            }

            echo "<tr align=center>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td align=right><b>" . number_format($qtytot, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($distot, 2, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($AMOUNTtot, 2, ".", ",") . "</b></td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "</tr>";

            echo "</table>";
        }

        function invRecsAbstract() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $sql_invpara = "select * from invpara ";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);

            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT sum(qty) as qty,sum(amodef) as AMOUNT,brand_name from viewdef where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' "
                            . "group by brand_name order by brand_name ";
                } else {
                    $sql = "SELECT sum(qty) as qty,sum(amodef) as AMOUNT,brand_name from viewdef where c_code= '" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' "
                            . "group by brand_name order by brand_name ";
                }
            }

            //echo $sql;
            if ($_GET["chkcus"] == "on") {
                $txtcus = $_GET["cusname"];
            }
            $txthead = "Defective Item Report From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To   " . date("Y-m-d", strtotime($_GET["dtto"]));

            /* 	$sql_head="select * from invpara";
              $result_head =$db->RunQuery($sql_head);
              $row_head = mysql_fetch_array($result_head); */

            echo "<center><span class=\"style1\">" . $txthead . "</span></center><br>";
            echo "<center>" . $txtcus . "</center><br>";

            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Brand</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "</tr>";

            $qtytot = 0;
            $AMOUNTtot = 0;
            $result_rsPrInv = $db->RunQuery($sql);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {
                echo "<tr align=center>";
                echo "<td align=left><b>" . $row_rsPrInv["BRAND_NAME"] . "</b></td>";
                echo "<td align=right>" . number_format($row_rsPrInv["qty"], 0, ".", ",") . "</td>";
                echo "<td align=right>" . number_format($row_rsPrInv["AMOUNT"], 2, ".", ",") . "</td>";
                echo "</tr>";

                $qtytot = $qtytot + $row_rsPrInv["qty"];
                $AMOUNTtot = $AMOUNTtot + $row_rsPrInv["AMOUNT"];
            }

            echo "<tr align=center>";
            echo "<td><b>Total</b></td>";
            echo "<td align=right><b>" . number_format($qtytot, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($AMOUNTtot, 2, ".", ",") . "</b></td>";
            echo "</tr>";

            echo "</table>";
        }

        function invRecs() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $sql_invpara = "select * from invpara ";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);


            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT,brand_name from viewdef where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no,brand_name order by brand_name,STK_NO ";
                } else {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT,brand_name from viewdef where c_code= '" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no,brand_name order by brand_name,STK_NO ";
                }
            } else {

                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT,brand_name from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and  (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no,brand_name order by brand_name,STK_NO ";
                } else {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT,brand_name from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and c_code= '" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no,brand_name order by brand_name,STK_NO";
                }
            }

            //echo $sql;


            if ($_GET["chkcus"] == "on") {
                $txtcus = $_GET["cusname"];
            }
            $txthead = "Defective Item Report From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To   " . date("Y-m-d", strtotime($_GET["dtto"]));



            /* 	$sql_head="select * from invpara";
              $result_head =$db->RunQuery($sql_head);
              $row_head = mysql_fetch_array($result_head); */

            echo "<center><span class=\"style1\">" . $txthead . "</span></center><br>";


            echo "<center>" . $txtcus . "</center><br>";



            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Stock No</b></td>";
            echo "<td><b>Description</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "</tr>";

            $STK_NO = "";
            $i = 0;
            $result_rsPrInv = $db->RunQuery($sql);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                if (trim($brand) != trim($row_rsPrInv["BRAND_NAME"])) {
                    if ($brand != "") {
                        echo "<tr align=center>";
                        echo "<td>&nbsp;</td>";
                        echo "<td>&nbsp;</td>";
                        echo "<td align=right><b>" . number_format($qty, 0, ".", ",") . "</b></td>";
                        echo "<td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td>";
                        echo "</tr>";
                        $AMOUNT = 0;
                        $qty = 0;
                    }
                    echo "<tr>
		   <td align=\"left\" colspan=4><b>" . $row_rsPrInv["BRAND_NAME"] . "</b></td></tr>";
                    $brand = trim($row_rsPrInv["BRAND_NAME"]);
                }
                echo "<tr align=center>";
                echo "<td align=left>" . $row_rsPrInv["STK_NO"] . "</td>";

                $sql_mas = "select * from s_mas where STK_NO='" . $row_rsPrInv["STK_NO"] . "'";
                $result_mas = $db->RunQuery($sql_mas);
                $row_mas = mysql_fetch_array($result_mas);

                echo "<td align=left>" . $row_mas["DESCRIPT"] . " " . $row_mas["PART_NO"] . " " . $row_mas["GEN_NO"] . " " . $row_mas["SUBSTITUTE"] . "</td>";
                echo "<td align=right>" . $row_rsPrInv["qty"] . "</td>";

                echo "<td align=right>" . number_format($row_rsPrInv["AMOUNT"], 2, ".", ",") . "</td>";

                echo "</tr>";

                $qty = $qty + $row_rsPrInv["qty"];

                $AMOUNT = $AMOUNT + $row_rsPrInv["AMOUNT"];

                $qtytot = $qtytot + $row_rsPrInv["qty"];

                $AMOUNTtot = $AMOUNTtot + $row_rsPrInv["AMOUNT"];




                //  Call PrintRep(m_Report, 57)
            }
            echo "<tr align=center>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td align=right><b>" . number_format($qty, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td>";
            echo "</tr>";
            echo "<tr align=center>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td align=right><b>" . number_format($qtytot, 0, ".", ",") . "</b></td>";

            echo "<td align=right><b>" . number_format($AMOUNTtot, 2, ".", ",") . "</b></td>";

            echo "</tr>";

            echo "</table>";
        }

        function invRecv() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $sql_invpara = "select * from invpara ";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);


            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT c_code from viewdef where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by c_code order by c_code ";
                } else {
                    $sql = "SELECT c_code from viewdef where c_code= '" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by c_code order by c_code ";
                }
            } else {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT c_code from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and  (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by c_code order by c_code ";
                } else {
                    $sql = "SELECT c_code from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and c_code= '" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by c_code order by c_code";
                }
            }

            //echo $sql;


            if ($_GET["chkcus"] == "on") {
                $txtcus = $_GET["cusname"];
            }
            $txthead = "Defective Item Report From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To   " . date("Y-m-d", strtotime($_GET["dtto"]));



            /* 	$sql_head="select * from invpara";
              $result_head =$db->RunQuery($sql_head);
              $row_head = mysql_fetch_array($result_head); */

            echo "<center><span class=\"style1\">" . $txthead . "</span></center><br>";


            echo "<center>" . $txtcus . "</center><br>";



            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Stock No</b></td>";
            echo "<td><b>Description</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "</tr>";

            $STK_NO = "";
            $i = 0;
            $result_rsPrInv = $db->RunQuery($sql);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                if ($_GET["cmbbrand"] == "All") {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT from viewdef where c_code= '" . trim($row_rsPrInv['c_code']) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no order by STK_NO ";
                } else {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and c_code= '" . trim($row_rsPrInv['c_code']) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no order by STK_NO";
                }

                echo "<tr align=center>";
                echo "<th align=left>" . $row_rsPrInv["c_code"] . "</th>";
                $sqlv = "select * from vendor where code = '" . $row_rsPrInv["c_code"] . "'";
                $result_ven = $db->RunQuery($sqlv);
                if ($row_ven = mysql_fetch_array($result_ven)) {
                    if (($_GET["radio"] == "Option9")) {
                        echo "<th align=left>" . $row_ven["NAME"] . "</th>";
                    } else {
                        echo "<th colspan=3 align=left>" . $row_ven["NAME"] . "</th>";
                    }
                }

                if (($_GET["radio"] == "Option9")) {
                    if ($_GET["salefrom"] != "") {
                        $saleStart = $_GET["salefrom"];
                    } else {
                        $saleStart = $_GET["dtfrom"];
                    }

                    $sqls = "select sum(GRAND_TOT) as stot from s_salma
                         where sdate BETWEEN '" . $saleStart . "' and '" . $_GET["dtto"] .
                            "' and CANCELL = '0' and C_CODE= '" . $row_rsPrInv["c_code"] . "'";
                    $result_s = $db->RunQuery($sqls);
                    $row_s = mysql_fetch_array($result_s);
                    $saleTot = $row_s["stot"];
                    $totalSale += $saleTot;

                    echo "<th colspan align=left>Total sale from " . $saleStart . "</th>";
                    echo "<th colspan align=right>" . number_format($saleTot, 2, ".", ",") . "</th>";

                    $sqls = "select SUM(AMOUNT) as ctot from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  
                            and SDATE BETWEEN '" . $saleStart . "' AND '" . $_GET["dtto"] .
                            "' AND CUSCODE = '" . $row_rsPrInv["c_code"] . "'";
                    $result_s = $db->RunQuery($sqls);
                    $row_s = mysql_fetch_array($result_s);

                    $creditTot = $row_s["ctot"];
                    $totalCredit += $creditTot;
                    if ($saleTot != 0) {
                        $per = $creditTot / $saleTot * 100;
                    } else {
                        $per = 0;
                    }

                    echo "</tr><tr>";
                    echo "<th colspan=3 align=right>(" . number_format($per, 2, ".", ",") . "%) Credit Note Total from " . $saleStart . "</th>";
                    echo "<th colspan align=right>" . number_format($creditTot, 2, ".", ",") . "</th>";

                    $sqls = "select sum(AMOUNT) as grnTot from viewreturn where  CUSCODE='" . $row_rsPrInv["c_code"] . "' and   trn_type='GRN' and SDATE BETWEEN '" . $saleStart . "' AND '" . $_GET["dtto"] .
                            "' and DEV!='A' and ((REFNO like 'GRN/C%') or (REFNO like 'GRNC%'))";
                    $result_s = $db->RunQuery($sqls);
                    $row_s = mysql_fetch_array($result_s);

                    $grnTot = $row_s["grnTot"];
                    $totalGrn += $grnTot;
                    if ($saleTot != 0) {
                        $per = $grnTot / $saleTot * 100;
                    } else {
                        $per = 0;
                    }

                    echo "</tr><tr>";
                    echo "<th colspan=3 align=right>(" . number_format($per, 2, ".", ",") . "%) Goods Return Total from " . $saleStart . "</th>";
                    echo "<th colspan align=right>" . number_format($grnTot, 2, ".", ",") . "</th>";

                    $netSale = $saleTot - $creditTot - $grnTot;
                    echo "</tr><tr>";
                    echo "<th colspan=3 align=right>Net Sale from " . $saleStart . "</th>";
                    echo "<th colspan align=right>" . number_format($netSale, 2, ".", ",") . "</th>";
                }

                echo "</tr>";

                $qty = 0;
                $AMOUNT = 0;

                $result_rsPrInv1 = $db->RunQuery($sql);
                while ($row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1)) {

                    echo "<tr align=center>";
                    echo "<td align=left>" . $row_rsPrInv1["STK_NO"] . "</td>";

                    $sql_mas = "select * from s_mas where STK_NO='" . $row_rsPrInv1["STK_NO"] . "'";
                    $result_mas = $db->RunQuery($sql_mas);
                    $row_mas = mysql_fetch_array($result_mas);

                    echo "<td align=left>" . $row_mas["DESCRIPT"] . " " . $row_mas["PART_NO"] . " " . $row_mas["GEN_NO"] . " " . $row_mas["SUBSTITUTE"] . "</td>";
                    echo "<td align=right>" . $row_rsPrInv1["qty"] . "</td>";

                    echo "<td align=right>" . number_format($row_rsPrInv1["AMOUNT"], 2, ".", ",") . "</td>";

                    echo "</tr>";

                    $qty = $qty + $row_rsPrInv1["qty"];
                    $AMOUNT = $AMOUNT + $row_rsPrInv1["AMOUNT"];

                    $qtytot = $qtytot + $row_rsPrInv1["qty"];
                    $AMOUNTtot = $AMOUNTtot + $row_rsPrInv1["AMOUNT"];
                }


                echo "<tr align=center>";
                echo "<td>&nbsp;</td>";
                if (($_GET["radio"] == "Option9")) {
                    if ($netSale != 0) {
                        $per = $AMOUNT / $netSale * 100;
                    } else {
                        $per = 0;
                    }
                    echo "<td align=right><b>(" . number_format($per, 2, ".", ",") . "%)</b></td>";
                } else {
                    echo "<td>&nbsp;</td>";
                }
                echo "<td align=right><b>" . number_format($qty, 0, ".", ",") . "</b></td>";
                echo "<td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td>";
                echo "</tr>";
            }

            if ($_GET["chkcus"] != "on") {

                if (($_GET["radio"] == "Option9")) {
                    echo "<tr align=center>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td align=right><b>Total Sale</b></td>";
                    echo "<td align=right><b>" . number_format($totalSale, 2, ".", ",") . "</b></td>";
                    echo "</tr>";

                    if ($totalSale != 0) {
                        $per = $totalCredit / $totalSale * 100;
                    } else {
                        $per = 0;
                    }
                    echo "<tr align=center>";
                    echo "<td>&nbsp;</td>";
                    if (true) {
                        echo "<td><b>(" . number_format($per, 2, ".", ",") . "%)</b></td>";
                    } else {
                        echo "<td>&nbsp;</td>";
                    }
                    echo "<td align=right><b>Total Credit Note</b></td>";
                    echo "<td align=right><b>" . number_format($totalCredit, 2, ".", ",") . "</b></td>";
                    echo "</tr>";

                    if ($totalSale != 0) {
                        $per = $totalGrn / $totalSale * 100;
                    } else {
                        $per = 0;
                    }
                    echo "<tr align=center>";
                    echo "<td>&nbsp;</td>";
                    echo "<td><b>(" . number_format($per, 2, ".", ",") . "%)</b></td>";
                    echo "<td align=right><b>Total Goods Return</b></td>";
                    echo "<td align=right><b>" . number_format($totalGrn, 2, ".", ",") . "</b></td>";
                    echo "</tr>";

                    $finalNetSale = $totalSale - $totalCredit - $totalGrn;
                    echo "<tr align=center>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td align=right><b>NET SALE</b></td>";
                    echo "<td align=right><b>" . number_format($finalNetSale, 2, ".", ",") . "</b></td>";
                    echo "</tr>";

                    if ($finalNetSale != 0) {
                        $per = $AMOUNTtot / $finalNetSale * 100;
                    } else {
                        $per = 0;
                    }
                    echo "<tr align=center>";
                    echo "<td>&nbsp;</td>";
                    echo "<td align=right><b>(" . number_format($per, 2, ".", ",") . "%)Total Defective</b></td>";
                    echo "<td align=right><b>" . number_format($qtytot, 0, ".", ",") . "</b></td>";
                    echo "<td align=right><b>" . number_format($AMOUNTtot, 2, ".", ",") . "</b></td>";
                    echo

                    "</tr>";
                } else {
                    echo "<tr align=center>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td align=right><b>" . number_format($qtytot, 0, ".", ",") . "</b></td>";
                    echo "<td align=right><b>" . number_format($AMOUNTtot, 2, ".", ",") . "</b></td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        }

        function invRecrep() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector ( );


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $sql_invpara = "select * from invpara ";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);


            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT SAL_EX from viewdef where (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by SAL_EX order by SAL_EX ";
                } else {
                    $sql = "SELECT SAL_EX from viewdef where c_code= '" . trim($_GET ["cuscode"]) . "' and (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by SAL_EX order by SAL_EX ";
                }
            } else {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT SAL_EX from viewdef where BRAND_NAME='" . $_GET ["cmbbrand"] . "' and  (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by SAL_EX order by SAL_EX ";
                } else {
                    $sql = "SELECT SAL_EX from viewdef where BRAND_NAME='" . $_GET["cmbbrand"] . "' and c_code= '" . trim($_GET ["cuscode"]) . "' and (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by SAL_EX order by SAL_EX";
                }
            }

            //echo $sql;


            if ($_GET["chkcus"] == "on") {
                $txtcus = $_GET["cusname"];
            }
            $txthead = "Defective Item Report From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To   " . date("Y-m-d", strtotime($_GET["dtto"]));



            /* 	$sql_head="select * from invpara";
              $result_head =$db->RunQuery($sql_head);
              $row_head = mysql_fetch_array($result_head); */

            echo "<center><span class=\"style1\">" . $txthead . "</span></center><br>";


            echo "<center>" . $txtcus . "</center><br>";



            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Stock No</b></td>";
            echo "<td><b>Description</b></td>";
            echo "<td><b>Qty</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "</tr>";

            $STK_NO = "";
            $i = 0;
            $result_rsPrInv = $db->RunQuery($sql);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                if ($_GET["cmbbrand"] == "All") {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT from viewdef where SAL_EX= '" . trim($row_rsPrInv ['SAL_EX']) . "' and (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no order by STK_NO ";
                } else {
                    $sql = "SELECT stk_no,sum(qty) as qty,sum(amodef) as AMOUNT from viewdef where BRAND_NAME='" . $_GET ["cmbbrand"] . "' and SAL_EX= '" . trim($row_rsPrInv ['SAL_EX']) . "' and (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL = '0' group by stk_no order by STK_NO";
                }

                echo "<tr align=center>";
                echo "<th align=left>" . $row_rsPrInv["SAL_EX"] . "</th>";
                $sqlv = "select * from s_salrep where REPCODE = '" . $row_rsPrInv["SAL_EX"] . "'";
                $result_ven = $db->RunQuery($sqlv);
                if ($row_ven = mysql_fetch_array($result_ven)) {
                    echo "<th  colspan ='3' align=left>" . $row_ven["Name"] . "</th>";
                }

                echo "</tr>";

                $qty = 0;

                $AMOUNT = 0;




                $result_rsPrInv1 = $db->RunQuery($sql);
                while ($row_rsPrInv1 = mysql_fetch_array($result_rsPrInv1)) {

                    echo "<tr align=center>";
                    echo "<td align=left>" . $row_rsPrInv1["STK_NO"] . "</td>";

                    $sql_mas = "select * from s_mas where STK_NO='" . $row_rsPrInv1["STK_NO"] . "'";
                    $result_mas = $db->RunQuery($sql_mas);
                    $row_mas = mysql_fetch_array($result_mas);

                    echo "<td align=left>" . $row_mas["DESCRIPT"] . " " . $row_mas["PART_NO"] . " " . $row_mas["GEN_NO"] . " " . $row_mas["SUBSTITUTE"] . "</td>";
                    echo "<td align=right>" . $row_rsPrInv1["qty"] . "</td>";
                    echo "<td align=right>" . number_format($row_rsPrInv1["AMOUNT"], 2, ".", ",") . "</td>";

                    echo "</tr>";

                    $qty = $qty + $row_rsPrInv1["qty"];

                    $AMOUNT = $AMOUNT + $row_rsPrInv1["AMOUNT"];

                    $qtytot = $qtytot + $row_rsPrInv1["qty"];

                    $AMOUNTtot = $AMOUNTtot + $row_rsPrInv1["AMOUNT"];
                }

                echo "<tr align=center>";
                echo "<td>&nbsp;</td>";
                echo "<td>&nbsp;</td>";
                echo "<td align=right><b>" . number_format($qty, 0, ".", ",") . "</b></td>";
                echo "<td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td>";
                echo "</tr>";
            }
            echo "<tr align=center>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td align=right><b>" . number_format($qtytot, 0, ".", ",") . "</b></td>";
            echo "<td align=right><b>" . number_format($AMOUNTtot, 2, ".", ",") .
            "</b></td>";
            echo "</tr>";
            echo "</table>";
        }

        function defrep() {


            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector ( );

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");



            $sql_invpara = "select * from invpara ";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);

            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT * from viewdef_trn where (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL='0' order by ID ";
                } else {
                    $sql = "SELECT * from viewdef_trn where c_code= '" . trim($_GET ["cuscode"]) . "' and (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL='0' order by ID ";
                }
            } else {

                if ($_GET["chkcus"] != "on") {
                    $sql = "SELECT * from viewdef_trn where Brand ='" . $_GET ["cmbbrand"] . "' and  (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL='0' order by ID ";
                } else {
                    $sql = "SELECT * from viewdef_trn where Brand ='" . $_GET ["cmbbrand"] . "' and c_code= '" . trim($_GET["cuscode"] . Text) . "' and (SDATE='" . $_GET ["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and CANCELL='0' order by ID ";
                }
            }

            //  echo $sql;

            $result_rsPrInv = $db->RunQuery($sql);
            $row_rsPrInv = mysql_fetch_array($result_rsPrInv);


            if ($_GET["cmbbrand"] != "All") {
                if ($_GET ["chkcus"] == "on") {
                    $txtcus = $_GET["cusname"] . "   Brand   :" . $_GET ["cmbbrand"];
                } else {
                    $txtcus = "   Brand   :" . $_GET["cmbbrand"];
                }
            } else {
                if ($_GET["chkcus"] == "on") {
                    $txtcus = $_GET["cusname"];
                }
            }

            $TXTHEAD = "Defective Item Report From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To   " . date("Y-m-d", strtotime($_GET["dtto"]));



            $table = "<center><span class=\"style1\">" . $TXTHEAD . "</span></center><br>";


            $table .= "<center>" . $txtcus . "</center><br>";
            $table .= date("Y-m-d");



            $table .= "<center><table border=0 color=balck >";
            $table .= "<tr align=center bgcolor=#00aaaa>";
            $table .= "<td width=50 align=left><b>Date</b></td>";
            $table .= "<td width=50 align=left><b>Ref No</b></td>";
            $table .= "<td width=110 align=left><b>Bat No</b></td>";
            $table .= "<td width=120 align=left><b>Claim No</b></td>";
            $table .= "<td width=50 align=left><b>Code</b></td>";
            $table .= "<td width=50 align=left><b>Stk No</b></td>";
            $table .= "<td width=50 align=right><b>Net Amt</b></td>";
            $table .= "<td width=150 align=left><b>Result</b></td>";
            $table .= "<td width=350 align=left><b>Remarks</b></td>";
            $table .= "<td width=70 align=left><b>Approved</b></td>";
            // $table .=  "<td width=50 align=left><b>Ar No</b></td>";

            $table .= "</tr>";

            $SDATE = "";
            $i = 0;
            $netamt_tot = 0;
            $netamt_tot_grp = 0;
            $result_rsPrInv = $db->RunQuery($sql);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                if ($SDATE != $row_rsPrInv["SDATE"]) {
                    if ($i != 0) {
                        $table .= "<tr align=center>";
                        $table .= "<td colspan=6>&nbsp;</td>";
                        $table .= "<td align=right><b>" . number_format($netamt_tot, 2, ".", ",") . "</b></td>";
                        $table .= "<td colspan=4>&nbsp;</td>";
                        $table .= "</tr>";

                        $netamt_tot = 0;
                    }

                    $table .= "<tr align=center>";
                    $table .= "<td colspan=11></td>";

                    $table .= "</tr>";

                    $SDATE = $row_rsPrInv["SDATE"];
                    $i = 1;
                }

                $netamt = $row_rsPrInv["Expr1"] / (1 + ($row_rsPrInv["vatrate"] / 100 ) );

                $table .= "<tr align=center>";
                $table .= "<td>" . $row_rsPrInv["SDATE"] . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["REFNO"] . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["BAT_NO"] . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["CLAM_NO"] . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["c_code"] . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["STK_NO"] . "</td>";
                $table .= "<td align=right>" . number_format($netamt, 2, ".", ",") . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["REsult"] . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["Remarks"] . "</td>";
                $table .= "<td align=left>" . $row_rsPrInv["approve_md_wd"] . "</td>";
                //$table .=  "<td align=left>".$row_rsPrInv["arno"]."</td>";
                //$sql_wdmd="select * from c_clamas where  cl_no='".$row_rsPrInv["CLAM_NO"]."'";
                //$result_wdmd=$db->RunQuery($sql_wdmd);
                //  $row_wdmd = mysql_fetch_array($result_wdmd);	  



                $table .= "</tr>";

                $netamt_tot = $netamt_tot + $netamt;

                $netamt_tot_grp = $netamt_tot_grp + $netamt;


                //  Call PrintRep(m_Report, 57)
            }

            $table .= "<tr align=center>";
            $table .= "<td>&nbsp;</td>";
            $table .= "<td>&nbsp;</td>";
            $table .= "<td>&nbsp;</td>";
            $table .= "<td>&nbsp;</td>";
            $table .= "<td>&nbsp;</td>";
            $table .= "<td>&nbsp;</td>";
            $table .= "<td align=right><b>" . number_format($netamt_tot_grp, 2, ".", ",") . "</b></td>";

            $table .= "<td>&nbsp;</td>";
            $table .= "<td>&nbsp;</td>";
            $table .= "<td>&nbsp;</td>";


            $table .= "</tr>";

            $table .= "</table>";

            echo $table;

            $file = "report/rpt_defective.xls";

            $f = fopen($file, "w+");

            fwrite($f, $table);

            echo

            "<a href=\"report/rpt_defective.xls\">Download Excel Report</a>";
        }

        function defall_detailed() {

            require_once("config.inc.php");
            require_once("DBConnector.php" );
            $db = new DBConnector();



            if ($_GET["cmbbrand"] == "All") {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "'  ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET ["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended' and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET ["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET ["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET ["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                }
            }



            $sql_rsPrInv = $sql_rsPrInv . " order by brand, Refund desc, Commercialy desc, entdate";

            $result_rsPrInv = $db->RunQuery($sql_rsPrInv);
            $row_rsPrInv = mysql_fetch_array($result_rsPrInv);
//rsPrInv.Open rst

            $Text24 = "Amount";
            $Text25 = "Tyres";
            /* if ($_SESSION['company']=="BEN"){
              $TXTHEAD = "BENEDICTSONS (PVT) LTD,. COMPLAINT TYRES/TUBES/ALLOY WHEELS REPORT";
              $rtxsumhead = "Benedictsons (Pvt) Ltd,. Complaint Report Summery";
              } else {
              $TXTHEAD = "TYRE HOUSE TRADING (PVT) LTD,. COMPLAINT TYRES/TUBES/ALLOY WHEELS/BATTERY REPORT";
              $rtxsumhead = "Tyre House Trading (Pvt) Ltd,. Complaint Report Summery";
              } */ $txtdrange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));
            $rtxdaterange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));
            $Text21 = "Totals";

//Dim rst1 As New ADODB.Recordset 'total sum of amount & qty for non recommended claims commercialy approved
//Dim rst2 As New ADODB.Recordset 'total sum of amount & qty for non recommended claims rejected

            $a1 = 0;
            $a2 = 0;
            $a3 = 0;
            $q1 = 0;
            $q2 = 0;
            $q3 = 0;

            if ($_GET["cmbbrand"] == "All") {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                        }

                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }
                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }
                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $q1;
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            }

                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = number_format($a1, 2, ".", ",");
                            $Text18 = $q1;
                            $Text22 = number_format($a1, 2, ".", ",");
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                }

                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }

                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }

                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";

                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = ($q2 + q3);
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }

                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);

                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                    $Text19 = $q2;
                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }

                                    $result_rst2 = $db->RunQuery($rst2);
                                    $row_rst2 = mysql_fetch_array($result_rst2);

                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst2["qty"]) == false) {
                                        $q3 = $row_rst2["qty"];
                                    }
                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        if (trim($_GET["stkno"]) == "") {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                        } else {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        if (trim($_GET["stkno"]) == "") {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                        } else {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }
                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }
                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $row_rst["qty"];
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = $a1;
                            $Text18 = $q1;
                            $Text22 = $a1;
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                }

                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                if (trim($_GET["stkno"]) == "") {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                } else {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }
                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }
                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";
                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = $q2 + $q3;
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }

                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);

                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");

                                    $Text19 = $q2;

                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst2 = $db->RunQuery($rst2);
                                    $row_rst2 = mysql_fetch_array($result_rst2);
                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst2["qty"]) == false) {
                                        $q3 = $row_rst2["qty"];
                                    }
                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                }
            } else {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "'  ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        if (trim($_GET["stkno"]) == "") {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        if (trim($_GET["stkno"]) == "") {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }
                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }

                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $q1;
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = number_format($a1, 2, ".", ",");
                            $Text18 = $q1;
                            $Text22 = number_format($a1, 2, ".", ",");
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                if (trim($_GET["stkno"]) == "") {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }

                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }

                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";
                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = $q2 + $q3;
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);

                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                    $Text19 = $q2;
                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        if (trim($_GET["stkno"]) == "") {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        if (trim($_GET["stkno"]) == "") {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }

                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }

                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $q1;
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                            }
                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = number_format($a1, 2, ".", ",");
                            $Text18 = $q1;
                            $Text22 = number_format($a1, 2, ".", ",");
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                if (trim($_GET["stkno"]) == "") {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }
                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }
                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";
                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = $q2 + $q3;
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);
                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }

                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                    $Text19 = $q2;
                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst2 = $db->RunQuery($rst2);
                                    $row_rst2 = mysql_fetch_array($result_rst2);

                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst2["qty"]) == false) {
                                        $q3 = $row_rst2["qty"];
                                    }

                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                }
            }

            /* if ($_SESSION['company']=="BEN"){
              echo "<center><span class=\"style1\"><b><u>BENEDICTSONS (PVT) LTD - DEFECT ITEMS DETAIL REPORT</u></b></span></center><br>";
              } */

            echo "<center><span class=\"style1\">" . $txthead . "</span></center><br>";


            echo "<center>" . $txtdrange . "</center><br>";
            echo date("Y-m-d");



            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td width=50><b>Form #</b></td>";
            echo "<td width=50><b>Date</b></td>";
            echo "<td width=50><b>Claim #</b></td>";
            echo "<td width=50><b>Code</b></td>";
            echo "<td width=150><b>Name</b></td>";
            echo "<td width=50><b>Stk_No</b></td>";
            echo "<td width=150><b>Description</b></td>";
            echo "<td width=50><b>Serial_no</b></td>";
            echo "<td width=50><b>Batch No</b></td>";
            echo "<td width=250><b>Technical Observation</b></td>";
            echo "<td width=50><b>Remaining</b></td>";
            echo "<td width=50><b>Refund %</b></td>";
            echo "</tr>";

            $SDATE = "";
            $i = 0;
            $netamt_tot = 0;
            $netamt_tot_grp = 0;
//echo $sql_rsPrInv;
            $result_rsPrInv = $db->RunQuery($sql_rsPrInv);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

//echo "Brand-".$row_rsPrInv["brand"];
                if ($brand != $row_rsPrInv["brand"]) {

                    echo "<tr align=center bgcolor=#00bbaa>";
                    echo "<td align=left colspan=17><b>" . $row_rsPrInv["brand"] . "</b></td>";
                    echo "</tr>";
                    $brand = $row_rsPrInv["brand"];
                }

                if ($Refund != $row_rsPrInv["Refund"]) {


                    echo "<tr align=center>";
                    echo "<td align=left colspan=17><b>" . $row_rsPrInv["Refund"] . "</b></td>";


                    echo "</tr>";

                    $Refund = $row_rsPrInv ["Refund"];
                }

                if ($row_rsPrInv["Refund"] == "Not Recommended") {


                    if ($Commercialy != $row_rsPrInv["Commercialy"]) {

                        echo "<tr align=center>";
                        echo "<td>&nbsp;</td>";
                        if ($row_rsPrInv["Commercialy"] == "0") {
                            echo "<td align=left colspan=11 ><b>Not Allowed</b></td>";
                        } else {
                            echo "<td align=left colspan=11 ><b>Allowed on Commercial Value</b></td>";
                        }


                        echo "</tr>";
                    }
                }

                $Commercialy = $row_rsPrInv["Commercialy"];

                $ok = "1";
                /* 	if ($row_rsPrInv["Refund"]=="Recommended") {
                  if ($row_rsPrInv["DGRN_NO"]=="0"){
                  $ok="0";
                  } else {
                  $ok="1";
                  }
                  } else {
                  $ok="1";
                  } */

                if ($ok == "1") {
                    echo "<tr align=center>";
                    echo "<td align=left>" . $row_rsPrInv["refno"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["entdate"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["cl_no"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["ag_code"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["ag_name"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["stk_no"] . "</td>";

                    $sql_mas = "select * from s_mas where STK_NO='" . $row_rsPrInv["stk_no"] . "'";
                    $result_mas = $db->RunQuery($sql_mas);
                    $row_mas = mysql_fetch_array($result_mas);

                    echo "<td align=left>" . $row_mas["DESCRIPT"] . " " . $row_mas["PART_NO"] . " " . $row_mas["GEN_NO"] . " " . $row_mas ["SUBSTITUTE"] . "</td>";
                    echo "<td align=left colspan=2>" . $row_rsPrInv["seri_no"] . "</td>";

                    echo "<td align=left>" . trim($row_rsPrInv["tc_ob"]) . " / " . trim($row_rsPrInv["Mn_ob"]) . "</td>";
                    echo "<td align=left><table border=\"1\" width=\"200\">
      <tr>
        <td align=\"center\">" . $row_rsPrInv ["remin1"] . "</td>
        <td align=\"center\">" . $row_rsPrInv ["remin2"] . "</td>
        <td align=\"center\">" . $row_rsPrInv ["remin3"] . "</td>
        <td align=\"center\">" . $row_rsPrInv ["remin4"] . "</td>
      </tr>
     
      <tr>
        <td align=\"center\">" . $row_rsPrInv ["origin1"] . "</td>
        <td align=\"center\">" . $row_rsPrInv ["origin1"] . "</td>
        <td align=\"center\">" . $row_rsPrInv ["origin1"] . "</td>
        <td align=\"center\">" . $row_rsPrInv["origin1"] . "</td>
      </tr>
    </table></td>";
                    echo "<td align=left>" . $row_rsPrInv ["rem_per"] . "<br><br><b>" . number_format($row_rsPrInv["Amount"], 2, ".", ",") . "</b></td>";

                    echo "</tr>";

//$Amount=$Amount+$row_rsPrInv["Amount"];
                }



//  Call PrintRep(m_Report, 57)
            }

            echo "<tr align=center>";

            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo

            "</tr>";

            echo "</table>";



            echo "</br></br>";
        }

        function toapprove() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql_rsPrInv = "Select * from  c_clamas where DGRN_NO = '0' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' order by entdate ";



            echo "Date From : " . $_GET["dtfrom"] . " Date To : " . $_GET["dtto"];

            echo "<center><table border=1 width=1500 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td width=50><b>Form #</b></td>";
            echo "<td width=50><b>Date</b></td>";
            echo "<td width=50><b>Claim #</b></td>";
            echo "<td width=50><b>Code</b></td>";
            echo "<td width=150><b>Name</b></td>";
            echo "<td width=50><b>Stk_No</b></td>";
            echo "<td width=200><b>Description</b></td>";
            echo "<td width=50><b>Serial_no</b></td>";
            echo "<td width=120><b>Technical Observation</b></td>";
            echo "<td width=50><b>RTD</b></td>";
            echo "<td width=40><b>Amount</b></td>";
            echo "<td width=50><b>Appro: Signature</b></td>";

            echo "</tr>";

            $result_rsPrInv = $db->RunQuery($sql_rsPrInv);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {
                echo "<tr align=center>";
                echo "<td align=left>" . $row_rsPrInv ["refno"] . "</td>";
                echo "<td align=left>" . $row_rsPrInv ["entdate"] . "</td>";
                echo "<td align=left>" . $row_rsPrInv ["cl_no"] . "</td>";
                echo "<td align=left>" . $row_rsPrInv["ag_code"] . "</td>";
                echo "<td align=left>" . $row_rsPrInv ["ag_name"] . "</td>";
                echo "<td align=left>" . $row_rsPrInv ["stk_no"] . "</td>";
                $sql_mas = "select * from s_mas where STK_NO='" . $row_rsPrInv["stk_no"] . "'";
                $result_mas = $db->RunQuery($sql_mas);
                $row_mas = mysql_fetch_array($result_mas);

                echo "<td align=left>" . $row_mas["DESCRIPT"] . " " . $row_mas["PART_NO"] . " " . $row_mas["GEN_NO"] . " " . $row_mas["SUBSTITUTE"] . " " . $row_rsPrInv ["patt"] . "</td>";

                echo "<td align=left>" . $row_rsPrInv["seri_no"] . "</td>";

                echo "<td align=left>" . trim($row_rsPrInv["tc_ob"]) . " / " . trim($row_rsPrInv ["Mn_ob"]) . "</td>";
                echo "<td align=left>" . $row_rsPrInv["rem_per"] . "</td>";
                echo "<td align=right>" . $row_rsPrInv["Amount"] . "</td>";
                echo

                "<td align=right>&nbsp;</td>";

                echo "</tr>";
            }
        }

        function defall() {

            require_once("config.inc.php");
            require_once("DBConnector.php" );
            $db = new DBConnector();



            if ($_GET["cmbbrand"] == "All") {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "'  ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET ["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended' and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET ["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy > '0' and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and refund = 'Not Recommended' and commercialy = '0' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET ["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $sql_rsPrInv = "Select * from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy > '0' and brand = '" . trim($_GET ["cmbbrand"]) . "'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $sql_rsPrInv = "Select * from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                }
                            }
                        }
                    }
                }
            }



            $sql_rsPrInv = $sql_rsPrInv . " order by Refund desc, Commercialy desc, entdate";

            $result_rsPrInv = $db->RunQuery($sql_rsPrInv);
            $row_rsPrInv = mysql_fetch_array($result_rsPrInv);
//rsPrInv.Open rst

            $Text24 = "Amount";
            $Text25 = "Tyres";


            $txtdrange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));
            $rtxdaterange = "Date from " . " " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " to " . date("Y-m-d", strtotime($_GET["dtto"]));
            $Text21 = "Totals";

//Dim rst1 As New ADODB.Recordset 'total sum of amount & qty for non recommended claims commercialy approved
//Dim rst2 As New ADODB.Recordset 'total sum of amount & qty for non recommended claims rejected

            $a1 = 0;
            $a2 = 0;
            $a3 = 0;
            $q1 = 0;
            $q2 = 0;
            $q3 = 0;

            if ($_GET["cmbbrand"] == "All") {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                        }

                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }
                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }
                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $q1;
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            }

                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = number_format($a1, 2, ".", ",");
                            $Text18 = $q1;
                            $Text22 = number_format($a1, 2, ".", ",");
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                }

                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }

                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }

                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";

                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = ($q2 + q3);
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }

                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);

                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                    $Text19 = $q2;
                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }

                                    $result_rst2 = $db->RunQuery($rst2);
                                    $row_rst2 = mysql_fetch_array($result_rst2);

                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst2["qty"]) == false) {
                                        $q3 = $row_rst2["qty"];
                                    }
                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        if (trim($_GET["stkno"]) == "") {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                        } else {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        if (trim($_GET["stkno"]) == "") {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                        } else {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }
                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }
                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $row_rst["qty"];
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Recommended'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = $a1;
                            $Text18 = $q1;
                            $Text22 = $a1;
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                }

                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                if (trim($_GET["stkno"]) == "") {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                } else {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }
                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }
                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";
                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = $q2 + $q3;
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if ($_GET["cmb_approv"] == "All") {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' ";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    } else {
                                        if (trim($_GET["stkno"]) == "") {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "'";
                                        } else {
                                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0'  and approve_md_wd='" . $_GET["cmb_approv"] . "' and stk_no='" . $_GET["stkno"] . "' ";
                                        }
                                    }

                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);

                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");

                                    $Text19 = $q2;

                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst2 = $db->RunQuery($rst2);
                                    $row_rst2 = mysql_fetch_array($result_rst2);
                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst2["qty"]) == false) {
                                        $q3 = $row_rst2["qty"];
                                    }
                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                }
            } else {
                if (($_GET["chkcus"] == "on") and ( $_GET["cuscode"] != "")) {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "'  ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        if (trim($_GET["stkno"]) == "") {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        if (trim($_GET["stkno"]) == "") {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }
                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }

                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $q1;
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                            }
                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = number_format($a1, 2, ".", ",");
                            $Text18 = $q1;
                            $Text22 = number_format($a1, 2, ".", ",");
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                if (trim($_GET["stkno"]) == "") {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }

                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }

                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";
                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = $q2 + $q3;
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);

                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                    $Text19 = $q2;
                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where ag_code = '" . trim($_GET["cuscode"]) . "' and entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }
                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                } else {
                    if ($_GET["cmb_refund"] == "All") {
                        if (trim($_GET["stkno"]) == "") {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst = $db->RunQuery($rst);
                        $row_rst = mysql_fetch_array($result_rst);

                        if (trim($_GET["stkno"]) == "") {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst1 = $db->RunQuery($rst1);
                        $row_rst1 = mysql_fetch_array($result_rst1);

                        if (trim($_GET["stkno"]) == "") {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                        } else {
                            $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where  entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                        }
                        $result_rst2 = $db->RunQuery($rst2);
                        $row_rst2 = mysql_fetch_array($result_rst2);

                        if (is_null($row_rst["amount"]) == false) {
                            $a1 = $row_rst["amount"];
                        }
                        if (is_null($row_rst1["amount"]) == false) {
                            $a2 = $row_rst1["amount"];
                        }
                        if (is_null($row_rst2["amount"]) == false) {
                            $a3 = $row_rst2["amount"];
                        }

                        if (is_null($row_rst["qty"]) == false) {
                            $q1 = $row_rst["qty"];
                        }
                        if (is_null($row_rst1["qty"]) == false) {
                            $q2 = $row_rst1["qty"];
                        }
                        if (is_null($row_rst2["qty"]) == false) {
                            $q3 = $row_rst2["qty"];
                        }

                        $Text17 = "Recommended ";
                        $Text15 = "Not Recommended - Commercialy Allowed";
                        $Text16 = "Not Recommended";
                        $rtxrecamoun = number_format($a1, 2, ".", ",");
                        $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                        $Text18 = $q1;
                        $Text19 = $q2;
                        $Text20 = $q3;
                        $Text22 = number_format(($a1 + $a2), 2, ".", ",");
                        $Text23 = $q1 + $q2 + $q3;
                    } else {
                        if ($_GET["cmb_refund"] == "Recommended") {
                            if (trim($_GET["stkno"]) == "") {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                            } else {
                                $rst = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Recommended' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                            }
                            $result_rst = $db->RunQuery($rst);
                            $row_rst = mysql_fetch_array($result_rst);

                            if (is_null($row_rst["amount"]) == false) {
                                $a1 = $row_rst["amount"];
                            }
                            if (is_null($row_rst["qty"]) == false) {
                                $q1 = $row_rst["qty"];
                            }
                            $Text17 = "Recommended ";
                            $rtxrecamoun = number_format($a1, 2, ".", ",");
                            $Text18 = $q1;
                            $Text22 = number_format($a1, 2, ".", ",");
                            $Text23 = $q1;
                        } else {
                            if ($_GET ["cmb_notreco"] == "All") {
                                if (trim($_GET["stkno"]) == "") {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst1 = $db->RunQuery($rst1);
                                $row_rst1 = mysql_fetch_array($result_rst1);

                                if (trim($_GET["stkno"]) == "") {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                } else {
                                    $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                }
                                $result_rst2 = $db->RunQuery($rst2);
                                $row_rst2 = mysql_fetch_array($result_rst2);

                                if (is_null($row_rst1["amount"]) == false) {
                                    $a2 = $row_rst1["amount"];
                                }
                                if (is_null($row_rst2["amount"]) == false) {
                                    $a3 = $row_rst2["amount"];
                                }
                                if (is_null($row_rst1["qty"]) == false) {
                                    $q2 = $row_rst1["qty"];
                                }
                                if (is_null($row_rst2["qty"]) == false) {
                                    $q3 = $row_rst2["qty"];
                                }
                                $Text15 = "Not Recommended - Commercialy Allowed";
                                $Text16 = "Not Recommended";
                                $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                $Text19 = $q2;
                                $Text20 = $q3;
                                $Text22 = number_format($a2, 2, ".", ",");
                                $Text23 = $q2 + $q3;
                            } else {
                                if ($_GET["cmb_notreco"] == "Allowed") {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst1 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy > '0' and brand = '" . trim($_GET["cmbbrand"]) . "' and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst1 = $db->RunQuery($rst1);
                                    $row_rst1 = mysql_fetch_array($result_rst1);
                                    if (is_null($row_rst1["amount"]) == false) {
                                        $a2 = $row_rst1["amount"];
                                    }
                                    if (is_null($row_rst1["qty"]) == false) {
                                        $q2 = $row_rst1["qty"];
                                    }

                                    $Text15 = "Not Recommended - Commercialy Allowed";
                                    $RTXNRECAMOU = number_format($a2, 2, ".", ",");
                                    $Text19 = $q2;
                                    $Text22 = number_format($a2, 2, ".", ",");
                                    $Text23 = $q2;
                                } else {
                                    if (trim($_GET["stkno"]) == "") {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "' ";
                                    } else {
                                        $rst2 = "Select sum(Amount) as amount, sum(qty) as qty from  c_clamas where entdate >= '" . $_GET["dtfrom"] . "' and entdate <= '" . $_GET ["dtto"] . "' and Refund = 'Not Recommended' and Commercialy = '0' and brand = '" . trim($_GET["cmbbrand"]) . "'  and stk_no='" . $_GET["stkno"] . "' ";
                                    }
                                    $result_rst2 = $db->RunQuery($rst2);
                                    $row_rst2 = mysql_fetch_array($result_rst2);

                                    if (is_null($row_rst2["amount"]) == false) {
                                        $a3 = $row_rst2["amount"];
                                    }
                                    if (is_null($row_rst2["qty"]) == false) {
                                        $q3 = $row_rst2["qty"];
                                    }

                                    $Text16 = "Not Recommended";
                                    $Text20 = $q3;
                                    $Text23 = $q3;
                                }
                            }
                        }
                    }
                }
            }


            echo "<center><span class=\"style1\">" . $txthead . "</span></center><br>";


            echo "<center>" . $txtdrange . "</center><br>";
            echo date("Y-m-d");



            echo "<center><table border=1 width=1500 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td width=50><b>Form #</b></td>";
            echo "<td width=50><b>Date</b></td>";
            echo "<td width=50><b>Claim #</b></td>";
            echo "<td width=50><b>Code</b></td>";
            echo "<td width=150><b>Name</b></td>";
            echo "<td width=50><b>Stk_No</b></td>";
            echo "<td width=150><b>Description</b></td>";
// echo  "<td width=50><b>Serial_no</b></td>";
// echo  "<td width=50><b>Batch No</b></td>";
// echo  "<td width=200><b>Technical Observation</b></td>";
// echo  "<td width=50><b>RTD</b></td>";
            echo "<td width=50><b>DGRN_#</b></td>";
            echo "<td width=50><b>DGRN_#</b></td>";
            echo "<td width=50><b>Amount</b></td>";
//  echo  "<td width=50><b>Gate Pass Date</b></td>";
//  echo  "<td width=50><b>Return Date</b></td>";
//   echo  "<td width=50><b>Approved By WD/MD</b></td>";
            echo "</tr>";

            $SDATE = "";
            $i = 0;
            $netamt_tot = 0;
            $netamt_tot_grp = 0;
            $brand = "";
//echo $sql_rsPrInv;
            $result_rsPrInv = $db->RunQuery($sql_rsPrInv);
            while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)) {

                if ($brand != $row_rsPrInv["brand"]) {

                    echo "<tr align=center bgcolor=#00bbaa>";
                    echo "<td align=left colspan=10><b>" . $row_rsPrInv["brand"] . "</b></td>";
                    echo "</tr>";
                    $brand = $row_rsPrInv["brand"];
                }

                if ($Refund != $row_rsPrInv["Refund"]) {


                    echo "<tr align=center>";
                    echo "<td align=left colspan=10><b>" . $row_rsPrInv["Refund"] . "</b></td>";
                    echo "</tr>";

                    $Refund = $row_rsPrInv ["Refund"];
                }

                if ($row_rsPrInv["Refund"] == "Not Recommended") {


                    if ($Commercialy != $row_rsPrInv["Commercialy"]) {

                        echo "<tr align=center>";
                        echo "<td>&nbsp;</td>";
                        if ($row_rsPrInv["Commercialy"] == "0") {
                            echo "<td align=left colspan=9 ><b>Not Allowed</b></td>";
                        } else {
                            echo "<td align=left colspan=9 ><b>Allowed on Commercial Value</b></td>";
                        }


                        echo "</tr>";
                    }
                }

                $Commercialy = $row_rsPrInv["Commercialy"];

                $ok = "1";
                /* 	if ($row_rsPrInv["Refund"]=="Recommended") {
                  if ($row_rsPrInv["DGRN_NO"]=="0"){
                  $ok="0";
                  } else {
                  $ok="1";
                  }
                  } else {
                  $ok="1";
                  } */

                if ($ok == "1") {
                    echo "<tr align=center>";
                    echo "<td align=left>" . $row_rsPrInv["refno"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["entdate"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["cl_no"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["ag_code"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["ag_name"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["stk_no"] . "</td>";
//	echo  "<td align=left>".$row_rsPrInv["des"]."</td>";
                    $sql_mas = "select * from s_mas where STK_NO='" . $row_rsPrInv["stk_no"] . "'";
                    $result_mas = $db->RunQuery($sql_mas);
                    $row_mas = mysql_fetch_array($result_mas);

                    echo "<td align=left>" . $row_mas["DESCRIPT"] . " " . $row_mas["PART_NO"] . " " . $row_mas["GEN_NO"] . " " . $row_mas["SUBSTITUTE"] . " " . $row_rsPrInv["patt"] . "</td>";
//echo  "<td align=left colspan=2>".$row_rsPrInv["seri_no"]."</td>";
//echo  "<td align=left>".trim($row_rsPrInv["tc_ob"]) . " / " . trim($row_rsPrInv["Mn_ob"])."</td>";
//echo  "<td align=left>".$row_rsPrInv["rem_per"]."</td>";
                    echo "<td align=left>" . $row_rsPrInv["DGRN_NO"] . "</td>";
                    echo "<td align=left>" . $row_rsPrInv["DGRN_NO2"] . "</td>";
                    echo "<td align=right>" . $row_rsPrInv["Amount"] . "</td>";
                    /* 	if ($row_rsPrInv["gatepass"]=="0000-00-00"){
                      echo  "<td align=right></td>";
                      } else {
                      echo  "<td align=right>".$row_rsPrInv["gatepass"]."</td>";
                      }
                      if ($row_rsPrInv["returndate"]=="0000-00-00"){
                      echo  "<td align=right></td>";
                      } else {
                      echo  "<td align=right>".$row_rsPrInv["returndate"]."</td>";
                      }
                      if ($row_rsPrInv["approve_md_wd"]=="0000-00-00"){
                      echo  "<td align=right></td>";
                      } else {
                      echo  "<td align=right>".$row_rsPrInv["approve_md_wd"]."</td>";
                      } */
                    echo "</tr>";

                    $Amount = $Amount + $row_rsPrInv["Amount"];
                }



//  Call PrintRep(m_Report, 57)
            }

            echo "<tr align=center>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";


            echo "<td align=right><b>" . number_format($Amount, 2, ".", ",") . "</b></td>";

            echo "</tr>";

            echo "</table>";



            echo "</br></br>";

            echo "<table width=\"1000\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <th colspan=\"4\" scope=\"col\">" . $rtxsumhead . "</th>
    <th scope=\"col\">&nbsp;</th>
    <th scope=\"col\">&nbsp;</th>
  </tr>
  <tr>
    <td colspan=\"4\">" . $rtxdaterange . "</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>" . $Text24 . "</td>
    <td>" . $Text25 . "</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>" . $Text17 . "</td>
    <td>&nbsp;</td>
    <td>" . $rtxrecamoun . "</td>
    <td>" . $Text18 . "</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"2\">" . $Text15 . "</td>
    <td>" . $RTXNRECAMOU . "</td>
    <td>" . $Text19 . "</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>" . $Text16 . "</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>" . $Text20 . "</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>" . $Text21 . "</td>
    <td>&nbsp;</td>
    <td>" . $Text22 . "</td>
    <td>" . $Text23 . "</td>
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
  </tr>
  <tr>
    <td>" . $txtrepono . "</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>";
        }
        ?>
    </body>
</html>
