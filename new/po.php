<?php
include './connection_sql.php';
?>

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Purchase Order</h3>
        </div>
        <form name= "form1" role="form" class="form-horizontal">
            <div class="box-body">
                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">

                <div class="form-group">
                    <a onclick="sess_chk('new', 'crn');" class="btn btn-default btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="sess_chk('save', 'crn');" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <a onclick="sess_chk('print', 'crn');" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>

                    <a onclick="sess_chk('cancel', 'crn');" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash-o"></span> &nbsp; Cancel
                    </a>

                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Shipment</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="PO NO" id="txt_entno" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_po.php', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>
                    <div class="col-sm-2">

                    </div>

                    <label class="col-sm-2 control-label" for="invdate">Date</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Date" id="invdate" value="<?php echo date('Y-m-d'); ?>" class="form-control dt input-sm">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="c_code">Supplier</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Code" name="c_code" id="c_code" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Name" name = "c_name" id="c_name" class="form-control input-sm">
                    </div>
                    <div class="col-sm-1">


                        <a onfocus="this.blur()" onclick="NewWindow('serach_customer.php', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>



                    </div>



                    <label class="col-sm-1 control-label" for="c_code">LC No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="LC" name="lc_no" id="lc_no" class="form-control  input-sm">
                    </div>


                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="cus_address"></label>
                    <div class="col-sm-5">
                        
                    </div>

                    <div class="col-sm-1">

                    </div>


                    <label class="col-sm-1 control-label" for="invno">Department</label>

                    <div class="col-sm-2">
                        <select id="department" class="form-control input-sm" >

                            <?php
                            $sql = "select * from s_stomas order by CODE";
                            foreach ($conn->query($sql) as $row) {
                                echo "<option value='" . $row["CODE"] . "'>" . $row["DESCRIPTION"] . "</option>";
                            }
                            ?>
                        </select>
                    </div> 


                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_remarks">Remark</label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Remarks" id="txt_remarks" class="form-control input-sm">
                    </div>
                </div>





                <table class="table table-striped">
                    <tr class='info'>
                        <th style="width: 120px;">Item</th>
                        <th>Description</th>
                        <th style="width: 10px;"></th>
                        <th style="width: 120px;">Qty</th>

                        <th style="width: 100px;"></th>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" placeholder="Item" id="itemCode" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="text" placeholder="Description" id="itemDesc" class="form-control input-sm">
                        </td>
                        <td>
                            <a href="" onclick="NewWindow('serach_item.php', 'mywin', '800', '700', 'yes', 'center');
                                    return false" onfocus="this.blur()">
                                <input type="button" name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm">
                            </a>
                        </td>
                        <td>
                            <input type="text" placeholder="Qty" id="qty" class="form-control input-sm">
                        </td>

                        <td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                    </tr>

                </table>
                <input type="hidden"  placeholder="Rate" id="itemPrice" class="form-control input-sm">
                <div id="itemdetails" >

                </div>



            </div>
        </form>
    </div>

</section>
<script src="js/po.js"></script>
<script>
                            new_inv();
</script>
<?php
include 'login.php';
include './cancell.php';
?>
    