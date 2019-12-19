<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Purchase Order Entry</b></h3>
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


                <div class="form-group"></div>
                <div class="form-group"></div>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <div class="col-md-12">
                    <h2>General Detail</h2>

                    <div class="form-group-sm">
                        <label class="col-sm-1 input-sm "  style="text-align:  left;" for="invno">Reference No</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Reference Number" id="refTxt" name="refTxt" class="form-control  input-sm ">
                        </div> 
                        <label class="col-sm-1 input-sm "  style="text-align:  left; " for="invno">Manual No</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Mnual Number " id="manuTxt" name="manuTxt" class="form-control  input-sm ">
                        </div> 
                        <label class="col-sm-1 input-sm "   style="text-align: left;" for="invno">PO Requisition</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="PO Req No "  disabled id="poTxt" name="poTxt" class="form-control  input-sm ">
                        </div> 
                        <div class="col-sm-2">
                            <input type="text" placeholder="PO Req Date " disabled id="dtTxt" name="dtTxt" class="form-control  input-sm">
                        </div> 
                        <div class="col-sm-1">
                            <a onfocus="this.blur()" onclick="NewWindow('Search_poReq.php', 'mywin', '800', '700', 'yes', 'center');
                                    return false" href="">

                                <button type="button" class="btn btn-default">
                                    <span>...</span>
                                </button>
                            </a>
                        </div>

                    </div>

                    <div class="form-group" ></div>

                    <div class="form-group-sm" >
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Currency Code</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Currency Code" id="cuTxt" class="form-control  input-sm ">
                        </div>
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Exchange Rate</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Exchange Rate" id="exTxt" class="form-control  input-sm ">
                        </div>


                        <label class="col-sm-2 input-sm " style="text-align: left;   background-color:white;" for="invno"> 
                            <div class="row"style="margin-top: 10px;" >
                                <input type="radio" name="gender" value="male"> LOCAL &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;
                                <input type="radio" name="gender" value="male"> SEA &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;
                                <input type="radio" name="gender" value="male">AIR<br></label>
                            </div>
                    </div>

                    <div class="form-group" ></div>

                    <div class="form-group-sm" >
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Supplier</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Supplier Code" id="supCodeTxt" class="form-control  input-sm ">
                        </div>  

                        <div class="col-sm-5">
                            <input type="text" placeholder="Supplier Name " id="supNameTxt" class="form-control  input-sm ">
                        </div> 

                        <div class="col-sm-1">
                            <a onfocus="this.blur()" onclick="NewWindow('Search_Supplier.php', 'mywin', '800', '700', 'yes', 'center');
                                    return false" href="">

                                <button type="button" class="btn btn-default">
                                    <span>...</span>
                                </button>
                            </a>
                        </div>

                    </div>

                    <div class="form-group"></div>
                    <div class="form-group-sm" >
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Cost Center</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Code " id="cCodeTxt" class="form-control  input-sm ">
                        </div>  


                        <div class="col-sm-5">
                            <input type="text" placeholder="Name " id="cNameTxt" class="form-control  input-sm ">
                        </div> 

                        <div class="col-sm-1">
                            <a onfocus="this.blur()" onclick="NewWindow('Search_cost.php', 'mywin', '800', '700', 'yes', 'center');
                                    return false" href="">

                                <button type="button" class="btn btn-default">
                                    <span>...</span>
                                </button>
                            </a>
                        </div>

                    </div>


                    <div class="form-group"></div>

                    <div class="form-group-sm" >

                        <label class="col-sm-1 input-sm " style="text-align: left;" for="invno">Remark</label>
                        <div class="col-sm-7">
                            <input type="text" placeholder="Remark " id="remarkTxt" class="form-control  input-sm ">
                        </div> 

                    </div>

                    <div class="form-group"></div>



                    <div class="form-group-sm" >
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Text Combination</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Code" id="taxCodeTxt" class="form-control  input-sm ">
                        </div>  
                        <div class="col-sm-5">
                            <input type="text" placeholder="Tax Combination Name" id="taxNameTxt" class="form-control  input-sm ">
                        </div>  
                        <!--                        <div class="col-sm-1">
                                                    <a onfocus="this.blur()" onclick="NewWindow('Search_poReq.php', 'mywin', '800', '700', 'yes', 'center');
                                                            return false" href="">
                        
                                                        <button type="button" class="btn btn-default">
                                                            <span>...</span>
                                                        </button>
                                                    </a>
                                                </div>-->

                    </div>

                    <div class="form-group"></div>

                    <h2>Delivery Details</h2>

                    <div class="form-group-sm" >
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Location Code</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Location Code" id="locCodeTxt" class="form-control  input-sm ">
                        </div>  
                        <div class="col-sm-5">
                            <input type="text" placeholder="Location Name" id="locNameTxt" class="form-control  input-sm ">
                        </div> 
                        <div class="col-sm-1">
                            <a onfocus="this.blur()" onclick="NewWindow('Search_Location.php', 'mywin', '800', '700', 'yes', 'center');
                                    return false" href="">

                                <button type="button" class="btn btn-default">
                                    <span>...</span>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="form-group"></div>

                    <div class="form-group-sm" >
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Contact Person</label>
                        <div class="col-sm-7">
                            <input type="text" placeholder="Contact Person" id="conPerTxt" class="form-control  input-sm ">
                        </div> 
                    </div>

                    <div class="form-group"></div>

                    <div class="form-group-sm" >
                        <label class="col-sm-1 input-sm " style="text-align: left; " for="invno">Delivery Address</label>
                        <div class="col-sm-7">
                            <input type="text" placeholder="Delivery Address" id="delAddTxt" class="form-control  input-sm ">
                        </div> 
                    </div>

                </div>

                <div class="form-group"></div>
                <div class="form-group"></div>
                <table class="table table-striped col-md-12">
                    <tr class='info'>

                        <th style="width: 20px;">Rec No</th>
                        <th style="width: 60px;">Product Code</th>
                        <th style="width: 100px;"></th>
                        <th style="width: 100px;">Product Description</th>
                        <th style="width: 100px;"></th>
                        <th style="width: 60px;">Req Bal</th>
                        <th style="width: 100px;"></th>
                        <th style="width: 60px;">Quntity</th>
                        <th style="width: 100px;"></th>
                        <th style="width: 60px;">Purchse Price</th>
                        <th style="width: 100px;"></th>
                        <th style="width: 60px;">Discount</th>
                        <th style="width: 100px;"></th>
                        <th style="width: 60px;">Value</th>
                        <th style="width: 100px;"></th>
                        <th style="width: 60px;">Tax Combination</th>
                        <th style="width: 100px;"></th>

                    </tr>
                </table>


                <div id="itemdetails"></div>

                <div id="form-group"></div>
                <div id="form-group"></div>

                <div class="form-group-sm">
                    <label class="col-sm-1 input-sm hidden" style=" " for="invno">Total Discount</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Total Discount" disabled id="areaCodeTxt" class="form-control  input-sm hidden">
                    </div>
                    <label class="col-sm-1 input-sm " style=" " for="invno"></label>
                    <label class="col-sm-1 input-sm hidden" style="" for="invno">Total Tax</label>
                    <div class="col-sm-2 hidden">
                        <input type="text" placeholder="Total Tax" disabled id="areaCodeTxt" class="form-control  input-sm hidden">
                    </div>
                    <label class="col-sm-1 input-sm " style=" " for="invno"></label>
                    <label class="col-sm-1 input-sm hidden" style="" for="invno">Total Value</label>

                </div>
                <div class="form-group-sm">
                    <div class="col-sm-2">
                        <input type="text" placeholder="Total Value" disabled id="totValTxt" class="form-control  input-sm hidden">
                    </div>
                </div>

            </div>
    </div>
</div>

</form>       

</section>

<script src="js/Stc_PurO_E.js"></script>

<!-- Modal -->


<script>
                                newent();
</script>