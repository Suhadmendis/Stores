<?php 	session_start();
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();

	$m_ok="";
	
 if ($_GET["Command"]=="new_item"){
        header('Content-Type: text/xml');
	$sql="Select itemno from invpara";
	
	$result =$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
        
        $ResponseXML = "<salesdetails>";
	
        $ResponseXML .= "<itemno><![CDATA[" . $row["itemno"] . "]]></itemno>";
        
        $sql="Select itemno from tmpinvpara";
        $result =$db->RunQuery($sql);
        $sql="update tmpinvpara set itemno = itemno + 1";
        $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
        
        $ResponseXML .= "<tmpno><![CDATA[" . $row["itemno"] . "]]></tmpno>";
        
        $ResponseXML .= "</salesdetails>";
        echo $ResponseXML;

}	
	
	
 if ($_GET["Command"]=="chk_number"){
 	$sql="Select * from s_mas where stk_no = '".trim($_GET["txtSTK_NO"]). "'";
	$result =$db->RunQuery($sql);
	if($row = mysql_fetch_array($result)){
		echo "included";
	} else { 
		echo "no";
	}
 }
 
 	
 if ($_GET["Command"]=="item_data_save"){
     
        $sql = "select stk_no, SELLING from s_mas where  tmp_no ='" . $_GET['tmpno'] . "'";
        $result =$db->RunQuery($sql);
        $stkNo = $_GET["txtSTK_NO"];
        if ($rowInit = mysql_fetch_array($result)){
            
        }else{
            $sql="Select itemno from invpara";
            $result =$db->RunQuery($sql);
            $sql="update invpara set itemno = itemno + 1";
            $db->RunQuery($sql);
            $row = mysql_fetch_array($result);
            $stkNo = $row["itemno"];
        }
        
        
        
 	$sql="Select * from s_stomas";
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
 		$M_STOCODE=$row["CODE"];
		
		$sql1="select * from s_submas where sto_code= '".trim($M_STOCODE)."' and stk_no= '".trim($stkNo)."'";
		//echo $sql1;
		$result1 =$db->RunQuery($sql1);
		if($row1 = mysql_fetch_array($result1)){
			$sql2="update s_submas set STO_CODE='".trim($M_STOCODE)."', STK_NO='".trim($stkNo)."', DESCRIPt='".$_GET["txtDESCRIPTION"]."' where  sto_code= '".trim($M_STOCODE)."' and stk_no= '".trim($stkNo)."'";
			$result2 =$db->RunQuery($sql2);
		} else {
			$sql2="Insert into s_submas (STO_CODE, STK_NO, DESCRIPt) values ('".trim($M_STOCODE)."', '".trim($stkNo)."', '".$_GET["txtDESCRIPTION"]."')";
			$result2 =$db->RunQuery($sql2);
		}
	
	}
	
	if ($_GET["txtDESCRIPTION"]=="") { $m_ok= "Item Description Not Entered";}
	
	if ($m_ok==""){
				
		$sql="SELECT * FROM s_mas WHERE stk_no = '".trim($stkNo). "'";
		$result =$db->RunQuery($sql);
		if($row = mysql_fetch_array($result)){
		
			$sql2="update s_mas set SDATE='".date("Y-m-d")."', DESCRIPT='".$_GET["txtDESCRIPTION"]."', BRAND_NAME='".$_GET["txtBRAND_NAME"]."', GEN_NO='".$_GET["txtGEN_NO"]."', PART_NO='".$_GET["txtPART_NO"]."', COST='".$_GET["txtCOST"]."', LOCATE_1='".$_GET["txtLOCATE_1"]."', LOCATE_2='".$_GET["txtLOCATE_2"]."', LOCATE_3='".$_GET["txtLOCATE_3"]."', LOCATE_4='".$_GET["txtLOCATE_4"]."', CAT1='".$_GET["cmbcat"]."', type='".$_GET["cmbtype"]."', MARGIN='".$_GET["txtMARGIN"]."', SELLING='".$_GET["txtSELLING"]."', AR_selling='".$_GET["TXTSELLING_DISPLAY"]."', model='".$_GET["txtmodel"]."', UNIT='".$_GET["txtUNIT"]."', SIZE='".$_GET["txtSIZE"]."', RE_O_LEVEL='".$_GET["txtRE_O_LEVEL"]."', RE_O_qty='".$_GET["txtRE_O_qty"]."', GROUP1='".$_GET["Com_group1"]."', GROUP2='".$_GET["Com_group2"]."', GROUP3='".$_GET["Com_group3"]."', GROUP4='".$_GET["Com_group4"]."', cus_ord='".$_GET["txtcus_ord"]."', delivered='".$_GET["txtdelivered"]."', weight = '".trim($_GET["txtweight"]). "', SUBSTITUTE = '".trim($_GET["txtcountry"]). "', jobno='".$_GET["txtjobno"]."', comno='".$_GET["txtcomno"]."', NSD='".$_GET["txtNSD"]."' WHERE stk_no = '".trim($stkNo). "'";
			//echo $sql2;
			$result2 =$db->RunQuery($sql2);	
			
			echo "Records are updated";
		} else {
		
			$sql2="Insert into s_mas (SDATE, stk_no, DESCRIPT, BRAND_NAME, GEN_NO, PART_NO, COST, LOCATE_1, LOCATE_2, LOCATE_3, LOCATE_4, CAT1, type, MARGIN, SELLING, model,  UNIT, SIZE, RE_O_LEVEL, RE_O_qty, GROUP1, GROUP2, GROUP3, GROUP4, cus_ord, delivered, weight, SUBSTITUTE, AR_selling, jobno, comno, NSD, tmp_no) values ('".date("Y-m-d")."', '".trim($stkNo)."', '".$_GET["txtDESCRIPTION"]."', '".$_GET["txtBRAND_NAME"]."', '".$_GET["txtGEN_NO"]."', '".$_GET["txtPART_NO"]."', '".$_GET["txtCOST"]."', '".$_GET["txtLOCATE_1"]."', '".$_GET["txtLOCATE_2"]."', '".$_GET["txtLOCATE_3"]."', '".$_GET["txtLOCATE_4"]."', '".$_GET["cmbcat"]."', '".$_GET["cmbtype"]."', '".$_GET["txtMARGIN"]."', '".$_GET["txtSELLING"]."', '".$_GET["txtmodel"]."', '".$_GET["txtUNIT"]."', '".$_GET["txtSIZE"]."', '".$_GET["txtRE_O_LEVEL"]."', '".$_GET["txtRE_O_qty"]."', '".$_GET["Com_group1"]."', '".$_GET["Com_group2"]."', '".$_GET["Com_group3"]."', '".$_GET["Com_group4"]."', '".$_GET["txtcus_ord"]."', '".$_GET["txtdelivered"]."', '".trim($_GET["txtweight"]). "', '".trim($_GET["txtcountry"]). "', '".$_GET["TXTSELLING_DISPLAY"]."', '".$_GET["txtjobno"]."', '".$_GET["txtcomno"]."', '".$_GET["txtNSD"]."', '".$_GET["tmpno"]."')";
			//echo $sql2;
			$result2 =$db->RunQuery($sql2);	
			
			echo "Records are saved";

		}
                if($rowInit["SELLING"]!=$_GET["txtSELLING"]){
                        $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate, crLmt, TmpCrLmt) values ('".trim($stkNo)."', '".$_SESSION["CURRENT_USER"]."', 'Item', 'PriceUpdate', '".date("Y-m-d H:i:s")."', '".date("Y-m-d")."'," . $rowInit["SELLING"].",". $_GET["txtSELLING"]. ")";
//                        echo $sql;
                        $db->RunQuery($sql);
                }
                
                if($_GET["chkUpdate"] == "true"){
                    $cur_qty = $_GET["qty"];
                    if (is_numeric($cur_qty)) {
                        $sql2="update s_submas set QTYINHAND=" . $cur_qty . " where STK_NO='" . trim($stkNo) . "' and STO_CODE='" . $_GET["to_dep"] . "'";
                        $result2 =$db->RunQuery($sql2);
                        $sql2="update s_submas set QTYINHAND=0 where STK_NO = '" . trim($stkNo) . "' and STO_CODE != '" . $_GET["to_dep"] . "'";
                        $result2 =$db->RunQuery($sql2);
                        $sql21="update s_mas set QTYINHAND=" . $cur_qty . " where STK_NO='" . trim($stkNo) . "'";
                        $result2 =$db->RunQuery($sql21);
                        
                        $sql1 = "insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('" . trim($stkNo) . "', '" . date("Y-m-d") . "', '" . $cur_qty . "', 'TRN', 'STK UPDATE', '" . $_GET["to_dep"] . "', '', '" . $_SESSION['dev'] . "', '', '1', '')";
                        $result2 =$db->RunQuery($sql1);
                        
                        echo " with amount";
                    }else{
                        echo " Error in stock quantity";
                    }
                }
	
	}else{
            echo "Error Occured";
        }
	
		
		
}


