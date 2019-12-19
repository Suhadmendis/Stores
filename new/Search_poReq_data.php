<?php

session_start();

include_once './connection_sql.php';

if ($_GET["Command"] == "pass_quot") {


    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from po_req where ref_no='" . $cuscode . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {


        $ResponseXML .= "<id><![CDATA[" . $row['ref_no'] . "]]></id>";
        $ResponseXML .= "<name><![CDATA[" . $row['req_date'] . "]]></name>";
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class = \"table\">
					";
    $tot = 0;
    $i = 1;
    $sql = "Select * from por_item where ref_no='" . $cuscode . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                      
                        <td>" . $i . "</td>
                        
                            <td><input type=\"text\" value=\"" . $row['code'] . "\" disabled  class=\"form-control  input-sm\"></td>
                            <td><input type=\"text\" value=\"" . $row['des'] . "\" disabled class=\"form-control  input-sm\"></td>
                             <td><input type=\"text\" value=\"" . $row['req_bal'] . "\"    id=\"" . $row['code'] . "reqBal\"   class=\"form-control  input-sm\"></td>
                             <td><input type=\"text\" value=\"" . $row['qty'] . "\" id=\"" . $row['code'] . "qty\"  class=\"form-control  input-sm\"></td>
                             <td><input type=\"text\" value=\"" . $row['pur_price'] . "\"  id=\"" . $row['code'] . "pur_price\" class=\"form-control  input-sm\"></td>
                             <td><input type=\"text\" value=\"" . $row['discount'] . "\" id=\"" . $row['code'] . "discount\"  class=\"form-control  input-sm\"></td>
                             <td><input type=\"text\" value=\"" . $row['value'] . "\" id=\"" . $row['code'] . "p_value\"   class=\"form-control  input-sm\"></td>
                             <td><input type=\"text\" value=\"" . $row['tax_com'] . "\"   id=\"" . $row['code'] . "tax_com\"  class=\"form-control  input-sm\"></td>
                        
                        <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['code'] . "')\"> <span class='fa fa-remove'></span></a></td>
			<td><a class=\".btn-primary btn-xs\" onClick=\"update_item('" . $row['code'] . "')\"> <span class='fa fa-check'></span></a></td>
</tr>";
        $i = $i + 1;
        $tot = $tot + $row['value'];

        $sql = "Insert into tmp_po (ref_no,p_code,p_des,r_bal,qty,p_price,dis,p_value,tax_com)values 
             ('" . $row['ref_no'] . "','" . $row['code'] . "', '" . $row['des'] . "', '" . $row['r_bal'] . "','" . $row['qty'] . "', '" . $row['p_price'] . "', '" . $row['dis'] . "','" . $row['value'] . "', '" . $row['tax_com'] . "') ";
        $result = $conn->query($sql);
    }


    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
    $ResponseXML .= "<totval><![CDATA[" . $tot . "]]></totval>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

//
//
//if ($_GET["Command"] == "update_item") {
//
//
//    try {
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $conn->beginTransaction();
////        $sql = "delete from tmp_po where ref_no = '" . $_GET['ref_no'] . "'";
////        $result = $conn->query($sql);
////cancel = '1' 
////        $sql = "update tmp_po set '" . $row['p_des'] . "', '" . $row['r_bal'] . "','" . $row['qty'] . "', '" . $row['p_price'] . "', '" . $row['dis'] . "','" . $row['value'] . "', '" . $row['tax_com'] . "'  where ref_no = '" . $_GET['ref_no'] . "'";
//        $sql = "update tmp_po set r_bal = '1'   where ref_no = '" . $_GET['ref_no'] . "'";
//        $result1 = $conn->query($sql);
//
//
//        $conn->commit();
//        echo "Saved";
//    } catch (Exception $e) {
//        $conn->rollBack();
//        echo $e;
//    }
//}












if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >PO NO</th>
                    <th width=\"424\"  >PO DATE</th>
                   

                </tr>";
    if (isset($_GET["mstatus"])) {
        if ($_GET["mstatus"] == "cusno") {
            $letters = $_GET['cusno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select ref_no,req_date from po_req where  ref_no like '%$letters%' ";
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select ref_no,req_date from po_req where  req_date like '%$letters%' ";
        }
    } else {
        $sql = "select ref_no,req_date from po_req";
    }
    $sql .= " ORDER BY ref_no limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['ref_no'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['req_date'] . "</a></td>
                              
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
