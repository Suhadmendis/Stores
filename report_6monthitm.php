<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>6 Month Sales Report</title>

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
                font-size:14px;
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

//        if ($_GET["radio"] == "op_traget") {
//            tragetbrand();
//        } else {
        othersales();

//        }

        function othersales() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql = "delete from 6monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = $db->RunQuery($sql);
            $date = date("Y-m-d", strtotime($_GET["DTPicker1"]));
            $caldays = " - 90 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));
            $i = 0;

            // $strinv = "select sum(grand_tot/(1 +gst/100)) as gtot,c_code,month(sdate) as month ,year(sdate) as year,sal_ex,brand from s_salma where  CANCELL='0' ";
            if ($_SESSION['COMCODE'] == "C") {
                $strinv = "select stk_no,LEDINDI,sum(qty) as gtot,month(sdate) as month ,year(sdate) as year,sal_ex,brand_name from viewstran where  (LEDINDI='INV' or LEDINDI = 'GRN') ";
            } else {
                $strinv = "select sum((price-dis_rs)*qty) as gtot,c_code,month(sdate) as month ,year(sdate) as year,brand_name from viewstran where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and  CANCELL='0' ";
                $strinv = "select stk_no,LEDINDI,sum(qty) as gtot,month(sdate) as month ,year(sdate) as year,brand_name from viewstran  where mid(REF_NO, 1, 2)='" . $_SESSION['INVC'] . "' and  (LEDINDI='INV' or LEDINDI = 'GRN') ";
            }
			$strinv .= " and brand_name ='" . $_GET['cmbbrand'] . "'";
            
             

            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));
            $month4 = date("m", strtotime($_GET["month4"]));
            $month5 = date("m", strtotime($_GET["month5"]));
            $month6 = date("m", strtotime($_GET["month6"]));
            $month7 = date("m", strtotime($_GET["month7"]));
            $month8 = date("m", strtotime($_GET["month8"]));
            $month9 = date("m", strtotime($_GET["month9"]));
            $month10 = date("m", strtotime($_GET["month10"]));
            $month11 = date("m", strtotime($_GET["month11"]));
            $month12 = date("m", strtotime($_GET["month12"]));


            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));
            $month4_y = date("Y", strtotime($_GET["month4"]));
            $month5_y = date("Y", strtotime($_GET["month5"]));
            $month6_y = date("Y", strtotime($_GET["month6"]));
            $month7_y = date("Y", strtotime($_GET["month7"]));
            $month8_y = date("Y", strtotime($_GET["month8"]));
            $month9_y = date("Y", strtotime($_GET["month9"]));
            $month10_y = date("Y", strtotime($_GET["month10"]));
            $month11_y = date("Y", strtotime($_GET["month11"]));
            $month12_y = date("Y", strtotime($_GET["month12"]));


            $strinv.= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month4 . "'  and year(sdate) = '" . $month4_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month5 . "'  and year(sdate) = '" . $month5_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month6 . "'  and year(sdate) = '" . $month6_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month7 . "'  and year(sdate) = '" . $month7_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month8 . "'  and year(sdate) = '" . $month8_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month9 . "'  and year(sdate) = '" . $month9_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month10 . "'  and year(sdate) = '" . $month10_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month11 . "'  and year(sdate) = '" . $month11_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month12 . "'  and year(sdate) = '" . $month12_y . "')) ";
            $strinv .="  group by stk_no,year(sdate), month(sdate),brand_name, LEDINDI ";

            $mon1 = 0;
            $mon2 = 0;
            $mon3 = 0;
            $mon4 = 0;
            $mon5 = 0;
            $mon6 = 0;
            $mon7 = 0;
            $mon8 = 0;
            $mon9 = 0;
            $mon10 = 0;
            $mon11 = 0;
            $mon12 = 0;

            $Gmon12 = 0;
            $Gmon11 = 0;
            $Gmon10 = 0;
            $Gmon9 = 0;
            $Gmon8 = 0;
            $Gmon7 = 0;
            $Gmon6 = 0;
            $Gmon5 = 0;
            $Gmon4 = 0;
            $Gmon3 = 0;
            $Gmon2 = 0;
            $Gmon1 = 0;

            $j = 0;
            $i = 0;
