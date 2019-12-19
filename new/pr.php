<?php
include './connection_sql.php';
?>
<section class="content">
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">Purchase Received</h3>
        </div>

        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">


                <div class="form-group">
                    <a onclick="sess_chk('new', 'crn');" class="btn btn-default btn-sm">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>

                    <a onclick="sess_chk('save', 'crn');" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <a  onclick="sess_chk('print', 'crn');" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a> 

                    <a onclick="sess_chk('cancel', 'crn');" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash-o"></span> &nbsp; Cancel
                    </a>

                </div>
                <input type="hidden"  id="tmpno" >
                <div id="msg_box"  class="span12 text-center"  >

                </div>

                <div class="form-group">

                    <label class="col-sm-2 control-label" for="Receipt_code">ARN No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="ARN No" id="txt_entno" class="form-control input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_arn.php', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>


                    <label class="col-sm-1 control-label" for="name">Supplier</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Code" id="c_code" class="form-control input-sm">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Name" id="c_name" class="form-control input-sm">
                    </div> 
                </div>

                <div class="form-group">

                    <label class="col-sm-2 control-label" for="Receipt No">Date</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="" id="invdate" value="<?php echo date('Y-m-d'); ?>" class="form-control dt  input-sm">
                    </div>
                    <div class="col-sm-1">
                        <input type="hidden" placeholder="count" id="arn_item_count" value="hidden count" class="form-control input-sm">
                    </div>

                    <label class="col-sm-1 control-label" for="name">Order No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="" id="orderno1" class="form-control input-sm">
                    </div>
                    <div class="col-sm-1">
                        <a onfocus="this.blur()" onclick="NewWindow('serach_po.php?stname=arn', 'mywin', '800', '700', 'yes', 'center');
                                return false" href="">
                            <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                        </a>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="LCNO">Invoice</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="" id="LCNO" class="form-control input-sm">
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
                    <label class="col-sm-2 control-label" for="LCNO">BL No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="" id="BLNO" class="form-control input-sm">
                    </div>
                </div>


            </div>









            <div class="container">




                <h3>Item Details</h3>
                <input type="hidden" value="3"  id="count" > 
                <form role="form" class="form-horizontal">
                    <div id='invdt' class="box-body">

                    </div>

                    <table id='subtotal' class="table">
                        <tr>
                            <td></td>
                            <td></td>
                            <th>Sub Total</th>

                            <td></td>                        
                            <td style="width: 150px;"><input type="text" placeholder="Sub Total" id="total_value" class="form-control input-sm"></td>
                        </tr>
                    </table>
                </form>





            </div>




            <div class="container">

                <h3>Container Details</h3>
                <table style="width: 330px;" class="table table-striped">

                    <tr class='info'>
                        <th style="width: 250px;">Container No</th>
                        <th style="width: 80px;">Qty</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" placeholder="Container No" id="contno" class="form-control input-sm">
                        </td>
                        <td>
                            <input type="text" placeholder="Qty" id="qty" class="form-control input-sm">
                        </td>                        
                        <td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>
                    </tr>

                </table>


                <div id='condt' class="box-body">

                </div>


            </div>


            <div class="form-group"  style="visibility: hidden" id="filup">
                <label class="col-sm-1 control-label" for="file-3">File Box</label>
                <label class="btn btn-default" for="file-3">
                    <input id="file-3" name="file-3" multiple="true" type="file" >
                    Select Files

                </label>
                <a  class="btn btn-primary" onclick="uploadfile('arn');" class="btn"/>Upload</a>
            </div>




            <div id="filebox" >

            </div>


    </div>

</div>       
</form>


</section>
<script src="js/pr.js">

</script>
<script>
    new_inv();
</script>
<?php
include 'login.php';
include './cancell.php';
?>
    