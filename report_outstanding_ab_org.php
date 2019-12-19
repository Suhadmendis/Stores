<?php
session_start();
date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Outstanding Report</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:12px;
            }
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {

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
                border-bottom:none;
                border-top:none;
            }
        </style>
</head>

    <body>
        <!-- Progress bar holder -->


        <?php
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();



        if ($_GET["radio2"] == "optcur") {
            if ($_GET["radio"] == "optinv") {
                currentrepinv();
            }
            if ($_GET["radio"] == "optcus") {
                currentrepinv();
            }
            if ($_GET["radio"] == "optscrap") {
                currentrepscrap();
            }
        }


        if ($_GET["radio2"] == "optdate") {

            //  $inv= "Select C_CODE, NAME, REF_NO, SDATE, GRAND_TOT, sum(ST_PAID) as paid from  view_sttr_salma1 where SDATE <= '" & $_GET["dtdate"] & "' and ST_DATE <= '" & $_GET["dtdate"] & "' AND S_DEV = '0' group by C_CODE, NAME, REF_NO, SDATE, GRAND_TOT order by C_CODE  ";

            $sql = "delete from tmpoutinv ";
            $result = $db->RunQuery($sql);

            $sql_inv = "Select C_CODE, NAME, REF_NO, SDATE, GRAND_TOT, rep, sum(ST_PAID) as paid from  view_sttr_salma1 where SDATE <= '" . $_GET["dtdate"] . "' and ST_DATE <= '" . $_GET["dtdate"] . "' and DEV='0' group by C_CODE, NAME, REF_NO, SDATE, GRAND_TOT order by C_CODE  ";
            $result_inv = $db->RunQuery($sql_inv);
            //echo $sql_inv;
            while ($row_inv = mysql_fetch_array($result_inv)) {
                $sql_tmpinv = "insert into tmpoutinv(REF_NO, Customer, Cus_Code, AMOUNT, paid, SDATE, sal_ex) values ('" . $row_inv["REF_NO"] . "', '" . $row_inv["NAME"] . "', '" . $row_inv["C_CODE"] . "', " . $row_inv["GRAND_TOT"] . ", " . $row_inv["paid"] . ", '" . $row_inv["SDATE"] . "', '" . $row_inv["rep"] . "')";

                $result_tmpinv = $db->RunQuery($sql_tmpinv);
            }

            $sql_inv = "Select C_CODE, NAME, REF_NO, SDATE, GRAND_TOT, rep, sum(ST_PAID) as paid from  view_sttr_salma1 where SDATE <= '" . $_GET["dtdate"] . "' and ST_DATE > '" . $_GET["dtdate"] . "'   and DEV='0' group by C_CODE, NAME, REF_NO, SDATE, GRAND_TOT order by C_CODE ";
            $result_inv = $db->RunQuery($sql_inv);
            //echo $sql_inv;
            while ($row_inv = mysql_fetch_array($result_inv)) {
                $sql_tmpinv = "insert into tmpoutinv(REF_NO, Customer, Cus_Code, AMOUNT, paid, SDATE, sal_ex) values ('" . $row_inv["REF_NO"] . "', '" . $row_inv["NAME"] . "', '" . $row_inv["C_CODE"] . "', " . $row_inv["GRAND_TOT"] . ", 0, '" . $row_inv["SDATE"] . "', '" . $row_inv["rep"] . "')";
                $result_tmpinv = $db->RunQuery($sql_tmpinv);
            }


            $sql_inv = "Select C_CODE, CUS_NAME, REF_NO, SDATE, rep, GRAND_TOT from view_salma_vendor where SDATE <= '" . $_GET["dtdate"] . "' and CANCELL = '0' and TOTPAY = '0' and GRAND_TOT > '1' AND DEV = '0' ";
            //echo $sql_inv;
            $result_inv = $db->RunQuery($sql_inv);

            while ($row_inv = mysql_fetch_array($result_inv)) {

                $rst_cus = "select * from vendor where CODE='" . $row_inv["C_CODE"] . "'";
                $result_cus = $db->RunQuery($rst_cus);
                $row_cus = mysql_fetch_array($result_cus);

                $sql_tmpinv = "insert into tmpoutinv(REF_NO, Customer, Cus_Code, AMOUNT, paid, SDATE, sal_ex) values ('" . $row_inv["REF_NO"] . "', '" . $row_cus["NAME"] . "', '" . $row_inv["C_CODE"] . "', " . $row_inv["GRAND_TOT"] . ", 0, '" . $row_inv["SDATE"] . "', '" . $row_inv["rep"] . "')";
                $result_tmpinv = $db->RunQuery($sql_tmpinv);
            }




            $sql_head = "select * from invpara where COMCODE='" . $_SESSION['company'] . "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";



            echo "<center>" . $heading . "</center><br>";


            if ($_GET["radio"] == "optinv") {

                $heading = "<center>OutStanding Report On  " . $_GET["dtdate"] . "  Invoice Wise ";
                $heading .= "Brand   :  " . $_GET["cmbbrand"] . "</center>";

                echo $heading;

                echo "<center><table border=1><tr>
		<th>Customer</th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		</tr>";
                //echo $sql;

                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 order by Cus_Code";
                } else {
                    $sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 and sal_ex='" . $_GET["cmbrep"] . "' order by Cus_Code";
                }


                $baltot = 0;
                $result = $db->RunQuery($sql);
                while ($row = mysql_fetch_array($result)) {
                    echo "<tr>
			<td>" . $row["Cus_Code"] . " " . $row["Customer"] . "</td>
			<td>" . $row["SDATE"] . "</td>
			<td></td>
			<td>" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"] - $row["paid"], 2, ".", ",") . "</td>";
                    $baltot = $baltot + ($row["AMOUNT"] - $row["paid"]);


                    echo "</tr>";
                }

                echo "<tr>
			<td colspan=4>" . $row["SDATE"] . "</td>
			
			<td align=\"right\"><b>" . number_format($baltot, 2, ".", ",") . "</b></td>
			
			</tr>";

                echo "<table>";
            }




            if ($_GET["radio"] == "optcus") {

                $heading = "Outstanding Report on  " . $_GET["dtdate"] . "     Customer Wise Over  " . $_GET["txtdays"] . "  Days";
                $heading .= "Brand   :  " . $_GET["cmbbrand"];




                echo "<center><table border=1><tr>
		<th>Customer Code</th>
		<th>Customer Name</th>
		<th>Amount</th>
		<th>Balance</th>
		</tr>";
                //echo $sql;


                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 order by Cus_Code";
                } else {
                    $sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 and sal_ex='" . $_GET["cmbrep"] . "' order by Cus_Code";
                }


                $baltot = 0;
                $result = $db->RunQuery($sql);
                while ($row = mysql_fetch_array($result)) {
                    echo "<tr>
			<td>" . $row["Cus_Code"] . "</td>
			<td>" . $row["Customer"] . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			
			<td align=\"right\">" . number_format($row["AMOUNT"] - $row["paid"], 2, ".", ",") . "</td>";
                    $baltot = $baltot + ($row["AMOUNT"] - $row["paid"]);


                    echo "</tr>";
                }

                echo "<tr>
			<td colspan=3>" . $row["SDATE"] . "</td>
			
			<td align=\"right\"><b>" . number_format($baltot, 2, ".", ",") . "</b></td>
			
			</tr>";

                echo "<table>";
            }
        }

