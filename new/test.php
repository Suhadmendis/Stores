<?php session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Report KOT ENTRY</title>


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
    if ($_GET["Command"] == "rep") {

        $table = "";



        $table .= "<table   style='width: 1200px;' class='table1'>
            <tr>
                 <th class='bottom head' colspan='3'>SILUETA (PVT) LTD</th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'>Biyagama Export Processing Zone</th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'>Walagama,Malwana</th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'>Tel : 0114768000 Fax : 114768010</th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'></th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'>KOT ENTRY REPORT</th> 
            </tr>
              </table>";




        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Entry No :</th>
                        <th style='width: 80px;' class='left'>" . $_GET['entryNo'] . "</th>  
                       
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Visiter Type :</th>
                        <th style='width: 80px;' class='left p solid'>" . $_GET['visitorType'] . "</th> 
                        <th style='width: 10px;' class='left'>Organization Name :</th>
                        <th style='width: 80px;' class='left'>" . $_GET['visitorName'] . "</th> 
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>No of Visitors :</th>
                        <th style='width: 80px;' class='left'>" . $_GET['visitorNo'] . "</th>  
                        <th style='width: 10px;' class='left'>Department :</th>
                        <th style='width: 80px;' class='left'>" . $_GET['department'] . "</th>  
               
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>No of Persons :</th>
                        <th style='width: 80px;' class='left'>" . $_GET['personNo'] . "</th>  
                        <th style='width: 10px;' class='left'>Require Time:</th>
                        <th style='width: 80px;' class='left'>" . $_GET['requireTime'] . "</th>  
               
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Require Date :</th>
                        <th style='width: 80px;' class='left'>" . $_GET['requireDate'] . "</th>  
                        <th style='width: 10px;' class='left'>Remarks :</th>
                        <th style='width: 80px;' class='left'>" . $_GET['remark'] . "</th>  
                   </tr></table>";


        $table .= "<table style='width: 1000px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                                               
                   </tr></table>";



        $table .= "<table class='table' >	
      	<tr>
                        <th style='width: 100px;' class='left'>No</th>     
                        <th style='width: 100px;' class='left'>Meal Type</th>      
                        <th style='width: 100px;' class='left'>Item Code</th>                        
                        <th style='width: 100px;' class='left'>Description</th>
                        <th style='width: 100px;' class='left'>Qty</th>
                        <th style='width: 100px;' class='left'>Amount</th>
                        <th style='width: 100px;' class='left'>Sub Total</th>
	
        </tr>";

        $i = 0;
        $tot = 0;
        $sql3 = "select * from kot_itemdetail  where entryNo = '" . $_GET['entryNo'] . "'";

        foreach ($conn->query($sql3) as $row) {
            $i = $i + 1;

            $table .= "<tr>";

            $table .= "<td>" . $i . "</td>";
            $table .= "<td>" . $row['mealtype'] . "</td>";
            $table .= "<td>" . $row['itemcode'] . "</td>";
            $table .= "<td>" . $row['itemdesc'] . "</td>";
            $table .= "<td>" . $row['qty'] . "</td>";
            $table .= "<td>" . $row['amount'] . "</td>";
            $table .= "<td>" . $row['subtot'] . "</td>";

            $table .= "</tr>";
            $tot = $tot + $row['subtot'];
        }


        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";

        $table .= "<table style='width: 1200px;' class='table1'><tr>
                        <th style='width: 300px;' class='left'></th>
                        <th style='width: 100px;' class='left'>Total :</th>
                        <th style='width: 80px;' class='left'>" . $tot . "</th> 
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 80px;' class='left'>" . $_GET[''] . "</th>  
                        
                   </tr></table>";

        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";

//        $table .= "<table class='table1' ><tr>
//                                
//                        <th style='width: 100px;' class='horizontal_dotted_line'></th>                        
//                        <th style='width: 100px;' class='horizontal_dotted_line'></th>
//                        <th style='width: 100px;' class='horizontal_dotted_line'></th>
//                        <th style='width: 100px;' class='horizontal_dotted_line'></th>
//	
//                    </tr></table>";
//
//        $table .= "<table class='table1' ><tr>
//                         <th><h1></h1></th>           
//                        <th style='width: 100px;' class='left'>W/S:S/E SIG</th>                        
//                        <th style='width: 100px;' class='left'>DRIVER'S SIG</th>
//                        <th style='width: 100px;' class='left'>S/O SIG</th>
//                        <th style='width: 100px;' class='left'>O.I.C SIG</th>
//	
//                    </tr></table>";

        echo $table;
    }
    ?>


