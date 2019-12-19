<?php
include './connection_sql.php';
?>

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Direct Sale Invoice</h3>
        </div>
        <form name= "form1" role="form" class="form-horizontal">
            <div class="box-body">

                <input type="hidden" id="tmpno" class="form-control">

                <input type="hidden" id="item_count" class="form-control">
                <input type="hidden" id="item_count_org" class="form-control">

                <div class="form-group">

                    <a onclick="new_inv();" class="btn btn-default btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv('getGl');" class="btn btn-info btn-sm">
                        <span class="fa fa-balance-scale"></span> &nbsp; Check GL
                    </a>
                    <a onclick="save_inv();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <a onclick="print_inv('');" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    
                    <a onclick="checkGL();" class="btn btn-info btn-sm">
                        <span class="fa fa-balance-scale"></span> &nbsp; ViewGL
                    </a>

                    <a onclick="cancel_inv();" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash-o"></span> &nbsp; Cancel
                    </a>

                </div>

                <div id="msg_box"  class="span12 text-center"  ></div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Invoice No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="PO NO" id="txt_entno" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_inv.php?stname=dinv', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>
                    <label class="col-sm-2 control-label" for="invdate">Date</label>
                    <div class="col-sm-2">
                        <input type="text"  onchange="getno1();"   placeholder="Date" id="invdate" value="<?php echo date('Y-m-d'); ?>" class="form-control dt input-sm">
                    </div>
                    <label class="col-sm-1 control-label" for="invno">DA No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="DA NO" id="DANO" class="form-control  input-sm">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="c_code">Customer</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Code" name="c_code" id="c_code" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Name" name = "c_name" id="c_name" class="form-control input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_customer.php?stname=inv', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>
                    <label class="col-sm-1 control-label" for="invno">Direct Request</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="DSR" id="txt_minno" class="form-control  input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_dsr.php?stname=dinv', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="cus_address">Address</label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Name" id="cus_address" class="form-control input-sm">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="txt_remarks">Remark</label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Remarks" id="txt_remarks" class="form-control input-sm">
                    </div>

                    <div class="col-sm-1">
                        &nbsp;
                    </div>
                    <div class="col-sm-5">
                        <!--del_item('.') onclick function removed-->
                        <label  class="col-sm-4 control-label" ><input type="radio" id="non" name="optradio" value="non">&nbsp;SVAT</label>
                        <label  class="col-sm-3 control-label" ><input type="radio" id="svat" name="optradio" value="svat">&nbsp;VAT</label>
                        <label  class="col-sm-3 control-label" ><input type="checkbox" id="chkNbt" name="chkNbt" value="chkNbt">&nbsp;NBT</label>

                    </div>
                </div>
                <input id='currency' type='hidden' value='LKR'>
                <input id='txt_rate' type='hidden' value='1'>

                <div class="form-group hidden">
                    <label class="col-sm-1 control-label" for="invno">Sales Ex.</label>

                    <div class="col-sm-2">
                        <select id="salesrep" class="form-control input-sm" >

                            <?php
                            $sql = "select * from s_salrep order by REPCODE";
                            foreach ($conn->query($sql) as $row) {
                                echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                            }
                            ?>
                        </select>
                    </div> 
                </div>
                <div class="form-group hidden">
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
                <table class="table table-striped">
                    <tr class='info'>
                        <th style="width: 120px;">Item</th>
                        <th>Description</th>
                        <th style="width: 10px;"></th>
                        <th style="width: 120px;">Qty</th>
                        <th style="width: 120px;">Rate</th>
                        <th style="width: 100px;"></th>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" placeholder="Item" id="itemCode" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="text" placeholder="Description" id="itemDesc" class="form-control input-sm">
                        </td>
                        <!--adjust to direct sale-->
                        <!--<td style="visibility: hidden;">-->
                        <td>
                            <a href="" onclick="NewWindow('serach_item_1.php?stname=dinv', 'mywin', '800', '700', 'yes', 'center');
                                    return false" onfocus="this.blur()">
                                <input type="button" name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm">
                            </a>
                        </td>
                        <td>
                            <input type="text" placeholder="Qty" id="qty" class="form-control input-sm" disabled="">
                        </td>
                        <td>
                            <input type="text" placeholder="Rate" id="itemPrice" class="form-control input-sm">
                        </td>
                        <td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                    </tr>

                </table>

                <div id="itemdetails" >

                </div>

                <table id='subtotal' class="table">
                    <tr>
                        <td></td>
                        <td></td>
                        <th>Sub Total</th>

                        <td></td>                        
                        <td style="width: 150px;"><input type="text" placeholder="Sub Total" id="subtot" class="form-control input-sm"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th>NBT</th>
                        <td></td>                        
                        <td style="width: 150px;"><input type="text" placeholder="NBT" id="nbt" class="form-control input-sm"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th>VAT</th>
                        <td></td>                        
                        <td style="width: 150px;"><input type="text" placeholder="VAT" id="svattot" class="form-control input-sm"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th>SVAT</th>
                        <td></td>                        
                        <td style="width: 150px;"><input type="text" placeholder="SVAT" id="svattot1" class="form-control input-sm"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th>Grand Total</th>

                        <td></td>                        
                        <td style="width: 150px;"><input type="text" placeholder="Grand Total" id="gtot" class="form-control input-sm"></td>
                    </tr>
                </table>		

            </div>
        </form>
    </div>

</section>
<script src="js/invoice_drc.js"></script>
<script>
                            new_inv();
</script>
<?php
include 'login.php';
include './cancell.php';
?>
    