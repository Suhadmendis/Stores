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

    $sql = "Select * from master_cost where cost_cen='" . $cuscode . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {


        $ResponseXML .= "<id><![CDATA[" . $row['cost_cen'] . "]]></id>";
        $ResponseXML .= "<name><![CDATA[" . $row['des'] . "]]></name>";

    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >Cost Center</th>
                    <th width=\"424\"  >Description</th>
                   

                </tr>";
    if (isset($_GET["mstatus"])){
        if ($_GET["mstatus"] == "cusno") {
            $letters = $_GET['cusno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select cost_cen,des from master_cost where  cost_cen like '%$letters%' ";
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select cost_cen,des from master_cost where  des like '%$letters%' ";
        }
    }else{
        $sql = "select cost_cen,des from master_cost";
    }
    $sql .= " ORDER BY cost_cen limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['cost_cen'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['des'] . "</a></td>
                              
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
