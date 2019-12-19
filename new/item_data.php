<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {

    $sql = "select itno from invpara";
    $result = $conn->query($sql);
    $rowInvpara = $result->fetch();

    $tb = "";
    $tb .= "<table class='table table-hover'>";

    if ($_GET["ls"] == "new") {
        $sql = "select * from s_mas order by STK_NO desc";
    } else {
        if ($_GET["ls"] == "STK_NO") {
            $sql = "select * from s_mas where STK_NO like '" . Trim($_GET["txt_code"]) . "%' order by STK_NO desc limit 50";
        }
        if ($_GET["ls"] == "DPTMNT") {
            $sql = "select * from s_mas where DPTMNT like '" . Trim($_GET["txt_dep"]) . "%' order by STK_NO desc limit 50";
        }
    }



    $tb .= "<tr>";
    $tb .= "<th style=\"width: 350px;\">Item Code</th>";
    $tb .= "<th style=\"width: 500px;\">Description</th>";
    $tb .= "<th style=\"width: 350px;\">Department</th>";
    $tb .= "</tr>";

    foreach ($conn->query($sql) as $row) {

        $tb .= "<tr>";
//        $tb .= $row['STK_NO'];
        $tb .= "<td onclick=\"getcode('" . $row['STK_NO'] . "','" . $row['DESCRIPT'] . "','" . $row['SELLING'] . "','" . trim($row['lockitem']) . "','" . $row['BRAND_NAME'] . "','" . $row['MANF_Y'] . "','" . $row['model'] . "','" . $row['COLOR'] . "','" . $row['SPLR'] . "','" . $row['CPTY'] . "','" . $row['DPTMNT'] . "','" . $row['OW_CODE'] . "','" . $row['w_prd'] . "','" . $row['srl_num'] . "','" . $row['inv_num'] . "','" . $row['CAT'] . "','" . $row['file_num'] . "')\">" . $row['STK_NO'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['STK_NO'] . "','" . $row['DESCRIPT'] . "','" . $row['SELLING'] . "','" . trim($row['lockitem']) . "','" . $row['BRAND_NAME'] . "','" . $row['MANF_Y'] . "','" . $row['model'] . "','" . $row['COLOR'] . "','" . $row['SPLR'] . "','" . $row['CPTY'] . "','" . $row['DPTMNT'] . "','" . $row['OW_CODE'] . "','" . $row['w_prd'] . "','" . $row['srl_num'] . "','" . $row['inv_num'] . "','" . $row['CAT'] . "','" . $row['file_num'] . "')\">" . $row['DESCRIPT'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['STK_NO'] . "','" . $row['DESCRIPT'] . "','" . $row['SELLING'] . "','" . trim($row['lockitem']) . "','" . $row['BRAND_NAME'] . "','" . $row['MANF_Y'] . "','" . $row['model'] . "','" . $row['COLOR'] . "','" . $row['SPLR'] . "','" . $row['CPTY'] . "','" . $row['DPTMNT'] . "','" . $row['OW_CODE'] . "','" . $row['w_prd'] . "','" . $row['srl_num'] . "','" . $row['inv_num'] . "','" . $row['CAT'] . "','" . $row['file_num'] . "')\">" . $row['DPTMNT'] . "</td>";
        $tb .= "</tr>";
    }
    $tb .= "</table>";


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<itemList><![CDATA[" . $tb . "]]></itemList>";
    $ResponseXML .= "<itemCode><![CDATA[" . $rowInvpara["itno"] . "]]></itemCode>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "update_list") {
    
    $stname = "";
    if (isset($_GET['stname'])) {
        $stname = $_GET["stname"];
    }
    
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
	            <tr>
                        <th width=\"121\">Item No</th>
                        <th width=\"424\">Item Description </th>";
    if($stname != "pre_ink"){
        $ResponseXML .= "<th width=\"121\">All Quantity</th>";  
    }else{
        $ResponseXML .= "<th width=\"121\">Avg Cost</th>";
    }                    
    
    $ResponseXML .= "</tr>";

    $sql = "SELECT * from s_mas where STK_NO <> ''";
    if ($stname == "pre_ink") {
        $sql .= " and GROUP1 = 'PRE_INK'";
    }
    if ($stname == "fg") {
        $sql .= " and GROUP2 = 'FG'";
    }
    if ($_GET['refno'] != "") {
        $sql .= " and STK_NO like '%" . $_GET['refno'] . "%'";
    }
    if ($_GET['cusname'] != "") {
        $sql .= " and DESCRIPT like '%" . $_GET['cusname'] . "%'";
    }

    $sql .= " ORDER BY STK_NO limit 50";

    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["STK_NO"];


        $ResponseXML .= "<tr>               
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['STK_NO'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['DESCRIPT'] . "</a></td>";
        if($stname == "pre_ink"){
            $ResponseXML .= "<td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['GROUP2'] . "</a></td>";
        }else{
            $ResponseXML .= "<td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['QTYINHAND'] . "</a></td>";
        }
        
        
        $ResponseXML .= "</tr>";
    }
    $ResponseXML .= "</table>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "select STK_NO from s_mas where STK_NO = '" . $_GET['txt_itcode'] . "'";

        $result = $conn->query($sql);
        if ($row_rst = $result->fetch()) {
            $sql = "delete from s_mas where STK_NO = '" . $_GET['txt_itcode'] . "'";
            $conn->exec($sql);
        } else {
            $sql = "update invpara set itno = itno + 1";
            $conn->exec($sql);
        }



        $sql = "select NAME from vendor where CODE = '" . $_GET['owner'] . "'";
        $result = $conn->query($sql);
        $row = $result->fetch();

        $sql = "Insert into s_mas (STK_NO, DESCRIPT, SELLING, lockitem, BRAND_NAME, MANF_Y, model, COLOR, SPLR, CPTY, DPTMNT, OW_CODE, OW_NAME, w_prd, srl_num, inv_num, cat, file_num)values 
    ('" . $_GET['txt_itcode'] . "', '" . $_GET['txt_description'] . "', " . $_GET['txt_amount'] . ",'" . $_GET['lockitem'] . "', '" . $_GET['txt_brand'] . "', '" . $_GET['txt_manuf'] . "','" . $_GET['txt_model'] . "', '" . $_GET['txt_color'] . "', '" . $_GET['txt_splr'] . "','" . $_GET['txt_cpty'] . "', '" . $_GET['department'] . "','" . $_GET['owner'] . "','" . $row['NAME'] . "', " . $_GET['txt_wrnty'] . ", '" . $_GET['txt_srlnumber'] . "', '" . $_GET['txt_invno'] . "','" . $_GET['category'] . "','" . $_GET['txt_file'] . "') ";

        $conn->exec($sql);
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>