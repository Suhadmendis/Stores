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

    $sql = "Select * from stc_po_e where ref_no='" . $cuscode . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {

        $ResponseXML .= "<id><![CDATA[" . $row['ref_no'] . "]]></id>";
        $ResponseXML .= "<cur_code><![CDATA[" . $row['cur_code'] . "]]></cur_code>";
        $ResponseXML .= "<ex_rate><![CDATA[" . $row['ex_rate'] . "]]></ex_rate>";
        $ResponseXML .= "<sup_code><![CDATA[" . $row['sup_code'] . "]]></sup_code>";
        $ResponseXML .= "<sup_name><![CDATA[" . $row['sup_name'] . "]]></sup_name>";
        $ResponseXML .= "<cost_code><![CDATA[" . $row['cost_code'] . "]]></cost_code>";
        $ResponseXML .= "<cost_name><![CDATA[" . $row['cost_name'] . "]]></cost_name>";
        $ResponseXML .= "<tax_code><![CDATA[" . $row['tax_code'] . "]]></tax_code>";
        $ResponseXML .= "<tax_name><![CDATA[" . $row['tax_name'] . "]]></tax_name>";
        
    }

    //auto fill table code
    
$ResponseXML .= "<sales_table><![CDATA[<table class = \"table\">
					";

    $i = 1;
    $sql = "Select * from po_item where ref_no='" . $cuscode . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                      
                        <td>" . $i . "</td>
                             <td>" . $row['p_code'] . "</td>  
                             <td>" . $row['p_des'] . "</td> 
                             <td><input type=\"text\" value=\"" . $row['r_bal'] . "\" class=\"form-control  input-sm\"></td>
                            <td><input type=\"text\" value=\"" . $row['qty'] . "\" class=\"form-control  input-sm\"></td>
                            <td><input type=\"text\" value=\"" . $row['p_price'] . "\" class=\"form-control  input-sm\"></td>
                            <td><input type=\"text\" value=\"" . $row['dis'] . "\" class=\"form-control  input-sm\"></td>
                            <td><input type=\"text\" value=\"" . $row['value'] . "\" class=\"form-control  input-sm\"></td>
                            <td><input type=\"text\" value=\"" . $row['tax_com'] . "\" class=\"form-control  input-sm\"></td>
                          


                        <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['p_code'] . "')\"> <span class='fa fa-remove'></span></a></td>
			</tr>";
        $i = $i + 1;
    }

//    $sql = "Insert into tmp_po (p_code,p_des,r_bal,qty,p_price,dis,value,tax_com,tmp_no)values 
//			('" . $_GET['code'] . "', '" . $_GET['des'] . "','" . $_GET['r_bal'] . "','" . $_GET['qty'] . "', '" . $_GET['p_price'] . "', '" . $_GET['dis'] . "','" . $_GET['value'] . "', '" . $_GET['tax_com'] . "','" . $_GET['tmpno'] . "') ";
//    $result = $conn->query($sql);

    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    
    
    //
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >PO NO</th>
                    
                   

                </tr>";
    if (isset($_GET["mstatus"])) {
        if ($_GET["mstatus"] == "cusno") {
            $letters = $_GET['cusno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select ref_no from stc_PO_e where  ref_no like '%$letters%' ";
        }
    } else {
        $sql = "select ref_no from stc_PO_e";
    }
    $sql .= " ORDER BY ref_no limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['ref_no'] . "</a></td>
                           
                              
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
