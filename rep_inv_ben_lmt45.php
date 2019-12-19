<?php
session_start();
if (!isset($_SESSION["UserName"])) {
    echo "Invalid Login";
    exit();
}
date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Invoice</title>
        <style type="text/css">
            <!--
            table{
                margin-top: 110px;
                border-collapse:collapse;
                width: 1000px;
                border: 0px;
            }
            table td{
                /*color: red;*/
                font-family:Arial, Helvetica, sans-serif;
                height: 18px;
                font-size:18px;
                padding:0px; /*5*/
            }
            -->

        </style>
    </head>

    <body><center>
            <?php
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql = "Select count(*) as mcount from s_salma where REF_NO='" . $_GET["invno"] . "'";
            $result = $db->RunQuery($sql);
            $row = mysql_fetch_array($result);

            if ($row["mcount"] > 1) {
                exit("Duplicate Invoice No Detected. Please contact Supervisor.");
            }

            $copy = "";

            $sql_invpara = "SELECT * from invpara where COMCODE='" . $_SESSION['company'] . "'";
            $result_invpara = $db->RunQuery($sql_invpara);
            $row_invpara = mysql_fetch_array($result_invpara);

            $sql = "Select * from s_salma where REF_NO='" . $_GET["invno"] . "'";

            $result = $db->RunQuery($sql);
            $row = mysql_fetch_array($result);

            //echo $row["CANCELL"];
            if ($row["pirnt_serial"] == "0") {

                if ($row["CANCELL"] == "0") {
                    $sql = "update s_salma set pirnt_serial='1' where REF_NO='" . $_GET["invno"] . "'";
                    $result = $db->RunQuery($sql);
                } else {
                    $copy = "Cancelled";
                }
            } else if ($row["pirnt_serial"] > 0) {

                if ($_SESSION['User_Type'] == "0") {

                    if ($row["CANCELL"] == "0") {
                        exit("Cannot Print Twice !!!");
                    } else {
                        exit("Canceled Invoice !!!");
                    }
                } else {
                    if ($_SESSION['User_Type'] == "1") {

                        if ($row["CANCELL"] == "0") {
                            $copy = "COPY";
                        } else {
                            $copy = "Cancelled";
                        }

                        $print_serial = $row["pirnt_serial"] + 1;
                        $sql = "update s_salma set pirnt_serial='" . $print_serial . "' where REF_NO='" . $_GET["invno"] . "'";
                        $result = $db->RunQuery($sql);
                    }
                }
            }

            $sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
            $result1 = $db->RunQuery($sql1);
            $row1 = mysql_fetch_array($result1);

            $sql2 = "Select * from s_stomas where CODE='" . $row["DEPARTMENT"] . "'";
            $result2 = $db->RunQuery($sql2);
            $row2 = mysql_fetch_array($result2);

            $TXTDEP = $row2["DESCRIPTION"];
            $rtxtinvno = $row["invno"];
            $rtxtordno = $row["ORD_NO"];

            $sql2 = "Select * from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
            $result2 = $db->RunQuery($sql2);
            $row2 = mysql_fetch_array($result2);





            $rtxtrep = $row2["Name"];
            $rtxtSupCode = $row1["CODE"];
            $rtxtSupName = $row1["CODE"] . " " . $row1["NAME"];
            $txtadd1 = $row1["ADD1"];
            $txtadd1 = substr($txtadd1, 0, 40);
            //$txtadd2 = $row1["ADD2"];
            $txtadd2 = $_GET["cus_address2"];
            $txtadd = $row1["ADD1"] . "</br>" . $row1["ADD2"];
            $rtxtdate = date("Y-m-d", strtotime($row["SDATE"]));
            $rtxttot = $row["GRAND_TOT"];


            $sql_salrep = "Select * from s_salrep where REPCODE=" . $row["SAL_EX"];
            $result_salrep = $db->RunQuery($sql_salrep);
            $row_salrep = mysql_fetch_array($result_salrep);

            $VAT_per = $row["VAT"];


            $sql_para = "Select * from invpara  where COMCODE='" . $_SESSION['company'] . "'";
            $result_para = $db->RunQuery($sql_para);
            $row_para = mysql_fetch_array($result_para);
            $isVat = 0;
            if ($row["VAT"] != "0") {
                $isVat = 1;
            }
