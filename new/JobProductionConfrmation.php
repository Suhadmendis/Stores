<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title"><strong>Job Production Confirmation</strong></h1>
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
                <div id="msg_box"  class="span12 text-center"  ></div>

                <div class="form-group"></div>
                <div class="form-group"></div>
                <h3>Details</h3>
                <table class="table table-borderless">
                    <tr>
                        <td class="col-sm-12">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno">Job No:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="jobNoText" placeholder="Job No" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno">Target Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="targetDateText" placeholder="Target Date" class="form-control dt input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">FG Product:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="fgProductText" placeholder="FG Product" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="fgProduct1Text" placeholder="FG Product" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Debtor Code:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="debtorCodeTxt" placeholder="Debtor Code" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="debtorCode1Txt" placeholder="Debtor Code" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Brand Code:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="brandCodeTxt" placeholder="Brand Code" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="brandCode1Txt" placeholder="Brand Code" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Artwork Completion Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="brandCodeTxt" placeholder="Artwork Completion Date" class="form-control dt input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno"></label>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Expose Completion Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="brandCode1Txt" placeholder="Expose Completion Date" class="form-control dt input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Positive Completion Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="brandCodeTxt" placeholder="Positive Completion Date" class="form-control dt input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno"></label>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Proof Approved Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="brandCode1Txt" placeholder="Proof Approved Date" class="form-control dt input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Sitting Completion Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="brandCodeTxt" placeholder="Sitting Completion Date" class="form-control dt input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Die Cut Available:</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="dieCutCheck" name="2">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Yes</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="dieCut1Check" name="2">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">No</label>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Die Cut Type:</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="dieCutTypeCheck" name="3">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">External</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="dieCutType1Check" name="3">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Internal</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="dieCutType2Check" name="3">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">None</label>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-3 control-label text-center" style="text-align: left;" for="invno">External Die Cut Completion Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="extrnaDieCutCompletionDateTxt" placeholder="External Die Cut Completion Date" class="form-control dt input-sm">
                                </div>
                                <label  class="col-sm-3 control-label text-center" style="text-align: left;" for="invno">Asembly Completion Date:</label>
                                <div class="col-sm-3">
                                    <input type="date" id="asemblyCompletionDateTxt" placeholder="Asembly Completion Date" class="form-control dt input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-3 control-label text-center" style="text-align: left;" for="invno">Planing Remarks:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="planingRemarksTxt" placeholder="Planing Remarks" class="form-control  input-sm">
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
<script src="js/costing.js"></script>


