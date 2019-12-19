<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');
//
if ($_GET["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT poE_no FROM invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $no = $row['poE_no'];
    $ResponseXML .= "<idd><![CDATA[$no]]></idd>";
    $ResponseXML .= "</new>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "update_list") {
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
	            <tr>
                        <th width=\"121\">Supplier Code</th>
                        <th width=\"424\"> Supplier Name </th>
                        <th width=\"424\">Address </th>
                        <th width=\"121\">Telephone</th>  
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


if ($_GET["Command"] == "setitem") {
    header('Content-Type: text/xml');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_po where p_code='" . $_GET['p_code'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);
    if ($_GET["Command1"] == "add_tmp") {
        $sql = "Insert into tmp_po (p_code,p_des,r_bal,qty,p_price,dis,value,tax_com,tmp_no)values 
			('" . $_GET['p_code'] . "', '" . $_GET['p_des'] . "','" . $_GET['r_bal'] . "','" . $_GET['qty'] . "', '" . $_GET['p_price'] . "', '" . $_GET['dis'] . "','" . $_GET['value'] . "', '" . $_GET['tax_com'] . "','" . $_GET['tmpno'] . "') ";
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					";

    $i = 1;

    $sql = "Select * from tmp_po where tmp_no='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
                             <td>" . $i . "</td>
                                                         <td>" . $row['p_code'] . "</td>
                                                         <td>" . $row['p_des'] . "</td>
							 <td>" . $row['r_bal'] . "</td>
							 <td>" . $row['qty'] . "</td>
                                                         <td>" . $row['p_price'] . "</td>
							 <td>" . $row['dis'] . "</td>
                                                         <td>" . $row['value'] . "</td>  
							 <td>" . $row['tax_com'] . "</td>
                                                             
							 
    <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['p_code'] . "')\"> <span class='fa fa-remove'></span></a></td>

							 </tr>";

        $i = $i + 1;
    }

    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql = "delete from stc_PO_e where po_order_num = '" . $_GET['ref_no'] . "'";
        $result = $conn->query($sql);



        $sql5 = "Insert into stc_po_e (po_order_num,manu_no,po_req,p_date,cur_code,ex_rate,sup_code,sup_name,cost_code,cost_name,remark,txtC_code,txtC_name,loc_code,loc_name,con_person,deli_add)values 
    ('" . $_GET['ref_no'] . "', '" . $_GET['manu_no'] . "', '" . $_GET['po_req'] . "','" . $_GET['p_date'] . "', '" . $_GET['cur_code'] . "', '" . $_GET['ex_rate'] . "','" . $_GET['sup_code'] . "', '" . $_GET['sup_name'] . "', '" . $_GET['cost_code'] . "','" . $_GET['cost_name'] . "', '" . $_GET['remark'] . "', '" . $_GET['txtC_code'] . "', '" . $_GET['txtC_name'] . "', '" . $_GET['loc_code'] . "', '" . $_GET['loc_name'] . "', '" . $_GET['con_person'] . "', '" . $_GET['deli_add'] . "') ";
        $result = $conn->query($sql5);

        $sql2 = "Select * from tmp_po where ref_no='" . $_GET['po_req'] . "'";
        foreach ($conn->query($sql2) as $row) {

            $sql1 = "Insert  into po_item (ref_no,p_code,p_des,r_bal,qty,p_price,dis,p_value,tax_com)values 
            
             ('" . $_GET['ref_no'] . "','" . $row['p_code'] . "', '" . $row['p_des'] . "', '" . $row['r_bal'] . "','" . $row['qty'] . "', '" . $row['p_price'] . "', '" . $row['dis'] . "','" . $row['p_value'] . "', '" . $row['tax_com'] . "') ";
            $result = $conn->query($sql1);
        }

//        $result = $conn->query($sql);


        $sql = "SELECT poE_no FROM invpara";
        $resul = $conn->query($sql);
        $row = $resul->fetch();
        $no = $row['poE_no'];
        $no2 = $no + 1;
        $sql = "update invpara set poE_no = $no2 where poE_no = $no";
        $result = $conn->query($sql);




        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_GET["Command"] == "update_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $ResponseXML = "";
        $ResponseXML .= "<salesdetails>";

        $sql = "delete from tmp_po where ref_no='" . $_GET['ref_no'] . "'";
        $result = $conn->query($sql);

        $tot1 = 0;
        
        $sql = "update  tmp_po set r_bal= '" . $_GET['r_bal'] . "',qty='" . $_GET['qty'] . "',p_price= '" . $_GET['p_price'] . "',dis= '" . $_GET['dis'] . "',p_value='" . $_GET['p_value'] . "',tax_com= '" . $_GET['tax_com'] . "'  where p_code = '" . $_GET['ref_no'] . "'";
        $result1 = $conn->query($sql);
        
        $sql = "Select * from tmp_po where ref_no = '" . $_GET['ref_no'] . "'";
//        echo $sql;
//        foreach ($conn->query($sql) as $row) {

            $tot1 = $tot1 + $row['value'];
//        }



        $ResponseXML .= "<totvall><![CDATA[" . $tot1 . "]]></totvall>";
        $ResponseXML .= "</salesdetails>";

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>