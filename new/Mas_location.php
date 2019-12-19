
                <!-- Main content -->
                <section class="content">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b> Location Master File</b></h3>
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


                                <div class="col-md-12">
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm " style="text-align: left; " for="invno">Location Code</label>
                                        <div class="col-sm-2">
                                            <input type="text" placeholder="Location Code" id="lCode_txt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm " style="text-align: left; " for="invno">Location Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Location Name" id="lName_txt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm " style="text-align: left; " for="invno">Telephone No</label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Telephone No" id="tel_txt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm " style="text-align: left; " for="invno">Fax No</label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Fax No" id="fax_txt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm " style="text-align: left; " for="invno">Email</label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Email" id="email_txt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm " style="text-align: left; " for="invno">Location Type</label>
                                        <div class="col-sm-2">

                                            <select id="catCombo" class="form-control input-sm">
                                                <option value="001">LT1</option>
                                                <option value="002">LT2</option>
                                                <option value="003">LT3</option>
                                            </select>
                                        </div>    
                                        <div class="col-sm-2">
                                            <input type="text" placeholder="" id="lo_Ty_txt" class="form-control  input-sm">
                                        </div>   
                                    </div>
                                    <div class="form-group-sm">


                                        <div id="item_details">

                                        </div>
                                    </div>



                                    </form>
                                </div>

                                </section>
                                <script src="js/Mas_location.js"></script>
                                <script>
                                        new_inv();
                                </script>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title" id="myModalLabel">Please Login</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="form-signin">

                                                        <div class="form-group">
                                                            <div class="col-sm-2">
                                                                <input type="text" id="inputEmail" class="form-control" placeholder="User Name" required autofocus>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2">
                                                                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="action">
                                                        <input type="hidden" id="form">

                                                    </div>
                                                </div> <!-- /container -->
                                                <span   id="txterror">

                                                </span>
                                            </div>

                                            <div class="modal-footer">

                                                <button class="btn btn-primary"  onclick="IsValiedData();">Sign in</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="js/user.js"></script><!-- Modal -->
                                <div class="modal fade" id="myModal_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirm Cancel</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="form-signin">

                                                        <div class="modal-body">
                                                            <p>Cancel this entry?&hellip;</p>
                                                        </div>
                                                        <input type="hidden" id="action">
                                                        <input type="hidden" id="form">

                                                    </div>
                                                </div> <!-- /container -->
                                                <span   id="txterror">

                                                </span>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary"  onclick="cancel_inv();">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="js/user.js"></script>    <style>

                                    .sf-bottom-list li img {
                                        float: left;
                                        margin-right: 5px;
                                    }
                                </style>

                                <footer class="footer">

                                </footer>



                                </body>
                                </html>


                                <!-- jQuery 2.2.3 -->
                                <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
                                <!-- Bootstrap 3.3.6 -->
                                <script src="bootstrap/js/bootstrap.min.js"></script>
                                <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
                                <script type="text/javascript">
                                                    $(function () {
                                                        $('.dt').datepicker({
                                                            format: 'yyyy-mm-dd',
                                                            autoclose: true
                                                        });
                                                    });
                                </script>

                                <!-- FastClick -->
                                <script src="plugins/fastclick/fastclick.js"></script>
                                <!-- AdminLTE App -->
                                <script src="dist/js/app.min.js"></script>
                                <!-- Sparkline -->
                                <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
                                <!-- jvectormap -->
                                <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
                                <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
                                <!-- SlimScroll 1.3.0 -->
                                <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
                                <!-- ChartJS 1.0.1 -->
                                <script src="plugins/chartjs/Chart.min.js"></script>
                                <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
                                <script src="dist/js/pages/dashboard2.js"></script>
                                <!-- AdminLTE for demo purposes -->
                                <script src="dist/js/demo.js"></script>

                                <script src="js/user.js"></script>



                                <script src="js/comman.js"></script>

                                <script>
                                                    $("body").addClass("sidebar-collapse");
                                </script>    


                                <script>newent();</script>