//           	echo $strinv;
            $result2 = $db->RunQuery($strinv);
            while ($row_RSINVO01 = mysql_fetch_array($result2)) {

                $yy = "y";

                if ($yy == "y") {

                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $mon4 = 0;
                    $mon5 = 0;
                    $mon6 = 0;
                    $mon7 = 0;
                    $mon8 = 0;
                    $mon9 = 0;
                    $mon10 = 0;
                    $mon11 = 0;
                    $mon12 = 0;
                   
                    $Gmon12 = 0;
                    $Gmon11 = 0;
                    $Gmon10 = 0;
                    $Gmon9 = 0;
                    $Gmon8 = 0;
                    $Gmon7 = 0;
          
                    $Gmon6 = 0;
                    $Gmon5 = 0;
                    $Gmon4 = 0;
                    $Gmon3 = 0;
                    $Gmon2 = 0;
                    $Gmon1 = 0;
					if ($row_RSINVO01["LEDINDI"] == "INV") {
					$mtot = $row_RSINVO01["gtot"]; 	
					} else {
					$mtot = $row_RSINVO01["gtot"] *-1 ;
					}
					
                    $sql_rsVENDOR = "SELECT * FROM s_mas WHERE stk_no='" . trim($row_RSINVO01['STK_NO']) . "' ";
                    $result_rsVENDOR = $db->RunQuery($sql_rsVENDOR);
                    $row_rsVENDOR = mysql_fetch_array($result_rsVENDOR);
                    if ($month1 == $row_RSINVO01["month"] and $month1_y == $row_RSINVO01["year"]) {
                        $mon1 = ($mtot);
                    }
					
                    if ($month2 == $row_RSINVO01["month"] and $month2_y == $row_RSINVO01["year"]) {
                        $mon2 = ($mtot);
                    }
                    if ($month3 == $row_RSINVO01["month"] and $month3_y == $row_RSINVO01["year"]) {
                        $mon3 = ($mtot);
                    }
                    if ($month4 == $row_RSINVO01["month"] and $month4_y == $row_RSINVO01["year"]) {
                        $mon4 = ($mtot);
                    }
                    if ($month5 == $row_RSINVO01["month"] and $month5_y == $row_RSINVO01["year"]) {
                        $mon5 = ($mtot);
                    }
                    if ($month6 == $row_RSINVO01["month"] and $month6_y == $row_RSINVO01["year"]) {
                        $mon6 = ($mtot);
                    }
                    if ($month7 == $row_RSINVO01["month"] and $month7_y == $row_RSINVO01["year"]) {
                        $mon7 = ($mtot);
                    }
                    if ($month8 == $row_RSINVO01["month"] and $month8_y == $row_RSINVO01["year"]) {
                        $mon8 = ($mtot);
                    }
                    if ($month9 == $row_RSINVO01["month"] and $month9_y == $row_RSINVO01["year"]) {
                        $mon9 = ($mtot);
                    }
                    if ($month10 == $row_RSINVO01["month"] and $month10_y == $row_RSINVO01["year"]) {
                        $mon10 = ($mtot);
                    }
                    if ($month11 == $row_RSINVO01["month"] and $month11_y == $row_RSINVO01["year"]) {
                        $mon11 = ($mtot);
                    }
                    if ($month12 == $row_RSINVO01["month"] and $month12_y == $row_RSINVO01["year"]) {
                        $mon12 = ($mtot);
                    }

                    $cat = $row_rsVENDOR["CAT"];
//                    $sql_RSMONSALES = "insert into 6monsales(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12) values "
//                            . "('" . $row_RSINVO01['c_code'] . "', '" . $row_rsVENDOR["NAME"] . "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "' , '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "', '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "' )";
                    // $userData1[] = "('" . $row_RSINVO01['c_code'] . "', '" . $row_rsVENDOR["NAME"] . "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "' , '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "', '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "','" . $row_RSINVO01['sal_ex'] . "','" . $row_RSINVO01['brand'] . "', '".$_SESSION["CURRENT_USER"]."' )";

                    if ($i != 0) {
                        $insert = $insert . ", ";
                    }

                    $insert = $insert . " ('" . $row_RSINVO01['STK_NO'] . "', '" . $row_rsVENDOR["PART_NO"] . " " . $row_rsVENDOR["DESCRIPT"] .  "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "' , '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "', '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "','','" . $row_rsVENDOR['BRAND_NAME'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";


                    $i = 1;
                     
                }
            }


            //if ($j==50){	
            if ($insert != "") {
                $sql_RSMONSALES = "insert into 6monsales(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12,sal_ex,brand, user_id) values " . $insert;
                //echo $sql_RSMONSALES;
                //echo $sql_RSMONSALES;
                $result_rsVENDOR = $db->RunQuery($sql_RSMONSALES);
            }
            //$j=1;		
            $insert = "";
            //	}

            $i = $i + 1;



       





             
                PrintRep2();
             
        }

        function PrintRep2() {
            //echo "aaaa";
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql_head = "select * from invpara";
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
            $rtxtm4 = date("M", strtotime($_GET["month4"])) . " " . date("Y", strtotime($_GET["month4"]));
            $rtxtm5 = date("M", strtotime($_GET["month5"])) . " " . date("Y", strtotime($_GET["month5"]));
            $rtxtm6 = date("M", strtotime($_GET["month6"])) . " " . date("Y", strtotime($_GET["month6"]));
            $rtxtm7 = date("M", strtotime($_GET["month7"])) . " " . date("Y", strtotime($_GET["month7"]));
            $rtxtm8 = date("M", strtotime($_GET["month8"])) . " " . date("Y", strtotime($_GET["month8"]));
            $rtxtm9 = date("M", strtotime($_GET["month9"])) . " " . date("Y", strtotime($_GET["month9"]));
            $rtxtm10 = date("M", strtotime($_GET["month10"])) . " " . date("Y", strtotime($_GET["month10"]));
            $rtxtm11 = date("M", strtotime($_GET["month11"])) . " " . date("Y", strtotime($_GET["month11"]));
            $rtxtm12 = date("M", strtotime($_GET["month12"])) . " " . date("Y", strtotime($_GET["month12"]));

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            if ($_GET["radio"] == "Option2") {
                echo "<center>12 Month Sales Summery";
            } else {
                echo "<center>6 Month Sales Summery";
            }
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>
		<th>Code</th>
		
		<th>Name</th>
		
		<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
                <th>" . $rtxtm4 . "</th>   
                <th>" . $rtxtm5 . "</th>
                <th>" . $rtxtm6 . "</th>";

            if ($_GET["radio"] == "Option2") {
                echo "<th>" . $rtxtm7 . "</th>    
                <th>" . $rtxtm8 . "</th>    
                <th>" . $rtxtm9 . "</th>    
                <th>" . $rtxtm10 . "</th>    
                <th>" . $rtxtm11 . "</th>    
                <th>" . $rtxtm12 . "</th> ";
            }

            echo "<th>Total</th>";
            echo "<th>Per. Month Avg.</th>";
            echo "</tr>";
            //echo $sql;

            $month1_tot = 0;
            $month2_tot = 0;
            $month3_tot = 0;
            $month4_tot = 0;
            $month5_tot = 0;
            $month6_tot = 0;
            $month7_tot = 0;
            $month8_tot = 0;
            $month9_tot = 0;
            $month10_tot = 0;
            $month11_tot = 0;
            $month12_tot = 0;

            $sql_sql = "SELECT cus_code,cus_name from 6monsales where cus_code <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code,cus_name order by   sum(month1+month2+month3+month4+month5+month6+month7+month8+month9+month10+month11+month12) desc";
            $result_sql = $db->RunQuery($sql_sql);

            while ($row_sql = mysql_fetch_array($result_sql)) {
                $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12 from 6monsales where cus_code ='" . $row_sql["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
                $result_sql1 = $db->RunQuery($sql_sql1);

                while ($row_sql1 = mysql_fetch_array($result_sql1)) {

                    $sql_vendor = "select * from vendor where code ='" . $row_sql["cus_code"] . "' ";


                    echo "<tr>
				<td>" . $row_sql["cus_code"] . "</td>
				<td>" . $row_sql["cus_name"] . "</td>		
				<td align=\"right\">" . number_format($row_sql1["month1"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month4"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month5"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month6"], 0, ".", ",") . "</td>";
                    if ($_GET["radio"] == "Option2") {
                        echo "<td align=\"right\">" . number_format($row_sql1["month7"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month8"], 0, ".", ",") . "</td>                                
                                <td align=\"right\">" . number_format($row_sql1["month9"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month10"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month11"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month12"], 0, ".", ",") . "</td>";
                    }
                    $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"];
                    if ($_GET["radio"] == "Option2") {
                        $rowt = $rowt + $row_sql1["month7"] + $row_sql1["month8"] + $row_sql1["month9"] + $row_sql1["month10"] + $row_sql1["month11"] + $row_sql1["month12"];
                    }
                    echo "<td  align=\"right\" >" . number_format($rowt, 0, ".", ",") . "</td>";

                    if ($_GET["radio"] == "Option2") {
                        $avgmon = $rowt / 12;
                    } else {
                        $avgmon = $rowt / 6;
                    }

                    echo "<td  align=\"right\">" . number_format($avgmon, 0, ".", ",") . "</td>";

                    echo "</tr>";
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];
                    $month4_tot = $month4_tot + $row_sql1["month4"];
                    $month5_tot = $month5_tot + $row_sql1["month5"];
                    $month6_tot = $month6_tot + $row_sql1["month6"];
                    $month7_tot = $month7_tot + $row_sql1["month7"];
                    $month8_tot = $month8_tot + $row_sql1["month8"];
                    $month9_tot = $month9_tot + $row_sql1["month9"];
                    $month10_tot = $month10_tot + $row_sql1["month10"];
                    $month11_tot = $month11_tot + $row_sql1["month11"];
                    $month12_tot = $month12_tot + $row_sql1["month12"];
                }
            }
            echo "<tr>
			<th colspan='2'>Total</td>
			
			
			<th align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></th>	
			<th align=\"right\"><b>" . number_format($month4_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month5_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month6_tot, 0, ".", ",") . "</b></th>";
            if ($_GET["radio"] == "Option2") {
                echo "<th align=\"right\"><b>" . number_format($month7_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month8_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month9_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month10_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month11_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month12_tot, 0, ".", ",") . "</b></th>";
            }


            $rowft = $month1_tot + $month2_tot + $month3_tot + $month4_tot + $month5_tot + $month6_tot;
            if ($_GET["radio"] == "Option2") {
                $rowft = $rowft + $month7_tot + $month8_tot + $month9_tot + $month10_tot + $month11_tot + $month12_tot;
            }
            echo "<th  align=\"right\"><b>" . number_format($rowft, 0, ".", ",") . "</b></th>";


            if ($_GET["radio"] == "Option2") {
                $avgmon = $rowft / 12;
            } else {
                $avgmon = $rowft / 6;
            }

            echo "<th  align=\"right\"><b>" . number_format($avgmon, 0, ".", ",") . "</b></th>";



            echo "</tr>";
        }

        function PrintRep3() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql_head = "select * from invpara";
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
            $rtxtm4 = date("M", strtotime($_GET["month4"])) . " " . date("Y", strtotime($_GET["month4"]));
            $rtxtm5 = date("M", strtotime($_GET["month5"])) . " " . date("Y", strtotime($_GET["month5"]));
            $rtxtm6 = date("M", strtotime($_GET["month6"])) . " " . date("Y", strtotime($_GET["month6"]));
            $rtxtm7 = date("M", strtotime($_GET["month7"])) . " " . date("Y", strtotime($_GET["month7"]));
            $rtxtm8 = date("M", strtotime($_GET["month8"])) . " " . date("Y", strtotime($_GET["month8"]));
            $rtxtm9 = date("M", strtotime($_GET["month9"])) . " " . date("Y", strtotime($_GET["month9"]));
            $rtxtm10 = date("M", strtotime($_GET["month10"])) . " " . date("Y", strtotime($_GET["month10"]));
            $rtxtm11 = date("M", strtotime($_GET["month11"])) . " " . date("Y", strtotime($_GET["month11"]));
            $rtxtm12 = date("M", strtotime($_GET["month12"])) . " " . date("Y", strtotime($_GET["month12"]));

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>6 Month Sales Summery";
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>";

            if ($_GET["cmbreptype"] == "rep") {
                echo "<th>Rep Code</th>	
		  <th>Rep Name</th>";
            } else {
                echo "<th></th>	
		  <th>Brand Name</th>";
            }




            echo "<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
                <th>" . $rtxtm4 . "</th>   
                <th>" . $rtxtm5 . "</th>
                <th>" . $rtxtm6 . "</th>";

            if ($_GET["radio"] == "Option2") {
                echo "<th>" . $rtxtm7 . "</th>    
                <th>" . $rtxtm8 . "</th>    
                <th>" . $rtxtm9 . "</th>    
                <th>" . $rtxtm10 . "</th>    
                <th>" . $rtxtm11 . "</th>    
                <th>" . $rtxtm12 . "</th> ";
            }

            echo "<th>Total</th>";
            echo "<th>Per. Month Avg.</th>";
            echo "</tr>";
            //echo $sql;

            $month1_tot = 0;
            $month2_tot = 0;
            $month3_tot = 0;
            $month4_tot = 0;
            $month5_tot = 0;
            $month6_tot = 0;
            $month7_tot = 0;
            $month8_tot = 0;
            $month9_tot = 0;
            $month10_tot = 0;
            $month11_tot = 0;
            $month12_tot = 0;


            if ($_GET["cmbreptype"] == "rep") {
                $sql_sql = "SELECT sal_ex from 6monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'  group by sal_ex ";
            } else {
                $sql_sql = "SELECT brand from 6monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'  group by brand ";
            }
            $result_sql = $db->RunQuery($sql_sql);

            while ($row_sql = mysql_fetch_array($result_sql)) {

                if ($_GET["cmbreptype"] == "rep") {
                    $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12 from 6monsales where sal_ex ='" . $row_sql["sal_ex"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
                } else {
                    $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12 from 6monsales where brand ='" . $row_sql["brand"] . "'  and user_id='" . $_SESSION["CURRENT_USER"] . "'";
                }
                $result_sql1 = $db->RunQuery($sql_sql1);

                while ($row_sql1 = mysql_fetch_array($result_sql1)) {

                    if ($_GET["cmbreptype"] == "rep") {
                        $sql_vendor = "select * from s_salrep where repcode ='" . $row_sql["sal_ex"] . "' ";
                        $result_vendor = $db->RunQuery($sql_vendor);
                        $row_vendor = mysql_fetch_array($result_vendor);
                    }

                    echo "<tr>";

                    if ($_GET["cmbreptype"] == "rep") {
                        echo "<td>" . $row_sql["sal_ex"] . "</td>
				<td>" . $row_vendor["Name"] . "</td>";
                    } else {
                        echo "<td></td>
				<td>" . $row_sql["brand"] . "</td>";
                    }

                    echo "<td align=\"right\">" . number_format($row_sql1["month1"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month4"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month5"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month6"], 0, ".", ",") . "</td>";
                    if ($_GET["radio"] == "Option2") {
                        echo "<td align=\"right\">" . number_format($row_sql1["month7"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month8"], 0, ".", ",") . "</td>                                
                                <td align=\"right\">" . number_format($row_sql1["month9"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month10"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month11"], 0, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month12"], 0, ".", ",") . "</td>";
                    }
                    $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"];
                    if ($_GET["radio"] == "Option2") {
                        $rowt = $rowt + $row_sql1["month7"] + $row_sql1["month8"] + $row_sql1["month9"] + $row_sql1["month10"] + $row_sql1["month11"] + $row_sql1["month12"];
                    }
                    echo "<td  align=\"right\" >" . number_format($rowt, 0, ".", ",") . "</td>";

                    if ($_GET["radio"] == "Option2") {
                        $avgmon = $rowt / 12;
                    } else {
                        $avgmon = $rowt / 6;
                    }

                    echo "<td  align=\"right\">" . number_format($avgmon, 0, ".", ",") . "</td>";
                    echo "</tr>";
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];
                    $month4_tot = $month4_tot + $row_sql1["month4"];
                    $month5_tot = $month5_tot + $row_sql1["month5"];
                    $month6_tot = $month6_tot + $row_sql1["month6"];
                    $month7_tot = $month7_tot + $row_sql1["month7"];
                    $month8_tot = $month8_tot + $row_sql1["month8"];
                    $month9_tot = $month9_tot + $row_sql1["month9"];
                    $month10_tot = $month10_tot + $row_sql1["month10"];
                    $month11_tot = $month11_tot + $row_sql1["month11"];
                    $month12_tot = $month12_tot + $row_sql1["month12"];
                }
            }



            echo "<tr>
			<th colspan='2'>Total</th>
			
			
			<th align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></th>	
			<th align=\"right\"><b>" . number_format($month4_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month5_tot, 0, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month6_tot, 0, ".", ",") . "</b></th>";
            if ($_GET["radio"] == "Option2") {
                echo "<th align=\"right\"><b>" . number_format($month7_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month8_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month9_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month10_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month11_tot, 0, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month12_tot, 0, ".", ",") . "</b></th>";
            }


            $rowft = $month1_tot + $month2_tot + $month3_tot + $month4_tot + $month5_tot + $month6_tot;
            if ($_GET["radio"] == "Option2") {
                $rowft = $rowft + $month7_tot + $month8_tot + $month9_tot + $month10_tot + $month11_tot + $month12_tot;
            }
            echo "<th  align=\"right\"><b>" . number_format($rowft, 0, ".", ",") . "</b></th>";

            if ($_GET["radio"] == "Option2") {
                $avgmon = $rowft / 12;
            } else {
                $avgmon = $rowft / 6;
            }

            echo "<th  align=\"right\"><b>" . number_format($avgmon, 0, ".", ",") . "</b></th>";

            echo "</tr>";
        }
        ?>


    </body>
</html>
