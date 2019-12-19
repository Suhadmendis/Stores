
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><b> Supplier Master File</b></h3>
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

                </div>
                <br>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a data-toggle="tab" href="#home">General</a></li>
                    <li><a data-toggle="tab" href="#menu1">Grouping</a></li>
                    <li><a data-toggle="tab" href="#menu2">Credit Control</a></li>
                    <li><a data-toggle="tab" href="#menu3">Tax Detail</a></li>
                </ul>

                <div class="tab-content">
                    <div class="form-group" ></div>
                    <div class="form-group" ></div>
                    <div id="home" class="tab-pane fade in active">
                        <h3>Details</h3>
                        <div class="form-group-sm">
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Supplier Code</label>
                            <div class="col-sm-1">
                                <input type="text" placeholder="Supplier Code" id="supCTxt" name="supCTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Supplier Name</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Supplier Name" id="supNTxt" name="supNTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left; font-size: 10px;" for="invno">Supplier Address</label>
                            <div class="col-sm-5">
                                <input type="text" placeholder="Supplier Address" id="supATxt" name="supATxt" class="form-control  input-sm ">
                            </div>
                        </div>
                        <div class="form-group" ></div>
                        <div class="form-group-sm">
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Telephone</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Telephone" id="supTelTxt" name="supTelTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Fax</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Fax" id="supFaxTxt" name="supFaxTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Mobile No</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Mobile No" id="supMobTxt" name="supMobTxt" class="form-control  input-sm ">
                            </div>

                        </div>
                        <div class="form-group" ></div>
                        <div class="form-group-sm">
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Web Site</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Web Site" id="supWebTxt" name="supWebTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">E mail</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="E mail" id="supEmailTxt" name="supEmailTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Status</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Status" id="statusTxt" name="statusTxt" class="form-control  input-sm ">
                            </div>

                        </div>
                        <div class="form-group" ></div>
                        <div class="form-group-sm">
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Supplier A/C Code</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Supplier A/C" id="supACTxt" name="supACTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left; font-size: 10px;" for="invno">Advanced A/C Code</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Advanced A/C" id="addACTxt" name="addACTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;" for="invno">Gain/Loss/A/C</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Gain/Loss/A/C" id="gainACTxt" name="gainACTxt" class="form-control  input-sm ">
                            </div>
                        </div>
                        <div class="form-group" ></div>
                        <div class="form-group" ></div>
                        <div class="form-group" ></div>

                        <h3>Contacts</h3>
                        <div class="form-group-sm">
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Contact Person</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Contact Person" id="conPerTxt" name="conPerTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Telephone</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Telephone" id="conTelTxt" name="conTelTxt" class="form-control  input-sm ">
                            </div>
                        </div>
                        <div class="form-group" ></div>
                        <div class="form-group-sm">
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Address</label>
                            <div class="col-sm-7">
                                <input type="text" placeholder="Address" id="conAddTxt" name="conAddTxt" class="form-control  input-sm ">
                            </div>

                        </div>
                        <div class="form-group" ></div>
                        <div class="form-group-sm">
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Fax</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Fax" id="conFaxTxt" name="conFaxTxt" class="form-control  input-sm ">
                            </div>
                            <label class="col-sm-1 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Email</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="Email" id="conEmailTxt" name="conEmailTxt" class="form-control  input-sm ">
                            </div>
                        </div>

                    </div>

                    <div id="menu1" class="tab-pane fade in active">
                        <h3>Supplier Group</h3>
                        <label class="col-sm-2 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Supplier Group</label>
                        <div class="col-sm-3">
                            <input type="text" placeholder="Supplier Group" id="supGrupTxt" name="supGrupTxt" class="form-control  input-sm ">
                        </div>

                    </div>

                    <div id="menu2" class="tab-pane fade in active">
                        <h3>Credit Control</h3>
                        <div class="form-group-sm"> 

                            <label class="col-sm-2 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Check Credit Period</label>

                            <div class="col-sm-3">
                                YES &nbsp;&nbsp;&nbsp;<input type="radio" name="radio1" value="yes" id="radio1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                NO &nbsp;&nbsp;&nbsp;<input type="radio" name="radio2" value="no" id="radio2" />
                            </div>

                            <label class="col-sm-2 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Credit Period(days)</label>

                            <div class="col-sm-3">
                                <input type="text" placeholder="Credit Period" id="crePerTxt" name="crePerTxt" class="form-control  input-sm ">
                            </div>
                        </div>
                        <div class="form-group" ></div>
                        <div class="form-group-sm"> 

                            <label class="col-sm-2 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Check Credit Limit</label>

                            <div class="col-sm-3">
                                YES &nbsp;&nbsp;&nbsp;<input type="radio" name="radio3" value="yes" id="radio3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                NO &nbsp;&nbsp;&nbsp;<input type="radio" name="radio4" value="no" id="radio4" />
                            </div>

                            <label class="col-sm-2 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Credit Limit</label>

                            <div class="col-sm-3">
                                <input type="text" placeholder="Credit Limit" id="creLimtTxt" name="creLimtTxt" class="form-control  input-sm ">
                            </div>
                        </div>

                    </div>

                    <div id="menu3" class="tab-pane fade in active">
                        <h3>Tax Details</h3>

                        <label class="col-sm-2 input-sm labelColour"  style="text-align:  left;font-size: 10px;" for="invno">Tax Registration(Y/N)</label>

                        <div class="col-sm-3">
                            YES &nbsp;&nbsp;&nbsp;<input type="radio" name="radio5" value="yes" id="radio5" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            NO &nbsp;&nbsp;&nbsp;<input type="radio" name="radio6" value="no" id="radio6" />
                        </div>


                    </div>
                </div>

            </div>

            </section>
            <script src="js/Mas_supplier.js"></script>


            <script>newent();</script>
