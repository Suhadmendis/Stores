<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title"><strong>Design Allocation</strong></h1>
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
                                                               <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno"></label>
                                                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno"></label>
                                                                <div class="col-sm-2">

                                                                </div>
                                                                <label  class="col-sm-1 control-label text-center" style="text-align: left;"  for="invno">Date :</label>
                                                                <div class="col-sm-2">
                                                                    <input type="date" id="dateText" class="form-control dt input-sm">
                                                                </div>
                            </div>
                            <div class="form-group">

                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">DRF No :</label>
                                <div class="col-sm-2">
                                    <input type="text" id="drfText" placeholder="DRF No" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Marketing Excecative :</label>
                                <div class="col-sm-2">
                                    <input type="text" id="marketing1Text" placeholder="DRF No" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="marketing2Text" placeholder="DRF No" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Customer :</label>
                                <div class="col-sm-2">
                                    <input type="text" id="customerText" placeholder="Customer" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" id="customer1Text" placeholder="Customer" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Product Description :</label>
                                <div class="col-sm-9">
                                    <input type="text" id="proDecriptionText" placeholder="Product Description"  class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Same as Previous</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" id="sameAsPreviousCheck">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Art Work Path:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="artWorkPathText" placeholder="Art Work Path" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Concept Path:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="ConceptPathText" placeholder="Concept Path" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Costing & Specification Path:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="costingSpecText" placeholder="Costing & Specification Path" class="form-control  input-sm">
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="form-group"></div>
                <div class="form-group">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a data-toggle="tab" href="#home">Designer Details</a></li>
                        <li><a data-toggle="tab" href="#menu1">Product Breakdown</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group"></div>
                                    <div class="form-group"></div>
                                    <table class="table table-striped">
                                        <tr class='info'>
                                            <th>Designer</th>
                                            <th>Designer Name</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="home" class="tab-pane fade in active">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group"></div>
                                    <div class="form-group"></div>
                                    <table class="table table-striped">
                                        <tr class='info'>
                                            <th>Designer</th>
                                            <th>Designer Name</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </form>
    </div>

</section>
<script src="js/costing.js"></script>


