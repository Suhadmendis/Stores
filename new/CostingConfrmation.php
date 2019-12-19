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
                                    <input type="text" id="refText" placeholder="Reference No" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Date:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="refText" placeholder="Date" class="form-control dt input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">DRF No:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="refText" placeholder="DRF No" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                               
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Customer :</label>
                                <div class="col-sm-3">
                                    <input type="text" id="customerCodeText" placeholder="Customer" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="customerNameText" placeholder="Customer" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Product:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="proCodeText" placeholder="Product" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="proText" placeholder="Product" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Commission %</label>
                                <div class="col-sm-2">
                                    <input type="radio" name="a" id="CommissionPresent">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Commission Value</label>
                                <div class="col-sm-2">
                                   <input type="radio" name="a" id="CommissionValue">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Commission</label>
                                <div class="col-sm-2">
                                   <input type="text" id="commissionText" placeholder="Commission" class="form-control  input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="form-group"></div>
                <div class="form-group"></div>
                <div class="form-group">
                    <table class="table table-striped">
                        <tr class='info'>
                            <th>Req No</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Cost Price</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Commission</th>
                            <th>Approved Unit Price</th>
                        </tr>
                    </table>
                </div>                          
        </form>
    </div>

</section>
<script src="js/costing.js"></script>


