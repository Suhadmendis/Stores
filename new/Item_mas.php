
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Item Master File</title>

        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="dist/css/font-awesome-4.7.0/css/font-awesome.min.css">  

        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="css/ionicons/css/ionicons.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <style>
            .form-group {margin-bottom : 8px; }
            .btnupload{

                -webkit-border-radius: 30px 30px 30px 30px;
                border-radius: 30px 30px 30px 30px;
            }

        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="home.php" class="logo"> <!-- mini logo for sidebar mini 50x50 pixels --> <span class="logo-mini"><b>H</b>MS</span> <!-- logo for regular state and mobile devices --> <span class="logo-lg"><b>HOSPITAL</b>&nbsp;HOLDING</span> </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!--                                                 Messages: style can be found in dropdown.less
                                                
                                                                             Notifications: style can be found in dropdown.less 
                                                
                                                                             Tasks: style can be found in dropdown.less 
                                                
                                                                             User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs">Alexander Pierce</span>
                                </a>
                                <ul class="dropdown-menu">
                                    User image 
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                        <p>
                                        </p>
                                    </li>
                                    <!--                                                         Menu Body -->
                                    <!--                                                        <li class="user-body">
                                                        
                                                                                                 /.row 
                                                                                            </li>-->
                                    <!--Menu Footer-->
                                    <li class="user-footer">
                                        <!--                                                            <div class="pull-left">
                                                                                                        <a href="mspace" class="btn btn-default btn-flat">Profile</a>
                                                                                                    </div>-->
                                        <div class="pull-right">
                                            <a onclick="logout();" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--Control Sidebar Toggle Button--> 
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <!--<img src="" class="img-circle" alt="User Image">-->
                        </div>
                        <div class="pull-left info">
                            <p>
                                <br />
                            <font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
                                <tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined index: UserName in C:\wamp64\www\wings_simple_2\header.php on line <i>100</i></th></tr>
                                <tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
                                <tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
                                <tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0025</td><td bgcolor='#eeeeec' align='right'>260600</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp64\www\wings_simple_2\home.php' bgcolor='#eeeeec'>...\home.php<b>:</b>0</td></tr>
                                <tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.0069</td><td bgcolor='#eeeeec' align='right'>314680</td><td bgcolor='#eeeeec'>include( <font color='#00bb00'>'C:\wamp64\www\wings_simple_2\header.php'</font> )</td><td title='C:\wamp64\www\wings_simple_2\home.php' bgcolor='#eeeeec'>...\home.php<b>:</b>16</td></tr>
                            </table></font>
                            </p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
