<?php
include './CheckCookie.php';
/*
  $cookie_name = "user";
  if(isset($_COOKIE[$cookie_name])) {
  $mo = chk_cookie($_COOKIE[$cookie_name]);
  if ($mo !="ok") {
  header('Location: '. "index.php");
  exit();
  }
  } else {
  header('Location: '. "index.php");
  exit();
  }
 */
include "header.php";

if (isset($_GET['url'])) {
    if ($_GET['url'] == "Mas_supplier") {
        include_once './Mas_supplier.php';
    }

    if ($_GET['url'] == "I_Mas") {
        include_once './I_Mas.php';
    }
    if ($_GET['url'] == "Mas_location") {
        include_once './Mas_location.php';
    }
    if ($_GET['url'] == "Mar_seg_mas") {
        include_once './Mar_seg_mas.php';
    }
    if ($_GET['url'] == "Mas_CardTyp") {
        include_once './Mas_CardTyp.php';
    }
    if ($_GET['url'] == "Mas_UOM") {
        include_once './Mas_UOM.php';
    }
    if ($_GET['url'] == "Mas_borrower") {
        include_once './Mas_borrower.php';
    }
    if ($_GET['url'] == "Mas_reason") {
        include_once './Mas_reason.php';
    }
    if ($_GET['url'] == "ProductGroupMaster") {
        include_once './ProductGroupMaster.php';
    }
    if ($_GET['url'] == "SalesExecMas") {
        include_once './SalesExecMas.php';
    }
    if ($_GET['url'] == "Mas_ArtWork") {
        include_once './Mas_ArtWork.php';
    }
    if ($_GET['url'] == "Mas_Brand") {
        include_once './Mas_Brand.php';
    }
    if ($_GET['url'] == "Mas_Target") {
        include_once './Mas_Target.php';
    }
    if ($_GET['url'] == "Assesments") {
        include_once './assesments_manager.php';
    }
    if ($_GET['url'] == "Item") {
        include_once './Ass_ItemMasterFile.php';
    }
    if ($_GET['url'] == "Location") {
        include_once './Ass_Location_Mas.php';
    }
    if ($_GET['url'] == "Complain") {
        include_once './Ass_Comments.php';
    }
    if ($_GET['url'] == "Payments") {
        include_once './Payments.php';
    }
    if ($_GET['url'] == "CompleteOrNotcomplete") {
        include_once './Ass_NotComplete.php';
    }
    if ($_GET['url'] == "ComplainProgress") {
        include_once './Ass_ComplaneProgress.php';
    }
    if ($_GET['url'] == "Return_Receipt") {
        include_once './Return_Receipt.php';
    }


    if ($_GET['url'] == "Purchase") {
        include_once './purchase.php';
    }
    if ($_GET['url'] == "History") {
        include_once './history.php';
    }
    if ($_GET['url'] == "DueDate") {
        include_once './due_date_report.php';
    }
    if ($_GET['url'] == "DailyTrans") {
        include_once './daily_trans_report.php';
    }
    if ($_GET['url'] == "StockReport") {
        include_once './stock_reports.php';
    }
    if ($_GET['url'] == "inv") {
        include_once './invoice.php';
    }
    if ($_GET['url'] == "user") {
        include_once './new_user.php';
    }
    if ($_GET['url'] == "pnlbs") {
        include_once './rep_pnlbs.php';
    }
    if ($_GET['url'] == "pr") {
        include_once './pr.php';
    }
    if ($_GET['url'] == "POReq") {
        include_once './POReq.php';
    }
    if ($_GET['url'] == "Stc_PurO_E") {
        include_once './Stc_PurO_E.php';
    }
    if ($_GET['url'] == "Grn") {
        include_once './Grn.php';
    }
    if ($_GET['url'] == "DispathNote") {
        include_once './DispathNote.php';
    }
    if ($_GET['url'] == "DispatchReturn") {
        include_once './DispatchReturn.php';
    }
    if ($_GET['url'] == "IssueNote") {
        include_once './IssueNote.php';
    }
    if ($_GET['url'] == "IssueReturn") {
        include_once './IssueReturn.php';
    }
} else {


    include_once './fpage.php';
}

include_once './footer.php';
?>

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


