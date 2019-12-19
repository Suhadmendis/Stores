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

    $sql = "Select * from item_mas where rec_no='" . $cuscode . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {


        $ResponseXML .= "<id><![CDATA[" . $row['ref_no'] . "]]></id>";
//        $ResponseXML .= "<name><![CDATA[" . $row['des'] . "]]></name>";

    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >Ref No</th>

                   

                </tr>";
    if (isset($_GET["mstatus"])){
        if ($_GET["mstatus"] == "cusno") {
            $letters = $_GET['cusno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = "select ref_no from redelivery where  ref_no like '%$letters%' ";
//        } else if ($_GET["mstatus"] == "customername") {
//            $letters = $_GET['customername'];
//            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
//            $sql = "select rec_no,des from item_mas where  des like '%$letters%' ";
//        }
    }else{
        $sql = "select ref_no from redelivery";
    }
    $sql .= " ORDER BY ref_no limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['code'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['ref_no'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['des'] . "</a></td>
                              
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
