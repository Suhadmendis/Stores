<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title"><strong>Costing</strong></h1>
        </div>
        <form name= "form1" role="form" class="form-horizontal">
            <div class="box-body">

                <input type="hidden" id="tmpno" class="form-control">

                <input type="hidden" id="item_count" class="form-control">
                <div class="form-group-sm">
                    <a onclick="newent();" class="btn btn-default btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; NEW
                    </a>
                    <a onclick="save_inv();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; SAVE
                    </a>
                    <a onclick="cancel_inv();" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash-o"></span> &nbsp; CANCEL
                    </a>
                </div>
                <div class="form-group"></div>
                <div class="form-group"></div>

                <div id="msg_box"  class="span12 text-center"  ></div>

                <div class="form-group"></div>
                <div class="form-group"></div>
                <table class="table table-borderless">
                    <tr>
                        <td class="col-sm-12">
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Ref No:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="refText" name="refText" placeholder="Reference No" class="form-control  input-sm" disabled>
                                </div>
                                <div class="col-sm-1">
                                    <a onfocus="this.blur()" onclick="NewWindow('search_costing.php', 'mywin', '800', '700', 'yes', 'center');
                                            return false" href="">
                                        <button type="button" class="btn btn-default">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </a>
                                </div>
                                <!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno"></label>-->
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Date:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="dateTxt" value="<?php echo date("Y-m-d"); ?>" class="form-control dt input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Manual Ref No:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="drfTxt" placeholder="DRF No" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Customer</label>
                                <div class="col-sm-3">
                                    <input type="text" id="cusText" name="cusText" placeholder="Customer Code" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Customer Name</label>
                                <div class="col-sm-3">
                                    <input type="text" id="cusTextName" name="cusTextName" placeholder="Customer Name" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-1">
                                    <a onfocus="this.blur()" onclick="NewWindow('serach_customer.php?stname=costing', 'mywin', '800', '700', 'yes', 'center');
                                            return false" href="">
                                        <button type="button" class="btn btn-default">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Description:</label>
                                <div class="col-sm-10">
                                    <input type="text" id="desText" name="desText" placeholder="Product Description" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Product:</label>
                                <div class="col-sm-5">
                                    <input type="text" id="proCodeText" name="proCodeText" placeholder="Product Code" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-1">
                                    <a onfocus="this.blur()" onclick="NewWindow('serach_item.php?stname=fg', 'mywin', '800', '700', 'yes', 'center');
                                            return false" href="">
                                        <button type="button" class="btn btn-default">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </a>
                                </div>
                                <div class="col-sm-3">
                                    <select id="txt_factory" class="form-control input-sm">
                                        <option value="1">Factroy 1</option>
                                        <option value="2">Factory 2</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Costing Qty:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="reqQtyText" name="reqQtyText" placeholder="Requested Qty" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Selling</label>
                                <div class="col-sm-2">
                                    <input type="text" id="sellingText" name="sellingText" placeholder="Selling Price" class="form-control  input-sm">
                                </div>

                                <label  class="col-sm-1 control-label hidden text-center" style="text-align: left;" for="invno">Order Qty:</label>
                                <div class="col-sm-2 hidden">
                                    <input type="text" id="orderQtyTxt" name="orderQtyTxt" placeholder="Order Qty" class="form-control  input-sm">
                                </div>
                                <!--                    <label  class="col-sm-1 control-label text-center"  for="invno">Square Feet</label>-->
                                <!--                    <div class="col-sm-2">-->
                                <!--                        <input type="checkbox" id="sqFeetCheck" value="Square Feets">-->
                                <!--                    </div>-->
                                <div>
                                    <?php
                                    include './connectioni.php';
                                    echo" <div class = \"col-md-6\" style = \"height: 210px;\" id = \"filup\">";

                                    echo" <label class = \"col-md-12\" for = \"file-3\">File Box</label>";
                                    echo"  <label class = \"btn btn-default col-md-9\" for = \"file-3\">";
                                    echo" <input class=\"form-control\" id = \"file-3\" name = \"file-3\" multiple = \"true\" type = \"file\" >";
                                    echo"Select Files";

                                    echo"  </label>";
                                    echo" <div class = \"col-sm-12\">";
                                    echo" <label class = \"col-sm-2\"></label>";
                                    echo" <div class = \"form-group\"></div>";
                                    // echo" <input type=\"submit\" id=\"submit\" name=\"submit\" value=\"upload\">";
                                    echo" <a class = \"btn btn-primary\" style = \"margin-left: 300px;\" onclick = \"upfile();\" class = \"btn\"/>Upload</a>";
                                    echo" </div>";
                                    echo" </div>";
                                    echo" </div>";

                                    echo" <div class = \"row\">";
                                    echo" <div id = \"filebox\" class = \"col-md-6 scroll\" style = \"visibility: hidden\">";
                                    echo"</div>";
                                    echo"</div>";
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Length</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Length" name="lengthTxt" id="lengthTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Total SQ Inch</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Total SQ Inch" name="totSqInchTxt" id="totSqInchTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">No Of Ups</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="No Of Ups" id="noOfUpsTxt" name="noOfUpsTxt" class="form-control input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Width</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="width" id="widthTxt" name="widthTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Total SQFT</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Total SQFT" id="totSqftTxt" name="totSqftTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">FOH Margin</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="FOH Margin" id="fohMarginTxt" name="fohMarginTxt" class="form-control input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Color</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Color" id="colorTxt" name="colorTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">No Of Impressions</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="No Of Impressions" id="noOfImpTxt" name="noOfImpTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Sales Margin</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Sales Margin" id="salesMarginTxt" name="salesMarginTxt" class="form-control input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Waste</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Waste" id="wasteTxt" name="wasteTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno"> No. of Outs</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder=" No. of Outs" id="noOfOutsTxt" name="noOfOutsTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Commission Per Unit</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Commission Per Unit" id="commissionPerUnitTxt" name="commissionPerUnitTxt" class="form-control input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Unit Cost</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="unit cost" id="unitCostTxt" name="unitCostTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Unit Waste</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="unit waste" id="unitWasteTxt" name="unitWasteTxt" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group-sm">
                                <label class="col-sm-2 input-sm" for="invno">Unit Job Cost</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="unit job cost" id="unitJobCostTxt" name="unitJobCostTxt" class="form-control input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Ink</label>
                                <div class="col-sm-2">
                                    <input type="text" id="inkCode" name="inkCode" placeholder="Ink" class="form-control  input-sm" disabled>
                                </div>
                                <div class="col-sm-1">
                                    <a onfocus="this.blur()" onclick="NewWindow('serach_item_ink.php?stname=pre_ink', 'mywin', '800', '700', 'yes', 'center');
                                            return false" href="">
                                        <button type="button" class="btn btn-default">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </a>
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Ink Avg Cost</label>
                                <div class="col-sm-2">
                                    <input type="text" id="inkAvg" name="inkAvg" placeholder="Avg Cost" class="form-control  input-sm"  disabled>
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Sqft Capacity</label>
                                <div class="col-sm-2">
                                    <input type="text" id="inkCap" name="inkCap" placeholder="Sqft Capacity" class="form-control  input-sm" disabled>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>    
                            <div class="form-group">
                                <div class="col-sm-4">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Ink Qty</label>
                                <div class="col-sm-2">
                                    <input type="text" id="inkQty" name="inkQty" placeholder="Ink Qty" class="form-control  input-sm" disabled>
                                    <input type="hidden" id="effSqFt" name="effSqFt" placeholder="effSqFt" class="form-control  input-sm" disabled>
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Ink Total Cost</label>
                                <div class="col-sm-2">
                                    <input type="text" id="inkTotCost" name="inkTotCost" placeholder="Ink Total Cost" class="form-control  input-sm" disabled>
                                </div>
                            </div>
                        </td>
                    </tr>    
                </table>

                <div id="itemList"  class="span12 text-center"  ></div>




                <div class="form-group">

                </div>
        </form>
    </div>

</section>
<script src="js/costing.js"></script>

<script>

                                        function stock_report() {

                                            if (document.getElementById('dt').value == "") {
                                                return false;
                                            }

                                            var url = "report_stock.php";
                                            url = url + "?dtto=" + document.getElementById('dt').value;

                                            window.open(url, '_blank');




                                        }


</script>

<script>
    newent();
</script>
