<?php
include './connection_sql.php';
?>
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Invoice Info</h3>
        </div>
        <form  name= "form1"  role="form" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="save();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Update
                    </a>
                </div>

                <div id="msg_box"  class="span12 text-center">

                </div>

                <input type="hidden"  id="tmpno" >
                <div class="form-group">
                    <label class="col-sm-1 control-label">Details</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Inv#" id="c_code" class="form-control input-sm">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Dealer" id="c_name" class="form-control input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_invoice.php', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">Invoice Date</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Date" id="invdate" value="" class="form-control dt" disabled="">
                    </div>
                    <label class="col-sm-1 control-label">Mode</label>
                    <div class="col-sm-2">    
                        <select id="comboStatus" class="form-control">
                            <option value="not">Not Set</option>";
                            <option value="direct">Direct</option>";
                            <option value="courier">Courier</option>";
                            <option value="bus">Bus</option>";
                            <option value="train">Train</option>";
                            <option value="cus">Customer Request</option>";
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-5">
                        <textarea placeholder="Remarks" id="txt_remarks" class="form-control input-sm"></textarea>

                    </div>
                </div>
            </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks1</label>
                    <div class="col-sm-5">
                        <textarea placeholder="Remarks" id="txt_remarks1" class="form-control input-sm"></textarea>

                    </div>
                </div>
            </div>
            <div id="itemdetails"></div>
        </form>
    </div>

</section>

<script src="js/invoice_info.js">

</script>

