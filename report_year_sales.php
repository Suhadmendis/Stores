<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Year Sales Report</title>

        <style>
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
                font-size:14px;

            }
            td
            {
                font-size:14px;;
                border-bottom:none;
                border-top:none;        

            }
        </style>

    </head>

    <body>


        <?php
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();

        if ($_GET["radio"] == "Option2") {
            nilsal();
        } else {
            othersales();
        }

        function nilsal() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql = "delete from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = $db->RunQuery($sql);
            $date = date("Y-m-d", strtotime($_GET["DTPicker1"]));
            $caldays = " - 90 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));
            $i = 0;

            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));
            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));


            $sqlv = "SELECT cus_code FROM view_brtrn_vendor  WHERE pen0  <>'1' and  opdate <= '" . $tmpdate . "'";
            if ($_GET["cmbrep"] != "All") {
                $sqlv .=" and rep= '" . $_GET['cmbrep'] . "'";
            }
            if ($_GET["ChKCUS"] == "on") {
                $sqlv .=" and cus_CODE= '" . trim($_GET["cuscode"]) . "'";
            }
            $sqlv .= " group by cus_code";

            $i = 0;
            $result_v = $db->RunQuery($sqlv);
            while ($row_v = mysql_fetch_array($result_v)) {

                if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ($_SESSION['COMCODE']=="R")) {
                    $strinv = "select sum(grand_tot/(1 +gst/100)) as gtot,brand,c_code,month(sdate) as month ,year(sdate) as year from s_salma where company='" . $_SESSION['company'] . "' and  CANCELL='0' ";
                } else {
                    $strinv = "select sum(grand_tot/(1 +gst/100)) as gtot,brand,c_code,month(sdate) as month ,year(sdate) as year from s_salma where  CANCELL='0' ";
                }
                if ($_GET["cmbrep"] != "All") {
                    $strinv .=" and sal_ex= '" . $_GET['cmbrep'] . "'";
                }
                if ($_GET["cmbbrand"] != "All") {
                    $strinv .=" and brand= '" . $_GET['cmbbrand'] . "'";
                }
                $strinv .=" and c_code= '" . trim($row_v["cus_code"]) . "'";
                $strinv.= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
                $strinv.= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
                $strinv.= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "')) ";
                $strinv .="  group by brand,c_code,year(sdate), month(sdate) ";


                $result2 = $db->RunQuery($strinv);
                $nmr = mysql_num_rows($result2);

                $strgrn = "select sum(amount/(1 +vatrate/100)) as gtot,CUSCODE,brand,month(sdate) as month ,year(sdate) as year from c_bal where  trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN'  and flag1 <> '1'";
                if ($_GET["cmbrep"] != "All") {
                    $strgrn .=" and SAL_EX ='" . $_GET['cmbrep'] . "'";
                }
                $strgrn .=" and cuscode= '" . trim($row_v["cus_code"]) . "'";
                if (!isset($_GET["chkdef"])) {
                    $strgrn .=" and trn_type <> 'DGRN'";
                }
                if ($_GET["cmbbrand"] != "All") {
                    $strgrn .=" and brand= '" . $_GET['cmbbrand'] . "'";
                }
                $strgrn.= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
                $strgrn.= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
                $strgrn.= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "')) ";
                $strgrn .="  group by brand,CUSCODE,year(sdate), month(sdate) ";

                $result2 = $db->RunQuery($strgrn);
