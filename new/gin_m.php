
<?php
include './connection_sql.php';
?>
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Stock Issue/Return</h3>
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <?php if (!isset($_GET['refno'])) { ?>
                        <a onclick="new_inv();" class="btn btn-default">
                            <span class="fa fa-user-plus"></span> &nbsp; New
                        </a>
                        <a onclick="save_inv();" class="btn btn-primary">
                            <span class="fa fa-save"></span> &nbsp; Save
                        </a>
                    <?php } ?>         
                    <a onclick="print_inv();" class="btn btn-default">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    <?php if (!isset($_GET['refno'])) { ?>
                        <a onclick="NewWindow('search_gin_multi.php', 'mywin', '800', '700', 'yes', 'center');
                                return false" class="btn btn-default">
                            <span class="fa fa-search"></span> &nbsp; Find
                        </a>
                    <?php } ?>         
                    <a onclick="cancel_inv();" class="btn btn-danger">
                        <span class="fa fa-print"></span> &nbsp; Cancel
                    </a>	

                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="firstname_hidden">Ref No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Ref No" id="invno" class="form-control">
                    </div> 

                </div>

                <div class="form-group">
                    <label for="firstname_hidden" class="col-sm-2 control-label">To Department</label>
                    <div class="col-sm-4">
                        <select id="to_dep" onblur="itno_ind();" width='120' >

                            <?php
                            $sql = "select * from s_stomas order by CODE";
                            foreach ($conn->query($sql) as $row) {
                                //echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                                if ($row["CODE"] == "01") {
                                    echo "<option selected value='" . $row["CODE"] . "'>" . $row["DESCRIPTION"] . "</option>";
                                } else {
                                    echo "<option value='" . $row["CODE"] . "'>" . $row["DESCRIPTION"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div> 
                    <div id="unsold" class="col-sm-1">

                    </div>
                </div>


                <div class="col-sm-12">
                    <table class="table">
                        <?php if (!isset($_GET['refno'])) { ?>
                        <tr>
                            <th style="width: 150px;">From Department</th>
                            <th style="width: 150px;">Item</th>
                            <th style="width: 5px;"></th>
                            <th style="width: 280px;">Description</th>
                            <th style="width: 100px;">Container</th>
                            <th style="width: 80px;">Qty</th>

                            <th style="width: 10px;"></th>
                            <td style="width: 90px;"></td>
                        </tr>
                        
                            <tr>
                                <td>
                                    <select onblur="itno_ind();" id="from_dep" >

                                        <?php
                                        $sql = "select * from s_stomas order by CODE";
                                        foreach ($conn->query($sql) as $row) {
                                            //echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                                            if ($row["CODE"] == "01") {
                                                echo "<option selected value='" . $row["CODE"] . "'><strong>" . $row["DESCRIPTION"] . "-" . $row["CODE"] . "<strong></option>";
                                            } else {
                                                echo "<option value='" . $row["CODE"] . "'>" . $row["DESCRIPTION"] . "-" . $row["CODE"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>

                                </td>
                                <td>
                                    <input type="text"  onkeypress="keyset('qty', event);" onblur="itno_ind();" placeholder="Item" id="itemCode" class="form-control">
                                </td>
                                <td>
                                    <a href="" onclick="NewWindow('serach_item.php', 'mywin', '800', '700', 'yes', 'center');
                                            return false" onfocus="this.blur()">
                                        <input name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm" type="button">
                                    </a>
                                </td>
                                <td>
                                    <input type="text" placeholder="Description" id="itemDesc" class="form-control">
                                </td>
                                <td>
                                    <input type="text" placeholder="Container No" id="container" class="form-control">
                                </td>

                                <td>
                                    <input type="text" onkeypress="keyset('add_tmp_it', event);" placeholder="Qty" id="qty" class="form-control">
                                </td>                        
                                <td>

                                    <input type="button"  onclick="add_tmp();" id="add_tmp_it" value= "+"  class="btn btn-default" ></input>

                                </td>
                                <td>
                                    <input type="hidden" id="itemPrice" name="itemPrice">
                                </td>
                            </tr>
                        <?php } ?>         
                    </table>
                    <div class="span6 pull-right">
                        <div id="submas">

                        </div>
                    </div>
                    <div id="itemdetails" class="col-sm-9" >

                    </div>
                </div>
                <?php if (!isset($_GET['refno'])) { ?>
                    <table class="table">
                        <tr>
                            <td style="width: 90px;">In Hand</td>
                            <td style="width: 100px;"><input type="text" name='qtyinhand'  id="qtyinhand" class="form-control"></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                            <td></td>
                        </tr>
                    </table>	 
                <?php } ?>            
            </div>

    </div>

    <div  class='space' >
        <br>&nbsp;
        <br>&nbsp;
        <br>&nbsp;

    </div>

</form>
</div>

</section>

<script src="js/gin_m.js"></script>

<script>
     new_inv();
</script>


<?php if (isset($_GET['refno'])) { ?>

<script>
     find_me('<?php echo $_GET['refno'];  ?>');
</script>


 <?php } ?>   