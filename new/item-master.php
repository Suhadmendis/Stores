
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Item Master File Complete</title>

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
            <h3 class="box-title">FIXED ASSETS</h3>
        </div>
        <form name= "form1" role="form" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="newent();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv();" class="btn btn-success">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                </div>

                <div id="msg_box"  class="span12 text-center"  >

                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label "  for="carrier_code">Code</label>
                    <div class="col-sm-1">
                        <input type="text" placeholder="Code" disabled id="codeTxt" class="form-control">
                    </div>

                    <label class="col-sm-1 control-label">Serial Number</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Serial Number" id="serialTxt" class="form-control">
                    </div>
                    <label class="col-sm-1 control-label">Morter No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Morter No" id="morterNoTxt" class="form-control">
                    </div>

                    <label class="col-sm-1 control-label">Plant No</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Plant No" id="plantNoTxt" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Description</label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Description" id="descriptionTxt" class="form-control">

                    </div>
                    <label class="col-sm-1 control-label" for="address">Price</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Price" id="priceTxt" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Manufactured Year</label>
                    <div class="col-sm-1">
                        <input type="number" placeholder="Year" id="manuYearTxt" class="form-control" min="1990" max="2040">
                    </div>

                    <label class="col-sm-1 control-label">Color</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Color" id="colorTxt" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Warranty Period</label>
                    <div class="col-sm-1">
                        <input type="number" placeholder="Months" id="wrntyTxt" class="form-control" min="3" max="36">
                    </div>
                    <label class="col-sm-1 control-label">Brand</label>
                    <div class="col-sm-2">
                        <select id="brandCombo" class="form-control input-sm">
                            <option value="LG">LG</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Abans">Abans</option>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Invoice #</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Invoice Number" id="invTxt" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">File #</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="File Number" id="fileTxt" class="form-control">
                    </div>



                </div>   <div class="form-group"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Supplier</label>
                    <div class="col-sm-5">
                        <select id="supplierCombo" class="form-control input-sm">
                            <option value="AAA">AAA</option>
                            <option value="BBB">BBB</option>
                            <option value="CCC">CCC</option>
                        </select>
                    </div>                    
                    <label class="col-sm-1 control-label">Condition</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Condition" id="conTxt" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Department</label>
                    <div class="col-sm-5">
                        <select id="departCombo" class="form-control input-sm">
                            <option value="Office">Office</option>
                            <option value="Office1">Office1</option>
                            <option value="Office2">Office2</option>
                        </select>
                    </div>                    

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Photo</label>
                    <div class="col-sm-3">
                        <input type="button"  class="" name="idcopy" id="idcopy" value="Upload Photo" onClick="NewWindow('upload_image.php?cou=image1', 'mywin', '700', '200', 'yes', 'center');return false" />
                        <input type="button"  class="" name="idcopy2" id="idcopy2" value="Display Photo" onclick="NewWindow('display_image.php?cou=image1', 'mywin', '900', '800', 'yes', 'center');return false" />
                    </div>
                </div>
                <div class="form-group-sm" hidden="">    
                    <legend><b>Ingredionts</b></legend>
                    <div class="col-sm-12">
                        <table class="col-sm-12 table-striped">
                            <tr class="info">
                                <th>
                                    Item Code
                                </th>
                                <th style="width: 10px;"></th>
                                <th>
                                    Description
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text"  placeholder="Item Code" id="Txtcode" class="form-control">
                                </td>
                                <td></td>
                                <td>
                                    <input type="text" placeholder="Description" id="descripTxt" class="form-control">
                                </td>
                                <td><a onclick="add_tmp();" class="btn btn-default btn-sm"> <span class="fa fa-plus"></span> &nbsp; </a></td>

                            </tr>
                        </table>
                    </div>
                </div>

                <table  class='table hidden'>
                    <tr>
                        <th style="width: 350px;">
                            Item Code
                        </th>
                        <th style="width: 350px;">
                            Department
                        </th>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" onkeyup="getbycode('STK_NO');" placeholder="Item Code" id="txt_code" class="form-control">
                        </td>
                        <td>
                            <input type="text" onkeyup="getbycode('DPTMNT');" placeholder="Department" id="txt_dep" class="form-control">
                        </td>
                    </tr>
                </table>                

                <div id="itemdetails">
                </div>



            </div>
        </form>
    </div>

</section>
<script src="js/fix_mas.js"></script>
<script>newent();</script>