if ($_GET["Command"]=="delete_item"){
 	$sql="Select * from s_stomas";
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
 		$M_STOCODE=$row["code"];
		
		$sql1="delete from s_submas where sto_code= '".trim($M_STOCODE)."' and stk_no= '".trim($_GET["txtSTK_NO"])."'";
		$result1 =$db->RunQuery($sql1);
	
	}
	

	
	
				
		$sql="Delete FROM s_mas WHERE stk_no = '".trim($_GET["txtSTK_NO"]). "'";
		$result =$db->RunQuery($sql);
		echo "Records are Deleted";
	
	}
	
	


 if ($_GET["Command"]=="stores_update")
 {		
/*	$sql="select * from s_mas order by stk_no";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result))
	{
		$_SESSION["txt_stkno"]=$row["STK_NO"];
			
		$sqlsto="select * from S_STOMAS";
		$resultsto =$db->RunQuery($sqlsto);
		while ($rowsto = mysql_fetch_array($resultsto))
		{
			$sqlsto1="select * from s_submas where sto_code='".rowsto["code"]."' and stk_no='".$row["STK_NO"]."'";
			$resultsto1 =$db->RunQuery($sqlsto1);
			if ($rowsto1 = mysql_fetch_array($resultsto1))
			{
				$sqlinst= "insert into s_submas(sto_code, stk_no, descrip, opent_date, qtyinhand) values('13','".trim($row["STK_NO"])."','"trim($row["descript"]."','".date("Y-m-d")."','0')";
				$resultinst =$db->RunQuery($sqlinst);
			}
		}
	}
	 
	 echo "Ok";*/

}
$db = null;
?>