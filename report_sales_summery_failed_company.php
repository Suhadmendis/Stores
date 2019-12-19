<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sales Summery</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
            }
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {

                font-family:Arial, Helvetica, sans-serif;
                padding:4px;
            }
            th
            {
                font-weight:bold;
                font-size:12px;

            }
            td
            {
                font-size:12px;
                border-bottom:  none;
                border-top:  none;
            }
            .topbor {
                border-top: none;
                border-bottom: none;
                border-right: 1px solid ;
            }

            .topbor1 {
                border-bottom: 0.5px dotted #000000 ;
            }
        </style>
        <style type="text/css">
            <!--
            .style1 {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }
            <!--
            .style2 {
                color: #0000FF;
                font-weight: bold;
                font-size: 20px;
            }

            -->
        </style>
    </head>

    <body>
        <!-- Progress bar holder -->


        <?php
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();






        //  if ($_GET["cmbdev"] == "All") {
        $GLOBALS[$sysdiv] = "A";
        //    }
        /*   if ($_GET["cmbdev"] == "Computer") {
          $GLOBALS[$sysdiv] = "1";
          }
          if ($_GET["cmbdev"] == "Manual") {
          $GLOBALS[$sysdiv] = "0";
          } */

        if ($_GET["radio"] == "optsales") {
            PrintRep1();
        }
        if ($_GET["radio"] == "optscrap") {
            printscrap();
        }
        if ($_GET["radio"] == "optreturn") {
            if ($_GET["cmbtype"] == "All") {
                Printret();
            }
            if ($_GET["cmbtype"] == "GRN") {
                grnsummery();
            }
            if ($_GET["cmbtype"] == "Credit Note") {
                crnsummery();
            }
            if ($_GET["cmbtype"] == "DGRN") {
                Dgrnsummery();
            }
        }
        if ($_GET["radio"] == "optreceipt") {
            recieptrep();
        }

        if (($_GET["radio"] == "optsalcan") || ($_GET["radio"] == "radio7")) {
            PrintRepC();
        }


        if ($_GET["radio"] == "opttyfit") {
            $opt = "tyre";
            PrintRepfit($opt);
        }
        if ($_GET["radio"] == "optbat") {
            $opt = "bat";
            PrintRepfit($opt);
        }
        if ($_GET["radio"] == "opttyfitg") {
            $opt = "tyre";
            PrintRepfitg($opt);
        }

        if ($_GET["radio"] == "optbatsum") {
            $opt = "bat";
            PrintRepfitg($opt);
        }

        if ($_GET["radio"] == "optsummery") {
            if ($_GET["cmbsummerytype"] == "All") {
                summeryrep();
            }
            if ($_GET["cmbsummerytype"] == "Seperate") {
                summerysprte();
            }
            if ($_GET["cmbsummerytype"] == "Deffective") {
                summer_defect();
            }
        }
        if ($_GET["radio"] == "optitem") {
            item_sales();
        }

        if ($_GET["radio"] == "optgrninv") {
            grnwinv();
        }


        if ($_GET["radio"] == "optcuswise") {
            print_cuswise();
        }

        if ($_GET["radio"] == "optdaily") {
            print_daily();
        }

        function print_daily() {

            $d1 = $_GET["dtfrom"];
            $d2 = $_GET["dtto"];
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();
            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            $stt = "<center><h3>" . $row_head["COMPANY"] . "</h3></center><br>";
            $stt = "<center><h3>Daily Sales</h3></center>";
            $stt .= "<center><h4>Form " . $d1 . " To " . $d2 . " </h4></center>";
            $stt .= "<center><table border='1'>";
            $stt .="<tr><th width='200'>Date</th><th width='120'>Day</th>"
                    . "<th  width='160'>Sale</th>"
                    . "<th  width='160'>Vat</th>";
            $stt .= "</tr>";

            $tot = 0;
            $dt1 = $d1;
            $tot1 = 0;
            $diff = (strtotime($d2) - strtotime($d1));
            $days = floor($diff / (60 * 60 * 24));


            for ($i = 0; $i <= $days; $i++) {

                $sql_sal = "select sum(grand_tot) as sales,sum(grand_tot/(1 +gst/100)) as sales1 from s_salma  where sdate ='" . $dt1 . "' and CANCELL='0' ";
                $result_invo = $db->RunQuery($sql_sal);
                while ($row_result_invo = mysql_fetch_array($result_invo)) {
                    $msale = $row_result_invo['sales1'];
                }

                $sql_ret = "select sum(Amount) as salesret from C_bal where  sdate ='" . $dt1 . "' and  TRN_TYPE<>'REC'and TRN_TYPE<>'DGRN' and TRN_TYPE<>'ARN' AND TRN_TYPE<>'INC' AND  TRN_TYPE<>'PAY'";
                $result_ret = $db->RunQuery($sql_ret);
                while ($row_result_ret = mysql_fetch_array($result_ret)) {
                    $msale1 = $row_result_ret['salesret'];
                }

                $stt .= "<tr>";

                $stt .="<td>" . date('d-M-Y', strtotime($dt1)) . "</td>";
                $stt .="<td>" . date('D', strtotime($dt1)) . "</td>";
                $stt .="<td align='right'>" . number_format(($msale - $msale1) / 1.12, "2", ".", ".") . "</td>";
                $vat = ($msale - $msale1 - (($msale - $msale1) / 1.12));
                $stt .="<td align='right'>" . number_format(($vat / 1.12), "2", ".", ".") . "</td>";
                $tot = $tot + ($msale);
                $tot1 = $tot1 + ($msale1);
                $stt .= "</tr>";

                $dt1 = date("Y-m-d", strtotime($dt1));
                $caldays = " + 1 day";
                $dt1 = date('Y-m-d', strtotime($dt1 . $caldays));
            }
            $stt .= "<tr>";

            $stt .="<td></td>";
            $stt .="<td></td>";
            $stt .="<td align='right'>" . number_format(($tot - $tot1) / 1.12, "2", ".", ".") . "</td>";
            $vat = ($tot - $tot1 - (($tot - $tot1) / 1.12));
            $stt .="<td align='right'>" . number_format(($tot1 / 1.12), "2", ".", ".") . "</td>";
            $stt .= "</tr>";
            $stt .= "</table>";

            echo $stt;
        }

        function print_cuswise() {

            $d1 = $_GET["dtfrom"];
            $d2 = $_GET["dtto"];
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();
            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            $stt = "<center><h3>" . $row_head["COMPANY"] . "</h3></center><br>";
            $stt = "<center><h3>Customer Wise Sales</h3></center>";
            $stt .= "<center><h4>Form " . $d1 . " To " . $d2 . " </h4></center>";
            $stt .= "<center><table border='1'>";
            $stt .="<tr><th width='500'>Dealer</th>"
                    . "<th  width='200'>Sale</th>";
            $stt .= "</tr>";

            $tot = 0;

            $sql = "update vendor set opbal=0";
            $result = $db->RunQuery($sql);

            $sql_sal = "select sum(grand_tot) as sales,c_code from s_salma  where sdate >='" . $d1 . "'  and sdate <='" . $d2 . "'  and CANCELL='0' group by c_code ";
            $result_invo = $db->RunQuery($sql_sal);
            while ($row_result_invo = mysql_fetch_array($result_invo)) {
                $msale = $row_result_invo['sales'];
                $sql = "update vendor set opbal = '" . $msale . "' where code = '" . $row_result_invo['c_code'] . "'";
                $result = $db->RunQuery($sql);
            }
            $sql_ret = "select sum(Amount) as salesret,cuscode from C_bal where  sdate >='" . $d1 . "'  and sdate <='" . $d2 . "'  and TRN_TYPE<>'REC'and TRN_TYPE<>'DGRN' and TRN_TYPE<>'ARN' AND TRN_TYPE<>'INC' AND  TRN_TYPE<>'PAY' group by cuscode";

            $result_ret = $db->RunQuery($sql_ret);
            while ($row_result_ret = mysql_fetch_array($result_ret)) {
                $msale = $row_result_ret['salesret'];
                $sql = "update vendor set opbal = opbal - '" . $msale . "' where code = '" . $row_result_invo['c_code'] . "'";
                $result = $db->RunQuery($sql);
            }


            $sql = "select * from vendor where opbal <> '0' order by opbal desc";

            $result_mas = $db->RunQuery($sql);
            while ($row_result_mas = mysql_fetch_array($result_mas)) {

                $stt .= "<tr>";
                $stt .="<td>" . $row_result_mas['CODE'] . "-" . $row_result_mas['NAME'] . "</td>";
                $stt .="<td align='right'>" . number_format(($row_result_mas['OPBAL']), "2", ".", ",") . "</td>";
                $tot = $tot + ($row_result_mas['OPBAL']);
                $stt .= "</tr>";
            }

            $stt .= "</table>";

            echo $stt;
        }

        function PrintRepC() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            $heading = "Cancelled Invoice Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));

            if ($_GET["chkcus"] != "on") {
                if (($_GET["radio"] == "optsalcan")) {
                    $sql = "SELECT * from s_salma where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='1'  order by id";
                } else {
//                    $sql = "SELECT s.SDATE AS SDATE,s.REF_NO AS REF_NO,s.C_CODE AS C_CODE,s.CUS_NAME AS CUS_NAME,s.TYPE AS TYPE,s.cre_pe AS cre_pe,s.GRAND_TOT AS GRAND_TOT,s.GST AS GST,l.sdate AS CDATE from s_salma AS s,entry_log as l  where s.REF_NO=l.refno and l.sdate>='" . $_GET["dtfrom"] . "' and l.sdate <='" . $_GET["dtto"] . "' and s.DEV<>'" . $GLOBALS[$sysdiv] . "'and s.CANCELL='1' and l.trnType='Cancel' and l.docname='Invoice' order by l.sdate,s.REF_NO";
                    $sql = "SELECT s.SDATE AS SDATE,s.REF_NO AS REF_NO,s.C_CODE AS C_CODE,s.CUS_NAME AS CUS_NAME,s.TYPE AS TYPE,s.cre_pe AS cre_pe,s.GRAND_TOT AS GRAND_TOT,s.GST AS GST,s.use_name AS use_name,l.sdate AS CDATE from s_salma AS s,entry_log as l  where s.REF_NO=l.refno and l.sdate>='" . $_GET["dtfrom"] . "' and l.sdate <='" . $_GET["dtto"] . "' and s.DEV<>'" . $GLOBALS[$sysdiv] . "'and s.CANCELL='1' and l.trnType='Cancel' and l.docname='Invoice' order by s.REF_NO";
//                    $heading .= " (Based on Invoiced Cancelled Date)";
                }
            } else {
                if (($_GET["radio"] == "optsalcan")) {
                    $sql = "SELECT * from s_salma where c_code= '" . trim($_GET["cuscode"]) . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='1'  order by id";
                } else {
//                    $sql = "SELECT s.SDATE AS SDATE,s.REF_NO AS REF_NO,s.C_CODE AS C_CODE,s.CUS_NAME AS CUS_NAME,s.TYPE AS TYPE,s.cre_pe AS cre_pe,s.GRAND_TOT AS GRAND_TOT,s.GST AS GST,l.sdate AS CDATE from s_salma AS s,entry_log as l  where s.REF_NO=l.refno and c_code= '" . trim($_GET["cuscode"]) . "' and l.sdate>='" . $_GET["dtfrom"] . "' and l.sdate <='" . $_GET["dtto"] . "' and s.DEV<>'" . $GLOBALS[$sysdiv] . "'and s.CANCELL='1' and l.trnType='Cancel' and l.docname='Invoice' order by l.sdate,s.REF_NO";
                    $sql = "SELECT s.SDATE AS SDATE,s.REF_NO AS REF_NO,s.C_CODE AS C_CODE,s.CUS_NAME AS CUS_NAME,s.TYPE AS TYPE,s.cre_pe AS cre_pe,s.GRAND_TOT AS GRAND_TOT,s.GST AS GST,s.use_name AS use_name,l.sdate AS CDATE from s_salma AS s,entry_log as l  where s.REF_NO=l.refno and c_code= '" . trim($_GET["cuscode"]) . "' and l.sdate>='" . $_GET["dtfrom"] . "' and l.sdate <='" . $_GET["dtto"] . "' and s.DEV<>'" . $GLOBALS[$sysdiv] . "'and s.CANCELL='1' and l.trnType='Cancel' and l.docname='Invoice' order by s.REF_NO";
//                    $heading .= " (Based on Invoiced Cancelled Date)";
                }
            }

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>" . $heading . "</center><br>";
            if ($_GET["chkcus"] == "on") {
                $txtcus = $_GET["cusname"];
            }
            echo "<center>" . $txtcus . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>";
            if (($_GET["radio"] == "radio7")) {
                echo "<th>Entered By</th>";                
                echo "<th>Canceled Date</th>";
            }
            echo "<th>Customer</th>
		<th>Type</th>
		<th>Cr. Days</th>
		<th>Gross Amount</th>
		</tr>";
            //echo $sql;
            $totgross = 0;
            $totvat = 0;
            $totnet = 0;


            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {

                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>";

                if (($_GET["radio"] == "radio7")) {
                    echo "<td>" . $row["use_name"] . "</td>";                    
                    echo "<td><b>" . $row["CDATE"] . "</b></td>";
                }

                echo "<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
			<td>" . $row["TYPE"] . "</td>
			<td align=\"right\">" . $row["cre_pe"] . "</td>
			<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                $vat = $row["GRAND_TOT"] - $net;


                echo "</tr>";

                $totgross = $totgross + $row["GRAND_TOT"];
                $totvat = $totvat + $vat;
                $totnet = $totnet + $net;
            }
            if (($_GET["radio"] == "optsalcan")) {
                echo "<tr><th colspan=5></th>";
            } else {
                echo "<tr><th colspan=7></th>";
            }
            echo"<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th></tr>";
        }

