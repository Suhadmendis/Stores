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
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno">Ref No:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="refText" placeholder="Reference No" class="form-control  input-sm">
                                </div>
<!--                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Date:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="refText" placeholder="Date" class="form-control dt input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">DRF No:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="refText" placeholder="DRF No" class="form-control  input-sm">
                                </div>-->
                            </div>
                            <div class="form-group">
                               
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Job No :</label>
                                <div class="col-sm-2">
                                    <input type="text" id="jobNoText" placeholder="Job No" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Item Description:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="jobNoText" placeholder="Job No" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Customer :</label>
                                <div class="col-sm-2">
                                   <input type="text" id="customerText" placeholder="Customer" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-5">
                                   <input type="text" id="customer1Text" placeholder="Customer" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Date :</label>
                                <div class="col-sm-2">
                                   <input type="text" id="dateText"  class="form-control dt input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Location:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="locationText" placeholder="Location" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Quantity:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="qtyText" placeholder="Quantity" class="form-control  input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="form-group"></div>
                <div class="form-group"></div>
                                        
        </form>
    </div>

</section>
<script src="js/costing.js"></script>


