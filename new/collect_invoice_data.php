<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {

    $sql2 = "delete from tmp_po_data_collect where C_CODE ='" . $_GET['C_CODE'] . "'";
    $conn->query($sql2);
    
    $tb = "";
    $tb .= "<table class='table table-hover'>";


    $sql = "select * from s_salma where C_CODE ='" . $_GET['C_CODE'] . "' and TOTPAY='0' and CANCELL='0' and con_ref = '' and VAT = '". $_GET["arg"]. "'order by REF_NO desc ";

//echo $sql;
    $tb .= "<tr>";
    $tb .= "<th class=\"danger\" >REF No</th>";
    $tb .= "<th class=\"danger\" >C CODE</th>";
    $tb .= "<th class=\"danger\" >Grand Total</th>";
    $tb .= "<th class=\"danger\" ></th>";
    $tb .= "<th class=\"danger\" ></th>";


    $tb .= "</tr>";

    foreach ($conn->query($sql) as $row) {

        $j = $row['id'];
        $y = $row['REF_NO'];
        $sdate = $row['SDATE'];
        $tb .= "<tr>";
        $tb .= "<td onclick=\"getcode('" . $row['REF_NO'] . "','" . $row['C_CODE'] . "','" . $row['GRAND_TOT'] . "')\">" . $row['REF_NO'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['REF_NO'] . "','" . $row['C_CODE'] . "','" . $row['GRAND_TOT'] . "')\">" . $row['C_CODE'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['REF_NO'] . "','" . $row['C_CODE'] . "','" . $row['GRAND_TOT'] . "')\">" . $row['GRAND_TOT'] . "</td>";
        $tb .= "<td><input type=\"checkbox\" id=\"$j\" onclick=\"gen(" . $j . ");\"></td>";
        $tb .= "<td><input type=\"radio\" name=\"nameradio\" id=\"$y\" onclick=\"setInv('$y','$sdate')\";></td>";
        $tb .= "</tr>";
    }

    $tb .= "</table>";


    echo $tb;
}


if ($_GET["Command"] == "set") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select * from s_salma where id = '" . $_GET['id'] . "'";

        foreach ($conn->query($sql) as $row) {

            if ($_GET['stat'] == "1") {
                $sql1 = "Insert into tmp_po_data_collect(C_CODE,GRAND_TOT,TOTPAY,tmp_no,REF_NO)values
                ('" . $row['C_CODE'] . "','" . $row['GRAND_TOT'] . "','" . $row['TOTPAY'] . "','" . $_GET['tmpno'] . "','" . $row['REF_NO'] . "')";
                $result = $conn->query($sql1);
            } elseif ($_GET['stat'] == "0") {
                $sql2 = "delete from tmp_po_data_collect where REF_NO ='" . $row['REF_NO'] . "'";
                $result = $conn->query($sql2);
            }
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">REF No</td>
                                                <td style=\"width: 90px;\">C CODE</td>
						<td style=\"width: 100px;\">GRAND TOT</td>
						<td style=\"width: 10px;\"></td>
					</tr>";
    $subtot = 0;
    $sql = "Select * from tmp_po_data_collect where tmp_no='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {
        $ResponseXML .= "<tr>
            
            <td>" . $row['REF_NO'] . "</td>
                             <td>" . $row['C_CODE'] . "</td>
                                                         <td>" . $row['GRAND_TOT'] . "</td>
                                                          </tr>";
        $subtot = $row['GRAND_TOT'] + $subtot;
    }


    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<tot><![CDATA[" . $subtot . "]]></tot>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "save_item") {
   try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select REF_NO from tmp_po_data_collect where REF_NO = '" .$_GET["invNo"]. "'";
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
        }else{
            exit ("Please select the " .$_GET["invNo"]. " invoice also!");
        }
        
        $sql = "Select * from tmp_po_data_collect where C_CODE='" . $_GET['C_CODE'] . "'";
        foreach ($conn->query($sql) as $row) {

            $sql = "update s_salma set con_ref = '" . $_GET['invNo'] . "', con_date = '" . $_GET['conDate'] . "', con_vat = '" . $_GET['arg'] . "'   where REF_NO = '" . $row['REF_NO'] . "'";

            $result = $conn->query($sql);
        }

        $sql2 = "delete from tmp_po_data_collect where C_CODE ='" . $row['C_CODE'] . "'";
        $result = $conn->query($sql2);

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
//}


if ($_GET["Command"] == "cancel") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "select con_ref FROM s_salma where con_ref='" . $_GET['con_ref'] . "'";
        foreach ($conn->query($sql) as $row) {

            $sql = "update s_salma set con_ref = '', con_date = '' where con_ref = '" . $row['con_ref'] . "'";

            $result = $conn->query($sql);
        }
        $conn->commit();
        echo "Cancel";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>