/////////// Sales Summery////////////////////////////////////////
        function PrintRep1() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if ($_GET["radio"] == "optsales") {
                
                $phrase = " company = '" .$_SESSION["company"]. "' and ";
                
                if ($_GET["chk_svat"] != "on") {
                    if ($_GET["chkcus"] == "on") {
                        //echo "cmbrep ".$_GET["cmbrep"]."/ CmbBrand ".$_GET["CmbBrand"]."/ radio2 ".$_GET["radio2"];
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' order by  id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'    order by  id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'    order by  id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                            $sql = "SELECT * from s_salma where  $phrase SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'    order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   order by  id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'    order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   order by  id";
                        }
                    } else {
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by  id";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'    order by  id";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'    order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   order by  id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by  id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and CANCELL='0' order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'   order by  id";
                        }
                    }
                } else {
                    if ($_GET["chkcus"] == "on") {

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by  id";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'  order by  id";
                            //echo $sql;
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0'  order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0'  order by  id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by  id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by  REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  and SVAT > '0' order by id";
                        }
                    } else {

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  and SVAT > '0' order by id";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by id";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  and SVAT > '0' order by REF_NO";
                        }

                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  and SVAT > '0' order by id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            // $sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by id";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and SVAT > '0' order by REF_NO";
                            $sql = "SELECT * from s_salma where $phrase SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   and SVAT > '0' order by REF_NO";
                        }

                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            //$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0' and SVAT > '0' order by id";
                            $sql = "SELECT * from s_salma where $phrase (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'   and SVAT > '0' order by id";
                        }
                    }
                }
            }

            if ($_GET["chk_discount"] == "on") {
                dis_sales();
            } else {
                if ($_GET["chk_svat"] != "on") {
                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                        $heading = "Sales Summery Report with " . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                    }

                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optperiod")) {
                        $heading = "Sales Summery Report with " . $_GET["txt_disper"] . " Discount From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                    }
                } else {
                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                        $heading = "S.V.A.T. Sales Summery Report with " . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                    }

                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optperiod")) {
                        $heading = "S.V.A.T. Sales Summery Report with " . $_GET["txt_disper"] . " Discount From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                    }
                }

                if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optdaily")) {
                    $heading = "Sales Return Summery Report with " . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                }

                if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optperiod")) {
                    $heading = "Sales Return Summery Report with " . $_GET["txt_disper"] . " Discount From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                }

                $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
                $result_head = $db->RunQuery($sql_head);
                $row_head = mysql_fetch_array($result_head);

                echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
                echo $sql;

                echo "<center>" . $heading . "</center><br>";

                echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>
		<th>Entered By</th>
		<th width=100>DA No</th>
		<th>Customer</th>
		<th>Type</th>
		<th>Cr. Days</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";
                //echo $sql;
                $totgross = 0;
                $totvat = 0;
                $totnet = 0;

                $txt = "";

                /////////// Company A
                /*
                if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "C")) {
                    echo "<tr><td colspan=7><b>Company A</b></td></tr>";
                    $result = $db->RunQuery($sql);
                    while ($row = mysql_fetch_array($result)) {

                        if (substr($row["REF_NO"], 0, 1) == "P" or $row["company"] == "A") {

                            echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td>" . $row["use_name"] . "</td>
			<td>" . $row["dele_no"] . "</td>
			<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
			<td>" . $row["TYPE"] . "</td>
			<td align=\"right\">" . $row["cre_pe"] . "</td>";

                            if ($row["CANCELL"] == "0") {
                                echo "<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                                $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                                $vat = $row["GRAND_TOT"] - $net;

                                echo "<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($net, 2, ".", ",") . "</td>";
                                $txt = $txt . $row["REF_NO"] . "," . $row["SDATE"] . "," . $row["C_CODE"] . "," . $row["CUS_NAME"] . "," . $row["GRAND_TOT"] . "\n";
                            } else {
                                echo "<td align=\"right\">-</td><td align=\"right\">-</td>
			<td align=\"right\">-</td>";
                            }

                            echo "</tr>";
                            if ($row["CANCELL"] == "0") {
                                $totgross = $totgross + $row["GRAND_TOT"];
                                $totvat = $totvat + $vat;
                                $totnet = $totnet + $net;
                            }
                        }
                    }

                    echo "<tr>
			<th colspan=7></th>
			
			<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($totvat, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></th>
			</tr>";

                    $grand_gross = $totgross;
                    $grand_totvat = $totvat;
                    $grand_totnet = $totnet;
                }

                /////////// Company R

                if (($_SESSION['COMCODE'] == "R") or ( $_SESSION['COMCODE'] == "C")) {
                    $totgross = 0;
                    $totvat = 0;
                    $totnet = 0;

                    echo "<tr><td colspan=7><b>Company R</b></td></tr>";
                    $result = $db->RunQuery($sql);
                    while ($row = mysql_fetch_array($result)) {

                        if (substr($row["REF_NO"], 0, 1) == "R" or $row["company"] == "R") {

                            echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
                        <td>" . $row["use_name"] . "</td>    
			<td>" . $row["dele_no"] . "</td>
			<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
			<td>" . $row["TYPE"] . "</td>
			<td align=\"right\">" . $row["cre_pe"] . "</td>";

                            if ($row["CANCELL"] == "0") {
                                echo "<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                                $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                                $vat = $row["GRAND_TOT"] - $net;

                                echo "<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($net, 2, ".", ",") . "</td>";
                                $txt = $txt . $row["REF_NO"] . "," . $row["SDATE"] . "," . $row["C_CODE"] . "," . $row["CUS_NAME"] . "," . $row["GRAND_TOT"] . "\n";
                            } else {
                                echo "<td align=\"right\">-</td><td align=\"right\">-</td>
			<td align=\"right\">-</td>";
                            }

                            echo "</tr>";
                            if ($row["CANCELL"] == "0") {
                                $totgross = $totgross + $row["GRAND_TOT"];
                                $totvat = $totvat + $vat;
                                $totnet = $totnet + $net;
                            }
                        }
                    }

                    echo "<tr>
			<th colspan=7></th>
			
			<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($totvat, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></th>
			</tr>";

                    $grand_gross += $totgross;
                    $grand_totvat += $totvat;
                    $grand_totnet += $totnet;
                }


                /////////// Company B
                if (($_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "C")) {
                    $totgross = 0;
                    $totvat = 0;
                    $totnet = 0;

                    echo "<tr><td colspan=7><b>Company B</b></td></tr>";
                    $result = $db->RunQuery($sql);
                    while ($row = mysql_fetch_array($result)) {

                        if (substr($row["REF_NO"], 0, 1) == "T" or $row["company"] == "B") {
                            echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
                        <td>" . $row["use_name"] . "</td>
			<td>" . $row["dele_no"] . "</td>
			<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
			<td>" . $row["TYPE"] . "</td>
			<td align=\"right\">" . $row["cre_pe"] . "</td>";

                            if ($row["CANCELL"] == "0") {
                                echo "<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                                $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                                $vat = $row["GRAND_TOT"] - $net;

                                //    echo "<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
                                echo "<td align=\"right\"></td>
			<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                                $txt = $txt . $row["REF_NO"] . "," . $row["SDATE"] . "," . $row["C_CODE"] . "," . $row["CUS_NAME"] . "," . $row["GRAND_TOT"] . "\n";
                            } else {
                                echo "<td align=\"right\">-</td><td align=\"right\">-</td>
			<td align=\"right\">-</td>";
                            }


                            echo "</tr>";

                            if ($row["CANCELL"] == "0") {
                                $totgross = $totgross + $row["GRAND_TOT"];
                                $totvat = $totvat + $vat;
                                $totnet = $totnet + $net;
                            }
                        }
                    }

                    echo "<tr>
			<th colspan=7></th>
			
			<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b></b></th>
			<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th>
			</tr>";


                    $grand_gross = $grand_gross + $totgross;
                    $grand_totnet = $grand_totnet + $totgross;
                }
                */
                /////////Company C 

