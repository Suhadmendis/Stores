<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "new_inv") {

    $invno = getno();

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<tmpno><![CDATA[" . $invno . "]]></tmpno>";
    $ResponseXML .= "<dt><![CDATA[" . date('Y-m-d') . "]]></dt>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

function getno() {
    include './connection_sql.php';
    $sql = "select JOB from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $tmpinvno = "000000" . $row["JOB"];
    $lenth = strlen($tmpinvno);
    return $invno = trim("JBN/") . substr($tmpinvno, $lenth - 7);
}

if ($_GET["Command"] == "setitem") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_stock_adjust_data where str_code='" . $_GET['itemCode'] . "' and str_invno='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);
    if ($_GET["Command1"] == "add_tmp") {
        $rate = str_replace(",", "", $_GET["itemPrice"]);
        $qty = str_replace(",", "", $_GET["qty"]);

        $discount = 0;
        $subtotal = $rate * $qty;
//         str_code, str_description, cur_qty, str_invno
        $sql = "Insert into tmp_stock_adjust_data (str_code, str_description, cur_qty, str_invno)values 
			('" . $_GET['itemCode'] . "', '" . $_GET['itemDesc'] . "', " . $_GET['qty'] . ",'" . $_GET['tmpno'] . "') ";
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

    $i = 1;
    $mtot = 0;
    $sql = "Select * from tmp_stock_adjust_data where str_invno='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
                             <td>" . $row['str_code'] . "</td>
							 <td>" . $row['str_description'] . "</td>
							 <td>" . number_format($row['cur_qty'], 2, ".", ",") . "</td>
							 <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['str_code'] . "')\"> <span class='fa fa-remove'></span></a></td>
							 </tr>";

        $i = $i + 1;
    }


    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select REF_NO,cancel from job_mas where REF_NO ='" . $_GET['txt_entno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {

            /*
              if ($row['cancel'] != "0") {
              echo "Already Cancelled";
              exit();
              }

              $invno = $row['REF_NO'];
              $sql = "delete from s_ginmas where REF_NO = '" . $invno . "'";
              $conn->exec($sql);
              $sql = "delete from s_trn where REFNO = '" . $invno . "'";
              $conn->exec($sql);
              $sql = "delete from ledger where L_REFNO = '" . $invno . "'";
              $conn->exec($sql);
             */
            if ($row['cancel'] != "0") {
                echo "Already Cancelled";
                exit();
            } else {
                exit("Already Entered");
            }
        } else {
            $invno = getno();
            $sql = "update invpara set JOB=JOB+1";
            $conn->exec($sql);
        }

        /*
        $sql = "select * from tmp_stock_adjust_data where str_invno='" . $_GET["tmpno"] . "'";

        $cost = 0;
        $totCost = 0;

        foreach ($conn->query($sql) as $row) {
            $cur_qty = str_replace(",", "", $row["cur_qty"]);
            $sqlsub = "Select * from s_submas where STK_NO='" . $row["str_code"] . "' and STO_CODE='" . $_GET["to_dep"] . "'";

            $resultsub = $conn->query($sqlsub);
            if ($rowsub = $resultsub->fetch()) {
                $sql1 = "update s_submas set QTYINHAND=QTYINHAND+" . $cur_qty . " where STK_NO='" . $row["str_code"] . "' and STO_CODE = '" . $_GET["to_dep"] . "'";
                $conn->exec($sql1);
            } else {
                $sqlNew = "insert into s_submas(STO_CODE, STK_NO, DESCRIPt, OPEN_STK, QTYINHAND) values ('" . $_GET["to_dep"] . "',  '" . $row["str_code"] . "', '" . $row["str_description"] . "', 0, " . $cur_qty . ")";
                $conn->exec($sqlNew);
            }

            $sql1 = "update s_submas set QTYINHAND=QTYINHAND-" . $cur_qty . " where STK_NO='" . $row["str_code"] . "' and STO_CODE='" . $_GET["from_dep"] . "'";
            $conn->exec($sql1);

            $sql1 = "update s_mas set QTYINHAND=QTYINHAND-" . $cur_qty . " where STK_NO='" . $row["str_code"] . "'";
            $conn->exec($sql1);

            $sql = "select cost from s_mas where STK_NO='" . $row["str_code"] . "'";
            $rowItem = $conn->query($sql)->fetch();
            $cost = $rowItem["cost"] * $cur_qty;
            $totCost += $cost;

            $sql5 = "Insert into s_trn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, DESCRIPt, cost) values('" . $row["str_code"] . "', '" . $_GET["invdate"] . "', '" . trim($invno) . "', " . $cur_qty . ", 'GINMI','" . $_GET["from_dep"] . "', '" . $row["str_description"] . "', " . $rowItem["cost"] . ")";
            $conn->exec($sql5);
            $sql5 = "Insert into s_trn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, DESCRIPt, cost) values('" . $row["str_code"] . "', '" . $_GET["invdate"] . "', '" . trim($invno) . "', " . $cur_qty . ", 'GINMR','" . $_GET["to_dep"] . "', '" . $row["str_description"] . "', " . $rowItem["cost"] . ")";
            $conn->exec($sql5);
        }

        require_once './gl_posting.php';
        $ldate = $_GET["invdate"];
        $ayear = ac_year($ldate);

        $sqlGlPost = "select * from gl_posting where docname = 'ISSUE NOTE'";
        $ledgerRem = "Issue note";

        if ($_GET["Command1"] == "getGl") {
            $bal = 0;
            $msg = "<div class='col-sm-12'>
		<table class='table table-striped'>
		<tr class='success'>
			<th style='width: 100px;'>Ledger Details</th>
			<th style='width: 10px;'>DEB</th>
			<th style='width: 10px;'>CRE</th>
			<th style='width: 10px;'>Balance</th>
		</tr>";
        }

        foreach ($conn->query($sqlGlPost) as $rowGlPost) {
            $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . trim($invno) . "', '" . $ldate . "', '$ledgerRem', '" . $rowGlPost["l_code"] . "', " . $totCost . ", 'ISN', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "', '" . $_GET["txt_jobno"] . "')";
            $conn->exec($sqlLedger);
            if ($_GET["Command1"] == "getGl") {
                $msg .= "<tr>";
                $msg .= "<td style = 'width: 120px;text-align: left;'>" . $rowGlPost['l_code_dev_ref'] . "</td>";
                if ($rowGlPost['entry_flag'] == "DEB") {
                    $bal += $totCost;
                    $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($totCost, 2, ".", ",") . "</td>";
                    $msg .= "<td style = 'width: 10px;text-align: left;'></td>";
                } else {
                    $bal -= $totCost;
                    $msg .= "<td style = 'width: 10px;text-align: left;'></td>";
                    $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($totCost, 2, ".", ",") . "</td>";
                }
                $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($bal, 2, ".", ",") . "</td>";
                $msg .= "</tr>";
            }
        }

        if ($_GET["Command1"] == "getGl") {
            $msg .= "</table></div>";
            $conn->rollBack();
            exit($msg);
        }

        $sql2 = "select * from s_stomas where CODE='" . $_GET["from_dep"] . "' ";

        $result = $conn->query($sql2);
        $row2 = $result->fetch();
        $DESCRIPTION_from = $row2["DESCRIPTION"];

        $sql2 = "select * from s_stomas where CODE='" . $_GET["to_dep"] . "' ";

        $result = $conn->query($sql2);
        $row2 = $result->fetch();
        $DESCRIPTION_to = $row2["DESCRIPTION"];
        
        */

        $sql = "update costing_details set fl_job = '1' where ref_no = '" .$_GET["txt_jobno"]. "'";
        $conn -> exec($sql);
        
        $sql = "select * from costing_details where ref_no = '" .$_GET["txt_jobno"]. "'";
        $row = $conn -> query($sql) -> fetch();
        
        $sql1 = "insert into job_mas(SDATE, REF_NO, costing_no, remark, item_no, descript, qty, C_CODE, CUS_NAME, C_ADD1, jobCost, rawWaste, COST, rate) values ('" . $_GET["invdate"] . "', '" . $invno . "','" . $_GET["txt_jobno"] . "', '" . $_GET["txt_remarks"] . "','" . $_GET["itemCode"] . "', '" . $_GET["itemDesc"] . "', '" . $_GET["qty"] . "', '" . $_GET["txt_ccode"] . "', '" . $_GET["txt_cname"] . "', '" . $_GET["txt_caddress"] . "', '" . $row["jobCost"] . "', '" . $row["rawWaste"] . "', '" . $row["COST"] . "', '" . $_GET["itemPrice"] . "')";
        $conn->exec($sql1);

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}




