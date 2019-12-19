<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title"><strong>Selection Production Plan</strong></h1>
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
                <table class="table table-borderless">
                    <tr>
                        <td class="col-sm-12">
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Ref No:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="machineCatText" placeholder="Ref No" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">New:</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="newCheck" name="3">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Repeat:</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="repeatCheck" name="3">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">DRF No:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="drfNoText" placeholder="DRF No" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Cash</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" id="cashCheck">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Date</label>
                                <div class="col-sm-3">
                                    <input type="date" id="dateText"  class="form-control dt input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Customer:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="customerText" placeholder="Customer" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="customer1Text" placeholder="Customer" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Marketing Ex:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="marketingExText" placeholder="Marketing Execative" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="marketingEx1Text" placeholder="Marketing Execative" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Brand:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="brandText" placeholder="Brand" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="brand1Text" placeholder="Brand" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Target Audiance:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="targetAudText" placeholder="Target Audiance" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="targetAud1Text" placeholder="Target Audiance" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Required By:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="reqByText" placeholder="Required By" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Sample:</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" id="sampleCheck">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Only For Costing Purpose:</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" id="sampleCheck">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Printed:</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="printedRadio" name="5">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Unprinted</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="unprintedradio" name="5">
                                </div>
                            </div>
                            <div class="form-group"></div>
                            <h3>Product Specification</h3>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" id="descTxt" placeholder="Description" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Artwork Provided by</label>
                                <div class="col-sm-3">
                                    <input type="text" id="artwrkProvidedTxt" placeholder="Artwork Provided by" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="artwrkProvided1Txt" placeholder="Artwork Provided by" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Length</label>
                                <div class="col-sm-2">
                                    <input type="text" id="artwrkProvidedTxt" placeholder="Length" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Width</label>
                                <div class="col-sm-2">
                                    <input type="text" id="artwrkProvided1Txt" placeholder="Width" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Height</label>
                                <div class="col-sm-2">
                                    <input type="text" id="artwrkProvided1Txt" placeholder="Height" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">UMO</label>
                                <div class="col-sm-2">
                                    <input type="text" id="artwrkProvided1Txt" placeholder="UMO" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Sample Qty</label>
                                <div class="col-sm-3">
                                    <input type="text" id="sampleQtyTxt" placeholder="Sample Qty" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno"></label>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno">Budget Qty</label>
                                <div class="col-sm-3">
                                    <input type="text" id="budgetQtyTxt" placeholder="Budget Qty" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Artwork</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" id="artworksCheck">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Concept</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" id="conceptCheck">
                                </div>
                                <label  class="col-sm-3 control-label text-center" style="text-align: left;"  for="invno">Costing & Specification</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" id="costingSpecificationsCheck">
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