//                if ($nmr==0 && mysql_num_rows($result2)>0)  
//                    {
//               
//                $nmr =0;
//                    } else {
                $nmr = $nmr + mysql_num_rows($result2);
                //}
                if ($nmr == 0) {
                    $sql = "select * from br_trn where  cus_code='" . trim($row_v["cus_code"]) . "' ";
                    if ($_GET["cmbrep"] != "All") {
                        $sql .=" and Rep ='" . $_GET['cmbrep'] . "'";
                    }
                    //echo $sql;
                    $result4 = $db->RunQuery($sql);
                    $lmt = 0;
                    $numr = mysql_num_rows($result4);
                    $exist = 0;

                    $cat = "";
                    if ($numr == 1) {
                        $row_tmpLmt = mysql_fetch_array($result4);
                        $lmt = $lmt + $row_tmpLmt["credit_lim"];

                        if ((trim($row_tmpLmt["CAT"]) != "") and ( trim($row_tmpLmt["CAT"]) != "D")) {
                            $exist = 1;
                            $cat = $row_tmpLmt["CAT"];
                        }
                    } else {

                        while ($row_tmpLmt = mysql_fetch_array($result4)) {
                            if (trim($row_tmpLmt["CAT"]) == "A") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                                $exist = 1;
                            }
                            if (trim($row_tmpLmt["CAT"]) == "B") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                                $exist = 1;
                            }
                            if (trim($row_tmpLmt["CAT"]) == "C") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                                $exist = 1;
                            }

                            if (trim($row_tmpLmt["CAT"]) == "Z") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                                $exist = 1;
                            }

                            if ($_GET["cmbrep"] != "All") {
                                $cat = $row_tmpLmt["CAT"];
                            }
                        }
                    }

                    if ($exist == 1) {
                        $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_v["cus_code"]) . "' ";
                        $result_rsVENDOR = $db->RunQuery($sql_rsVENDOR);
                        $row_rsVENDOR = mysql_fetch_array($result_rsVENDOR);

                        if ($_GET["cmbrep"] == "All") {
                            $cat = $row_rsVENDOR["CAT"];
                        }

                        if ($i != 0) {
                            $insert = $insert . ", ";
                        }

                        $insert = $insert . "('" . trim($row_v["cus_code"]) . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "',  '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "', '', '" . $_SESSION["CURRENT_USER"] . "')";

                        $i = 1;

                        //$sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand) values "
                        //    . "('" . trim($row_v["cus_code"]) . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '' )";
                        //$result_rsVENDOR = $db->RunQuery($sql_RSMONSALES);
                    }
                }
            }

            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE, brand, user_id) values " . $insert;
            //echo $sql_RSMONSALES;
            $result_rsVENDOR = $db->RunQuery($sql_RSMONSALES);
            PrintRep2();
        }

        function othersales() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql = "delete from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = $db->RunQuery($sql);
            $date = date("Y-m-d", strtotime($_GET["DTPicker1"]));
            $caldays = " - 90 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));
            $i = 0;



            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));
            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));

            if ($_SESSION['COMCODE'] == "C") {
                $strinv = "select sum(grand_tot) as gtot,brand,c_code,year(sdate) as year from s_salma where   CANCELL='0' ";
            } else {
                $strinv = "select sum(grand_tot) as gtot,brand,c_code,year(sdate) as year from s_salma where  company='" . $_SESSION['company'] . "' and CANCELL='0' ";
            }
            if ($_GET["cmbrep"] != "All") {
                $strinv .=" and sal_ex= '" . $_GET['cmbrep'] . "'";
            }
            if ($_GET["cmbbrand"] != "All") {
                $strinv .=" and brand= '" . $_GET['cmbbrand'] . "'";
            }

            if ($_GET["ChKCUS"] == "on") {
                $strinv .=" and c_code= '" . trim($_GET["cuscode"]) . "'";
            }
            //$month1 = substr($_GET["month1"], 5 , 2);  // date("m", strtotime($_GET["month1"]));

            $strinv.= " and ((  year(sdate) = '" . $month1_y . "') ";
            $strinv.= " or (  year(sdate) = '" . $month2_y . "') ";
            $strinv.= " or (  year(sdate) = '" . $month3_y . "')) ";
            $strinv .="  group by brand,c_code,year(sdate) ";

            $mon1 = 0;
            $mon2 = 0;
            $mon3 = 0;
            $Gmon3 = 0;
            $Gmon2 = 0;
            $Gmon1 = 0;

            $result2 = $db->RunQuery($strinv);
            while ($row_RSINVO01 = mysql_fetch_array($result2)) {

                $yy = "n";
                if ($_GET["radio"] == "op_traget") {

                    if (date("Y", strtotime($_GET["month1"])) >= "2014") {
                        $sql_itclas = "select * from brand_mas where b60 = '1' and barnd_name ='" . $row_RSINVO01['brand'] . "' ";
                    } else {
                        $sql_itclas = "select * from brand_mas where delinrate = '2.5' and barnd_name ='" . $row_RSINVO01['brand'] . "' ";
                    }
                    $result_itclas = $db->RunQuery($sql_itclas);

                    if (mysql_num_rows($result_itclas) > 0) {
                        $yy = "y";
                    }
                } else {
                    $yy = "y";
                }


                if ($yy == "y") {

                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $Gmon3 = 0;
                    $Gmon2 = 0;
                    $Gmon1 = 0;
                    $sql = "select * from br_trn where  cus_code='" . Trim($row_RSINVO01['c_code']) . "' ";
                    if ($_GET["cmbrep"] != "All") {
                        $sql .=" and Rep ='" . $_GET['cmbrep'] . "'";
                    }
                    $result4 = $db->RunQuery($sql);
                    $lmt = 0;
                    $numr = mysql_num_rows($result4);

                    if ($numr == 1) {
                        $row_tmpLmt = mysql_fetch_array($result4);
                        $lmt = $lmt + $row_tmpLmt["credit_lim"];
                    } else {

                        while ($row_tmpLmt = mysql_fetch_array($result4)) {
                            if (trim($row_tmpLmt["CAT"]) == "A") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                            }
                            if (trim($row_tmpLmt["CAT"]) == "B") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                            }
                            if (trim($row_tmpLmt["CAT"]) == "C") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                            }
                            if (trim($row_tmpLmt["CAT"]) == "Z") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                            }
                        }
                    }
                    $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_RSINVO01['c_code']) . "' ";
                    $result_rsVENDOR = $db->RunQuery($sql_rsVENDOR);
                    $row_rsVENDOR = mysql_fetch_array($result_rsVENDOR);
                    if ($month1_y == $row_RSINVO01["year"]) {
                        $mon1 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month2_y == $row_RSINVO01["year"]) {
                        $mon2 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month3_y == $row_RSINVO01["year"]) {
                        $mon3 = ($row_RSINVO01["gtot"]);
                    }
                    $cat = $row_rsVENDOR["CAT"];

                    if ($_GET["chkdevelo_cus"] == "on") {
                        if ($cat == "Z") {

                            //$sql_RSMONSALES = "delete from monsales where Cus_Code='" . $row_RSINVO01['c_code'] . "' and user_id = '".$_SESSION["CURRENT_USER"]."'";
                            //$result_RSMONSALES = $db->RunQuery($sql_RSMONSALES);


                            $userData1[] = "('" . $row_RSINVO01['c_code'] . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                        }
                    } else {

                        $userData1[] = "('" . $row_RSINVO01['c_code'] . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                    }
                }
            }


            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values " . implode(",", $userData1);
            $result_RSMONSALES = $db->RunQuery($sql_RSMONSALES);
            $i = $i + 1;



            //  }
            //$strinv = "select sum(GRAND_TOT/(1 +GST/100)) as gtot,brand,c_code from s_salma where ACCNAME <> 'NON STOCK'   and CANCELL='0' ";
            if ($_SESSION['COMCODE'] == "C") {
                $strgrn = "select sum(amount) as gtot,CUSCODE,brand,year(sdate) as year from c_bal where  trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN'  ";
            } else {
                $strgrn = "select sum(amount) as gtot,CUSCODE,brand,year(sdate) as year from c_bal where  trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN' and company='" . $_SESSION['company'] . "'";
            }
            //sum(amount/(1 +vatrate/100))
            if ($_GET["cmbrep"] != "All") {
                $strgrn .=" and SAL_EX ='" . $_GET['cmbrep'] . "'";
            }
            if ($_GET["ChKCUS"] == "on") {
                $strgrn .=" and CUSCODE ='" . $_GET['cuscode'] . "'";
            }
            if (!isset($_GET["chkdef"])) {
                $strgrn .=" and trn_type <> 'DGRN'";
            }
            if ($_GET["cmbbrand"] != "All") {
                $strgrn .=" and brand= '" . $_GET['cmbbrand'] . "'";
            }


            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));

            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));

            $strgrn.= " and (( year(sdate) = '" . $month1_y . "') ";
            $strgrn.= " or ( year(sdate) = '" . $month2_y . "') ";
            $strgrn.= " or ( year(sdate) = '" . $month3_y . "')) ";
            $strgrn .="  group by brand,CUSCODE,year(sdate) ";


            $mon1 = 0;
            $mon2 = 0;
            $mon3 = 0;
            $Gmon3 = 0;
            $Gmon2 = 0;
            $Gmon1 = 0;



            $result2 = $db->RunQuery($strgrn);
            while ($row_RSINVO01 = mysql_fetch_array($result2)) {

                $int = 0;
                if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ($_SESSION['COMCODE']=="R")) {
                    if ($row_cbal["trn_type"] == "GRN") {
                        if (substr($row_cbal["REFNO"], 5, 1) == $_SESSION['COMCODE']) {
                            $int = 1;
                        }
                    } else {
                        $int = 1;
                    }
                } else {
                    $int = 1;
                }

                if ($int == 1) {
                    $yy = "n";
                    if ($_GET["radio"] == "op_traget") {
                        if (date("Y", strtotime($_GET["month1"])) >= "2014") {
                            $sql_itclas = "select * from brand_mas where b60 = '1' and barnd_name ='" . $row_RSINVO01['brand'] . "' ";
                        } else {
                            $sql_itclas = "select * from brand_mas where delinrate = '2.5' and barnd_name ='" . $row_RSINVO01['brand'] . "' ";
                        }
                        $result_itclas = $db->RunQuery($sql_itclas);

                        if (mysql_num_rows($result_itclas) > 0) {
                            $yy = "y";
                        }
                    } else {
                        $yy = "y";
                    }


                    if ($yy == "y") {



                        $mon1 = 0;
                        $mon2 = 0;
                        $mon3 = 0;
                        $Gmon3 = 0;
                        $Gmon2 = 0;
                        $Gmon1 = 0;
                        $sql = "select * from br_trn where  cus_code='" . Trim($row_RSINVO01['CUSCODE']) . "' ";
                        if ($_GET["cmbrep"] != "All") {
                            $sql .=" and rep= '" . $_GET['cmbrep'] . "'";
                        }
                        $result4 = $db->RunQuery($sql);
                        $lmt = 0;
                        $numr = mysql_num_rows($result4);

                        if ($numr == 1) {
                            $row_tmpLmt = mysql_fetch_array($result4);
                            $lmt = $lmt + $row_tmpLmt["credit_lim"];
                        } else {
                            while ($row_tmpLmt = mysql_fetch_array($result4)) {
                                if (trim($row_tmpLmt["CAT"]) == "A") {
                                    $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                                }
                                if (trim($row_tmpLmt["CAT"]) == "B") {
                                    $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                                }
                                if (trim($row_tmpLmt["CAT"]) == "C") {
                                    $lmt = $lmt + $row_tmpLmt["credit_lim"];
                                }
                                if (trim($row_tmpLmt["CAT"]) == "Z") {
                                    $lmt = $lmt + $row_tmpLmt["credit_lim"];
                                }
                            }
                        }

                        $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_RSINVO01['CUSCODE']) . "' ";
                        $result_rsVENDOR = $db->RunQuery($sql_rsVENDOR);
                        $row_rsVENDOR = mysql_fetch_array($result_rsVENDOR);

                        if ($month1_y == $row_RSINVO01["year"]) {
                            $Gmon1 = $row_RSINVO01["gtot"];
                        }
                        if ($month2_y == $row_RSINVO01["year"]) {
                            $Gmon2 = $row_RSINVO01["gtot"];
                        }
                        if ($month3_y == $row_RSINVO01["year"]) {
                            $Gmon3 = $row_RSINVO01["gtot"];
                        }
                        $cat = $row_rsVENDOR["CAT"];

                        if ($_GET["chkdevelo_cus"] == "on") {
                            if ($cat == "Z") {

                                //$sql_RSMONSALES = "delete from monsales where Cus_Code='" . $row_RSINVO01['c_code'] . "' and user_id = '".$_SESSION["CURRENT_USER"]."'";
                                //$result_RSMONSALES = $db->RunQuery($sql_RSMONSALES);

                                $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values "
                                        . "('" . $row_RSINVO01['CUSCODE'] . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                                $result_RSMONSALES = $db->RunQuery($sql_RSMONSALES);
                            }
                        } else {
                            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values "
                                    . "('" . $row_RSINVO01['CUSCODE'] . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                            $result_RSMONSALES = $db->RunQuery($sql_RSMONSALES);
                        }
                    }
                }
            }

            if ($_GET["chkdevelo_cus"] == "on") {

                $sql_rsVENDOR = "SELECT * FROM vendor WHERE CAT='Z' ";
                $result_rsVENDOR = $db->RunQuery($sql_rsVENDOR);
                while ($row_rsVENDOR = mysql_fetch_array($result_rsVENDOR)) {

                    $sql_mon = "SELECT * FROM monsales WHERE Cus_Code='" . $row_rsVENDOR["CODE"] . "'";
                    $result_mon = $db->RunQuery($sql_mon);
                    if ($row_mon = mysql_fetch_array($result_mon)) {
                        
                    } else {
                        $sql_br = "SELECT * FROM br_trn WHERE cus_code='" . $row_rsVENDOR["CODE"] . "' and Rep='" . $_GET['cmbrep'] . "'";
                        $result_br = $db->RunQuery($sql_br);
                        if ($row_br = mysql_fetch_array($result_br)) {

                            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values "
                                    . "('" . $row_rsVENDOR["CODE"] . "', '" . $row_rsVENDOR["NAME"] . "', '" . $row_br["credit_lim"] . "', 'Z', '0', '0', '0', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_br['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                            $result_RSMONSALES = $db->RunQuery($sql_RSMONSALES);
                        }
                    }
                }
            }


