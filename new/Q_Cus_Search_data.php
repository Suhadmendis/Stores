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

    $sql = "Select * from cus_master where cus_code='" . $cuscode . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {


        $ResponseXML .= "<id><![CDATA[" . $row['cus_code'] . "]]></id>";
        $ResponseXML .= "<name><![CDATA[" . $row['cus_name'] . "]]></name>";

    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >Customer Code</th>
                    <th width=\"424\"  >Customer Name</th>
                   

                </tr>";
    if (isset($_GET["mstatus"])){
        if ($_GET["mstatus"] == "cusno") {
            $letters = $_GET['cusno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select cus_code,cus_name from cus_master where  cus_code like '%$letters%' ";
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select cus_code,cus_name from cus_master where  cus_name like '%$letters%' ";
        }
    }else{
        $sql = "select cus_code,cus_name from cus_master";
    }
    $sql .= " ORDER BY cus_code limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['cus_code'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['cus_name'] . "</a></td>
                              
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
