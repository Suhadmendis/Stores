<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title"><strong>Machine Master</strong></h1>
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
                <div class="form-group-sm">
                    <h3>Details</h3>
                </div>
                <table class="table table-borderless">
                    <tr>
                        <td class="col-sm-12">

                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;"  for="invno">Machine Code:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="MachinecodeText" placeholder="Machine Code" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Machine Description:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="MachinedescriptionText" placeholder="Machine Description" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Machine Category Code:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="machineCategoryText" placeholder="Machine Category Code" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" id="machineCategory1Text" placeholder="Machine Category Code" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Stage:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="StageText" placeholder="Stage" class="form-control  input-sm">
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" id="Stage1Text" placeholder="Stage" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Speed:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="speedText" placeholder="Speed" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Maximum Width:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="maximumWidthText" placeholder="Maximum Width" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">No Of Colours:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="noOfColorsText" placeholder="No Of Colours" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Maximum Length:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="maximumLengthText" placeholder="Maximum Length" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Machine Available Hrs:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="noOfColorsText" placeholder="No Of Colours" class="form-control  input-sm">
                                </div>
                                <label  class="col-sm-2 control-label text-center" style="text-align: left;" for="invno">Sequence:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="sequenceText" placeholder="Sequence" class="form-control  input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Active:</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="activeRadio" name="1">
                                </div>
                                <label  class="col-sm-1 control-label text-center" style="text-align: left;" for="invno">Inactive:</label>
                                <div class="col-sm-1">
                                    <input type="radio" id="inactiveRadio" name="1">
                                </div>
                            </div>
                            <div class="form-group"></div>
                            <h3>Machine Type For Product</h3>
                            <div class="form-group">
                                <table class="table table-striped">
                                    <tr class='info'>
                                        <th>Machine Type</th>
                                        <th>Description</th>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="form-group">
                </div>

        </form>
    </div>

</section>
<script src="js/costing.js"></script>