/////////// Sales Summery////////////////////////////////////////
        function currentrepinv() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $txtrepono = date("Y-m-d") . "  " . date("H-m-s");

            $date = date("Y-m-d");
            $caldays = " - " . $_GET["txtdays"] . " days";
            $tmpdate = date('Y-m-d', strtotime($caldays));

            $date = date("Y-m-d");
            $caldays = " - " . $_GET["txtover"] . " days";
            $tmpover = date('Y-m-d', strtotime($caldays));

            $date = date("Y-m-d");
            $caldays = " - " . $_GET["txtdb"] . " days";
            $tmpbellow = date('Y-m-d', strtotime($caldays));



            $rep = $_GET["cmbrep"];


            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkpe"] != "on") {
                    if ($_GET["cmbdev"] == "All") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "') and CANCELL='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "') and CANCELL='0' order by CUS_NAME, SDATE";
//                                                                echo $sql;
							}	
                        }

                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' order by CUS_NAME, SDATE";
							}	
                        }
                    }
                    if ($_GET["cmbdev"] == "Computer") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							}	
                        }
                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							}	
                        }
                    }

                    if ($_GET["cmbdev"] == "Manual") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' order by CUS_NAME, SDATE";
							}	
                        }
                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1'order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1'order by CUS_NAME, SDATE";
							}	
                        }
                    }
                }

                if ($_GET["chkpe"] == "on") {
                    if ($_GET["cmbdev"] == "All") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "')  and CANCELL='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "')  and CANCELL='0' order by CUS_NAME, SDATE";
							}	
                        }

                        if ($_GET["cmbrep"] != "All") {
//echo "2";		
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' order by CUS_NAME, SDATE";
							}	
                        }
                    }

                    if ($_GET["cmbdev"] == "Computer") {
                        if ($_GET["cmbrep"] == "All") {
//echo "3";
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "' or SDATE='" . $tmpover . "') and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "' or SDATE='" . $tmpover . "') and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							}	
                        }

                        if ($_GET["cmbrep"] != "All") {
//echo "4";
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "' and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "' and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' order by CUS_NAME, SDATE";
							}	
                        }
                    }

                    if ($_GET["cmbdev"] == "Manual") {
                        if ($_GET["cmbrep"] == "All") {
//echo "5";
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "' or SDATE='" . $tmpover . "') and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "' or SDATE='" . $tmpover . "') and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' order by CUS_NAME, SDATE";
							}	
                        }

                        if ($_GET["cmbrep"] != "All") {
                      //echo "12";
					  		if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "' and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "' and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "' or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' order by CUS_NAME, SDATE";
							}	
                        }
                    }
                }
            }



            if ($_GET["cmbbrand"] != "All") {
                if ($_GET["chkpe"] != "on") {
                    if ($_GET["cmbdev"] == "All") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "' or SDATE='" . $tmpdate . "') and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "' or SDATE='" . $tmpdate . "') and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                    }

                    if ($_GET["cmbdev"] == "Computer") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                    }

                    if ($_GET["cmbdev"] == "Manual") {

                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
									$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
								} else {
									$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
								}	
							}	
                        }
                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                    }
                }

                if ($_GET["chkpe"] == "on") {
                    if ($_GET["cmbdev"] == "All") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "')  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "')  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }

                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                    }

                    if ($_GET["cmbdev"] == "Computer") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0'and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0'and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }

                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                    }

                    if ($_GET["cmbdev"] == "Manual") {
                        if ($_GET["cmbrep"] == "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                        if ($_GET["cmbrep"] != "All") {
							if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="R")){	
                            	$sql = "SELECT * from view_salma_vendor where mid(REF_NO, 1, 2)='".$_SESSION['INVC']."' and GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1'  and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							} else {
								$sql = "SELECT * from view_salma_vendor where  GRAND_TOT - TOTPAY >10 and rep='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1'  and Brand='" . $_GET["cmbbrand"] . "' order by CUS_NAME, SDATE";
							}	
                        }
                    }
                }
            }

            // echo $sql;
            $sql_head = "select * from invpara where COMCODE='" . $_SESSION['company'] . "'";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

            if ($_GET["chkpe"] != "on") {
                $heading = "OutStanding Report On  " . date("Y-m-d") . "  Invoice Wise     Over  " . $_GET["txtdays"] . "  Days";
            }
            if ($_GET["chkpe"] == "on") {
                $heading = "OutStanding Report On  " . date("Y-m-d") . "  Invoice Wise     Over  " . $_GET["txtover"] . " and bellow " . $_GET["txtdb"] . "  Days";
            }

            //echo "<center>".$heading."</center><br>";



            echo "<center>Rep :" . $_GET["cmbrep"] . "</center>";

            $rep = $_GET["cmbrep"];

            $date = date("Y-m-d");
            $caldays = " - 119 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));

            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["cmbdev"] == "All") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and CANCELL='0'";
                    }

                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and rep='" . $rep . "'  and CANCELL='0'";
                    }
                }

                if ($_GET["cmbdev"] == "Manual") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='1'  and CANCELL='0' ";
                    }

                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and rep='" . $rep . "' and DEV='1'  and CANCELL='0' ";
                    }
                }

                if ($_GET["cmbdev"] == "Computer") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='0'  and CANCELL='0' ";
                    }

                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and rep='" . $rep . "' and DEV='0'  and CANCELL='0'";
                    }
                }
            }


            $date = date("Y-m-d");
            $caldays = " - 119 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));

            if ($_GET["cmbbrand"] != "All") {
                if ($_GET["cmbdev"] == "All") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'";
                    }

                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and rep='" . $rep . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }

                if ($_GET["cmbdev"] == "Manual") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and rep='" . $rep . "' and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
                    }
                }

                if ($_GET["cmbdev"] == "Computer") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and rep='" . $rep . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }
            }


            $result1 = $db->RunQuery($rst1);
            $row1 = mysql_fetch_array($result1);
            $txtover120 = $row1["over120"];

            $date = date("Y-m-d");
            $caldays = " - 120 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));

            $date = date("Y-m-d");
            $caldays = " - 89 days";
            $tmpdate2 = date('Y-m-d', strtotime($date . $caldays));

            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["cmbdev"] == "All") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "'  and CANCELL='0'";
                    }
                }

                if ($_GET["cmbdev"] == "Computer") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "' and DEV='0'  and CANCELL='0' ";
                    }
                }

                if ($_GET["cmbdev"] == "Manual") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1' and CANCELL='0' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "'and DEV='1'  and CANCELL='0'";
                    }
                }
            }

            $date = date("Y-m-d");
            $caldays = " - 120 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));


            $date = date("Y-m-d");
            $caldays = " - 89 days";
            $tmpdate2 = date('Y-m-d', strtotime($date . $caldays));

            if ($_GET["cmbbrand"] != "All") {
                if ($_GET["cmbdev"] == "All") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "'  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }

                if ($_GET["cmbdev"] == "Computer") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }

                if ($_GET["cmbdev"] == "Manual") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1' and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "'and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }
            }

            $result1 = $db->RunQuery($rst1);
            $row1 = mysql_fetch_array($result1);
            $txt90to120 = $row1["t90to120"];

            $date = date("Y-m-d");
            $caldays = " - 90 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));

            $date = date("Y-m-d");
            $caldays = " - 59 days";
            $tmpdate2 = date('Y-m-d', strtotime($date . $caldays));

            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["cmbdev"] == "All") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "'  and CANCELL='0'";
                    }
                }

                if ($_GET["cmbdev"] == "Computer") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "' and DEV='0'  and CANCELL='0' ";
                    }
                }

                if ($_GET["cmbdev"] == "Manual") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1'  and CANCELL='0' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "' and DEV='1'   and CANCELL='0'";
                    }
                }
            }

            if ($_GET["cmbbrand"] != "All") {
                if ($_GET["cmbdev"] == "All") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }

                if ($_GET["cmbdev"] == "Computer") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "' and DEV='0'  and CANCELL='0'   and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }

                if ($_GET["cmbdev"] == "Manual") {
                    if ($_GET["cmbrep"] == "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1'  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' ";
                    }
                    if ($_GET["cmbrep"] != "All") {
                        $rst1 = "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from view_salma_vendor where  GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and rep='" . $rep . "' and DEV='1'   and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
                    }
                }
            }


            $result1 = $db->RunQuery($rst1);
            $row1 = mysql_fetch_array($result1);
            $txt60to90 = $row1["t60to90"];





            //echo $rst1;
            $txtbrand = "<center>Brand   :  " . $_GET["cmbbrand"] . "</center><br>";

            echo "<center>" . $heading . "</center><br>";





			$i=0;
            $sqld = "delete from tmpout where user_id = '" . $_SESSION["CURRENT_USER"] . "'";
            $result = $db->RunQuery($sqld);