//                    $i = $i + 1;
//                }
            //brand loop
            if ($_GET["radio"] == "op_traget") {
                PrintRep1();
            } else {
                PrintRep2();
            }
        }

        function PrintRep2() {
//            echo "aaaa";
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            if ($_GET["cmbrep"] != "All") {
                $rtxtrep = "Person : " . trim($_GET["cmbrep"]);
            }
            if ($_GET["cmbrep"] == "All") {
                $rtxtrep = "Person : " . $_GET["cmbrep"];
            }
            $rtxtbrand = "Brand : " . $_GET["cmbbrand"];

            $rtxtm1 = date("Y", strtotime($_GET["month3"]));
            $rtxtm2 = date("Y", strtotime($_GET["month2"]));
            $rtxtm3 = date("Y", strtotime($_GET["month1"]));

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>Yearly Sales Summery  ";
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>
		<th>Code</th>
		<th>Cat</th>
		<th>Customer Name</th>
		
		<th>" . $rtxtm1 . "</th>
		<th>%</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
		<th>3 Year Total</th>
		</tr>";
            //echo $sql;
            $month1 = 0;
            $month2 = 0;
            $month3 = 0;
            $limit = 0;
            $sql_sql = "SELECT cus_code,cus_name,cat,limit1 from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'  group by cus_code,cus_name,cat,limit1 order by sum(month3) desc";
            $result_sql = $db->RunQuery($sql_sql);

            while ($row_sql = mysql_fetch_array($result_sql)) {
                $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3 from monsales where cus_code ='" . $row_sql["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'  ";
                $result_sql1 = $db->RunQuery($sql_sql1);
                while ($row_sql1 = mysql_fetch_array($result_sql1)) {

                    $sql_vendor = "select * from vendor where code ='" . $row_sql["cus_code"] . "' ";
                    if ($row_sql1["month2"] != 0) {
                        $dif = $row_sql1["month3"] - $row_sql1["month2"];
                        $per = $dif / $row_sql1["month2"] * 100;
                        if($row_sql1["month2"]<0){
                            $per *= -1;
                        }
                    } else {
                        $per = 0;
                    }
                    echo "<tr>
				<td>" . $row_sql["cus_code"] . "</td>
				<td>" . $row_sql["cat"] . "</td>
				<td>" . $row_sql["cus_name"] . "</td>
				
				<td align=\"right\">" . number_format($row_sql1["month3"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($per, 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month1"], 0, ".", ",") . "</td>";
                    $three_month = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"];
                    echo "<td align=\"right\">" . number_format($three_month, 0, ".", ",") . "</td>
				</tr>";
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];
                    $limit = $limit + $row_sql["limit1"];
                }
            }

            ////add year % diff/////
            if ($month2_tot != 0) {
                $dif = $month3_tot - $month2_tot;
                $per = $dif / $month2_tot * 100;
            } else {
                $per = 0;
            }
            ////
            echo "<tr>
			<td colspan='3'>Total</td>
			
			
			<td align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($per, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></td>	
			</tr>";
        }

        function PrintRep1() {
//            echo "aaaa";
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql_head = "select * from invpara where COMCODE = '" .$_SESSION["company"]. "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            if ($_GET["cmbrep"] != "All") {
                $rtxtrep = "Person : " . trim($_GET["cmbrep"]);
            }
            if ($_GET["cmbrep"] == "All") {
                $rtxtrep = "Person : " . $_GET["cmbrep"];
            }
            $rtxtbrand = "Brand : " . $_GET["cmbbrand"];

            $rtxtm1 = date("M", strtotime($_GET["month1"])) . " " . date("Y", strtotime($_GET["month1"]));
            $rtxtm2 = date("M", strtotime($_GET["month2"])) . " " . date("Y", strtotime($_GET["month2"]));
            $rtxtm3 = date("M", strtotime($_GET["month3"])) . " " . date("Y", strtotime($_GET["month3"]));

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>Monthly Sales Summery  ";
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>
		<th>Code</th>
		<th>Cat</th>
		<th>Customer Name</th>
		<th>Brand</th>
		<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
		</tr>";
            //echo $sql;
            $month1 = 0;
            $month2 = 0;
            $month3 = 0;
            $limit = 0;

            if ($_GET["radio"] == "op_traget") {
                if ($_GET["txt_amou"] > 0) {
                    $sql_sql = "SELECT cus_code,cus_name,limit1 from monsales where month1 >" . $_GET["txt_amou"] . " and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code,cus_name ,limit1";
                } else {
                    $sql_sql = "SELECT cus_code,cus_name,limit1 from monsales where (month1<>0 or month2<>0 or month3<>0) and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code,cus_name ,limit1";
                }
            } else {
                $sql_sql = "SELECT cus_code,cus_name,limit1 from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'  group by cus_code,cus_name,limit1";
            }
            $result_sql = $db->RunQuery($sql_sql);
            while ($row_sql = mysql_fetch_array($result_sql)) {
                echo "<tr>
				<td>" . $row_sql["cus_code"] . "</td>
				<td></td>
				<td  colspan='5'>" . $row_sql["cus_name"] . "</td>
				 
				</tr>";
                $sql_sql1 = "SELECT brand,sum(month1)as month1,sum(month2) as month2,sum(month3) as month3 from monsales where cus_code ='" . $row_sql["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'  group by brand ";
                $result_sql1 = $db->RunQuery($sql_sql1);
                $month1 = 0;
                $month2 = 0;
                $month3 = 0;
                while ($row_sql1 = mysql_fetch_array($result_sql1)) {
                    echo "<tr>
				<td  colspan='3'></td>
				 
				<td>" . $row_sql1["brand"] . "</td>
				<td align=\"right\">" . number_format($row_sql1["month1"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 0, ".", ",") . "</td>
				</tr>";
                    $month1 = $month1 + $row_sql1["month1"];
                    $month2 = $month2 + $row_sql1["month2"];
                    $month3 = $month3 + $row_sql1["month3"];
                    $limit = $limit + $row_sql["limit1"];
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];
                }

                echo "<tr>
			<td colspan='4'></td>
			 
			<td align=\"right\"><b>" . number_format($month1, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month3, 0, ".", ",") . "</b></td>
			</tr>";
            }
            echo "<tr>
			<td  colspan='4' >Total</td>
			 
			<td align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></td>
			
			</tr>";

            echo "<tr>
			<td  colspan='4' >% From Credit Limit </td>
			 
			<td align=\"right\"><b>" . number_format($month1_tot / $limit * 100, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2_tot / $limit * 100, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month3_tot / $limit * 100, 0, ".", ",") . "</b></td>
			
			</tr>";
        }

//custom loop
        //cus list
//function end
        ?>


    </body>
</html>