<!--                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                    <i class="fa fa-search"></i>
                                </button> </span>-->
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">
                            MAIN MENU
                        </li>
                        <li class="treeview">
                            <a href="#"> <i class="fa fa-th"></i> <span>Master</span> <i class="fa fa-angle-left pull-right"></i> </a>
                            <ul class="treeview-menu ">



                                <li>                                <a href="home.php?url=Airport"><i class="fa fa-circle-o"></i>Airport Details</a></li>


                                                        <!--<a href="home.php?url=cusmas"><i class="fa fa-circle-o"></i>Clients Details</a></li>-->

                                                        <!--<a href="home.php?url=Carrier"><i class="fa fa-circle-o"></i>Carrier Details</a></li>-->

                                <li>                        <a href="home.php?url=Container"><i class="fa fa-circle-o"></i>Container Types</a></li>

                                <li>                        <a href="home.php?url=LoadUnload"><i class="fa fa-circle-o"></i>Loading / Unloading Places</a></li>

                                <li>                        <a href="home.php?url=Package_type"><i class="fa fa-circle-o"></i>Package Type</a></li>

                                                        <!--<a href="home.php?url=Charge_code"><i class="fa fa-circle-o"></i>Charge Code</a></li>-->

                                <li>                                <a href="home.php?url=item-master"><i class="fa fa-circle-o"></i>PO Items</a></li>


                                <li>                        <a href="home.php?url=pr"><i class="fa fa-circle-o"></i>PR</a></li>



                                <li>                        <a href="home.php?url=Currency"><i class="fa fa-circle-o"></i>Currency</a></li>

                                <li>                        <a href="home.php?url=Vessel"><i class="fa fa-circle-o"></i>Vessel</a></li>

                                                <!--<a href="home.php?url=Sales_rep"><i class="fa fa-circle-o"></i>Sales Rep</a></li>-->

                        <!--                                                                        <a href="home.php?url=helpdesk"><i class="fa fa-circle-o"></i>Help Desk</a></li>-->
                                <li>                        <a href="home.php?url=lcode"><i class="fa fa-circle-o"></i>Ledger Code</a></li>


                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"> <i class="fa fa-dashboard"></i> <span>OP Accounts</span> <i class="fa fa-angle-left pull-right"></i> </a>
                            <ul class="treeview-menu">


                                <li>                            <a href="home.php?url=po"><i class="fa fa-circle-o"></i>PO</a></li>


                                <li>                    <a href="home.php?url=Credit_note"><i class="fa fa-circle-o"></i>Credit Note</a></li>

                                <li>                    <a href="home.php?url=Debit_note"><i class="fa fa-circle-o"></i>Debit Note</a></li>

                                <li>                    <a href="home.php?url=Payments"><i class="fa fa-circle-o"></i>Payments In Cheque</a></li>

                                        <!--<a href="home.php?url=Consol_Costing"><i class="fa fa-circle-o"></i>Consol Costing</a></li>-->
                                <li>                    <a href="home.php?url=jou"><i class="fa fa-circle-o"></i>Journal Entry</a></li>

                                <li>                    <a href="home.php?url=Receipt_entry"><i class="fa fa-circle-o"></i>Direct Receipt</a></li>

                    <li>                    <!--<a href="home.php?url=Return_Receipt"><i class="fa fa-circle-o"></i>Return Cheque Entry</a></li>-->

                                <li class='active'>                    <a href="home.php?url=inv"><i class="fa fa-circle-o"></i>Invoice</a></li>
                                <li>                    <a href="home.php?url=Receipt"><i class="fa fa-circle-o"></i>Receipt</a></li>

                                <li>                    <a href="home.php?url=bank_rec"><i class="fa fa-circle-o"></i>Bank Rec.</a></li>




                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"> <i class="fa fa-book"></i> <span>Reports</span> <i class="fa fa-angle-left pull-right"></i> </a>
                            <ul class="treeview-menu"> 
                                <li>                            <a href="home.php?url=tb"><i class="fa fa-circle-o"></i>Trail Balance</a>
                                <li>                            <a href="home.php?url=out"><i class="fa fa-circle-o"></i>Outstanding</a>
                                <li>                            <a href="home.php?url=pnlbs"><i class="fa fa-circle-o"></i>PNL & BS</a>



                            </ul> 
                        </li>


                        <li class="treeview">
                            <a href="#"> <i class="fa fa-cogs"></i> <span>Administration</span> <i class="fa fa-angle-left pull-right"></i> </a>
                            <ul class="treeview-menu"> 
                                <li>                            <a href="home.php?url=user"><i class="fa fa-circle-o"></i>Create User</a>


                            </ul> 
                        </li>



                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Control Sidebar -->
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">

                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">

                        <!-- /.control-sidebar-menu -->


                        <!-- /.control-sidebar-menu -->

                    </div>
                    <!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Status Tab Content</div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">

                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- Content Wrapper Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b> Area Master File</b></h3>
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
                                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; background-color: #b3d1ff;" for="invno">Area Code</label>
                                        <div class="col-sm-2">
                                            <input type="text" placeholder="Item Code" id="areaCodeTxt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; background-color: #b3d1ff;" for="invno">Area Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Item Name" id="areaNameTxt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="form-group-sm">
                                        <label class="col-sm-2 input-sm labelColour" style="text-align: left; background-color: #b3d1ff;" for="invno">Mileage</label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Mileage" id="mileageTxt" class="form-control  input-sm">
                                        </div>                                        
                                    </div>





                                </div>

                                </section>
                                <script src="js/Area_mas.js"></script>
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
