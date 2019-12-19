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

    $sql = "Select QTNNO from tmpinvpara_acc";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $tono = $row['QTNNO'];

    $sql = "delete from tmp_po_data where tmp_no='" . $tono . "'";
    $result = $conn->query($sql);

    $sql = "update tmpinvpara_acc set QTNNO=QTNNO+1";
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
    $sql = "select INVNO from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $tmpinvno = "000000" . $row["INVNO"];
    $lenth = strlen($tmpinvno);
    return $invno = substr($tmpinvno, $lenth - 6);
}

if ($_GET["Command"] == "setitem") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_po_data where stk_no='" . $_GET['itemCode'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);
    if ($_GET["Command1"] == "add_tmp") {
        $rate = str_replace(",", "", $_GET["itemPrice"]);
        $qty = str_replace(",", "", $_GET["qty"]);

        if ($_GET['vat'] != "non") {
            $sql = "select vatrate,nbt from invpara";
            $result_vat = $conn->query($sql);
            if ($row_vat = $result_vat->fetch()) {
                $rate = $rate / (1 + $row_vat['vatrate'] / 100);
                $rate = $rate / (1 + $row_vat['nbt'] / 100);
            }
        }


        $discount = 0;
        $subtotal = $rate * $qty;

        $sql = "Insert into tmp_po_data (stk_no, descript, qty, rate,subtot, tmp_no)values 
			('" . $_GET['itemCode'] . "', '" . $_GET['itemDesc'] . "', " . $rate . ", " . $_GET['qty'] . ",'" . $subtotal . "','" . $_GET['tmpno'] . "') ";
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 100px;\">Rate</td>
						<td style=\"width: 100px;\">Sub Total</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

    $i = 1;
    $mtot = 0;
    $sql = "Select * from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
                             <td>" . $row['stk_no'] . "</td>
							 <td>" . $row['descript'] . "</td>
							 <td>" . number_format($row['rate'], 2, ".", ",") . "</td>
							 <td>" . number_format($row['qty'], 2, ".", ",") . "</td>
							 <td>" . number_format($row['subtot'], 2, ".", ",") . "</td>
							 <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['stk_no'] . "')\"> <span class='fa fa-remove'></span></a></td>
							 </tr>";

        $mtot = $mtot + $row['subtot'];
        $i = $i + 1;
    }

    $mtot1 = 0;
    if ($_GET['vat'] != "non") {
        $sql = "select vatrate from invpara";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            $mtot1 = $mtot * ($row['vatrate'] / 100);
        }
    }
    $sql = "select vatrate,nbt from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $nbt = ($mtot * ($row['nbt'] / 100));
    if ($_GET['vat'] != "non") {
        $mtot1 = ($mtot + $nbt) * ($row['vatrate'] / 100);
    }



    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
    $ResponseXML .= "<vattot><![CDATA[" . number_format($mtot1, 2, ".", ",") . "]]></vattot>";
    $ResponseXML .= "<nbt><![CDATA[" . number_format($nbt, 2, ".", ",") . "]]></nbt>";
    $ResponseXML .= "<gtot><![CDATA[" . number_format($mtot1 + $mtot + $nbt, 2, ".", ",") . "]]></gtot>";
    $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();



        $sql = "select REF_NO,CANCELL,totpay from s_salma where tmp_no ='" . $_GET['tmpno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {


            if ($row['CANCELL'] != "0") {
                echo "Already Enterd";
                exit();
            }
            if ($row['CANCELL'] != "0") {
                echo "Already Cancelled";
                exit();
            }

            if ($row['totpay'] > 0) {
                echo "Already Paid";
                exit();
            } else {
                $invno = $row['REF_NO'];
            }

            $sql = "delete from s_salma where REF_NO = '" . $invno . "'";
            $conn->exec($sql);

            $sql = "delete from s_invo where ref_no = '" . $invno . "'";
            $conn->exec($sql);

            $sql = "delete from ledger where l_refno = '" . $invno . "'";
            $conn->exec($sql);
        } else {
            $invno = getno();
            $sql = "update invpara set INVNO=INVNO+1";
            $conn->exec($sql);
        }

        $subtot = str_replace(",", "", $_GET["subtot"]);


        $mtot = 0;
        $jobCost = 0;
        $rawConsumpt = 0;

        $sql = "select * from tmp_po_data where tmp_no='" . $_GET["tmpno"] . "'";
        foreach ($conn->query($sql) as $row) {

            $sql = "Insert into s_invo (REF_NO, SDATE, STK_NO, DESCRIPT, QTY , PRICE) values 
		('" . trim($invno) . "', '" . $_GET['invdate'] . "','" . $row["stk_no"] . "','" . $row["descript"] . "', " . $row["rate"] . "," . $row["qty"] . ")";
            $result = $conn->query($sql);

            $sql = "Insert into s_trn (`SDATE`, `STK_NO`, `REFNO`, `QTY`, `LEDINDI`, `DEPARTMENT`) values 
		('" . $_GET['invdate'] . "','" . $row["stk_no"] . "','" . trim($invno) . "', " . $row["rate"] . ",'INV', '" . $_GET['department'] . "')";
            $result = $conn->query($sql);


            $sql1 = "update s_mas set  QTYINHAND=QTYINHAND-" . $row["rate"] . " where  STK_NO='" . $row["stk_no"] . "'";
            $conn->exec($sql1);

            $sql = "update s_submas set  QTYINHAND=QTYINHAND-" . $row["rate"] . " where  STK_NO='" . $row["stk_no"] . "' and STO_CODE='" . $_GET['department'] . "'";
            $conn->exec($sql);

            $mtot = $mtot + ($row["rate"] * $row["qty"]);

            $sql = "select jobCost from s_mas where STK_NO = '" . $row["stk_no"] . "'";
            $rowItem = $conn->query($sql)->fetch();
            $jobCost += ($rowItem["jobCost"]*$row["qty"]);
            
        }

        $sql = "select * from s_trn where REFNO='" . $_GET["txt_minno"] . "' and LEDINDI = 'GINMR'";
        foreach ($conn->query($sql) as $row) {
            $sql = "update s_submas set  QTYINHAND=QTYINHAND-" . $row["QTY"] . " where  STK_NO='" . $row["STK_NO"] . "' and STO_CODE='" . $row["DEPARTMENT"] . "'";
            $conn->exec($sql);
            $sql = "Insert into s_trn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, DESCRIPt, cost) values('" . $row["STK_NO"] . "', '" . $_GET["invdate"] . "', '" . trim($invno) . "', " . $row["QTY"] . ", 'GINMI','" . $row["DEPARTMENT"] . "', '" . $row["str_description"] . "', " . $row["cost"] . ")";
            $conn->exec($sql);
            $rawConsumpt += $row["cost"]*$row["QTY"];
        }
        $mtot1 = 0;

        $sql = "select vatrate,nbt from invpara";
        $result = $conn->query($sql);
        $row = $result->fetch();

        $nbt = ($mtot * ($row['nbt'] / 100));
        if ($_GET['vat'] != "non") {
            $mtot1 = ($mtot + $nbt) * ($row['vatrate'] / 100);
        }

        $mgrand_tot = ($mtot + $mtot1 + $nbt) * $_GET['txt_rate'];

        $sql = "insert s_salma (REF_NO,SDATE,trn_type,  C_CODE, CUS_NAME,c_add1, vat,tmp_no,REMARK,btt,grand_tot,SAL_EX,gst,use_name,DEPARTMENT,dele_no,ORD_NO) values 
	('" . $invno . "', '" . $_GET['invdate'] . "','INV' ,'" . $_GET["customercode"] . "', '" . $_GET["customername"] . "','" . $_GET["cont_p"] . "','" . $mtot1 . "','" . $_GET["tmpno"] . "','" . $_GET['txt_remarks'] . "','" . $nbt . "','" . $mgrand_tot . "','" . $_GET['salesrep'] . "','" . $row['vatrate'] . "','" . $_SESSION['UserName'] . "','" . $_GET['department'] . "','" . $_GET['DANO'] . "','" . $_GET['["txt_minno"]'] . "')";
        $result = $conn->query($sql);

        require_once '../gl_posting.php';
        $ayear = ac_year($_GET["invdate"]);

        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_VAT'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $vatAmount = $mtot1;
        $vatAmount = number_format($vatAmount, 2, ".", "");

        $ledgerDes = "Sale Invoice";
        $msg = "";
        
        $sqlLedger = "Insert into ledger(l_refno, l_date, l_code, L_LMEM, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $vatAmount . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);
        
        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($vatAmount, 2, ".", ",") . "<br/>";

        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_NBT'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $vatAmount = $nbt;
        $vatAmount = number_format($vatAmount, 2, ".", "");

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $vatAmount . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);

        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($vatAmount, 2, ".", ",") . "<br/>";
        
        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_DEBTORS'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $vatAmount = $mgrand_tot;
        $vatAmount = number_format($vatAmount, 2, ".", "");

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $vatAmount . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);
        
        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($vatAmount, 2, ".", ",") . "<br/>";

        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_TURNOVER'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $vatAmount = $mgrand_tot - $mtot1 - $nbt;
        $vatAmount = number_format($vatAmount, 2, ".", "");

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $vatAmount . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);
        
        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($vatAmount, 2, ".", ",") . "<br/>";

        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_FGSTK'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . ($jobCost + $rawConsumpt) . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);

        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format(($jobCost + $rawConsumpt), 2, ".", ",") . "<br/>";
        
        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_FGACR'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . ($jobCost + $rawConsumpt) . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);
        
        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format(($jobCost + $rawConsumpt), 2, ".", ",") . "<br/>";
 
        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_RMCOS'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $rawConsumpt . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);

        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($rawConsumpt, 2, ".", ",") . "<br/>";
        
        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_RMWIP'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $rawConsumpt . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);
        
        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($rawConsumpt, 2, ".", ",") . "<br/>";
        
        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_JOBCOSACR_PL'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $jobCost . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);

        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($jobCost, 2, ".", ",") . "<br/>";
        
        $sqlGlPost = "select * from gl_posting where docname = 'INVOICE' and action = 'ADD_JOBCOSACR_BS'";
        $result = $conn->query($sqlGlPost);
        $rowGlPost = $result->fetch();

        $sqlLedger = "Insert into ledger(l_refno, l_date, L_LMEM, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_GET["invdate"] . "', '" . $rowGlPost["l_code"] . "', '$ledgerDes', " . $jobCost . ", 'INV', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "','" . $_GET["customercode"] . "')";
        $conn->query($sqlLedger);
        
        $msg .= $rowGlPost["l_code_dev_ref"] . " : " . $rowGlPost['entry_flag'] . " : " . number_format($jobCost, 2, ".", ",") . "<br/>";
        
        if ($_GET["Command1"] == "getGl"){
            $conn->rollBack();
            exit($msg);
        }
        
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
    $sql = "Select * from s_salma where REF_NO='" . $_GET['refno'] . "'";
    $result = $conn->query($sql);

    if ($row = $result->fetch()) {
        $ResponseXML .= "<C_REFNO><![CDATA[" . $row["REF_NO"] . "]]></C_REFNO>";
        $ResponseXML .= "<C_DATE><![CDATA[" . $row["SDATE"] . "]]></C_DATE>";
        $ResponseXML .= "<C_CODE><![CDATA[" . $row["C_CODE"] . "]]></C_CODE>";
        $ResponseXML .= "<name><![CDATA[" . $row["CUS_NAME"] . "]]></name>";
        $ResponseXML .= "<txt_remarks><![CDATA[" . $row["REMARK"] . "]]></txt_remarks>";
        $ResponseXML .= "<Attn><![CDATA[" . $row['C_ADD1'] . "]]></Attn>";
        $ResponseXML .= "<tmp_no><![CDATA[" . $row["tmp_no"] . "]]></tmp_no>";

        $ResponseXML .= "<currency><![CDATA[LKR]]></currency>";
        $ResponseXML .= "<txt_rate><![CDATA[1]]></txt_rate>";
        $ResponseXML .= "<department><![CDATA[" . $row["DEPARTMENT"] . "]]></department>";
        $ResponseXML .= "<DANO><![CDATA[" . $row["dele_no"] . "]]></DANO>";
        $ResponseXML .= "<ORD_NO><![CDATA[" . $row["ORD_NO"] . "]]></ORD_NO>";

        $ResponseXML .= "<salesrep><![CDATA[" . $row["SAL_EX"] . "]]></salesrep>";


        $msg = "";
        if ($row['CANCELL'] == "1") {
            $msg = "Cancelled";
        }
        $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

        $sql = "delete from tmp_po_data where tmp_no='" . $row["tmp_no"] . "'";
        $result = $conn->query($sql);


        $sql = "Select * from s_invo where REF_NO='" . $row["REF_NO"] . "'";
        foreach ($conn->query($sql) as $row1) {
            $subtotal = $row1['QTY'] * $row1['PRICE'];
            $sql = "Insert into tmp_po_data (stk_no, descript, qty, rate,subtot, tmp_no) values 
			('" . $row1['STK_NO'] . "', '" . $row1['DESCRIPT'] . "', " . $row1['QTY'] . ", " . $row1['PRICE'] . ",'" . $subtotal . "','" . $row["tmp_no"] . "') ";
            $result_t = $conn->query($sql);
        }


        $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 100px;\">Rate</td>
						<td style=\"width: 100px;\">Sub Total</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

        $i = 1;
        $mtot = 0;
        $sql = "Select * from tmp_po_data where tmp_no='" . $row["tmp_no"] . "'";
        foreach ($conn->query($sql) as $row1) {

            $ResponseXML .= "<tr>                              
                             <td>" . $row1['stk_no'] . "</td>
							 <td>" . $row1['descript'] . "</td>
							 <td>" . number_format($row1['rate'], 2, ".", ",") . "</td>
							 <td>" . number_format($row1['qty'], 2, ".", ",") . "</td>
							 <td>" . number_format($row1['subtot'], 2, ".", ",") . "</td>
							 <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row1['stk_no'] . "')\"> <span class='fa fa-remove'></span></a></td>
							 </tr>";

            $mtot = $mtot + $row1['subtot'];
            $i = $i + 1;
        }

        $mtot1 = 0;


        $ResponseXML .= "   </table>]]></sales_table>";

        $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
        $ResponseXML .= "<vattot><![CDATA[" . number_format($row['VAT'], 2, ".", "") . "]]></vattot>";
        $ResponseXML .= "<nbt><![CDATA[" . number_format($row['BTT'], 2, ".", ",") . "]]></nbt>";
        $ResponseXML .= "<gtot><![CDATA[" . number_format($row['GRAND_TOT'], 2, ".", ",") . "]]></gtot>";
        $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></subtot>";
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
                        <th width=\"100\">Code</th> 
                        <th width=\"200\">Name</th> 
                        <th width=\"121\">Amount</th>  
                    </tr>";


    $sql = "select REF_NO, SDATE,C_CODE,CUS_NAME,GRAND_TOT from s_salma where trn_type = 'INV'";

    if ($_GET['refno'] != "") {
        $sql .= " and REF_NO like '%" . $_GET['refno'] . "%'";
    }
    if ($_GET['cusname'] != "") {
        $sql .= " and cus_NAME like '%" . $_GET['cusname'] . "%'";
    }
    $stname = $_GET['stname'];

    $sql .= " ORDER BY id desc limit 50";

    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["REF_NO"];


        $ResponseXML .= "<tr>               
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                                  <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                                      <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['GRAND_TOT'] . "</a></td>
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

        $sql = "select REF_NO,CANCELL,TOTPAY from s_salma where tmp_no ='" . $_GET['tmpno'] . "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {


            if ($row['CANCELL'] != "0") {
                echo "Already Enterd";
                exit();
            }
            if ($row['CANCELL'] != "0") {
                echo "Already Cancelled";
                exit();
            }

            if ($row['TOTPAY'] > 0) {
                echo "Already Paid";
                exit();
            }

            $invno = $row['REF_NO'];



            $sql = "update s_salma set CANCELL='1' where REF_NO = '" . $row['REF_NO'] . "'";
            $conn->exec($sql);

            $sql = "update s_invo set CANCELL='1' where ref_no = '" . $row['REF_NO'] . "'";
            $conn->exec($sql);

            echo "ok";
            $conn->commit();
        } else {
            echo "Entry Not Found";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>