if ($_GET["Command"] == "pass_rec") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $stname = "";
    if (isset($_GET["stname"])) {
        $stname = $_GET["stname"];
    }

    if (($stname == "") || ($stname == "isa")) {

        $sql = "Select * from s_ginmas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
            $ResponseXML .= "<C_JOBNO><![CDATA[" . $row["JOB_NO"] . "]]></C_JOBNO>";
            $ResponseXML .= "<C_DATE><![CDATA[" . $row["SDATE"] . "]]></C_DATE>";
            $ResponseXML .= "<txt_remarks><![CDATA[" . $row["remark"] . "]]></txt_remarks>";
            $_SESSION["gin_tmpno"] = $row["tmp_no"];
            $ResponseXML .= "<tmp_no><![CDATA[" . $row["tmp_no"] . "]]></tmp_no>";
            $ResponseXML .= "<department><![CDATA[" . $row["DEP_FROM"] . "]]></department>";
            $ResponseXML .= "<department1><![CDATA[" . $row["DEP_TO"] . "]]></department1>";
            $msg = "";
            if ($row['cancel'] == "1") {
                $msg = "Cancelled";
            }
            $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

            $sql = "delete from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            $result = $conn->exec($sql);

            if ($stname == "") {
                $sqlTrn = "Select * from s_trn where refno='" . $row["REF_NO"] . "' and LEDINDI = 'GINMI'";
            } else if ($stname == "isa") {
                $sqlTrn = "Select * from s_gintrn where refno='" . $row["REF_NO"] . "' and LEDINDI = 'GINMI'";
            }


            foreach ($conn->query($sqlTrn) as $row1) {
                $sql = "Insert into tmp_stock_adjust_data (str_code, str_description, cur_qty, str_invno) values
                    ('" . $row1['STK_NO'] . "', '" . $row1['DESCRIPt'] . "', " . $row1['QTY'] . ", '" . $row['tmp_no'] . "') ";
//                    $ResponseXML .= "<test><![CDATA[" . $sql . "]]></test>";
                $result = $conn->exec($sql);
            }

            $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

            $i = 1;
            $sql = "Select * from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            foreach ($conn->query($sql) as $row1) {

                $ResponseXML .= "<tr>                              
                            <td>" . $row1['str_code'] . "</td>
                            <td>" . $row1['str_description'] . "</td>
                            <td>" . number_format($row1['cur_qty'], 2, ".", ",") . "</td>
                            <td></td>
                            </tr>";

                $i = $i + 1;
            }

            $mtot1 = 0;

            $ResponseXML .= "   </table>]]></sales_table>";
            $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
        }
    } else if (($stname == "job") || ($stname == "jobi") || ($stname == "jobg")) {
        $sql = "Select * from s_mrnmas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";

            $sql = "delete from tmp_stock_adjust_data where str_invno='" . $_SESSION["gin_tmpno"] . "'";
            $result = $conn->exec($sql);

            $sqlTrn = "Select * from s_mrntrn where refno='" . $row["REF_NO"] . "' and LEDINDI = 'GINI'";


            foreach ($conn->query($sqlTrn) as $row1) {
                $sql = "Insert into tmp_stock_adjust_data (str_code, str_description, cur_qty, str_invno) values
                    ('" . $row1['STK_NO'] . "', '" . $row1['DESCRIPt'] . "', " . $row1['QTY'] . ", '" . $_SESSION["gin_tmpno"] . "') ";
//                    $ResponseXML .= "<test><![CDATA[" . $sql . "]]></test>";
                $result = $conn->exec($sql);
            }

            $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

            $i = 1;
            $sql = "Select * from tmp_stock_adjust_data where str_invno='" . $_SESSION["gin_tmpno"] . "'";
            foreach ($conn->query($sql) as $row1) {

                $ResponseXML .= "<tr>                              
                            <td>" . $row1['str_code'] . "</td>
                            <td>" . $row1['str_description'] . "</td>
                            <td>" . number_format($row1['cur_qty'], 2, ".", ",") . "</td>
                            <td></td>
                            </tr>";

                $i = $i + 1;
            }

            $mtot1 = 0;

            $ResponseXML .= "   </table>]]></sales_table>";
            $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
            $ResponseXML .= "<msg><![CDATA[]]></msg>";
        }
    } else if (($stname == "mrn") || ($stname == "mrni") || ($stname == "mrng")) {

        $sql = "Select * from s_mrnmas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
            $ResponseXML .= "<C_JOBNO><![CDATA[" . $row["JOB_NO"] . "]]></C_JOBNO>";
            $ResponseXML .= "<C_DATE><![CDATA[" . $row["SDATE"] . "]]></C_DATE>";
            $ResponseXML .= "<txt_remarks><![CDATA[" . $row["remark"] . "]]></txt_remarks>";
            $ResponseXML .= "<tmp_no><![CDATA[" . $row["tmp_no"] . "]]></tmp_no>";
            $ResponseXML .= "<department><![CDATA[" . $row["DEP_FROM"] . "]]></department>";
            $ResponseXML .= "<department1><![CDATA[" . $row["DEP_TO"] . "]]></department1>";
            $msg = "";
            if ($row['cancel'] == "1") {
                $msg = "Cancelled";
            }
            $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

            $sql = "delete from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            $result = $conn->exec($sql);


            $sqlTrn = "Select * from s_mrntrn where refno='" . $row["REF_NO"] . "' and LEDINDI = 'GINI'";


            foreach ($conn->query($sqlTrn) as $row1) {
                $sql = "Insert into tmp_stock_adjust_data (str_code, str_description, cur_qty, str_invno) values
                    ('" . $row1['STK_NO'] . "', '" . $row1['DESCRIPt'] . "', " . $row1['QTY'] . ", '" . $row['tmp_no'] . "') ";
//                    $ResponseXML .= "<test><![CDATA[" . $sql . "]]></test>";
                $result = $conn->exec($sql);
            }

            $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

            $i = 1;
            $sql = "Select * from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            foreach ($conn->query($sql) as $row1) {

                $ResponseXML .= "<tr>                              
                            <td>" . $row1['str_code'] . "</td>
                            <td>" . $row1['str_description'] . "</td>
                            <td>" . number_format($row1['cur_qty'], 2, ".", ",") . "</td>
                            <td></td>
                            </tr>";

                $i = $i + 1;
            }

            $mtot1 = 0;

            $ResponseXML .= "   </table>]]></sales_table>";
            $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
        }
    } else if ($stname == "ming") {

        $sql = "Select * from s_ginmas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
            $ResponseXML .= "<C_JOBNO><![CDATA[" . $row["JOB_NO"] . "]]></C_JOBNO>";
            $ResponseXML .= "<C_DATE><![CDATA[" . $row["SDATE"] . "]]></C_DATE>";
            $ResponseXML .= "<txt_remarks><![CDATA[" . $row["remark"] . "]]></txt_remarks>";
            $_SESSION["gin_tmpno"] = $row["tmp_no"];
            $ResponseXML .= "<tmp_no><![CDATA[" . $row["tmp_no"] . "]]></tmp_no>";
            $ResponseXML .= "<department><![CDATA[" . $row["DEP_FROM"] . "]]></department>";
            $ResponseXML .= "<department1><![CDATA[02]]></department1>";
            $msg = "";
            if ($row['cancel'] == "1") {
                $msg = "Cancelled";
            }
            $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

            $sql = "delete from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            $result = $conn->exec($sql);


            $sqlTrn = "Select * from s_trn where refno='" . $row["REF_NO"] . "'";


            foreach ($conn->query($sqlTrn) as $row1) {
                $sql = "Insert into tmp_stock_adjust_data (str_code, str_description, cur_qty, str_invno) values
                    ('" . $row1['STK_NO'] . "', '" . $row1['DESCRIPt'] . "', " . $row1['QTY'] . ", '" . $row['tmp_no'] . "') ";
//                    $ResponseXML .= "<test><![CDATA[" . $sql . "]]></test>";
                $result = $conn->exec($sql);
            }

            $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

            $i = 1;
            $sql = "Select * from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            foreach ($conn->query($sql) as $row1) {

                $ResponseXML .= "<tr>                              
                            <td>" . $row1['str_code'] . "</td>
                            <td>" . $row1['str_description'] . "</td>
                            <td>" . number_format($row1['cur_qty'], 2, ".", ",") . "</td>
                            <td></td>
                            </tr>";

                $i = $i + 1;
            }

            $mtot1 = 0;

            $ResponseXML .= "   </table>]]></sales_table>";
            $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
        }
    } else if (($stname == "pickJOB") || ($stname == "pick_is") || ($stname == "pickJOB_is_ut")) {

        $sql = "Select * from job_mas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
            $msg = "";
            if ($row['cancel'] == "1") {
                $msg = "Cancelled";
            }
            $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";
        }
        $_SESSION["pickRef_is"] = $row["REF_NO"];
        
    } else if (($stname == "pickJOB_fg")) {

        $sql = "Select * from job_mas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
            $ResponseXML .= "<jobQty><![CDATA[" . $row["qty"] . "]]></jobQty>";
            $ResponseXML .= "<trf_qty><![CDATA[" . $row["trf_qty"] . "]]></trf_qty>";
            $ResponseXML .= "<bal_qty><![CDATA[" . ($row["qty"] - $row["trf_qty"]) . "]]></bal_qty>";
            $ResponseXML .= "<descript><![CDATA[" . $row["descript"] . "]]></descript>";
            $ResponseXML .= "<item_no><![CDATA[" . $row["item_no"] . "]]></item_no>";
            $msg = "";
            if ($row['cancel'] == "1") {
                $msg = "Cancelled";
            }
            $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";
        }
        $_SESSION["pickRef_is"] = $row["REF_NO"];
    } else if (($stname == "pickJOB_mst")) {

        $sql = "Select * from job_mas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
            $ResponseXML .= "<jobQty><![CDATA[" . $row["qty"] . "]]></jobQty>";
            
            $ResponseXML .= "<C_CODE><![CDATA[" . $row["C_CODE"] . "]]></C_CODE>";
            $ResponseXML .= "<CUS_NAME><![CDATA[" . $row["CUS_NAME"]  . "]]></CUS_NAME>";
            $ResponseXML .= "<C_ADD1><![CDATA[" . $row["C_ADD1"] . "]]></C_ADD1>";
            $ResponseXML .= "<costing_no><![CDATA[" . $row["costing_no"] . "]]></costing_no>";
            
            $ResponseXML .= "<descript><![CDATA[" . $row["descript"] . "]]></descript>";
            $ResponseXML .= "<item_no><![CDATA[" . $row["item_no"] . "]]></item_no>";
            $ResponseXML .= "<txt_remarks><![CDATA[" . $row["remark"] . "]]></txt_remarks>";
            $ResponseXML .= "<rate><![CDATA[" . $row["rate"] . "]]></rate>";
            $msg = "";
            if ($row['cancel'] == "1") {
                $msg = "Cancelled";
            }
            $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";
        }
        $_SESSION["pickRef_is"] = $row["REF_NO"];
    }else if ($stname == "ginu") {

        $sql = "Select * from s_ginmas where REF_NO='" . $_GET['refno'] . "'";
        $result = $conn->query($sql);

        if ($row = $result->fetch()) {
            $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
            $ResponseXML .= "<C_JOBNO><![CDATA[" . $row["JOB_NO"] . "]]></C_JOBNO>";
            $ResponseXML .= "<C_DATE><![CDATA[" . $row["SDATE"] . "]]></C_DATE>";
            $ResponseXML .= "<txt_remarks><![CDATA[" . $row["remark"] . "]]></txt_remarks>";
            $_SESSION["gin_tmpno"] = $row["tmp_no"];
            $ResponseXML .= "<tmp_no><![CDATA[" . $row["tmp_no"] . "]]></tmp_no>";
            $ResponseXML .= "<department><![CDATA[" . $row["DEP_FROM"] . "]]></department>";
            $ResponseXML .= "<department1><![CDATA[" . $row["DEP_TO"] . "]]></department1>";
            $msg = "";
            if ($row['cancel'] == "1") {
                $msg = "Cancelled";
            }
            $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

            $sql = "delete from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            $result = $conn->exec($sql);

            $sqlTrn = "Select * from s_trn where refno='" . $row["REF_NO"] . "' and LEDINDI = 'GINU'";

            foreach ($conn->query($sqlTrn) as $row1) {
                $sql = "Insert into tmp_stock_adjust_data (str_code, str_description, cur_qty, str_invno) values
                    ('" . $row1['STK_NO'] . "', '" . $row1['DESCRIPt'] . "', " . $row1['QTY'] . ", '" . $row['tmp_no'] . "') ";
//                    $ResponseXML .= "<test><![CDATA[" . $sql . "]]></test>";
                $result = $conn->exec($sql);
            }

            $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Invoice Number</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

            $i = 1;
            $sql = "Select * from tmp_stock_adjust_data where str_invno='" . $row["tmp_no"] . "'";
            foreach ($conn->query($sql) as $row1) {

                $ResponseXML .= "<tr>                              
                            <td>" . $row1['str_code'] . "</td>
                            <td>" . $row1['str_description'] . "</td>
                            <td>" . number_format($row1['cur_qty'], 2, ".", ",") . "</td>
                            <td></td>
                            </tr>";

                $i = $i + 1;
            }

            $mtot1 = 0;

            $ResponseXML .= "   </table>]]></sales_table>";
            $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
        }
    }

    $ResponseXML .= "<stname><![CDATA[" . $stname . "]]></stname>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "update_list") {
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
	            <tr>
                        <th width=\"121\">Reference No</th>
                        <th width=\"121\">Date</th>
                        <th width=\"100\">From</th> 
                    </tr>";
    $stname = "";
    if (isset($_GET["stname"])) {
        $stname = $_GET["stname"];
    }

    if (($stname == "") || ($stname == "pickMIN")) {
        $sql = "select * from s_ginmas where TYPE = 'MIN'";
    } else if (($stname == "pickJOB_is_ut")) {
        $sql = "select * from job_mas where flag_inv='1'";
    } else if (($stname == "job") || ($stname == "mrn")) {
        $sql = "select * from s_mrnmas where TYPE = 'MRN'";
    } else if (($stname == "jobi") || ($stname == "mrni")) {
        $sql = "select * from s_mrnmas where TYPE = 'MRNI'";
    } else if (($stname == "jobg") || ($stname == "mrng")) {
        $sql = "select * from s_mrnmas where TYPE = 'MRNG'";
    } else if ($stname == "ming") {
        $sql = "select * from s_ginmas where TYPE = 'MING'";
    } else if ($stname == "fg") {
        $sql = "select * from s_ginmas where TYPE = 'FG'";
    } else if ($stname == "ginu") {
        $sql = "select * from s_ginmas where TYPE = 'ISU'";
    } else if (($stname == "pickJOB") || ($stname == "pickJOB_fg")) {
        $sql = "select * from job_mas where cancel='0'";
    }

    $sql .= " and cancel = '0' and REF_NO like '%" . $_GET['refno'] . "%' ORDER BY SDATE desc limit 50";

    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["REF_NO"];


        $ResponseXML .= "<tr>               
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['DEP_F_NAME'] . "</a></td>
                            </tr>";
    }
    $ResponseXML .= "</table>";
    echo $ResponseXML;
}



