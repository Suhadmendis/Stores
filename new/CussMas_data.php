<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {

//    $tb = "";
//    $tb .= "<table class='table table-hover'>";
//
//
//    $sql = "select * from ass_comments order by no";
//
//
//
//    
//    $tb .= "<tr>";
//    $tb .= "<th style=\"width: 350px;\">Complane No</th>";
//    $tb .= "<th style=\"width: 500px;\">Complane Date</th>";
//    $tb .= "<th style=\"width: 350px;\">Name</th>";
//     $tb .= "<th style=\"width: 350px;\">Location Name</th>";
//      $tb .= "<th style=\"width: 350px;\">Telephone No</th>";
//       $tb .= "<th style=\"width: 350px;\">Complane</th>";
//        $tb .= "<th style=\"width: 350px;\">Property Code</th>";
//         $tb .= "<th style=\"width: 350px;\">Property Name</th>";
//    $tb .= "</tr>";
//
//    foreach ($conn->query($sql) as $row) {
//        $tb .= "<tr>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "')\">" . $row['no'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "'))\">" . $row['dtComm'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "'))\">" . $row['name'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "'))\">" . $row['location'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "'))\">" . $row['telNo'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "'))\">" . $row['comments'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "'))\">" . $row['propCode'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['no'] . "','" . $row['dtComm'] . "','" . $row['name'] . "','" . $row['location'] . "','" . $row['telNo'] . "','" . $row['comments'] . "','" . $row['propCode'] . "','" . $row['propName'] . "'))\">" . $row['propName'] . "</td>";
//          
//
//        $tb .= "</tr>";
//    }
//    $tb .= "</table>";
//    echo $tb;
}

if ($_GET["Command"] == "update_list") {
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
	            <tr>
                        <th width=\"121\">Item No</th>
                        <th width=\"424\"> Item Description </th>
                        
                        <th width=\"121\">Amount</th>  
                    </tr>";


    $sql = "SELECT * from s_mas where itcode <> ''";
    if ($_GET['refno'] != "") {
        $sql .= " and itcode like '%" . $_GET['refno'] . "%'";
    }
    if ($_GET['cusname'] != "") {
        $sql .= " and itname like '%" . $_GET['cusname'] . "%'";
    }
    $stname = $_GET['stname'];

    $sql .= " ORDER BY itcode limit 50";

    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["itcode"];


        $ResponseXML .= "<tr>               
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['itcode'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['itname'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['price'] . "</a></td>
                            </tr>";
    }
    $ResponseXML .= "</table>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "delete from cus_master where cus_code = '" . $_GET['cus_code'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into cus_master (cus_code,cus_name,cus_tel,cus_address,cus_fax,cus_email,cus_mob,id_no,birth_day,cus_ac,status,adv_ac,gain_ac,con_name,con_tel,con_address,con_fax,con_email,group_code,group_name,area_code,area_name,ref_code,ref_name,seg_code,seg_name,deli_name,deli_addre,deli_tel,deli_fax,deli_email,cre_pre,cre_lim)values 
    ('" . $_GET['cus_code'] . "',  '" . $_GET['cus_name'] . "','" . $_GET['cus_tel'] . "','" . $_GET['cus_address'] . "',  '" . $_GET['cus_fax'] . "', '" . $_GET['cus_email'] . "', '" . $_GET['cus_mob'] . "', '" . $_GET['id_no'] . "', '" . $_GET['birth_day'] . "', '" . $_GET['cus_ac'] . "', '" . $_GET['status'] . "', '" . $_GET['adv_ac'] . "', '" . $_GET['gain_ac'] . "', '" . $_GET['con_name'] . "', '" . $_GET['con_tel'] . "', '" . $_GET['con_address'] . "', '" . $_GET['con_fax'] . "', '" . $_GET['con_email'] . "','" . $_GET['group_code'] . "',  '" . $_GET['group_name'] . "','" . $_GET['area_code'] . "','" . $_GET['area_name'] . "',  '" . $_GET['ref_code'] . "', '" . $_GET['ref_name'] . "', '" . $_GET['seg_code'] . "', '" . $_GET['seg_name'] . "','" . $_GET['deli_name'] . "',  '" . $_GET['deli_addre'] . "','" . $_GET['deli_tel'] . "','" . $_GET['deli_fax'] . "',  '" . $_GET['deli_email'] . "',  '" . $_GET['cre_pre'] . "',  '" . $_GET['cre_lim'] . "') ";

//        
//         $sql1 = "Insert into grouping_cus_master (group_code,group_name,area_code,area_name,ref_code,ref_name,seg_code,seg_name)values 
//    ('" . $_GET['group_code'] . "',  '" . $_GET['group_name'] . "','" . $_GET['area_code'] . "','" . $_GET['area_name'] . "',  '" . $_GET['ref_code'] . "', '" . $_GET['ref_name'] . "', '" . $_GET['seg_code'] . "', '" . $_GET['seg_name'] . "') ";
//
//          $sql1 = "Insert into grouping_cus_master (deli_name,deli_addre,deli_tel,deli_fax,deli_email)values 
//   ('" . $_GET['deli_name'] . "',  '" . $_GET['deli_addre'] . "','" . $_GET['deli_tel'] . "','" . $_GET['deli_fax'] . "',  '" . $_GET['deli_email'] . "') ";


        $result = $conn->query($sql);
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>