/////////////////////////////////////////



    <!--                <div class="form-group"></div>-->
    <!--                <div class="form-group"></div>-->
    <!--                <div class="form-group"></div>-->
    <!--                <ul class="nav nav-tabs nav-justified">-->
    <!--                    <li class="active"><a data-toggle="tab" href="#home">Input Data</a></li>-->
    <!--                    <li><a data-toggle="tab" href="#menu1">SQFT Materials</a></li>-->
    <!--                    <li><a data-toggle="tab" href="#menu2">Materials</a></li>-->
    <!--                    <li><a data-toggle="tab" href="#menu3">OverHead</a></li>-->
    <!--                    <li><a data-toggle="tab" href="#menu4">Costing Information</a></li>-->
    <!--                    <li><a data-toggle="tab" href="#menu5">Output Data</a></li>-->
    <!--                    <li><a data-toggle="tab" href="#menu6">Paths</a></li>-->
    <!--                </ul>-->
    <!--                <div class="tab-content">-->
    <!--                    <div id="home" class="tab-pane fade in active">-->
    <!--                        <div class="col-md-12">-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-1 control-label text-center"  for="invno">Manual</label>-->
    <!--                                <div>-->
    <!--                                    <input type="checkbox" id="inputcheck">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!---->
    <!--                                        <!--<div class="col-sm-12">-->-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Length(Inches)</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="lengthText" placeholder="Length(Inches)" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Width(Inches)</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="widthText" placeholder="Width(Inches)" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Printable Area(Square Inches)</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="printableText" placeholder="Printable Area(Square Inches)" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No of Sides Printed</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="sidePriText" placeholder="No of Sides Printed" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No of Colors</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="noColorText" placeholder="No of Colors" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Type of Inked</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="typeInkText" placeholder="Type of Inked" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Area Of Printed</label>-->
    <!--                                            <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">S</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="radio" id="r1" name="rr"> -->
    <!--                                            </div>-->
    <!--                                            <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">M</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="radio" id="r2" name="rr"> -->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <!--</div>-->-->
    <!--                                        <!--<div class="col-sm-12">-->-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Gripper Margin</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="gripperText" placeholder="Gripper Margin" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Cutting Margin</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="cuttingMarginText" placeholder="Cutting Margin" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Wastage%</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="wastageText" placeholder="Wastage%" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No of SQFT of cord</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="sqtCordText" placeholder="No of SQFT of cord" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No of Art Works</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="noArtWorksText" placeholder="No of Art Works" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!---->
    <!--                                        <div class="form-group"></div>-->
    <!--                                        <div class="form-group"></div>-->
    <!--                                        <div class="form-group"></div>-->
    <!--                                        <div class="form-group"></div>-->
    <!--                                        <div class="form-group"></div>-->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Previous Costing</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="preCostText" placeholder="Previous Costing" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div> -->
    <!--                                        <div class="form-group">-->
    <!--                                            <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Remark</label>-->
    <!--                                            <div class="col-sm-3">-->
    <!--                                                <input type="text" id="remarkText" placeholder="Remark" class="form-control  input-sm">-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                        </div> -->
    <!--                    </div>-->
    <!---->
    <!--                    <div id="menu1" class="tab-pane fade">-->
    <!--                        <div class="col-sm-12">-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">   -->
    <!--                                <label class="col-sm-2" for="invno">Main Metirials</label>-->
    <!--                                <label class="col-sm-1" for="invno"></label>-->
    <!--                                <label class="col-sm-1" for="invno">Roll</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="radio" id="rollRadio" name="1">-->
    <!--                                </div>-->
    <!--                                <label class="col-sm-1" for="invno">Board</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="radio" id="boardRadio" name="1">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group"></div>-->
    <!---->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">UOM</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="UOM" id="uomTxt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Main Raw Metirial</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="mainRaw1Txt" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text" placeholder="L" id="mainRawLTxt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text" placeholder="W" id="mainRawWTxt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Length</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Length" id="lengthText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Width</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Width" id="widthText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No of outs per run</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="noperr1Txt" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="noperr2Txt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="noperr3Txt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Length Inches</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Length Inches" id="lengthInchText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Actual no of outs per sheet</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="anopsheetText" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="anopsheet1Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="anopsheet2Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Width Inches</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Width Inches" id="widthInchText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No Of Square Feet</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" id="nosqureText" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                            </div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">   -->
    <!--                                <label class="col-sm-2" for="invno">Sub Materials</label>-->
    <!--                                <label class="col-sm-1" for="invno"></label>-->
    <!--                                <label class="col-sm-1" for="invno">Roll</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="radio" id="subrollRadio" name="3">-->
    <!--                                </div>-->
    <!--                                <label class="col-sm-1" for="invno">Board</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="radio" id="subboardRadio" name="3">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group"></div>-->
    <!---->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">UOM</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="UOM" id="subuomTxt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Sub Raw Metirial</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="subRaw1Txt" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text" placeholder="L" id="subRawLTxt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text" placeholder="W" id="subRawWTxt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Length</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Length" id="sublengthText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Width</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Width" id="subwidthText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No of outs per run</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="subnoperr1Txt" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="subnoperr2Txt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="subnoperr3Txt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Length Inches</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Length Inches" id="sublengthInchText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Actual no of outs per sheet</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="subanopsheetText" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="subanopsheet1Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-1">-->
    <!--                                    <input type="text"  id="subanopsheet2Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Width Inches</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Width Inches" id="subwidthInchText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No Of Square Feet</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" id="subnosqureText" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <div class="col-sm-2">-->
    <!---->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" id="subnosqure1Text" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!---->
    <!--                    <div id="menu2" class="tab-pane fade">-->
    <!--                        <div class="col-md-12">-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <table class="table table-striped">-->
    <!--                                    <tr class='info'>-->
    <!--                                        <th>Board</th>-->
    <!--                                        <th>Description</th>-->
    <!--                                        <th>Quantity</th>-->
    <!--                                        <th>Unit Price</th>-->
    <!--                                        <th>Average Price</th>-->
    <!--                                        <th>Balance</th>-->
    <!--                                    </tr>-->
    <!--                                    <tr class='info'>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="boardTxt" placeholder="Board" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="descripttext" placeholder="Description" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="quantityTxt" placeholder="Quantity" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="unitpriceTxt" placeholder="Unit Price" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="avgPriceTxt" placeholder="Average Price" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="balanceTxt" placeholder="Balance" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                        <td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span>  </a></td>-->
    <!---->
    <!--                                    </tr>-->
    <!---->
    <!--                                </table>-->
    <!--                                <div id="abcd"></div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <table class="table table-striped">-->
    <!--                                    <tr class='info'>-->
    <!--                                        <th>Ink</th>-->
    <!--                                        <th>Description</th>-->
    <!--                                        <th>Quantity</th>-->
    <!--                                        <th>Unit Price</th>-->
    <!--                                        <th>Average Price</th>-->
    <!--                                        <th>Value</th>-->
    <!--                                    </tr>-->
    <!--                                    <tr class='info'>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="inkTxt" placeholder="Ink" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="descript1text" placeholder="Description" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="quantity1Txt" placeholder="Quantity" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="unitprice1Txt" placeholder="Unit Price" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="avgPrice1Txt" placeholder="Average Price" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="value1Txt" placeholder="Value" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                        <td><a onclick="add_two();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span>  </a></td>-->
    <!--                                    </tr>-->
    <!--                                </table>-->
    <!--                            </div>-->
    <!--                            <div id="abcde"></div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <table class="table table-striped">-->
    <!--                                    <tr class='info'>-->
    <!--                                        <th>Other</th>-->
    <!--                                        <th>Description</th>-->
    <!--                                        <th>Quantity</th>-->
    <!--                                        <th>Unit Price</th>-->
    <!--                                        <th>Average Price</th>-->
    <!--                                        <th>Value</th>-->
    <!--                                    </tr>-->
    <!--                                    <tr class='info'>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="otherTxt" placeholder="Other" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="descript2text" placeholder="Description" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="quantity2Txt" placeholder="Quantity" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="unitprice2Txt" placeholder="Unit Price" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="avgPrice2Txt" placeholder="Average Price" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="value2Txt" placeholder="Value" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                        <td><a onclick="add_three();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span>  </a></td>-->
    <!--                                    </tr>-->
    <!--                                </table>-->
    <!--                            </div>-->
    <!--                            <div id="ab"></div>-->
    <!--                        </div>-->
    <!--                    </div>    -->
    <!--                    <div id="menu3" class="tab-pane fade">-->
    <!--                        <div class="col-md-12">-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <table class="table table-striped">-->
    <!--                                    <tr class='info'>-->
    <!--                                        <th>OverHead</th>-->
    <!--                                        <th>Description</th>-->
    <!--                                        <th>Rate</th>-->
    <!--                                        <th>Value</th>-->
    <!--                                    </tr>-->
    <!--                                    <tr class='info'>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="overHeadTxt" placeholder="OverHead" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="descript3text" placeholder="Description" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="rateTxt" placeholder="Rate" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="valTxt" placeholder="Value" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td><a onclick="add_newq();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span>  </a></td>-->
    <!--                                    </tr>-->
    <!--                                </table>-->
    <!--                            </div>-->
    <!--                            <div id="qwe"></div>-->
    <!---->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <table class="table table-striped">-->
    <!--                                    <tr class='info'>-->
    <!--                                        <th>Stage</th>-->
    <!--                                        <th>Description</th>-->
    <!--                                        <th>Select</th>-->
    <!--                                    </tr>-->
    <!--                                    <tr class='info'>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="stageTxt" placeholder="Stage" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="desTxt" placeholder="Description" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            <input type="text" id="selectTxt" placeholder="Select" class="form-control  input-sm ">-->
    <!--                                        </td>-->
    <!--                                        <td><a onclick="add_n();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span>  </a></td>-->
    <!--                                    </tr>-->
    <!--                                </table>-->
    <!--                            </div>-->
    <!--                            <div id="tab"></div>-->
    <!---->
    <!--                        </div>-->
    <!--                    </div>-->
    <!---->
    <!--                    <div id="menu4" class="tab-pane fade">-->
    <!--                        <div class="form-group"></div>-->
    <!--                        <div class="form-group"></div>-->
    <!--                        <div class="col-md-12">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Total Square Inches</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Total Square Inches" id="totsqInchTxt" name="priceLevelTxt" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Transport</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Transport" id="transportTxt"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Offset</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="offsetText" placeholder="Offset" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <input type="checkbox" id="checkoffsetText">-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Die Charge</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Die Charge" id="dieChargeText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Flexo</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="flexoText" placeholder="Flexo" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <input type="checkbox" id="checkflexoText">-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Packing</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Packing" id="packingText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Vinyl</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="vinylText" placeholder="Vinyl" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <input type="checkbox" id="checkflexoText">-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Positive</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Positive" id="positiveText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Digital</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="digitalText" placeholder="Digital" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <input type="checkbox" id="checkflexoText">-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Cord</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Cord" id="cordText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Manual Pasting</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="manualPastingText" placeholder="Manual Pasting" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <input type="checkbox" id="checkflexoText">-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Die Cutting Charge</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Die Cutting Charge" id="dieCuttingChargeText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Chain</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="chainText" placeholder="Chain" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <input type="checkbox" id="checkflexoText">-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Mold & D/Side</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Mold & D/Side" id="moldDSText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Laminating</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" id="laminatingText" placeholder="Laminating" class="form-control  input-sm ">-->
    <!--                                </div>    -->
    <!--                                <input type="checkbox" id="checkflexoText">-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Molding Charge</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Molding Charge" id="moldChargeText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <input type="checkbox" id="moldCharge">-->
    <!--                                <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Laminating</label>-->
    <!--                                                                <div class="col-sm-2">-->
    <!--                                                                    <input type="text" id="laminatingText" placeholder="Laminating" class="form-control  input-sm ">-->
    <!--                                                                </div>    -->
    <!--                                                                <input type="checkbox" id="checkflexoText">-->-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Bending Charge</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Bending Charge" id="bendingChargeText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <input type="checkbox" id="bendingCharge">-->
    <!--                                <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Laminating</label>-->
    <!--                                                                <div class="col-sm-2">-->
    <!--                                                                    <input type="text" id="laminatingText" placeholder="Laminating" class="form-control  input-sm ">-->
    <!--                                                                </div>    -->
    <!--                                                                <input type="checkbox" id="checkflexoText">-->-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Sub Contractor Charge</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Sub Contractor Charge" id="subContractorChargeText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <input type="checkbox" id="subContractorCharge">-->
    <!--                                <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Laminating</label>-->
    <!--                                                                <div class="col-sm-2">-->
    <!--                                                                    <input type="text" id="laminatingText" placeholder="Laminating" class="form-control  input-sm ">-->
    <!--                                                                </div>    -->
    <!--                                                                <input type="checkbox" id="checkflexoText">-->-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Forming Charge</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Forming Charge" id="formingChargeText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <input type="checkbox" id="formingCharge">-->
    <!--                                <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Laminating</label>-->
    <!--                                                                <div class="col-sm-2">-->
    <!--                                                                    <input type="text" id="laminatingText" placeholder="Laminating" class="form-control  input-sm ">-->
    <!--                                                                </div>    -->
    <!--                                                                <input type="checkbox" id="checkflexoText">-->-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Stitching Charge</label>-->
    <!--                                <div class="col-sm-2">-->
    <!--                                    <input type="text" placeholder="Stitching Charge" id="stitchingChargeText"  class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <input type="checkbox" id="stitchingCharge">-->
    <!--                                <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno"></label>-->
    <!--                                                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Laminating</label>-->
    <!--                                                                <div class="col-sm-2">-->
    <!--                                                                    <input type="text" id="laminatingText" placeholder="Laminating" class="form-control  input-sm ">-->
    <!--                                                                </div>    -->
    <!--                                                                <input type="checkbox" id="checkflexoText">-->-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div id="menu5" class="tab-pane fade">-->
    <!---->
    <!--                        <div class="col-md-12">-->
    <!--                            <h1>Output Data</h1>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Estimate No Of Outs Per Sheet</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimate No Of Outs Per Sheet" id="enofOutsPerSheetText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Estimate No Of Sheet Required For The Job</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimate No Of Sheet Required For The Job" id="enofReqForTheJobText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Cost Per Order</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Cost Per Order" id="costPerOrderText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Cost Per Unit</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Cost for Unit" id="costforOrderText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Estimated Margin Per Unit</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimated Margin Per Unit" id="estimatedMarginPerUnit1Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimated Margin Per Unit" id="estimatedMarginPerUnit2Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimated Margin Per Unit" id="estimatedMarginPerUnit3Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Contribution</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Contribution" id="contributionText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Contribution" id="contribution1Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Contribution" id="contribution2Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Contribution %</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Contribution %" id="contributionPresntageText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Contribution %" id="contributionPresntage1Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Contribution %" id="contributionPresntage2Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Net Profit</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Net Profit" id="netProfitText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Net Profit" id="netProfit1Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Net Profit" id="netProfit2Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Estimate Price Per Unit</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimate Price Per Unit" id="estimatePricePerUnitText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimate Price Per Unit" id="estimatePricePerUnit1Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Estimate Price Per Unit" id="estimatePricePerUnit2Text" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Order Value</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Order Value" id="orderValueText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Unit Price</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Unit Price" id="unitPriceText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">Material Price</label>-->
    <!--                                <div class="col-sm-3">-->
    <!--                                    <input type="text" placeholder="Material Price" id="materialPriceText" class="form-control  input-sm ">-->
    <!--                                </div>-->
    <!--                                <label class="col-sm-3 input-sm" for="invno">(For Account Purpose)</label>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div id="menu6" class="tab-pane fade">-->
    <!--                        <div class="col-md-12">-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group"></div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Artwork Path</label>-->
    <!--                                <div class="col-sm-8">-->
    <!--                                    <input type="text" placeholder="Artwork Path" id="artworkPathTxt" class="form-control input-sm">-->
    <!--                                </div>                                -->
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Concept Path</label>-->
    <!--                                <div class="col-sm-8">-->
    <!--                                    <input type="text" placeholder="Concept Path" id="conceptPathTxt" class="form-control input-sm">-->
    <!--                                </div>
    <!--                            </div>-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="col-sm-2 input-sm" for="invno">Costing & Specification Path</label>-->
    <!--                                <div class="col-sm-8">-->
    <!--                                    <input type="text" placeholder="Costing & Specification Path" id="costingSpecificationPathTxt" class="form-control input-sm">-->
    <!--                                </div>                                -->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
