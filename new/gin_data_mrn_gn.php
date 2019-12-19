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

    $sql = "Select GIN from tmpinvpara_acc";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $tono = $row['GIN'];

    $sql = "delete from tmp_stock_adjust_data where str_invno ='" . $tono . "'";
    $result = $conn->query($sql);

    $sql = "update tmpinvpara_acc set GIN=GIN+1";
    $result = $conn->query($sql);


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";
    $ResponseXML .= "<dt><![CDATA[" . date('Y-m-d') . "]]></dt>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

function getno() {
    include './connection_sql.php';
    $sql = "select MRNG from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $tmpinvno = "000000" . $row["MRNG"];
    $lenth = strlen($tmpinvno);
    return $invno = trim("STR/") . substr($tmpinvno, $lenth - 7);
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

        $sql = "select REF_NO,cancel from s_mrnmas where tmp_no ='" . $_GET['tmpno'] . "'";
        $result = $conn->query($sql);
//        exit ($sql);
        if ($row = $result->fetch()) {


            if ($row['cancel'] != "0") {
                echo "Already Cancelled";
                exit();
            }

            $invno = $row['REF_NO'];
            $sql = "delete from s_mrnmas where REF_NO = '" . $invno . "'";
            $conn->exec($sql);
            $sql = "delete from s_mrntrn where REFNO = '" . $invno . "'";
            $conn->exec($sql);
        } else {
            $invno = getno();
            $sql = "update invpara set MRNG=MRNG+1";
            $conn->exec($sql);
        }


        $sql = "select * from tmp_stock_adjust_data where str_invno='" . $_GET["tmpno"] . "'";

        foreach ($conn->query($sql) as $row) {
            $cur_qty = str_replace(",", "", $row["cur_qty"]);
            $sql5 = "Insert into s_mrntrn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, DESCRIPt, TYPE) values('" . $row["str_code"] . "', '" . $_GET["invdate"] . "', '" . trim($invno) . "', " . $cur_qty . ", 'GINI','" . $_GET["from_dep"] . "', '" . $row["str_description"] . "', 'RAW')";
            $conn->exec($sql5);
            $sql5 = "Insert into s_mrntrn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, DESCRIPt, TYPE) values('" . $row["str_code"] . "', '" . $_GET["invdate"] . "', '" . trim($invno) . "', " . $cur_qty . ", 'GINR','" . $_GET["to_dep"] . "', '" . $row["str_description"] . "', 'RAW')";
            $conn->exec($sql5);
        }
        
        $sql2 = "select * from s_stomas where CODE='" . $_GET["from_dep"] . "' ";

        $result = $conn->query($sql2);
        $row2 = $result->fetch();
        $DESCRIPTION_from = $row2["DESCRIPTION"];

        $sql2 = "select * from s_stomas where CODE='" . $_GET["to_dep"] . "' ";

        $result = $conn->query($sql2);
        $row2 = $result->fetch();
        $DESCRIPTION_to = $row2["DESCRIPTION"];

        $sql1 = "insert into s_mrnmas(SDATE, REF_NO, DEP_FROM, DEP_F_NAME, DEP_TO, DEP_T_NAME, tmp_no, JOB_NO, remark, TYPE) values ('" . $_GET["invdate"] . "', '" . $invno . "', '" . $_GET["from_dep"] . "', '" . $DESCRIPTION_from . "', '" . $_GET["to_dep"] . "', '" . $DESCRIPTION_to . "', '" . $_GET["tmpno"] . "', '" . $_GET["txt_jobno"] . "', '" . $_GET["txt_remarks"] . "', 'MRNG')";

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


    $sql = "select * from s_mrnmas where REF_NO <> ''";

    if ($_GET['refno'] != "") {
        $sql .= " and REF_NO like '%" . $_GET['refno'] . "%'";
    }
//    if ($_GET['cusname'] != "") {
//        $sql .= " and cname like '%" . $_GET['cusname'] . "%'";
//    }
    $stname = $_GET['stname'];

    $sql .= " ORDER BY REF_NO desc limit 50";

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

        $sql = "select REF_NO,cancel from s_mrnmas where tmp_no ='" . $_GET['tmpno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            if ($row['cancel'] != "0") {
                echo "Already Cancelled";
                exit();
            } else {
                $sql = "update s_mrnmas set cancel='1' where REF_NO = '" . $row['REF_NO'] . "'";
                $conn->exec($sql);

                $sql = "delete from s_mrntrn where REFNO='" . $row['REF_NO'] . "'";
                $conn->exec($sql);

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