//            $isVat = 1;
            ?>

                        <table>
                <tr>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtxtSupName; ?></td>
                    <td align="center"><?php echo $row["use_name"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["REF_NO"]; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $txtadd1; ?></td>
                    <td align="center"><?php echo $row_salrep["Name"]; ?></td>
                    <td>&nbsp;</td>
                    <td><?php echo $row["SDATE"]; ?></td>
                </tr>
                <tr>
                    <td><?php if ($isVat == 1) echo "VAT " . $row_para["VAT"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;114717690-7000"; ?></td>
                    <td>&nbsp;</td>
                    <td align="center"><?php echo $row["ORD_NO"]; ?></td>
                    <td>&nbsp;</td>
                    <td><?php if($_GET["isHideAdt"]=="false"){echo date("y-m-d H:i");}?></td>
                </tr>
                <tr>
                    <td>TAX INVOICE</td>
                </tr>
                <?php
                $totsuntot = 0;

                $sql1 = "Select * from s_invo where REF_NO='" . $_GET["invno"] . "' order by id limit 15";
                $result1 = $db->RunQuery($sql1);
                echo "<tr><td>&nbsp;</td><tr>";
                echo "<tr><td>&nbsp;</td><tr>";
                while ($row1 = mysql_fetch_array($result1)) {
                    $sql_part = "Select * from s_mas where STK_NO='" . $row1["STK_NO"] . "'";
                    $result_part = $db->RunQuery($sql_part);
                    $row_item = mysql_fetch_array($result_part);

                    if (($VAT_per == "1") or ( $VAT_per == "2")) {
                        $vatr = 100 + $row["GST"];
                        $PRICE = $row1["PRICE"] / $vatr * 100;
                    } else {
                        $PRICE = $row1["PRICE"];
                    }
                    $discount1 = $PRICE * $row1["QTY"] * $row1["DIS_per"] / 100;
                    $subtot = ($PRICE * $row1["QTY"]) - $discount1;
                    
                    $partNo = $row_item["PART_NO"];
                    $partNo1 =  str_pad($partNo, 22, "?");
                    $partNo1 = str_replace("?", "&nbsp;", $partNo1);
                    
                    $brand = $row_item["BRAND_NAME"];
                    $brand1 = str_pad($brand, 22, "?");
                    $brand1 = str_replace("?", "&nbsp;", $brand1);
                    $descript = substr($row_item["DESCRIPT"], 0, 26);
//                    $descript = "VALVE GUIDE - NISSAN";
                    
//                    echo "<tr><td colspan=3 width=70%>" . $partNo1 . " " . $brand1 . " " . $row_item["DESCRIPT"] . "</td><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
                    echo "<tr><td width=20%>" . $partNo1 . "</td><td width=23%>" . $brand1 . "</td><td width=27%>" . $descript . "</td><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "&nbsp;&nbsp;&nbsp;</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
//                    echo "<tr><td colspan=3 width=70%><table><tr><td>" . $partNo . "</td><td>" . $row_item["BRAND_NAME"] . "</td><td>" . $row_item["DESCRIPT"] . "</td></tr></table><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
                    $totsuntot = $totsuntot + $subtot;
                    $id = $row1["id"];
                }
                ?>
                <tr><td>&nbsp;</td><tr>
                        <tr><td colspan="5">Page 1 of 3 <?php if($_GET["isHideAdt"]=="false"){echo $copy;} ?></td><td>&nbsp;</td></tr>
                        <?php
                        $i = 1;
                        while ($i < 11) {
                            echo "<tr><td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td></tr>";
                            $i = $i + 1;
                        }
                        ?>
            </table>
                        
            <table>
                <tr>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtxtSupName; ?></td>
                    <td align="center"><?php echo $row["use_name"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["REF_NO"]; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $txtadd1; ?></td>
                    <td align="center"><?php echo $row_salrep["Name"]; ?></td>
                    <td>&nbsp;</td>
                    <td><?php echo $row["SDATE"]; ?></td>
                </tr>
                <tr>
                    <td><?php if ($isVat == 1) echo "VAT " . $row_para["VAT"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;114717690-7000"; ?></td>
                    <td>&nbsp;</td>
                    <td align="center"><?php echo $row["ORD_NO"]; ?></td>
                    <td>&nbsp;</td>
                    <td><?php if($_GET["isHideAdt"]=="false"){echo date("y-m-d H:i");}?></td>
                </tr>
                <tr>
                    <td>TAX INVOICE</td>
                </tr>
                <?php
                $totsuntot = 0;

                $sql1 = "Select * from s_invo where REF_NO='" . $_GET["invno"] . "' and id > $id order by id limit 15";
                $result1 = $db->RunQuery($sql1);
                echo "<tr><td>&nbsp;</td><tr>";
                echo "<tr><td>&nbsp;</td><tr>";
                while ($row1 = mysql_fetch_array($result1)) {
                    $sql_part = "Select * from s_mas where STK_NO='" . $row1["STK_NO"] . "'";
                    $result_part = $db->RunQuery($sql_part);
                    $row_item = mysql_fetch_array($result_part);

                    if (($VAT_per == "1") or ( $VAT_per == "2")) {
                        $vatr = 100 + $row["GST"];
                        $PRICE = $row1["PRICE"] / $vatr * 100;
                    } else {
                        $PRICE = $row1["PRICE"];
                    }
                    $discount1 = $PRICE * $row1["QTY"] * $row1["DIS_per"] / 100;
                    $subtot = ($PRICE * $row1["QTY"]) - $discount1;
                    
                    $partNo = $row_item["PART_NO"];
                    $partNo1 =  str_pad($partNo, 22, "?");
                    $partNo1 = str_replace("?", "&nbsp;", $partNo1);
                    
                    $brand = $row_item["BRAND_NAME"];
                    $brand1 = str_pad($brand, 22, "?");
                    $brand1 = str_replace("?", "&nbsp;", $brand1);
                    $descript = substr($row_item["DESCRIPT"], 0, 26);
//                    $descript = "VALVE GUIDE - NISSAN";
                    
//                    echo "<tr><td colspan=3 width=70%>" . $partNo1 . " " . $brand1 . " " . $row_item["DESCRIPT"] . "</td><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
                    echo "<tr><td width=20%>" . $partNo1 . "</td><td width=23%>" . $brand1 . "</td><td width=27%>" . $descript . "</td><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "&nbsp;&nbsp;&nbsp;</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
//                    echo "<tr><td colspan=3 width=70%><table><tr><td>" . $partNo . "</td><td>" . $row_item["BRAND_NAME"] . "</td><td>" . $row_item["DESCRIPT"] . "</td></tr></table><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
                    $totsuntot = $totsuntot + $subtot;
                    $id = $row1["id"];
                }
                ?>
                <tr><td>&nbsp;</td><tr>
                        <tr><td colspan="5">Page 2 of 3 <?php if($_GET["isHideAdt"]=="false"){echo $copy;} ?></td><td>&nbsp;</td></tr>
                        <?php
                        $i = 1;
                        while ($i < 8) {
                            echo "<tr><td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td></tr>";
                            $i = $i + 1;
                        }
                        ?>
            </table>
            
            <table>
                <tr>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtxtSupName; ?></td>
                    <td align="center"><?php echo $row["use_name"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["REF_NO"]; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $txtadd1; ?></td>
                    <td align="center"><?php echo $row_salrep["Name"]; ?></td>
                    <td>&nbsp;</td>
                    <td><?php echo $row["SDATE"]; ?></td>
                </tr>
                <tr>
                    <td><?php if ($isVat == 1) echo "VAT " . $row_para["VAT"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;114717690-7000"; ?></td>
                    <td>&nbsp;</td>
                    <td align="center"><?php echo $row["ORD_NO"]; ?></td>
                    <td>&nbsp;</td>
                    <td><?php if($_GET["isHideAdt"]=="false"){echo date("y-m-d H:i");}?></td>
                </tr>
                <tr>
                    <td>TAX INVOICE</td>
                </tr>
                <?php
                $i = 1;
                $totsuntot = 0;

                $sql1 = "Select * from s_invo where REF_NO='" . $_GET["invno"] . "' and id > $id order by id limit 15";
                $result1 = $db->RunQuery($sql1);
                echo "<tr><td>&nbsp;</td><tr>";
                echo "<tr><td>&nbsp;</td><tr>";
                while ($row1 = mysql_fetch_array($result1)) {
                    $sql_part = "Select * from s_mas where STK_NO='" . $row1["STK_NO"] . "'";
                    $result_part = $db->RunQuery($sql_part);
                    $row_item = mysql_fetch_array($result_part);

                    if (($VAT_per == "1") or ( $VAT_per == "2")) {
                        $vatr = 100 + $row["GST"];
                        $PRICE = $row1["PRICE"] / $vatr * 100;
                    } else {
                        $PRICE = $row1["PRICE"];
                    }
                    $discount1 = $PRICE * $row1["QTY"] * $row1["DIS_per"] / 100;
                    $subtot = ($PRICE * $row1["QTY"]) - $discount1;
                    
                    $partNo = $row_item["PART_NO"];
                    $partNo1 =  str_pad($partNo, 22, "?");
                    $partNo1 = str_replace("?", "&nbsp;", $partNo1);
                    
                    $brand = $row_item["BRAND_NAME"];
                    $brand1 = str_pad($brand, 22, "?");
                    $brand1 = str_replace("?", "&nbsp;", $brand1);
                    $descript = substr($row_item["DESCRIPT"], 0, 26);
//                    $descript = "VALVE GUIDE - NISSAN";
                    
//1                    echo "<tr><td colspan=3 width=70%>" . $partNo1 . " " . $brand1 . " " . $row_item["DESCRIPT"] . "</td><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
                    echo "<tr><td width=20%>" . $partNo1 . "</td><td width=23%>" . $brand1 . "</td><td width=27%>" . $descript . "</td><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "&nbsp;&nbsp;&nbsp;</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
//2                    echo "<tr><td colspan=3 width=70%><table><tr><td>" . $partNo . "</td><td>" . $row_item["BRAND_NAME"] . "</td><td>" . $row_item["DESCRIPT"] . "</td></tr></table><td>" . number_format($row1["QTY"], 2, ".", ",") . "</td><td align=right width=5%>" . number_format($PRICE, 2, ".", ",") . "</td><td align=right>" . number_format($subtot, 2, ".", ",") . "</td></tr>";
                    $totsuntot = $totsuntot + $subtot;
                    $i = $i + 1;
                }
                while ($i < 16) {
                    echo "<tr><td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td></tr>";
                    $i = $i + 1;
                }
                ?>
                <tr><td>&nbsp;</td><tr>
                <tr><td colspan="5">Page 3 of 3 <?php if($_GET["isHideAdt"]=="false"){echo $copy;} ?></td><td><?php echo number_format($row["AMOUNT"]+$row["DISCOU"], 2, ".", ","); ?></td></tr>
                <tr><td colspan="5">&nbsp;</td><td><?php echo number_format($row["DISCOU"], 2, ".", ","); ?></td></tr>
                <tr><td colspan="5">&nbsp;</td><td><?php echo number_format($row["GRAND_TOT"], 2, ".", ","); ?></td></tr>
                <?php if ($isVat == 1) { ?><tr><td colspan="4">&nbsp;</td><td><?php echo "VAT " . $row["GST"] . "%"; ?></td><td><?php echo number_format($row["VAT_VAL"], 2, ".", ","); ?></td></tr> <?php } ?>
            </table>

    </body>
</html>