//            echo "test 2 $sql";
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {
//                echo "test 3";
//                die();
                $date1 = date("Y-m-d");
                $date2 = $row["SDATE"];

                $diff = abs(strtotime($date2) - strtotime($date1));
                $days = floor($diff / (60 * 60 * 24));

                $sqlv = "select * from vendor where code ='" . $row['C_CODE'] . "'";
                $resultv = $db->RunQuery($sqlv);
                $rowv = mysql_fetch_array($resultv);
				/*
			  	if (($_SESSION['COMCODE']=="A") or ($_SESSION['COMCODE']=="C")){
			  		if (substr($row["REF_NO"], 0, 1) == "P" or $row["company"]=="A" ) {
						if ($i%50==0){
							$j=$i/50;
						} else {
							$insert[$j]=$insert[$j].", ";
						}
				 
				  		$insert[$j] = $insert[$j]." ('" . $row["REF_NO"] . "','" . $row["SDATE"] . "','" . $row["GRAND_TOT"] . "','" . $row["TOTPAY"] . "','" . $row["rep"] . "','" . $days . "','" . $row['C_CODE'] . "','" . $_SESSION["CURRENT_USER"] . "','" . $rowv['NAME'] . "')";
				  		$i=$i+1;
					}	
			  	}	  
              
            
			  	if (($_SESSION['COMCODE']=="R") or ($_SESSION['COMCODE']=="C")){
			  		if (substr($row["REF_NO"], 0, 1) == "R" or $row["company"]=="R" ) {
						if ($i%50==0){
							$j=$i/50;
						} else {
							$insert[$j]=$insert[$j].", ";
						}
			
				  		$insert[$j] = $insert[$j]." ('" . $row["REF_NO"] . "','" . $row["SDATE"] . "','" . $row["GRAND_TOT"] . "','" . $row["TOTPAY"] . "','" . $row["rep"] . "','" . $days . "','" . $row['C_CODE'] . "','" . $_SESSION["CURRENT_USER"] . "','" . $rowv['NAME'] . "')";
				  		$i=$i+1;
					}	
			  	}	  
              
            
			
				if (($_SESSION['COMCODE']=="B") or ($_SESSION['COMCODE']=="C")){	
			  		if (substr($row["REF_NO"], 0, 1) == "T" or $row["company"]=="B" ) {
						if ($i%50==0){
							$j=$i/50;
						} else {
							$insert[$j]=$insert[$j].", ";
						}
				 
				  		$insert[$j] = $insert[$j]." ('" . $row["REF_NO"] . "','" . $row["SDATE"] . "','" . $row["GRAND_TOT"] . "','" . $row["TOTPAY"] . "','" . $row["rep"] . "','" . $days . "','" . $row['C_CODE'] . "','" . $_SESSION["CURRENT_USER"] . "','" . $rowv['NAME'] . "')";
				  		$i=$i+1;
					}	
			  	}	  
                                */
            
			
				if ($_SESSION['COMCODE']=="C"){	
			  		//if (substr($row["REF_NO"], 0, 1) == "X" or $row["company"]=="C") {
						if ($i%50==0){
							$j=$i/50;
						} else {
							$insert[$j]=$insert[$j].", ";
						}
				 
				  		$insert[$j] = $insert[$j]." ('" . $row["REF_NO"] . "','" . $row["SDATE"] . "','" . $row["GRAND_TOT"] . "','" . $row["TOTPAY"] . "','" . $row["rep"] . "','" . $days . "','" . $row['C_CODE'] . "','" . $_SESSION["CURRENT_USER"] . "','" . $rowv['NAME'] . "')";
				  		$i=$i+1;
					//}	
			  	}	  
              
            }
            
			$k=0;
			while ($j>=$k){
				$sql1 = "INSERT into tmpout (refno,sdate,amount,paid,rep,days,c_code,user_id,cus_name) values ".$insert[$k];
				   	//echo $sql_tmp."</br>";                   
                                $resultp = $db->RunQuery($sql1);
				
				$k=$k+1;	
			} 	
				
            if ($_GET["cmbbrand"] == "All") {            
            $sql1 = "SELECT * from view_scheq_vendor where  CR_FLAG='0' and  CR_CHEVAL>PAID+1";
            if ($_GET["cmbrep"] != "All") {
                $sql1 = $sql1 . " and rep='" . $rep . "'";
            }

            if ($_GET["chkpe"] == "on") {
                $sql1 = $sql1 . " and (CR_DATE<'" . $tmpover . "' or CR_DATE='" . $tmpover . "') and (CR_DATE>'" . $tmpbellow . "' or CR_DATE='" . $tmpbellow . "') ";
            }
			
			$i=0;
			//echo $sql1;
            $result1 = $db->RunQuery($sql1);
            while ($row = mysql_fetch_array($result1)) {
                $date1 = date("Y-m-d");
                $date2 = $row["CR_DATE"];

                $diff = abs(strtotime($date2) - strtotime($date1));
                $days = floor($diff / (60 * 60 * 24));

                $sqlv = "select * from vendor where code ='" . $row['CR_C_CODE'] . "'";
                $resultv = $db->RunQuery($sqlv);
                $rowv = mysql_fetch_array($resultv);

				if ($i%50==0){
					$j=$i/50;
				} else {
					$insert1[$j]=$insert1[$j].", ";
				}
				 
				 $refno=$row["CR_REFNO"]." - ".$row["CR_CHNO"];
				  $insert1[$j] = $insert1[$j]." ('" . $refno . "','" . $row["CR_DATE"] . "','" . $row["CR_CHEVAL"] . "','" . $row["PAID"] . "','" . $days . "','" . $row['CR_C_CODE'] . "','" . $_SESSION["CURRENT_USER"] . "','" . $rowv['NAME'] . "')";
				  $i=$i+1;
				 
				 
				  
              
            }
			
			$k=0;
			while ($j>=$k){
				$sql1 = "INSERT into tmpout (refno,sdate,amount,paid,days,c_code,user_id,cus_name) values ".$insert1[$k];
				   //	echo $sql1."</br>";                   
                $resultp = $db->RunQuery($sql1);
				
				$k=$k+1;	
			}
        }	
         

            $ccode = "";
			$htmltxt="";
			$excel="<table>";


            if ($_GET["radio"] == "optinv") {
				if ($_GET["chktxt"] != "on") {
                	$htmltxt =$htmltxt. "<center><table border=1><tr>
		<th>Rep No</th>
		<th>Invoice Date</th>
		<th>Invoice No</th>
		<th>Days</th>
		<th>Grand Tot</th>
		<th>Balance</th>
		</tr>";
				}
            }
            if ($_GET["radio"] == "optcus") {
                $htmltxt =$htmltxt. "<center><table border=1><tr>
		<th>Customer Code</th>
		<th>Customer Name</th>
		<th>Amount</th>
		<th>Balance</th>
		</tr>";
            }
            $sql = "select c_code,cus_name from tmpout where user_id = '" . $_SESSION["CURRENT_USER"] . "' group by c_code,cus_name order by cus_name";
            $totbal = 0;
            $balance = 0;
            $i = 0;
			
            if ($_GET["radio"] == "optinv") {
                $result = $db->RunQuery($sql);
                while ($row = mysql_fetch_array($result)) {
                    $sql = "select * from tmpout where c_code ='" . $row['c_code'] . "' and user_id = '" . $_SESSION["CURRENT_USER"] . "'";
                    $result1 = $db->RunQuery($sql);


                    $htmltxt =$htmltxt. "<tr><th align=\"left\" colspan='6'>" . $row['c_code'] . " " . $row['cus_name'] . "</th></tr>";

                    $balance = 0;
                    while ($row1 = mysql_fetch_array($result1)) {
                       $htmltxt =$htmltxt."<tr>
			<td>" . $row1["rep"] . "</td>
			<td>" . $row1["sdate"] . "</td>
                        <td>" . $row1["refno"] . "</td>
                        <td align=\"right\">" . $row1["days"] . "</td>
                        <td align=\"right\">" . number_format($row1["amount"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format(($row1["amount"] - $row1["paid"]), 2, ".", ",") . "</td>
			</tr>";
                        $balance = $balance + ($row1["amount"] - $row1["paid"]);
                        $totbal = $totbal + $row1["amount"] - $row1["paid"];
						
						//if ($_GET["chktxt"] == "on") {
							$bal=$row1["amount"] - $row1["paid"];
							$txt=$txt.$row1["refno"].",".$row1["sdate"].",".$row['c_code'].",".$bal.",".$row["cus_name"]."\n";
							$excel=$excel."<tr><td>".$row1["refno"]."</td><td>".$row1["sdate"]."</td><td>".$row['c_code']."</td><td>".$bal."</td><td>".$row["cus_name"]."</td></tr>";
								
						//}
                    }
                    $htmltxt =$htmltxt. "<tr>
			<th align=\"right\" colspan='6'>" . number_format($balance, 2, ".", ",") . "</th>
			</tr>";
                }
                $htmltxt =$htmltxt. "<tr>
			<th align=\"right\" colspan='6'>" . number_format($totbal, 2, ".", ",") . "</th>
			</tr>";
                $htmltxt =$htmltxt. "<table>";
				
				$excel=$excel."<table>";
				
				//if ($_GET["chktxt"] == "on") {
					$myfile = fopen("txt/outstanding.txt", "w") or die("Unable to open file!");
					fwrite($myfile, $txt);
					fclose($myfile);
					
					$myfile = fopen("txt/outstanding.xls", "w") or die("Unable to open file!");
					fwrite($myfile, $excel);
					fclose($myfile);
					
				//} else {
					echo $htmltxt;
					
					
			
					echo "<a href=\"txt/outstanding.txt\"><strong>Outstanding txt file</strong></a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<a href=\"txt/outstanding.xls\"><strong>Outstanding Excel file</strong></a>";
				//}	
            }

            $sql = "select c_code,cus_name from tmpout where user_id = '" . $_SESSION["CURRENT_USER"] . "' group by c_code,cus_name order by cus_name";
            if ($_GET["radio"] == "optcus") {
                $result = $db->RunQuery($sql);
                while ($row = mysql_fetch_array($result)) {



                    //   echo "<tr><th align=\"left\" colspan='6'>" . $row['c_code'] . " " . $rowv['NAME'] . "</th></tr>";
                    $sql = "select c_code,sum(amount) as amount,sum(paid) as paid,rep from tmpout where c_code ='" . $row['c_code'] . "' and user_id = '" . $_SESSION["CURRENT_USER"] . "' group by c_code";

                    $result1 = $db->RunQuery($sql);
                    while ($row1 = mysql_fetch_array($result1)) {
                        $htmltxt =$htmltxt. "<td>" . $row["c_code"] . "</td>";
                        $htmltxt =$htmltxt. "<td>" . $row["cus_name"] . "</td>
					<td align=\"right\">" . number_format($row1['amount'], 2, ".", ",") . "</td>
					<td align=\"right\">" . number_format($row1['amount'] - $row['paid'], 2, ".", ",") . "</td>
					</tr>";

                        $totbal = $totbal + $row1["amount"] - $row1["paid"];
                    }
                }
                $htmltxt =$htmltxt. "<tr>
			<th align=\"right\" colspan='6'>" . number_format($totbal, 2, ".", ",") . "</th>
			</tr>";
                $htmltxt =$htmltxt. "<table>";
				echo $htmltxt;
            }
        }

//////////// Scrap //////////////////////////////////////
//////
        ?> 
        
                                                        </body>
</html>
