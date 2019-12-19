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

    $sql = "Select * from master_supplier where sup_code='" . $cuscode . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {


        $ResponseXML .= "<id><![CDATA[" . $row['sup_code'] . "]]></id>";
        $ResponseXML .= "<name><![CDATA[" . $row['sup_name'] . "]]></name>";
        $ResponseXML .= "<con_per><![CDATA[" . $row['sup_code'] . "]]></con_per>";
        $ResponseXML .= "<del_add><![CDATA[" . $row['sup_name'] . "]]></del_add>";

    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >Supplier Code</th>
                    <th width=\"424\"  >Supplier Name</th>
                   

                </tr>";
    if (isset($_GET["mstatus"])){
        if ($_GET["mstatus"] == "cusno") {
            $letters = $_GET['cusno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select sup_code,sup_name from master_supplier where  sup_code like '%$letters%' ";
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select sup_code,sup_name from master_supplier where  sup_name like '%$letters%' ";
        }
    }else{
        $sql = "select sup_code,sup_name from master_supplier";
    }
    $sql .= " ORDER BY sup_code limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['sup_code'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['sup_name'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['con_per'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['con_add'] . "</a></td>
                              
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