if ($_GET["Command"] == "del_inv") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select REF_NO,cancel from job_mas where REF_NO ='" . $_GET['crnno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            if ($row['cancel'] != "0") {
                echo "Already Cancelled";
                exit();
            } else {
/*                
                $sql = "select * from s_trn where REFNO='" . $row['REF_NO'] . "'";
                foreach ($conn->query($sql) as $row1) {

                    if ($row1["LEDINDI"] == "GINMR") {
                        $sql1 = "update s_submas set QTYINHAND=QTYINHAND-" . $row1['QTY'] . " where STK_NO='" . $row1["STK_NO"] . "' and STO_CODE = '" . $row1["DEPARTMENT"] . "'";
                        $conn->exec($sql1);
                    } else if ($row1["LEDINDI"] == "GINMI") {
                        $sql1 = "update s_submas set QTYINHAND=QTYINHAND+" . $row1['QTY'] . " where STK_NO='" . $row1["STK_NO"] . "' and STO_CODE = '" . $row1["DEPARTMENT"] . "'";
                        $conn->exec($sql1);
                        $sql1 = "update s_mas set QTYINHAND=QTYINHAND+" . $row1['QTY'] . " where STK_NO='" . $row1["STK_NO"] . "'";
                        $conn->exec($sql1);
                    }
                }
*/
                $sql = "update job_mas set cancel='1' where REF_NO = '" . $row['REF_NO'] . "'";
                $conn->exec($sql);

//                $sql = "delete from s_trn where REFNO='" . $row['REF_NO'] . "'";
//                $conn->exec($sql);
//
//                $sql = "delete from ledger where L_REFNO = '" . $row['REF_NO'] . "'";
//                $conn->exec($sql);

                echo "ok";

                $conn->commit();
            }
        } else {
            echo "Entry Not Found";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

?>