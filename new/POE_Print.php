<?php session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Report PURCHASE ORDER ENTRY</title>


    <style>
        @media print {
            a[href]:after {
                content: none !important;
            }
        }
        a:link, a:visited {

            text-decoration: none;
            color:#000000;
        }


        a:hover {
            text-decoration: underline;
        }
        body {
            color: #333;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 10px;
            line-height: 1.32857;
        }
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            border-top:2px solid #DDDDDD;
            line-height:1.2857;
            padding:1.5px;

            vertical-align:top;
        }
        .right {
            text-align: right;
        }   
        .left {
            text-align: left;
        }  
        .left {
            text-align: left;
        }
        .table1 {
            border-collapse: collapse;
            border: 1px;
        }
        .table1, td, th {

            font-family: Arial, Helvetica, sans-serif;
            padding: 5px;

        }
        .table1 th {
            font-weight: bold;
            font-size: 12px;
        }
        .table1 td {
            font-size: 12px;
        }
        .horizontal_dotted_line{
            border-bottom: 1px dotted black;
            width: 100px;
        }

        p.solid {border-style: solid;}

    </style>
</head>



<body> 
    <?php
    require_once ("./connection_sql.php");

    date_default_timezone_set("Asia/Colombo");
    if ($_GET["Command"] == "print") {

        $table = "";



        $table .= "<table   style='width: 1200px;' class='table1'>
            <tr>
                 <th class='bottom head' colspan='3'>Crymson</th> 
            </tr>
            
            <tr>
                 <th class='bottom head' colspan='3'>Tel : 0114768000 Fax : 114768010</th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'></th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'>Quotation Requisition Form</th> 
            </tr>
              </table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> </th>
                        <th style='width: 60px;' class='left'>" . $_GET[''] . "</th>  
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET[''] . "</th>
                   </tr></table>";


        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> </th>
                        <th style='width: 60px;' class='left'>" . $_GET[''] . "</th>  
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET[''] . "</th>
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> </th>
                        <th style='width: 60px;' class='left'>" . $_GET[''] . "</th>  
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET[''] . "</th>
                   </tr></table>";




        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Reference No :</th>
                        <th style='width: 60px;' class='left'>" . $_GET['ref_no'] . "</th> 
                            <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Manual No:</th>
                        <th style='width: 50px;' class='left'>" . $_GET['manu_no'] . "</th>
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 13px;' class='left'></th>
                        <th style='width: 10px;' class='left'> Po Requisition  :</th>
                        <th style='width: 60px;' class='left p solid'>" . $_GET['po_req'] . "</th> 
                            <th style='width: 35px;' class='left'></th>
                        <th style='width: 10px;' class='left'> Po Requisition Date :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['p_date'] . "</th> 
                   </tr></table>";



        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 12px;' class='left'></th>
                        <th style='width: 10px;' class='left'> Currency Code :</th>
                        <th style='width: 7px;' class='left'></th>
                        <th style='width: 60px;' class='left'>" . $_GET['cur_code'] . "</th>  
                           <th style='width: 17px;' class='left'></th> 
                        <th style='width: 10px;' class='left'> Exchange Rate :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['ex_rate'] . "</th>  
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 12px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Supplier Code :</th>
                        <th style='width: 7px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET['sup_code'] . "</th>
                           <th style='width:37px;' class='left'></th>  
                        <th style='width: 9px;' class='left'>  Supplier Name :</th>
                        <th style='width: 60px;' class='left'>" . $_GET['sup_name'] . "</th>
                         </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Cost Center Code :</th>
                        <th style='width: 7px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET['cost_code'] . "</th> 
                            <th style='width:20px;' class='left'></th>  
                            <th style='width: 15px;' class='left'>  Cost Center Name :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['cost_name'] . "</th>  
                         </tr></table>";



        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 5px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Remark :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['remark'] . "</th> 
                            <th style='width: 10px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET[''] . "</th>  
                        
                         </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 12px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Tax Combination Code :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['txtC_code'] . "</th> 
                            <th style='width: 48px;' class='left'></th>
                            <th style='width: 2px;' class='left'>Tax Combination Name</th>
                        <th style='width: 50px;' class='left'>" . $_GET['txtC_name'] . "</th>  
                        
                         </tr></table>";


        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Location Code :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['loc_code'] . "</th> 
                             <th style='width: 42px;' class='left'></th>
                            <th style='width: 10px;' class='left'>Location Name</th>
                        <th style='width: 50px;' class='left'>" . $_GET['loc_name'] . "</th>  
                        
                         </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 8px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Contact Person :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['con_person'] . "</th> 
                            <th style='width: 42px;' class='left'></th>
                            <th style='width: 12px;' class='left'>Delivery Address</th>
                        <th style='width: 50px;' class='left'>" . $_GET['deli_add'] . "</th>  
                        
                         </tr></table>";





        $table .= "<table style='width: 1000px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                                               
                   </tr></table>";

        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";

        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";

        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";

        $table .= "<table class='table' >	
      	<tr>
                        <th style='width: 100px;' class='left'>Product Code</th>     
                        <th style='width: 100px;' class='left'>Product Des</th>                        
                        <th style='width: 100px;' class='left'>Req Bal</th>
                        <th style='width: 100px;' class='left'>Qty</th>
                        <th style='width: 100px;' class='left'>Purchase Price</th>
                        <th style='width: 100px;' class='left'>Discount</th>
                         <th style='width: 100px;' class='left'>Value</th>
                          <th style='width: 100px;' class='left'>Tax Com</th>
                        
        </tr>";

        $i = 0;
        $tot = 0;
        $sql3 = "select * from qr_item  where ref_no = '" . $_GET['ref_no'] . "'";

        foreach ($conn->query($sql3) as $row) {
            $i = $i + 1;

            $table .= "<tr>";

            $table .= "<td>" . $i . "</td>";
            $table .= "<td>" . $row['ref_no'] . "</td>";
            $table .= "<td>" . $row['r_no'] . "</td>";
            $table .= "<td>" . $row['p_code'] . "</td>";
            $table .= "<td>" . $row['p_des'] . "</td>";
            $table .= "<td>" . $row['r_bal'] . "</td>";
            $table .= "<td>" . $row['qty'] . "</td>";
            $table .= "<td>" . $row['p_price'] . "</td>";
            $table .= "<td>" . $row['dis'] . "</td>";
            $table .= "<td>" . $row['value'] . "</td>";
            $table .= "<td>" . $row['tax_com'] . "</td>";


            $table .= "</tr>";
        }


        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";



        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";






        echo $table;
    }
    ?>