//                if ($_SESSION['COMCODE'] == "C") {
                if (true) {

                    $totgross = 0;
                    $totvat = 0;
                    $totnet = 0;
//                    echo $sql;
                    //echo "<tr><td colspan=7><b>Company C</b></td></tr>";
                    $result = $db->RunQuery($sql);
                    while ($row = mysql_fetch_array($result)) {

                        //if (substr($row["REF_NO"], 0, 1) == "X" or $row["company"] == "C") {
                            echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
                        <td>" . $row["use_name"] . "</td>
			<td>" . $row["dele_no"] . "</td>
			<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
			<td>" . $row["TYPE"] . "</td>
			<td align=\"right\">" . $row["cre_pe"] . "</td>";
                            if ($row["CANCELL"] == "0") {
                                echo "<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                                $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                                $vat = $row["GRAND_TOT"] - $net;

                                //echo "<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
                                echo "<td align=\"right\"></td>
			<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";
                                $txt = $txt . $row["REF_NO"] . "," . $row["SDATE"] . "," . $row["C_CODE"] . "," . $row["CUS_NAME"] . "," . $row["GRAND_TOT"] . "\n";
                            } else {
                                echo "<td align=\"right\">-</td><td align=\"right\">-</td>
			<td align=\"right\">-</td>";
                            }

                            echo "</tr>";

                            if ($row["CANCELL"] == "0") {
                                $totgross = $totgross + $row["GRAND_TOT"];
                                $totvat = $totvat + $vat;
                                $totnet = $totnet + $net;
                            }
                        //}
                    }

                    echo "<tr>
			<th colspan=7></th>
			
			<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b></b></th>
			<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th>
			</tr>";

                    $grand_gross = $grand_gross + $totgross;
                    $grand_totnet = $grand_totnet + $totgross;
                }
                echo "<tr>
			<th colspan=7></th>
			
			<th align=\"right\"><b>" . number_format($grand_gross, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($grand_totvat, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($grand_totnet, 2, ".", ",") . "</b></th>
			</tr>";
                echo "<table>";
            }

            $myfile = fopen("txt/salessummery.txt", "w") or die("Unable to open file!");
            fwrite($myfile, $txt);
            fclose($myfile);

            echo "<a href=\"txt/salessummery.txt\"><strong>Sales Summery txt file</strong></a>";
        }

        function dis_sales() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] = "optperiod")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and  CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and  CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where  DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }

            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                $heading = "Sales Summery Report(  " . $_GET["txt_disper"] . " % Discount)  On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optperiod")) {
                $heading = "Sales Summery Report   " . $_GET["txt_disper"] . " % Discount) From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optdaily")) {
                $heading = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optperiod")) {
                $heading = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
        }

//////////// Scrap //////////////////////////////////////
        function printscrap() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if ($_GET["radio"] == "optscrap") {
                if ($_GET["chk_svat"] != "on") {
                    if ($_GET["chkcus"] == "on") {
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] = "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] = "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                    } else {
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] = "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0' order by id";
                        }
                    }
                } else {

                    if ($_GET["chkcus"] == "true") {
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                    } else {
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                    }
                }
            }

            if ($_GET["chk_discount"] == "on") {
                dis_sales();
            } else {
                if ($_GET["chk_svat"] != "on") {
                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                        $heading = "Sales Summery Report with " . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                    }
                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                        $heading = "Sales Summery Report with" . $_GET["txt_disper"] . " Discount From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                    }
                } else {
                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                        $heading = "S.V.A.T. Sales Summery Report with" . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                    }
                    if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                        $heading = "S.V.A.T. Sales Summery Report with" . $_GET["txt_disper"] . " Discount From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                    }
                }
                if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optdaily")) {
                    $heading = "Sales Return Summery Report with" . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                }
                if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optdaily")) {
                    $heading = "Sales Return Summery Report with" . $_GET["txt_disper"] . " Discount From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                }
            }



            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>
		<th>Customer</th>
		<th>Cr. Days</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";
            //echo $sql;
            $totgross = 0;
            $totvat = 0;
            $totnet = 0;

            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
			<td align=\"right\">" . $row["cre_pe"] . "</td>
			<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                $vat = $row["GRAND_TOT"] - $net;

                echo "<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($net, 2, ".", ",") . "</td>
			</tr>";

                $totgross = $totgross + $row["GRAND_TOT"];
                $totvat = $totvat + $vat;
                $totnet = $totnet + $net;
            }

            echo "<tr>
			<td colspan=4>" . $row["SDATE"] . "</td>
			
			<td align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totvat, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></td>
			</tr>";

            echo "<table>";
        }

        function Printret() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if ($_GET["radio"] == "optreturn") {
                if ($_GET["chkcus"] == "on") {
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='INC' and   trn_type!='REC' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                    }
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and   trn_type!='ARN' and   trn_type!='INC' and CUSCODE ='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'    ";
                    }
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='INC' and   trn_type!='REC' and brand='" . $_GET["CmbBrand"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and  (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "' and CUSCODE ='" . $_GET["cuscode"] . "'  ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and   trn_type!='ARN' and   trn_type!='REC' and trn_type!='INC' and sal_ex ='" . $_GET["cmbrep"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and   trn_type!='ARN'  and  trn_type!='INC' and sal_ex ='" . $_GET["cmbrep"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC'and brand='" . $_GET["CmbBrand"] . "'and sal_ex =" . $_GET["cmbrep"] . " and CUSCODE ='" . $_GET["cuscode"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and  trn_type!='ARN'  and  trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "' and sal_ex ='" . $_GET["cmbrep"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'   ";
                    }
                } else {
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and DEV!='" . $GLOBALS[$sysdiv] . "'   ";
                    }
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "'and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "'and   trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "'   ";
                    }
                    if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and   trn_type!='REC' and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "'and  trn_type!='ARN' and    trn_type!='INC'and   trn_type!='REC' and sal_ex ='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and sal_ex ='" . $_GET["cmbrep"] . " 'and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "' and    trn_type!='REC'AND  sal_ex =" . $_GET["cmbrep"] . "and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                    if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and   trn_type!='REC' and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "'and sal_ex ='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  ";
                    }
                }
            }

            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                $heading = "Sales Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optperiod")) {
                $heading = "Sales Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optdaily")) {
                $heading = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optperiod")) {
                $heading = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
            $txtremark = "Sales By    " . $_GET["cmbrep"] . "   Brand  :  " . $_GET["CmbBrand"];

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";
            echo "<center>" . $txtremark . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";

            $refcode_new = "GRN/" . $_SESSION['COMCODE'];
            $refcode_old = "GRN" . $_SESSION['COMCODE'];

            if ($_SESSION['COMCODE'] == "C") {
                $sql = $sql . "  order by brand, id";
            } else {
                $sql = $sql . " and ((REFNO like '" . $refcode_new . "%') or (REFNO like '" . $refcode_old . "%') or (REFNO like 'CRN%') or (REFNO like 'BDRN%')) order by brand, id";
            }
//             echo $sql;
            $i = 0;
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {

                if ($row["brand"] != $brand) {
                    if ($i == 1) {
                        echo "<tr><td colspan=3>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($VAT_VAL, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($GRAND_TOT, 2, ".", ",") . "</b></td></tr>";
                        echo "<tr><th colspan=7 align=left><b>" . $row["brand"] . "</b></th></tr>";
                        $AMOUNT = 0;
                        $grand = 0;
                        $vat = 0;
                        $VAT_VAL = 0;
                        $GRAND_TOT = 0;
                    } else {

                        echo "<tr><th colspan=7 align=left><b>" . $row["brand"] . "</b></th></tr>";
                        $i = 1;
                        $AMOUNT = 0;
                        $grand = 0;
                        $vat = 0;
                        $VAT_VAL = 0;
                        $GRAND_TOT = 0;
                    }
                }

                $AMOUNT = $AMOUNT + $row["AMOUNT"];

                $grand = $row["AMOUNT"] / (1 + ($row["vatrate"] / 100 ));
                $GRAND_TOT = $GRAND_TOT + $grand;

                $vat = $row["AMOUNT"] - $grand;
                $VAT_VAL = $VAT_VAL + $vat;

                $tAMOUNT = $tAMOUNT + $row["AMOUNT"];

                $tgrand = $row["AMOUNT"] / (1 + ($row["vatrate"] / 100 ));
                $tGRAND_TOT = $tGRAND_TOT + $tgrand;

                $tvat = $row["AMOUNT"] - $tgrand;
                $tVAT_VAL = $tVAT_VAL + $tvat;


                echo "<tr>
				<td>" . $row["SDATE"] . "</td>
				<td>" . $row["REFNO"] . "</td>";
                $sql_cus = "Select * from vendor where CODE='" . $row["CUSCODE"] . "'";
                $result_cus = $db->RunQuery($sql_cus);
                $row_cus = mysql_fetch_array($result_cus);

                echo "<td>" . $row["CUSCODE"] . " " . $row_cus["NAME"] . "</td>
				<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($grand, 2, ".", ",") . "</td>
				</tr>";
                $brand = $row["brand"];
            }
            echo "<tr><td colspan=3>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($VAT_VAL, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($GRAND_TOT, 2, ".", ",") . "</b></td></tr>";
            echo "<tr><td colspan=3>&nbsp;</td><td align=\"right\"><b>" . number_format($tAMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($tVAT_VAL, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($tGRAND_TOT, 2, ".", ",") . "</b></td></tr>";

            echo "<table>";
        }

        function grnsummery() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if ($_GET["chk_svat"] != "on") {
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and    trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }

                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }

                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }

                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }
            } else {
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and    trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }

                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }

                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] = "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0' ";
                }
            }

            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Sales Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";


            if ($_SESSION['COMCODE'] != "C") {
                $refcode_new = "GRN/" . $_SESSION['COMCODE'];
                $refcode_old = "GRN" . $_SESSION['COMCODE'];
                $strsql = $strsql . " and ((REFNO like '" . $refcode_new . "%') or (REFNO like '" . $refcode_old . "%'))";
            }


            $strsql = $strsql . " order by brand";
