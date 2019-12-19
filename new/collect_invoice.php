
<!--<body class="hold-transition skin-red sidebar-mini" onload="getdt()" >-->

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h2 class="box-title"><strong>Collect Invoice</strong></h2>
        </div>
        <form name= "form1" role="form" class="form-horizontal">
            <div class="box-body">

                <div id="msg_box"  class="span12 text-center"  ></div>

                <div class="form-group"></div>
                <div class="form-group"></div>


                <input type="hidden" id="item_count" value="1" class="form-control">

                <div class="form-group"></div>
                <a onclick="newent();" class="btn btn-default btn-sm">
                    <span class="fa fa-user-plus"></span> &nbsp; NEW
                </a>
                <a onclick="save_inv('1');" class="btn btn-success btn-sm">
                    <span class="fa fa-save"></span> &nbsp; SAVE_TAX
                </a>
                <a onclick="save_inv('2');" class="btn btn-success btn-sm">
                    <span class="fa fa-save"></span> &nbsp; SAVE_NON_TAX
                </a>
                <a onclick="cancel();" class="btn btn-danger btn-sm">
                    <span class="fa fa-cancel"></span> &nbsp; CANCEL
                </a>

                <div class="form-group-sm">
                    <label class="col-sm-2" for="c_code">Con Ref</label>
                    <div class="col-sm-3">
                        <input type="text" placeholder="CNSLTD INV" id="invNo" value="" class="form-control  input-sm">
                    </div>
                    <a onclick = "NewWindow('serach_con_ref.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-default btn-sm">
                        <span>...</span> &nbsp;
                    </a>
                </div>
                <div class="form-group"></div>
                <div class="form-group-sm">
                    <label class="col-sm-2" for="c_code">Search Customer</label>
                    
                    <div class="col-sm-3">
                        <input type="text" placeholder="Customer Code" id="c_code" name="c_code" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Customer Name" id="c_name" name="c_name" class="form-control  input-sm">
                    </div>
                    <a onclick = "NewWindow('serach_customer.php?stname=basic', 'mywin', '800', '700', 'yes', 'center');" class = "btn btn-default btn-sm">
                        <span class = "">...</span> &nbsp
                    </a>

                    <a onclick="searchCus('1');" class="btn btn-default btn-sm">
                        <span class="fa fa-search"></span> &nbsp; SearchVAT
                    </a>
                    <a onclick="searchCus('2');" class="btn btn-default btn-sm">
                        <span class="fa fa-search"></span> &nbsp; SearchSVAT
                    </a>
                </div>
                <div class="form-group">

                </div>
                <div class="form-group">

                </div>

                <div id="itemdetails" >

                </div>
                <div id="itemdetails1" >

                </div>
                <div class="form-group-sm">
                    <label class="col-sm-2" for="c_code">Total</label>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Total" id="tot" class="form-control  input-sm">
                    </div>
                    <label class="col-sm-2" for="c_code">Date</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Date" id="conDate" class="form-control dt input-sm" value="<?php echo date("Y-m-d");?>">
                    </div>
                </div>
            </div>


    </div>

</form>


</div>

</section>
</div>
<script src="js/collect_invoice.js"></script>


<script>newent();</script>
