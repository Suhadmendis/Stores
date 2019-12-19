<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title"><strong>Brand Master File</strong></h1>
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
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno">Code :</label>
                                <div class="col-sm-3">
                                    <input type="text" id="codeText" placeholder="Code" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Name :</label>
                                <div class="col-sm-9">
                                    <input type="text" id="nameText" placeholder="Name" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Customer :</label>
                                <div class="col-sm-3">
                                    <input type="text" id="customerText" placeholder="Customer" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="customer1Text" placeholder="Customer" class="form-control  input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="form-group"></div>
                <div class="form-group">
                </div>

        </form>
    </div>

</section>
<script src="js/Brand_Master.js"></script>