//            echo $strsql;
            $br = "";
            $AMOUNT = 0;
            $SVAT = 0;
            $BALANCE = 0;

            $status = 0;

            $result = $db->RunQuery($strsql);
            while ($row = mysql_fetch_array($result)) {

                if ($br != $row["brand"]) {
                    if ($status != 0) {
                        echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
					</tr>";
                    }

                    echo "<tr>
				<th colspan=\"6\" align=\"left\"><b>" . $row["brand"] . "</b></th>
				</tr>";
                    $br = $row["brand"];
                    $AMOUNT = 0;
                    $SVAT = 0;
                    $BALANCE = 0;

                    $status = 1;
                }
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REFNO"] . "</td>
			<td>" . $row["CUSCODE"] . " " . $row["NAME"] . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100)), 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"] / (1 + ($row["vatrate"] / 100 )), 2, ".", ",") . "</td>
			</tr>";

                $bal = 0;
                $sql_cbal = "select * from c_bal where REFNO='" . $row["REFNO"] . "'";
                $result_cbal = $db->RunQuery($sql_cbal);
                if ($row_cbal = mysql_fetch_array($result_cbal)) {
                    if ($row_cbal["BALANCE"] > 0) {
                        $bal = (-1 * $row_cbal["BALANCE"]);
                        $txt = $txt . $row["REFNO"] . "," . $row["SDATE"] . "," . $row["CUSCODE"] . "," . $bal . "," . $row["NAME"] . "\n";
                    }
                }



                $AMOUNT = $AMOUNT + $row["AMOUNT"];
                $SVAT = $SVAT + $row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100));
                $BALANCE = $BALANCE + $row["AMOUNT"] - ($row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100)));

                $tAMOUNT = $tAMOUNT + $row["AMOUNT"];
                $tSVAT = $tSVAT + $row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100));
                $tBALANCE = $tBALANCE + $row["AMOUNT"] - ($row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100)));
            }

            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
				</tr>";
            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($tAMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($tSVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($tBALANCE, 2, ".", ",") . "</b></td>
				</tr>";
            echo "<table>";

            $myfile = fopen("txt/grnsummery.txt", "w") or die("Unable to open file!");
            fwrite($myfile, $txt);
            fclose($myfile);

            echo "<a href=\"txt/grnsummery.txt\"><strong>GRN Summery txt file</strong></a>";
        }

//////
        function crnsummery() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if ($_GET["chk_cash"] != "on") {
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and(trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }

                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno";
                }
            } else {

                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and flag1 = '1' order by refno ";
                }

                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and(trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }

                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and flag1 = '1' order by refno ";
                }

                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
            }

            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optsales") and ( $_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Sales Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ( $_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";

            //$strsql=$strsql." order by brand";
            //echo $strsql;
            $br = "";
            $AMOUNT = 0;
            $SVAT = 0;
            $BALANCE = 0;

            $status = 0;

            $result = $db->RunQuery($strsql);
            while ($row = mysql_fetch_array($result)) {
                if ($br != $row["brand"]) {
                    if ($status != 0) {
                        echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
					</tr>";
                    }

                    echo "<tr>
				<th colspan=\"6\" align=\"left\"><b>" . $row["brand"] . "</b></th>
				</tr>";
                    $br = $row["brand"];
                    $AMOUNT = 0;
                    $SVAT = 0;
                    $BALANCE = 0;

                    $status = 1;
                }
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REFNO"] . "</td>
			<td>" . $row["CUSCODE"] . " " . $row["NAME"] . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"] - ($row["AMOUNT"] / (1 + $row["vatrate"] / 100)), 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"] / (1 + $row["vatrate"] / 100), 2, ".", ",") . "</td>
			</tr>";

                $AMOUNT = $AMOUNT + $row["AMOUNT"];
                $SVAT = $SVAT + $row["AMOUNT"] - ($row["AMOUNT"] / (1 + $row["vatrate"] / 100));
                $BALANCE = $BALANCE + $row["AMOUNT"] / (1 + $row["vatrate"] / 100);

                $tAMOUNT = $tAMOUNT + $row["AMOUNT"];
                $tSVAT = $tSVAT + $row["AMOUNT"] - ($row["AMOUNT"] / (1 + $row["vatrate"] / 100));
                $tBALANCE = $tBALANCE + $row["AMOUNT"] / (1 + $row["vatrate"] / 100);
            }

            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
				</tr>";
            echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'><b>" . number_format($tAMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($tSVAT, 2, ".", ",") . "</b></td><td align='right'><b>" . number_format($tBALANCE, 2, ".", ",") . "</b></td>
					</tr>";
            echo "<table>";
        }

        function Dgrnsummery() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();
            
            $phrase = "";
            if ($_SESSION["company"] != "C"){
                $phrase = " and company = '" . $_SESSION["company"] . "'";
            }

            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }

            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] == "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }

            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }

            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }
            if (($_GET["chkcus"] != "on") and ( $_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'";
            }

            $strsql .= "$phrase order by REFNO";
            
            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Defective Item Report  On         " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Rep :    " . $_GET["cmbrep"] . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Defective Item Report  From      " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   To   " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Rep : " . $_GET["cmbrep"] . "   Brand  :  " . $_GET["CmbBrand"];
            }

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";
            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";

            //$strsql=$strsql." order by brand";
            //echo $strsql;
            $br = "";
            $AMOUNT = 0;
            $SVAT = 0;
            $BALANCE = 0;

            $status = 0;

            $result = $db->RunQuery($strsql);
            while ($row = mysql_fetch_array($result)) {
                if ($br != $row["brand"]) {
                    if ($status != 0) {
                        echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
					</tr>";
                    }

                    echo "<tr>
				<th colspan=\"6\" align=\"left\"><b>" . $row["brand"] . "</b></th>
				</tr>";
                    $br = $row["brand"];
                    $AMOUNT = 0;
                    $SVAT = 0;
                    $BALANCE = 0;

                    $status = 1;
                }
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REFNO"] . "</td>
			<td>" . $row["CUSCODE"] . " " . $row["NAME"] . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100)), 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"] / (1 + ($row["vatrate"] / 100)), 2, ".", ",") . "</td>
			</tr>";

                $AMOUNT = $AMOUNT + $row["AMOUNT"];
                $SVAT = $SVAT + $row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100));
                $BALANCE = $BALANCE + $row["AMOUNT"] / (1 + ($row["vatrate"] / 100));

                $tAMOUNT = $tAMOUNT + $row["AMOUNT"];
                $tSVAT = $tSVAT + $row["AMOUNT"] - $row["AMOUNT"] / (1 + ($row["vatrate"] / 100));
                $tBALANCE = $tBALANCE + $row["AMOUNT"] / (1 + ($row["vatrate"] / 100));
            }

            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
				</tr>";
            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($tAMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($tSVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($tBALANCE, 2, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }

        function recieptrep() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            //$sql = "delete from tmpreceipt where username='".$_SESSION['UserName']."'";
            $sql = "delete from tmpreceipt";
            $result = $db->RunQuery($sql);

            if ($_GET["cmbRECtype"] == "Ret.ch") {
                $rettype = "RET";
            }
            if ($_GET["cmbRECtype"] == "Normal") {
                $rettype = "REC";
            }
            if ($_GET["chkcus"] != "on") {
                if ($_GET["cmbretchktype"] == "All") {
                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO ";
                        }
                    }

                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO";
                        }
                    }

                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' order by CA_REFNO ";
                        }
                    }

                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' order by CA_REFNO ";
                        }
                    }
                } else {

                    if ($_GET["cmbretchktype"] == "Cheque") {
                        $cmbretchktype = "Cash";
                    } else {
                        $cmbretchktype = $_GET["cmbretchktype"];
                    }

                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO ";
                        }
                    }
                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' ) and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' ) and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO";
                        }
                    }

                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO";
                        }
                    }
                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' order by CA_REFNO";
                        }
                    }
                }
            }

            if ($_GET["chkcus"] == "on") {
                if ($_GET["cmbretchktype"] == "All") {
                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        }
                    }
                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                        }
                    }

                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        }
                    }
                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        }
                    }
                } else {

                    if ($_GET["cmbretchktype"] == "Cheque") {
                        $cmbretchktype = "Cash";
                    } else {
                        $cmbretchktype = $_GET["cmbretchktype"];
                    }
                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                        }
                    }
                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] == "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        }
                    }

                    if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $cmbretchktype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        } else {
                            $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $cmbretchktype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                        }
                    }
                    if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] != "All")) {
                        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                            $rct = "select * from s_crec where mid(CA_REFNO, 1, 1)='" . $_SESSION['COMCODE'] . "' and (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0'and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                        } else {
                            $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $cmbretchktype . "' and  CANCELL='0'and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                        }
                    }
                }
            }
            $tota = 0;
            //echo $rct;
            $result_rct = $db->RunQuery($rct);
            while ($row_rct = mysql_fetch_array($result_rct)) {

                if ($_GET["cmbretchktype"] == "Cash") {
                    if ($row_rct["CA_CASSH"] > 0) {

                        if (trim($row_rct["pay_type"]) == "Cheque") {
                            $ptype = "Cash";
                        } else {
                            $ptype = trim($row_rct["pay_type"]);
                        }



                        $ven = "select * from vendor where CODE='" . $row_rct["CA_CODE"] . "'";
                        $result_ven = $db->RunQuery($ven);
                        $row_ven = mysql_fetch_array($result_ven);

                        $cus = $row_rct["CA_CODE"] . " " . $row_ven["NAME"];

                        $sql = "insert into tmpreceipt(REF_NO, CUS_REF, ptype, SDATE, cash, DEPARTMENT, cust, username) values ('" . $row_rct["CA_REFNO"] . "', '" . $row_rct["CUS_REF"] . "', '" . $ptype . "', '" . $row_rct["CA_DATE"] . "', '" . $row_rct["CA_CASSH"] . "', '" . $row_rct["DEPARTMENT"] . "', '" . $cus . "', '" . $_SESSION['UserName'] . "')";
                        $result = $db->RunQuery($sql);
                        //$tota = tota + $row_rct["CA_CASSH"];
                    }
                } else {

                    if ($row_rct["CA_CASSH"] > 0) {

                        if (trim($row_rct["pay_type"]) == "Cheque") {
                            $ptype = "Cash";
                        } else {
                            $ptype = trim($row_rct["pay_type"]);
                        }

                        $ven = "select * from vendor where CODE='" . $row_rct["CA_CODE"] . "'";
                        $result_ven = $db->RunQuery($ven);
                        $row_ven = mysql_fetch_array($result_ven);

                        $cus = $row_rct["CA_CODE"] . " " . $row_ven["NAME"];

                        $sql = "insert into tmpreceipt(REF_NO, CUS_REF, ptype, SDATE, cash, DEPARTMENT, cust, username) values ('" . $row_rct["CA_REFNO"] . "', '" . $row_rct["CUS_REF"] . "', '" . $ptype . "', '" . $row_rct["CA_DATE"] . "', '" . $row_rct["CA_CASSH"] . "', '" . $row_rct["DEPARTMENT"] . "', '" . $cus . "', '" . $_SESSION['UserName'] . "')";
                        $result = $db->RunQuery($sql);
                        //$tota = tota + $row_rct["CA_CASSH"];
                    }

                    $sql_invch = "select * from s_invcheq where refno='" . $row_rct["CA_REFNO"] . "'";

                    $result_invch = $db->RunQuery($sql_invch);
                    while ($row_invch = mysql_fetch_array($result_invch)) {
                        $sql_tmpCh = "select * from tmpreceipt where ch_no='" . trim($row_invch["cheque_no"]) . "' and branch='" . trim($row_invch["cus_code"]) . "'";
                        $result_tmpCh = $db->RunQuery($sql_tmpCh);
                        if ($row_tmpCh = mysql_fetch_array($result_tmpCh)) {
                            
                        } else {
                            $chQty = $chQty + 1;
                        }

                        $ven = "select * from vendor where CODE='" . $row_rct["CA_CODE"] . "'";
                        $result_ven = $db->RunQuery($ven);
                        $row_ven = mysql_fetch_array($result_ven);

                        $cus = $row_rct["CA_CODE"] . " " . $row_ven["NAME"];

                        $sql = "insert into tmpreceipt(REF_NO, SDATE, ch_date, ch_no, ch_amount, bank, branch, DEPARTMENT, cust, username) values ('" . $row_rct["CA_REFNO"] . "', '" . $row_rct["CA_DATE"] . "', '" . $row_invch["che_date"] . "', '" . $row_invch["cheque_no"] . "', '" . $row_invch["che_amount"] . "', '" . $row_invch["cus_code"] . "', '" . $row_invch["bank"] . "', '" . $row_invch["department"] . "', '" . $cus . "', '" . $_SESSION['UserName'] . "')";
                        $result = $db->RunQuery($sql);
                        $tota = $tota + $row_invch["che_amount"];
                    }
                }
            }


            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Receipt Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Receipt Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
            if ($_GET["cmbRECtype"] == "Ret.ch") {
                $txtrectype = "Return Cheque";
            }
            if ($_GET["cmbRECtype"] == "Normal") {
                $txtrectype = "Invoice";
            }
            if ($_GET["cmbRECtype"] == "All") {
                $txtrectype = "All";
            }
            if ($_GET["chkcus"] == "on") {
                $txtcus = "Customer    " . $_GET["cuscode"] . "    " . $_GET["txt_cusname"];
            }


            // if ($_GET["cmbretchktype"] == "All") {

            if ($_GET["chkcus"] != "on") {

                if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] == "All")) {

                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV !='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque')  ";

                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                    $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  ";

                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry')  ";

                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')  ";
                }

                if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] == "All")) {
                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') ";
                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
                    $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') ";
                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "') and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') ";
                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')";
                }

                if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] != "All")) {
                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque')  ";

                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                    $sql_tt = "select sum(CA_AMOUNT) as ttamo  from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  ";

                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='J/Entry')  ";

                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='R/Deposit') ";
                }

                if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] != "All")) {

                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0'and (pay_type='Cash' or pay_type='Cheque') ";

                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                    $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') ";

                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='J/Entry') ";

                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='R/Deposit') ";
                }
            }

            if ($_GET["chkcus"] == "on") {

                if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] == "All")) {
                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                    $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                }

                if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] == "All")) {
                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                    $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["cuscode"]) . "'  ";

                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit') and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                }

                if (($_GET["radio2"] == "optdaily") and ( $_GET["cmbRECtype"] != "All")) {
                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                    $sql_tt = "select sum(CA_AMOUNT) as ttamo  from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='J/Entry')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='R/Deposit') and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                }

                if (($_GET["radio2"] == "optperiod") and ( $_GET["cmbRECtype"] != "All")) {
                    $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0'and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                    $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                    $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";

                    $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                    $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='R/Deposit')  and CA_CODE='" . trim($_GET["cuscode"]) . "' ";
                }
            }


            $result_ch = $db->RunQuery($sql_ch);
            $row_ch = mysql_fetch_array($result_ch);

            $result_ch1 = $db->RunQuery($sql_ch1);
            $row_ch1 = mysql_fetch_array($result_ch1);

            $result_ch_sc = $db->RunQuery($sql_ch_sc);
            $row_ch_sc = mysql_fetch_array($result_ch_sc);

            $result_tt = $db->RunQuery($sql_tt);
            $row_tt = mysql_fetch_array($result_tt);

            $result_jn = $db->RunQuery($sql_jn);
            $row_jn = mysql_fetch_array($result_jn);

            $result_re = $db->RunQuery($sql_re);
            $row_re = mysql_fetch_array($result_re);

            if (is_null($row_ch["chamo"]) == false) {
                $CHA = $row_ch["chamo"];
            } else {
                $CHA = 0;
            }

            if (is_null($row_ch1["chamo"]) == false) {
                $CHA1 = $row_ch1["chamo"];
            } else {
                $CHA1 = 0;
            }

            if (is_null($row_ch_sc["chamo"]) == false) {
                $CHA_SC = $row_ch_sc["chamo"];
            } else {
                $CHA_SC = 0;
            }

            if (is_null($row_tt["ttamo"]) == false) {
                $TTA = $row_tt["ttamo"];
            } else {
                $TTA = 0;
            }

            if (is_null($row_jn["jnamo"]) == false) {
                $JNA = $row_jn["jnamo"];
            } else {
                $JNA = 0;
            }

            if (is_null($row_re["reamo"]) == false) {
                $REA = $row_re["reamo"];
            } else {
                $REA = 0;
            }




            $rtxcash = number_format($CHA1 - $REA, 2, ".", ",");
            $rtxscchq = number_format($CHA_SC, 2, ".", ",");
            $rtxtt = number_format($TTA, 2, ".", ",");
            $rtxj = number_format($JNA, 2, ".", ",");
            $rtxre = number_format($REA, 2, ".", ",");
            $txttot = number_format($CHA + $TTA + $JNA + $REA, 2, ".", ",");
            // }


            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";



            echo "<center>" . $rtxtdate . "</center><br>";
            echo "<center>" . $txtrectype . "</center><br>";
            echo "<center>" . $txtcus . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Customer</th>
		<th>Ref No</th>
		<th>Cash</th>
		<th>Cash TT</th>
		<th>Cheque No</th>
		<th>Cheque Date</th>
		<th>Cheque Amount</th>
		</tr>";
            //echo $sql;

            $totcash = 0;
            $totjentry = 0;
            $tottt = 0;

            $sql = "select * from tmpreceipt  order by SDATE,id";
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {

                if ($_GET["cmbretchktype"] == "Cheque") {

                    if ($row["ch_no"] != "") {
                        echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["cust"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">" . $row["ch_no"] . "</td>
			<td align=\"right\">" . $row["ch_date"] . "</td>
			<td align=\"right\">" . number_format($row["ch_amount"], 2, ".", ",") . "</td>
			</tr>";
                        $ch_amount = $ch_amount + $row["ch_amount"];
                    }
                } else if ($_GET["cmbretchktype"] == "Cash") {

                    if ($row["ptype"] == "Cash") {
                        echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["cust"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";

                        $totcash = $totcash + $row["cash"];
                    }
                } else {

                    if (($row["DEPARTMENT"] == "O") and ( ($row["ptype"] == "Cash TT") or ( $row["ptype"] == "C/TT"))) {

                        echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["cust"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			
			</tr>";
                        $tottt = $tottt + $row["cash"];
                    } else if (($row["DEPARTMENT"] == "O") and ( $row["ptype"] == "J/Entry")) {

                        echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["cust"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";
                        $totjentry = $totjentry + $row["cash"];
                        /* } else if (($row["DEPARTMENT"] == "S") and ( trim($row["ptype"]) == "Cash")) {
                          echo "<tr>
                          <td>" . $row["SDATE"] . "</td>
                          <td>" . $row["REF_NO"] . "</td>
                          <td align=\"right\"></td>
                          <td align=\"right\"></td>
                          <td align=\"right\"></td>
                          <td align=\"right\"></td>
                          <td align=\"right\"></td>
                          <td align=\"right\"></td>
                          <td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
                          </tr>";
                          $totcrap = $totcrap + $row["cash"]; */
                        // } else if (($row["DEPARTMENT"] == "O") and ( trim($row["ptype"]) == "Cash")) {
                    } else if (( trim($row["ptype"]) == "Cash")) {

                        echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["cust"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";

                        $totcash = $totcash + $row["cash"];
                    } else {

                        echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["cust"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">" . $row["ch_no"] . "</td>
			<td align=\"right\">" . $row["ch_date"] . "</td>
			<td align=\"right\">" . number_format($row["ch_amount"], 2, ".", ",") . "</td>
			</tr>";
                        $ch_amount = $ch_amount + $row["ch_amount"];
                    }
                }
            }

            echo "<tr>
			<td colspan=3></td>
			<td align=\"right\"><b>" . number_format($totcash, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($tottt, 2, ".", ",") . "</b></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"><b>" . number_format($ch_amount, 2, ".", ",") . "</b></td>
			</tr>";

            echo "<table>";

            echo "<br><br>";

            echo "<table border=0 width=700>
		<tr><td><b>Normal</b></td><td>&nbsp;</td></tr>
		<tr><td>Cheque</td><td align=right>" . $rtxcash . "</td></tr>
		<tr><td>Cash</b></td><td align=right>" . number_format($totcash, 2, ".", ",") . "</td></tr>";

            echo "<tr><td>Cash TT</b></td><td align=right>" . number_format($tottt, 2, ".", ",") . "</td></tr>
		<tr><td>Redeposit</b></td><td align=right>" . $rtxre . "</td></tr>";
            $acttot = str_replace(",", "", $rtxcash) + str_replace(",", "", $totcash) + $tottt + $totjentry + str_replace(",", "", $rtxre);
            echo "<tr><td>Total</b></td><td align=right><b>" . number_format($acttot, 2, ".", ",") . "</b></td></tr>
		<tr><td><b>No of Cheques</b></td><td align=right>" . $chQty . "</td></tr>
		
		</table>";
        }

        function summeryrep() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $totGrosaleVatamt = 0;
            $VatGdRetAmt = 0;
            $VATnetSaleAmt = 0;

            if ($_GET["cmbdev"] == "All") {
                $dev = "All";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }

            $TotGroSale = 0;
            $VATgroSale = 0;
            $NVATatgross = 0;

            $totsvatgrosale = 0;
            $SVATgrosale = 0;
            $totgrosaleSVATamou = 0;
            $SVATgdRet = 0;
            $SVATret = 0;
            $SVATNetSale = 0;
            $SVATAmount = 0;
            $NonSvatNet = 0;

            $Totsalret = 0;
            $VATGdRet = 0;
            $NvaGdRet = 0;

            $TotNetSale = 0;
            $VATnetSale = 0;
            $NonVatNet = 0;

            if ($_GET["radio2"] == "optdaily") {
                //$sql_sale = "select sum(GRAND_TOT) as GRAND_TOT ,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1 from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' ";
                $sql_sale = "select sum(GRAND_TOT) as GRAND_TOT ,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1 from s_salma where  SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' ";
            }
            if ($_GET["radio2"] == "optperiod") {
                //$sql_sale = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1  from s_salma where Accname != 'NON STOCK' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and DEV!='" . $dev . "' and CANCELL='0'";
                $sql_sale = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1  from s_salma where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and DEV!='" . $dev . "' and CANCELL='0'";
            }


            $result_sale = $db->RunQuery($sql_sale);
            while ($row_sale = mysql_fetch_array($result_sale)) {

                $TotGroSale = $TotGroSale + $row_sale["GRAND_TOT"];
                $totGrosaleVatamt = $totGrosaleVatamt + ($row_sale["GRAND_TOT"] - $row_sale["GRAND_TOT1"]); //* ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));           
            }

            if ($_GET["radio2"] == "optdaily") {
                //$sql_sale = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1 from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' and SVAT >0";
                $sql_sale = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1 from s_salma where SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' and SVAT >0";
            }
            if ($_GET["radio2"] == "optperiod") {
                //$sql_sale = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1  from s_salma where Accname != 'NON STOCK' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and DEV!='" . $dev . "' and CANCELL='0' and SVAT >0";
                $sql_sale = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1 +gst/100)) as GRAND_TOT1  from s_salma where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and DEV!='" . $dev . "' and CANCELL='0' and SVAT >0";
            }

            $result_sale = $db->RunQuery($sql_sale);
            while ($row_sale = mysql_fetch_array($result_sale)) {
                $totsvatgrosale = $totsvatgrosale + $row_sale["GRAND_TOT"];
                $totgrosaleSVATamou = $totgrosaleSVATamou + ($row_sale["GRAND_TOT"] - $row_sale["GRAND_TOT1"]); //* ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100))
            }


            if ($_GET["radio2"] == "optdaily") {
                $sql_c_bal = "select sum(AMOUNT) as AMOUNT,sum(amount/(1 +vatrate/100)) as AMOUNT1  from c_bal where SDATE='" . $_GET["dtfrom"] . "' AND trn_type!='ARN' and  trn_type!='INC' and trn_type!='REC'  and DEV!='" . $dev . "' ";
            }
            if ($_GET["radio2"] == "optperiod") {
                $sql_c_bal = "select sum(AMOUNT) as AMOUNT,sum(amount/(1 +vatrate/100)) as AMOUNT1 from c_bal where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )AND trn_type!='ARN' and trn_type!='REC' and trn_type!='INC'  and DEV!='" . $dev . "'";
            }

            $result_c_bal = $db->RunQuery($sql_c_bal);
            while ($row_c_bal = mysql_fetch_array($result_c_bal)) {

                $TotGdRet = $TotGdRet + $row_c_bal["AMOUNT"];
                $VatGdRetAmt = $VatGdRetAmt + ($row_c_bal["AMOUNT"] - $row_c_bal["AMOUNT1"]);  //* ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));
            }

            if ($_GET["radio2"] == "optdaily") {
                $sql_c_bal = "select *  from view_cbal_scrnma_salma where SDATE='" . $_GET["dtfrom"] . "' AND trn_type!='ARN' and  trn_type!='INC' and trn_type!='REC'  and DEV!='" . $dev . "' and svat >0 ";
            }
            if ($_GET["radio2"] == "optperiod") {
                $sql_c_bal = "select * from view_cbal_scrnma_salma where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )AND trn_type!='ARN' and trn_type!='REC' and trn_type!='INC'  and DEV!='" . $dev . "' and svat >0";
            }

            $result_c_bal = $db->RunQuery($sql_c_bal);
            while ($row_c_bal = mysql_fetch_array($result_c_bal)) {

                $SVATgdRet = $SVATgdRet + $row_c_bal["AMOUNT"] * ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));
                $SVATret = $SVATret + $row_c_bal["AMOUNT"];
            }

            if ($_GET["radio2"] == "optdaily") {
                $sql_rct = "select sum(CA_AMOUNT) as CA_AMOUNT , sum(overpay) as overpay from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' and FLAG='REC' and DEPARTMENT = 'O' ";
            }
            if ($_GET["radio2"] == "optperiod") {
                $sql_rct = "select sum(CA_AMOUNT) as CA_AMOUNT , sum(overpay) as overpay from s_crec where ( CA_DATE='" . $_GET["dtfrom"] . "' OR  CA_DATE>'" . $_GET["dtfrom"] . "' ) AND ( CA_DATE='" . $_GET["dtto"] . "'  OR  CA_DATE<'" . $_GET["dtto"] . "' ) and DEV!='" . $dev . "' and CANCELL='0' and FLAG='REC' and department = 'O' ";
            }

            $result_rct = $db->RunQuery($sql_rct);
            while ($row_rct = mysql_fetch_array($result_rct)) {

                $RctAmount = $RctAmount + $row_rct["CA_AMOUNT"];
                if (is_null($row_rct["overpay"]) == false) {
                    $OVpAYMENT = $OVpAYMENT + $row_rct["overpay"];
                }
            }

            $RctAmount = $RctAmount + $OVpAYMENT;

            $VATgroSale = $totGrosaleVatamt;
            $VATGdRet = $VatGdRetAmt;
            $TotNetSale = $TotGroSale - $TotGdRet;
            $VATnetSale = $totGrosaleVatamt - $VatGdRetAmt;
            $NonVatNet = $TotNetSale - $VATnetSale;

            $SVATgrosale = $totgrosaleSVATamou;
            $SVATgdRet = $SVATgdRet;
            $SVATNetSale = $totsvatgrosale - $SVATret;
            $SVATAmount = $totgrosaleSVATamou - $SVATgdRet;
            $NonSvatNet = $SVATNetSale - $SVATAmount;


            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Sales Report On " . date("Y-m-d", strtotime($_GET["dtfrom"]));
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Sales Report  From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));
            }
            $Text1 = number_format($TotGroSale, 2, ".", ",");
            $Text2 = number_format($VATgroSale, 2, ".", ",");

            $Text3 = number_format($TotGdRet, 2, ".", ",");
            $Text4 = number_format($VATGdRet, 2, ".", ",");
            $Text5 = number_format($TotNetSale, 2, ".", ",");
            $Text6 = number_format($VATnetSale, 2, ".", ",");
            $Text7 = number_format($NonVatNet, 2, ".", ",");
            $Text8 = number_format($RctAmount, 2, ".", ",");
            $txtoverpay = number_format($OVpAYMENT, 2, ".", ",");
            $txtRecTot = number_format($RctAmount - $OVpAYMENT, 2, ".", ",");


            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style2\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border='1'  width=500>
		<tr><td>Total Sale</td><td align=right>" . number_format($TotGroSale, 2, ".", ",") . "</td><tr>
		<tr><td>VAT/SVAT on Sales</td><td align=right>" . number_format($VATgroSale, 2, ".", ",") . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Total Good Return</td><td align=right>" . number_format($TotGdRet, 2, ".", ",") . "</td><tr>
		<tr><td>VAT/SVAT on Goods Returns</td><td align=right>" . number_format($VATGdRet, 2, ".", ",") . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Total Gross Sales</td><td align=right>" . number_format($TotNetSale, 2, ".", ",") . "</td><tr>
		<tr><td>VAT/SVAT On Gross Sales</td><td align=right>" . number_format($VATnetSale, 2, ".", ",") . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Net  Sales (Without VAT/SVAT)</td><td align=right>" . number_format($NonVatNet, 2, ".", ",") . "</td><tr>
		<tr><td>Receipt Summery(Settlement)</td><td align=right>" . number_format($RctAmount, 2, ".", ",") . "</td><tr>
		<tr><td>Over Payment</td><td align=right>" . $txtoverpay . "</td><tr>
		<tr><td>Receipt Total</td><td align=right>" . $txtRecTot . "</td><tr>
	
		
		</table>";

            if ($_GET["cmbdev"] == "Computer") {


                //=============================== VAT ======================================================
                $Text45 = number_format($TotGroSale - $totsvatgrosale, 2, ".", ",");
                $Text46 = number_format($VATgroSale - $SVATgrosale, 2, ".", ",");
                $Text47 = number_format($TotGdRet - $SVATret, 2, ".", ",");
                $Text48 = number_format($VATGdRet - $SVATgdRet, 2, ".", ",");
                $Text49 = number_format($TotNetSale - $SVATNetSale, 2, ".", ",");
                $Text50 = number_format($VATnetSale - $SVATAmount, 2, ".", ",");
                $Text51 = number_format($NonVatNet - $NonSvatNet, 2, ".", ",");

                echo "<br><b>VAT SALE</b><br>";
                echo "<center><table  border='1'  width=500>
		<tr><td>Total Sales</td><td align=right>" . $Text45 . "</td><tr>
		<tr><td>VAT On Sales</td><td align=right>" . $Text46 . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Total Goods Returns</td><td align=right>" . $Text47 . "</td><tr>
		<tr><td>VAT on Goods  Returns</td><td align=right>" . $Text48 . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Total Gross Sales</td><td align=right>" . $Text49 . "</td><tr>
		<tr><td>VAT On Gross Sales</td><td align=right>" . $Text50 . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Net  Sales (Without VAT)</td><td align=right>" . $Text51 . "</td><tr>
		
		<table>";

                //=============================== SVAT =====================================================
                $Text67 = number_format($totsvatgrosale, 2, ".", ",");
                $Text68 = number_format($SVATgrosale, 2, ".", ",");
                $Text69 = number_format($SVATret, 2, ".", ",");
                $Text70 = number_format($SVATgdRet, 2, ".", ",");
                $Text71 = number_format($SVATNetSale, 2, ".", ",");
                $Text72 = number_format($SVATAmount, 2, ".", ",");
                $Text73 = number_format($NonSvatNet, 2, ".", ",");

                echo "<br><b>SVAT SALE</b><br>";
                echo "<center><table  border='1'  width=500>
		<tr><td>Total Sales</td><td align=right>" . $Text67 . "</td><tr>
		<tr><td>SVAT On Sales</td><td align=right>" . $Text68 . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Total Goods Returns</td><td align=right>" . $Text69 . "</td><tr>
		<tr><td>SVAT on Goods  Returns</td><td align=right>" . $Text70 . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Total Gross Sales</td><td align=right>" . $Text71 . "</td><tr>
		<tr><td>SVAT On Gross Sales</td><td align=right>" . $Text72 . "</td><tr>
		<tr><td >&nbsp;</td><td >&nbsp;</td><tr>
		<tr><td>Net  Sales (Without SVAT)</td><td align=right>" . $Text73 . "</td><tr>
		
		<table>";
            } else {
                
            }
        }

        function summerysprte() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            // $sql = "delete from tmptotbrandsale where username='".$_SESSION['UserName']."'";
            $sql = "delete from tmptotbrandsale ";
            $result = $db->RunQuery($sql);


            $sql_brand = "select * from brand_mas";
            $result_brand = $db->RunQuery($sql_brand);
            while ($row_brand = mysql_fetch_array($result_brand)) {
                $TotGroSaleAmt = 0;
                $TotGdRetAmt = 0;

                if ($_GET["chkcus"] == "on") {
                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                            $sql_sale = "select * from s_salma where C_CODE ='" . trim($_GET["cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }
                        if ($_GET["radio2"] == "optperiod") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                            $sql_sale = "select * from s_salma where c_code ='" . trim($_GET["cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                            $sql_sale = "select * from s_salma where c_code ='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                            $sql_sale = "select * from s_salma where c_code ='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }
                }

                if ($_GET["chkcus"] != "on") {
                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                            $sql_sale = "select * from s_salma where SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . trim($row_brand["barnd_name"]) . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                            $sql_sale = "select * from s_salma where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . trim($row_brand["barnd_name"]) . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                            $sql_sale = "select * from s_salma where sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            //$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                            $sql_sale = "select * from s_salma where sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }
                }

                $result_sale = $db->RunQuery($sql_sale);
                while ($row_sale = mysql_fetch_array($result_sale)) {

                    $TotGroSale = $TotGroSale + $row_sale["GRAND_TOT"];
                    $TotGroSaleAmt = $TotGroSaleAmt + ($row_sale["GRAND_TOT"] / (1 + ($row_sale["GST"] / 100)));
                }

                if ($_GET["chkcus"] == "on") {

                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] = "optdaily") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }
                }

                if ($_GET["chkcus"] != "on") {
                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }
                }


                $result_c_bal = $db->RunQuery($sql_c_bal);
                while ($row_c_bal = mysql_fetch_array($result_c_bal)) {

                    $TotGdRet = $TotGdRet + $row_c_bal["AMOUNT"];
                    $TotGdRetAmt = $TotGdRetAmt + ($row_c_bal["AMOUNT"] / (1 + ($row_c_bal["vatrate"] / 100)));
                }

                $nett = ($TotGroSaleAmt - $TotGdRetAmt);

                if ($nett <> 0) {
                    $sql_tmp = "insert into tmptotbrandsale(brand, gross, grn, nett, username) values ('" . trim($row_brand["barnd_name"]) . "', " . $TotGroSale . ", " . $TotGdRet . ", " . $nett . ", '" . $_SESSION['UserName'] . "')";
                    $result_tmp = $db->RunQuery($sql_tmp);
                }
                $TotGdRet = 0;
                $TotGroSale = 0;
            }


            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Total Sales  On " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "Rep   :" . $_GET["cmbrep"];
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Total Sales  From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"])) . " Rep   :" . $_GET["cmbrep"];
            }


            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th width ='350'>Brand</th>
		<th  width ='100' >Gross</th>
		<th  width ='100'>GRN</th>
		<th width ='100'>Net</th>
		</tr>";
            //echo $sql;
            $sql = "select * from tmptotbrandsale order by brand";
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {
                echo "<tr>
			<td >" . $row["brand"] . "</td>
			<td align=\"right\">" . number_format($row["gross"], 2, ".", ",") . "</td>
			<td  align=\"right\">" . number_format($row["grn"], 2, ".", ",") . "</td>
			<td  align=\"right\">" . number_format($row["nett"], 2, ".", ",") . "</td>
			</tr>";

                $tots = $tots + $row["gross"];
                $totr = $totr + $row["grn"];
                $totn = $totn + $row["nett"];
            }
            echo "<tr>
			<td></td>
			<td align=\"right\">" . number_format($tots, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($totr, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($totn, 2, ".", ",") . "</td>
			</tr>";

            echo "<table>";
        }

        function item_sales() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();
            if ($_GET["chkcus"] == "on") {
                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo where C_CODE='" . $_GET["cuscode"] . "' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where  C_CODE='" . $_GET["cuscode"] . "' and  SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo where  C_CODE='" . $_GET["cuscode"] . "' and   (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where  C_CODE='" . $_GET["cuscode"] . "' and  SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }

                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo  where C_CODE='" . $_GET["cuscode"] . "' and BRAND='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where C_CODE='" . $_GET["cuscode"] . "' and brand='" . $_GET["CmbBrand"] . "' and     SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo where  C_CODE='" . $_GET["cuscode"] . "' and brand='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where   C_CODE='" . $_GET["cuscode"] . "' and brand='" . $_GET["CmbBrand"] . "' and   SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }
            } else {

                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo where     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo where     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] == "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }

                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo where BRAND='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] == "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where brand='" . $_GET["CmbBrand"] . "' and     SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optperiod")) {
                    $sql = "SELECT * from view_s_invo where  brand='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }

                if (($_GET["cmbrep"] != "All") and ( $_GET["CmbBrand"] != "All") and ( $_GET["radio2"] == "optdaily")) {
                    $sql = "SELECT * from view_s_invo where   brand='" . $_GET["CmbBrand"] . "' and   SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
                }
            }

            if (($_GET["radio"] == "optitem") and ( $_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Item Sales Summery Report  On " . date("Y-m-d", strtotime($_GET["dtfrom"]));
            }

            if (($_GET["radio"] == "optitem") and ( $_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Item Sales Summery Report    From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));
            }

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th></th>
		<th></th>
		<th></th>
		<th>Type</th>
		<th></th>
		<th></th>
		<th></th>
		<th>Rep</th>
		</tr>";
            //echo $sql;
            $i = 0;
            $REF_NO = "";
            $sql = $sql . ", REF_NO, REP";
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {

                if ($REF_NO != $row["REF_NO"]) {
                    if ($i == 1) {
                        echo "<tr>
					<td  class='topbor topbor1'></td>
                                        <td  class='topbor topbor1'></td>
                                        <td  class='topbor topbor1'></td>
                                        <td  class='topbor topbor1'></td>
                                        <td class='topbor topbor1'></td>
                                        <td class='topbor topbor1'></td>
                                        
					<th  class='topbor topbor1' align=\"right\" >" . number_format($GRAND_TOT, 2, ".", ",") . "</th>
					<td  class='topbor topbor1'></td>
					</tr>";
                    } else {
                        $i = 1;
                    }
                    echo "<tr>
				<td class='topbor'>" . $row["SDATE"] . "</td>
				<td class='topbor'>" . $row["REF_NO"] . "</td>
				<td class='topbor'>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
				<td class='topbor'>" . $row["Brand_name"] . "</td>
				  <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td class='topbor'></td>
                                        <td class='topbor'></td>
			
				</tr>";

                    echo "<tr>
					<td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
					<td class='topbor' >" . $row["PART_NO"] . "</td>
					<td class='topbor' align=\"right\">" . number_format($row["QTY"], 2, ".", ",") . "</td>
					<td class='topbor' align=\"right\">" . number_format($row["PRICE"], 2, ".", ",") . "</td>
					<td class='topbor'>" . $row["REP"] . "</td>
					</tr>";

                    $REF_NO = $row["REF_NO"];
                } else {

                    echo "<tr>
				 
                                <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                         


				<td class='topbor'>" . $row["PART_NO"] . "</td>
				<td class='topbor' align=\"right\">" . number_format($row["QTY"], 2, ".", ",") . "</td>
				<td class='topbor' align=\"right\">" . number_format($row["PRICE"], 2, ".", ",") . "</td>
				<td class='topbor'>" . $row["REP"] . "</td>
				</tr>";
                }
                $GRAND_TOT = $row["GRAND_TOT"];
            }
            echo "<tr>
					<td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
                                        <td  class='topbor'></td>
					<th class='topbor' align=\"right\" >" . number_format($GRAND_TOT, 2, ".", ",") . "</th>
					<td  class='topbor'></td>
					</tr>";

            echo "<table>";
        }

        function summer_defect() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            // $sql = "delete from tmptotbrandsale where username='".$_SESSION['UserName']."'";
            $sql = "delete from tmptotbrandsale ";
            $result = $db->RunQuery($sql);


            $sql_brand = "select * from brand_mas";
            $result_brand = $db->RunQuery($sql_brand);
            while ($row_brand = mysql_fetch_array($result_brand)) {
                $TotGroSaleAmt = 0;
                $TotGdRetAmt = 0;



                if ($_GET["chkcus"] == "on") {

                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] = "optdaily") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' AND trn_type='DGRN' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' AND trn_type='DGRN'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and trn_type='DGRN' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' AND trn_type='DGRN'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }
                }

                if ($_GET["chkcus"] != "on") {
                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and trn_type='DGRN' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' AND trn_type='DGRN'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' AND trn_type='DGRN' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type='DGRN'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }
                }


                $result_c_bal = $db->RunQuery($sql_c_bal);
                while ($row_c_bal = mysql_fetch_array($result_c_bal)) {
                    $TotGdRet = $TotGdRet + $row_c_bal["AMOUNT"];
                    $TotGdRetAmt = TotGdRetAmt + ($row_c_bal["AMOUNT"] / (1 + ($row_c_bal["vatrate"] / 100)));
                }

                $nett = ($TotGroSaleAmt - $TotGdRetAmt);

                if ($nett <> 0) {
                    $sql_tmp = "insert into tmptotbrandsale(brand, gross, grn, nett, username) values ('" . trim($row_brand["barnd_name"]) . "', " . $TotGroSale . ", " . $TotGdRet . ", " . $nett . ", '" . $_SESSION['UserName'] . "')";
                    $result_tmp = $db->RunQuery($sql_tmp);
                }
                $TotGdRet = 0;
                $TotGroSale = 0;
            }


            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "On " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "Rep   :" . $_GET["cmbrep"];
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"])) . " Rep   :" . $_GET["cmbrep"];
            }


            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center><span>DEFECTIVE ITEM REPORT</span></center><br>";

            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th width ='350'>Brand</th>
		<th  width ='100' >Gross Amount</th>
		<th  width ='100'>Vat</th>
		<th width ='100'>Net Amount</th>
		</tr>";
            //echo $sql;
            $sql = "select * from tmptotbrandsale order by brand";
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {


                $vatt = round($row["grn"] - ( $row["grn"] / 1.12), 2);
                echo "<tr>
			<td>" . $row["brand"] . "</td>
			<td align=\"right\">" . number_format($row["grn"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($vatt, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["grn"] - $vatt, 2, ".", ",") . "</td>
		      </tr>";

                $tots = $tots + $row["grn"];
                $totr = $totr + $vatt;
                $totn = $totn + $row["grn"] - $vatt;
            }
            echo "<tr>
			<td></td>
			<td align=\"right\">" . number_format($tots, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($totr, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($totn, 2, ".", ",") . "</td>
			</tr>";

            echo "<table>";
        }

        function grnwinv() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "GRN Report On " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "Rep   :" . $_GET["cmbrep"];
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "GRN Report From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"])) . " Rep   :" . $_GET["cmbrep"];
            }


            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";


            if ($_GET["cmbdev"] == "All") {
                $dev = "All";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }


            $sql = "select SAL_EX from s_crnma where sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and trn_type = 'GRN'";
            $sql .=" and dev <> '" . $dev . "'";


            if ($_GET['CmbBrand'] != "All") {
                $sql .=" and Brand = '" . $_GET['CmbBrand'] . "'";
            }

            if ($_GET['cmbrep'] != "All") {
                $sql .=" and SAL_EX = '" . $_GET['cmbrep'] . "'";
            }

            $sql .="  group by SAL_EX";

            echo "<center><table> <tr>";
            echo "<td>REF NO</td>";
            echo "<td>Date</td>";
            echo "<td>Customer Name</td>";
            echo "<td>Invoice No</td>";
            echo "<td>Invoice Date</td>";
            echo "<td>Amount</td>";


            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {
                $mtot = 0;
                echo "<tr>"
                . "<td>" . $row['SAL_EX'] . "</td>";
                echo "<td colspan='5'></td>";
                echo "</tr>";

                $sql = "select *  from s_crnma where sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and trn_type = 'GRN' and cancell=0";
                $sql .=" and dev <> '" . $dev . "' and sal_ex = '" . $row['SAL_EX'] . "'";

                if ($_GET['CmbBrand'] != "All") {
                    $sql .=" and Brand = '" . $_GET['CmbBrand'] . "'";
                }

                if ($_GET['cmbrep'] != "All") {
                    $sql .=" and SAL_EX = '" . $_GET['cmbrep'] . "'";
                }


                $sql .=' order by ref_no';


                $result1 = $db->RunQuery($sql);
                while ($row1 = mysql_fetch_array($result1)) {
                    echo "<tr>"
                    . "<td>" . $row1['REF_NO'] . "</td>";
                    echo "<td>" . $row1['SDATE'] . "</td>";
                    echo "<td>" . $row1['CUS_NAME'] . "</td>";
                    echo "<td>" . $row1['INVOICENO'] . "</td>";
                    echo "<td>" . $row1['DDATE'] . "</td>";
                    echo "<td align='right'>" . number_format($row1['GRAND_TOT'], 2, ".", ",") . "</td>";
                    echo "</tr>";
                    $mtot = $mtot + $row1['GRAND_TOT'];
                    $mtot1 = $mtot1 + $row1['GRAND_TOT'];
                }
                echo "<tr>"
                . "<td  colspan='5'></td>";
                echo "<td align='right'><b>" . number_format($mtot, 2, ".", ",") . "</b></td>";
                echo "</tr>";
            }
            echo "<tr>"
            . "<td  colspan='5'></td>";
            echo "<td><b>" . number_format($mtot1, 2, ".", ",") . "</b></td>";
            echo "</tr>";
        }

        function PrintRepfit($opt) {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            if ($opt == "tyre") {
                $heading = "Tyre Fitting Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                    $sql = "SELECT rep from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16513' group by rep";
                } else {
                    $sql = "SELECT rep from view_s_invo where  SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16513' group by rep";
                }
            } else if ($opt == "bat") {
                $heading = "Battary Charge Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                    $sql = "SELECT rep from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16778' group by rep";
                } else {
                    $sql = "SELECT rep from view_s_invo where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16778' group by rep";
                }
            }



            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";

            $result_head = $db->RunQuery($sql_head);

            $row_head = mysql_fetch_array($result_head);
            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>" . $heading . "</center><br>";
            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>
		<th>Customer</th>
		<th>Type</th>
		<th>Cr. Days</th>
		<th>Gross Amount</th>
		</tr>";

            $totgross = 0;




            $result = $db->RunQuery($sql);

            while ($row = mysql_fetch_array($result)) {


                $sql = "select * from s_salrep where repcode = '" . $row["REP"] . "'";
                $resultrep = $db->RunQuery($sql);

                $rowrep = mysql_fetch_array($resultrep);



                echo "<tr>
			<th align='left' colspan='6'>" . $row["REP"] . "-" . $rowrep['Name'] . "</th>";



                echo "</tr>";

                if ($opt == "tyre") {
                    if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                        $sql = "SELECT * from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16513' and rep ='" . $row['REP'] . "' order by sdate";
                    } else {
                        $sql = "SELECT * from view_s_invo where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16513' and rep ='" . $row['REP'] . "' order by sdate";
                    }
                } else if ($opt == "bat") {
                    if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                        $sql = "SELECT * from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16778' and rep ='" . $row['REP'] . "' order by sdate";
                    } else {
                        $sql = "SELECT * from view_s_invo where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16778' and rep ='" . $row['REP'] . "' order by sdate";
                    }
                }

                $totgross = 0;


                $result1 = $db->RunQuery($sql);

                while ($row1 = mysql_fetch_array($result1)) {

                    echo "<tr>
			<td>" . $row1["SDATE"] . "</td>
			<td>" . $row1["REF_NO"] . "</td>
			<td>" . $row1["C_CODE"] . " " . $row1["CUS_NAME"] . "</td>
			<td>" . $row1["TYPE"] . "</td>
			<td align=\"right\">" . $row1["cre_pe"] . "</td>
			<td align=\"right\">" . number_format($row1["PRICE"], 2, ".", ",") . "</td>";

                    $totgross = $totgross + $row1["PRICE"];
                    $totNet = $totNet + $row1["PRICE"];
                    echo "</tr>";
                }
                echo "<tr>
			<th colspan=5></th>
			
			<th align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></th>
			 
			</tr>";
            }


            echo "<tr>
			<th colspan=5></th>
			
			<th align=\"right\"><b>" . number_format($totNet, 2, ".", ",") . "</b></th>
			 
			</tr>";
        }

        function PrintRepfitg($opt) {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            if ($opt == "tyre") {
                $heading = "Tyre Fitting Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                    $sql = "SELECT rep from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16513' group by rep";
                } else {
                    $sql = "SELECT rep from view_s_invo where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16513' group by rep";
                }
            } else if ($opt == "bat") {
                $heading = "Battary Charge Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                    $sql = "SELECT rep from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16778' group by rep";
                } else {
                    $sql = "SELECT rep from view_s_invo where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and stk_no='Z16778' group by rep";
                }
            }


            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";

            $result_head = $db->RunQuery($sql_head);

            $row_head = mysql_fetch_array($result_head);
            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>" . $heading . "</center><br>";
            echo "<center><table border=1><tr>
		<th width='350'>Rep</th>
		<th>Total</th>
			</tr>";

            $totgross = 0;




            $result = $db->RunQuery($sql);

            while ($row = mysql_fetch_array($result)) {


                $sql = "select * from s_salrep where repcode = '" . $row["REP"] . "'";
                $resultrep = $db->RunQuery($sql);

                $rowrep = mysql_fetch_array($resultrep);






                if ($opt == "tyre") {
                    if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                        $sql = "SELECT * from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16513' and rep ='" . $row['REP'] . "' order by sdate";
                    } else {
                        $sql = "SELECT * from view_s_invo where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16513' and rep ='" . $row['REP'] . "' order by sdate";
                    }
                } else if ($opt == "bat") {
                    if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
                        $sql = "SELECT * from view_s_invo where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16778' and rep ='" . $row['REP'] . "' order by sdate";
                    } else {
                        $sql = "SELECT * from view_s_invo where SDATE>='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and DEV<>'" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  and stk_no='Z16778' and rep ='" . $row['REP'] . "' order by sdate";
                    }
                }
                $totgross = 0;


                $result1 = $db->RunQuery($sql);

                while ($row1 = mysql_fetch_array($result1)) {



                    $totgross = $totgross + $row1["PRICE"];
                    $totNet = $totNet + $row1["PRICE"];
                    echo "</tr>";
                }

                echo "<tr>
<th align=\"left\">" . $row["REP"] . "-" . $rowrep['Name'] . "</th><th align=\"right\">" . number_format($totgross, 2, ".", ",") . "</th></tr>";
            }


            echo "<tr>
			<th></th>
			
			<th align=\"right\"><b>" . number_format($totNet, 2, ".", ",") . "</b></th>
			 
			</tr>";
        }
        ?>



    </body>
</html>
