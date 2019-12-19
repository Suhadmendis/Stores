<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><b>PO Requisition Note</b></h3>
        </div>
        <form name= "form1" role="form" class="form-horizontal">

            <div class="box-body">


                <input type="hidden" id="tmpno" class="form-control">

                <input type="hidden" id="item_count" class="form-control">

                <div class="form-group-sm">

                    <a onclick="newent();" class="btn btn-default btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>

                    <a  onclick="save_inv();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; SAVE
                    </a>

                    <a  onclick="print();" class="btn btn-primary btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Print
                    </a>

                </div>
                <br>
                <div id="msg_box"  class="span12 text-center"  ></div>


                <div class="col-md-12">
                    <div class="form-group-sm">
                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; " for="invno">Reference No</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Reference No"  id="refNoTxt" class="form-control  input-sm">
                        </div> 
                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; " for="invno"></label>
                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; " for="invno">Date</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Date" id="dateTxt" value="<?php echo date('Y-m-d'); ?>" class="form-control dt input-sm">
                        </div> 
                    </div>

                    <div class="form-group"></div>

                    <div class="form-group-sm">
                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; " for="invno">Manual No</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Manual No" id="manNoTxt" class="form-control  input-sm">
                        </div>
                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; " for="invno"></label>
                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; " for="invno">Job No</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Job No" id="jobNoTxt" class="form-control  input-sm">
                        </div>
                    </div>

                    <div class="form-group"></div>

                    <div class="form-group-sm">
                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; " for="invno">Remarks</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Remarks" id="remarkTxt" class="form-control  input-sm">
                        </div>                                        
                    </div>

                    <div class="form-group"></div>


                    <table class="table table-striped col-md-12">
                        <tr class='info'>
                            <th style="width: 120px;">Product Code</th>
                            <th style="width: 10px;"></th>
                            <th style="width: 120px;">Product Description</th>
                            <th style="width: 100px;"></th>
                            <th style="width: 120px;">Qty</th>
                            <th style="width: 100px;"></th>
                            <!--<th style="width: 120px;">UOM</th>-->
                            <th style="width: 100px;"></th>
                        </tr>

                        <tr>

                            <td>
                                <input type="text" placeholder="Product Code" disabled id="pCTxt" class="col-md-2 form-control input-sm">
                            </td>
                            <td>
                                <label class="col-sm-2 input-sm labelColour" style="text-align: left;" for="invno"></label>
                            </td>
                            <td>
                                <input type="text" placeholder="Product Description" disabled id="pDTxt" class="col-md-2 form-control input-sm">
                            </td>
                            <td>
                                <a onfocus="this.blur()" onclick="NewWindow('Search_Product.php', 'mywin', '800', '700', 'yes', 'center');
                                        return false" href="">
                                    <button type="button" class="btn btn-default">
                                        <span>...</span>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <input type="text" placeholder="Product Qty"  id="qtyTxt" class="col-md-2 form-control input-sm">
                            </td>
                            <td>
                                <label class="col-sm-2 input-sm labelColour" style="text-align: left;" for="invno"></label>
                            </td>

                            <td>
                                <a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a>
                            </td>

                        </tr>

                    </table>

                    <div id="itemdetails"></div>

                    </form>
                </div>

                </section>
                <script src="js/POReq.js"></script>
                <script>newent();</script>