function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function keyset(key, e) {

    if (e.keyCode == 13) {
        document.getElementById(key).focus();
    }
}

function got_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000000";

}

function newent() {
    
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('refText').value = "";
    document.getElementById('drfTxt').value = "";
    document.getElementById('cusText').value = "";
    document.getElementById('desText').value = "";
    document.getElementById('proCodeText').value = "";
    document.getElementById('reqQtyText').value = "";
    document.getElementById('lengthTxt').value = "";
    document.getElementById('totSqInchTxt').value = "";
    document.getElementById('noOfUpsTxt').value = "";
    document.getElementById('widthTxt').value = "";
    document.getElementById('totSqftTxt').value = "";
    document.getElementById('fohMarginTxt').value = "";
    document.getElementById('colorTxt').value = "";
    document.getElementById('noOfImpTxt').value = "";
    document.getElementById('salesMarginTxt').value = "";
    document.getElementById('wasteTxt').value = "";
    document.getElementById('noOfOutsTxt').value = "";
    document.getElementById('commissionPerUnitTxt').value = "";
    document.getElementById('itemList').innerHTML = "";
    document.getElementById('msg_box').innerHTML = "";
    document.getElementById('unitCostTxt').value = "";
    document.getElementById('unitWasteTxt').value = "";
    document.getElementById('unitJobCostTxt').value = "";
    
    document.getElementById('inkCode').value = "";
    document.getElementById('inkAvg').value = "";
    document.getElementById('inkCap').value = "";
    document.getElementById('effSqFt').value = "";
    document.getElementById('inkQty').value = "";
    document.getElementById('inkTotCost').value = "";
    
    document.getElementById('cusTextName').value = "";
    document.getElementById('txt_factory').value = "1";
    document.getElementById('sellingText').value = "";

    var url = "costing_data.php";
    url = url + "?Command=" + "new_inv";

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
    
    //getdt();
}

function assign_invno() {



    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('refText').value = XMLAddress1[0].childNodes[0].nodeValue;

    }

}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "Mas_borrower_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
    document.getElementById('item_details').innerHTML = xmlHttp.responseText;
}


function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "add_tmp";
    url = url + "&tmpno=" + document.getElementById('refText').value;
    url = url + "&bord=" + document.getElementById('boardTxt').value;
    url = url + "&Desc=" + document.getElementById('descripttext').value;
    url = url + "&qty=" + document.getElementById('quantityTxt').value;
    url = url + "&unit=" + document.getElementById('unitpriceTxt').value;
    url = url + "&avg=" + document.getElementById('avgPriceTxt').value;
    url = url + "&balance=" + document.getElementById('balanceTxt').value;

    xmlHttp.onreadystatechange = showarmyresultdelw;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showarmyresultdelw() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('abcd').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



        document.getElementById('boardTxt').value = "";
        document.getElementById('descripttext').value = "";
        document.getElementById('quantityTxt').value = "";
        document.getElementById('unitpriceTxt').value = "";
        document.getElementById('balanceTxt').value = "";
        document.getElementById('avgPriceTxt').value = "";
        document.getElementById('boardTxt').focus();
    }
}


function upfile() {

    var files = $('#file-3')[0].files; //where files would be the id of your multi file input
//or use document.getElementById('files').files;

    for (var i = 0, f; f = files[i]; i++) {
        var name = document.getElementById('file-3');
        var alpha = name.files[i];
        console.log(alpha.name);
        var data = new FormData();

        var refno = document.getElementById('refText').value;
        data.append('refno', refno);
        data.append('file-3', alpha);
        $.ajax({
            url: 'read_excel.php',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (msg) {
                alert(msg);
                var xmlDoc = msg



                    elemPic = xmlDoc.getElementsByTagName("salesdetails");
    //window.alert(elemPic);

            for(var i = 0; i < elemPic.length; i++){
        //whats the source path?
                document.getElementById('cusText').value = elemPic[i].getElementsByTagName('cus')[0].childNodes[0].nodeValue;
                document.getElementById('cusTextName').value = elemPic[i].getElementsByTagName('cusName')[0].childNodes[0].nodeValue;
                document.getElementById('proCodeText').value = elemPic[i].getElementsByTagName('product')[0].childNodes[0].nodeValue;
                document.getElementById('lengthTxt').value = elemPic[i].getElementsByTagName('length')[0].childNodes[0].nodeValue;
                document.getElementById('reqQtyText').value = elemPic[i].getElementsByTagName('qty')[0].childNodes[0].nodeValue;
                document.getElementById('wasteTxt').value = elemPic[i].getElementsByTagName('waste')[0].childNodes[0].nodeValue;
                document.getElementById('colorTxt').value = elemPic[i].getElementsByTagName('color')[0].childNodes[0].nodeValue;
                document.getElementById('noOfUpsTxt').value = elemPic[i].getElementsByTagName('noofups')[0].childNodes[0].nodeValue;
                document.getElementById('noOfOutsTxt').value = elemPic[i].getElementsByTagName('noofouts')[0].childNodes[0].nodeValue;
                document.getElementById('noOfImpTxt').value = elemPic[i].getElementsByTagName('noofimpre')[0].childNodes[0].nodeValue;
                document.getElementById('fohMarginTxt').value = elemPic[i].getElementsByTagName('fohmargin')[0].childNodes[0].nodeValue;
                document.getElementById('salesMarginTxt').value = elemPic[i].getElementsByTagName('salesmargin')[0].childNodes[0].nodeValue;
                document.getElementById('commissionPerUnitTxt').value = elemPic[i].getElementsByTagName('commisionperunit')[0].childNodes[0].nodeValue;
                document.getElementById('widthTxt').value = elemPic[i].getElementsByTagName('width')[0].childNodes[0].nodeValue;
                document.getElementById('itemList').innerHTML = elemPic[i].getElementsByTagName('itemList')[0].childNodes[0].nodeValue;
                document.getElementById('desText').value = elemPic[i].getElementsByTagName('description')[0].childNodes[0].nodeValue;
                document.getElementById('unitCostTxt').value = elemPic[i].getElementsByTagName('totalCost')[0].childNodes[0].nodeValue;
                document.getElementById('unitWasteTxt').value = elemPic[i].getElementsByTagName('rawWaste')[0].childNodes[0].nodeValue;
                document.getElementById('unitJobCostTxt').value = elemPic[i].getElementsByTagName('jobCost')[0].childNodes[0].nodeValue;
                document.getElementById('sellingText').value = elemPic[i].getElementsByTagName('sellingPrice')[0].childNodes[0].nodeValue;
                
                document.getElementById('totSqInchTxt').value = elemPic[i].getElementsByTagName('totSqIn')[0].childNodes[0].nodeValue;
                document.getElementById('totSqftTxt').value = elemPic[i].getElementsByTagName('totSqFt')[0].childNodes[0].nodeValue;
                document.getElementById('effSqFt').value = elemPic[i].getElementsByTagName('effSqFt')[0].childNodes[0].nodeValue;
                
                document.getElementById('inkCode').value = "";
                document.getElementById('inkAvg').value = "";
                document.getElementById('inkCap').value = "";
                document.getElementById('inkQty').value = "";
                document.getElementById('inkTotCost').value = "";
                }
            }
        });
    }

}


function excel(){

  xmlHttp = GetXmlHttpObject();

  if (xmlHttp == null) {
      alert("Browser does not support HTTP Request");
      return;
  }

  var url = "read_excel.php";

  xmlHttp.onreadystatechange = excel_fill;
  xmlHttp.open("GET", url, true);
  xmlHttp.send(null);
}

function excel_fill() {
  var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cus");
      opener.document.form1.cusText.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("product");
      opener.document.form1.proCodeText.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("length");
      opener.document.form1.drfTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qty");
      opener.document.form1.reqQtyText.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("waste");
      opener.document.form1.lengthTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("color");
      opener.document.form1.colorTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("noofouts");
      opener.document.form1.noOfUpsTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("noofimpre");
      opener.document.form1.drfTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("fohmargin");
      opener.document.form1.fohMarginTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesmargin");
      opener.document.form1.salesMarginTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("width");
      opener.document.form1.widthTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

      XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("commisionperunit");
      opener.document.form1.commissionPerUnitTxt.value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}


function add_two() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "kalifa";
    url = url + "&Command2=" + "add";
    url = url + "&tmp_no=" + document.getElementById('refText').value;
    url = url + "&ink=" + document.getElementById('inkTxt').value;
    url = url + "&Desc1=" + document.getElementById('descript1text').value;
    url = url + "&qty1=" + document.getElementById('quantity1Txt').value;
    url = url + "&unit1=" + document.getElementById('unitprice1Txt').value;
    url = url + "&avg1=" + document.getElementById('avgPrice1Txt').value;
    url = url + "&value1=" + document.getElementById('value1Txt').value;

    xmlHttp.onreadystatechange = show;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function show() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_tablee");
        document.getElementById('abcde').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



        document.getElementById('intTxt').value = "";
        document.getElementById('descript1text').value = "";
        document.getElementById('quantity1Txt').value = "";
        document.getElementById('unitprice1Txt').value = "";
        document.getElementById('balance1Txt').value = "";
        document.getElementById('avgPrice1Txt').value = "";
        document.getElementById('inkTxt').focus();
    }
}


function add_three() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "add_table";
    url = url + "&Command2=" + "add_three";
    url = url + "&tmp_no=" + document.getElementById('refText').value;
    url = url + "&other=" + document.getElementById('otherTxt').value;
    url = url + "&Desc2=" + document.getElementById('descript2text').value;
    url = url + "&qty2=" + document.getElementById('quantity2Txt').value;
    url = url + "&unit2=" + document.getElementById('unitprice2Txt').value;
    url = url + "&avg2=" + document.getElementById('avgPrice2Txt').value;
    url = url + "&value2=" + document.getElementById('value2Txt').value;

    xmlHttp.onreadystatechange = show_two;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function show_two() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_tablee");
        document.getElementById('ab').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



        document.getElementById('intTxt').value = "";
        document.getElementById('descript1text').value = "";
        document.getElementById('quantity1Txt').value = "";
        document.getElementById('unitprice1Txt').value = "";
        document.getElementById('balance1Txt').value = "";
        document.getElementById('avgPrice1Txt').value = "";
        document.getElementById('inkTxt').focus();
    }
}

function add_newq() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "add_table1";
    url = url + "&Command2=" + "add_three1";
    url = url + "&tmp_no=" + document.getElementById('refText').value;
    url = url + "&overHead=" + document.getElementById('overHeadTxt').value;
    url = url + "&Desc3=" + document.getElementById('descript3text').value;
    url = url + "&rate=" + document.getElementById('rateTxt').value;
    url = url + "&val=" + document.getElementById('valTxt').value;

    xmlHttp.onreadystatechange = show_three;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function show_three() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_tablee");
        document.getElementById('qwe').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



        document.getElementById('intTxt').value = "";
        document.getElementById('descript1text').value = "";
        document.getElementById('quantity1Txt').value = "";
        document.getElementById('unitprice1Txt').value = "";
        document.getElementById('balance1Txt').value = "";
        document.getElementById('avgPrice1Txt').value = "";
        document.getElementById('inkTxt').focus();
    }
}





function add_n() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "add_table2";
    url = url + "&Command2=" + "add_three2";
    url = url + "&tmp_no=" + document.getElementById('refText').value;
    url = url + "&stage=" + document.getElementById('stageTxt').value;
    url = url + "&stDesc=" + document.getElementById('desTxt').value;
    url = url + "&select=" + document.getElementById('selectTxt').value;

    xmlHttp.onreadystatechange = show_four;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function show_four() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('tab').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



        document.getElementById('intTxt').value = "";
        document.getElementById('descript1text').value = "";
        document.getElementById('quantity1Txt').value = "";
        document.getElementById('unitprice1Txt').value = "";
        document.getElementById('balance1Txt').value = "";
        document.getElementById('avgPrice1Txt').value = "";
        document.getElementById('inkTxt').focus();
    }
}


function update_cust_list(stname)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "search_custom";
     
    if (document.getElementById('cusno').value != "") {
        url = url + "&mstatus=cusno";
    } else if (document.getElementById('customername').value != "") {
        url = url + "&mstatus=customername";
    }

    url = url + "&cusno=" + document.getElementById('cusno').value;
    url = url + "&customername=" + document.getElementById('customername').value;
    url = url + "&stname=" + stname;

    xmlHttp.onreadystatechange = showcustresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showcustresult()
{
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('filt_table').innerHTML = xmlHttp.responseText;
    }
}

function custno(custno, stname)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "costing_data.php";
    url = url + "?Command=" + "pass_quot";
    url = url + "&custno=" + custno;
    url = url + "&stname=" + stname;




    xmlHttp.onreadystatechange = set_text;

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}



function set_text()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
         alert(xmlHttp.responseXML);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stname");
        if (XMLAddress1[0].childNodes[0].nodeValue == ""){
        
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
            opener.document.form1.refText.value = XMLAddress1[0].childNodes[0].nodeValue;


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cod");
            opener.document.form1.dateTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
            opener.document.form1.cusText.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("drf");
            opener.document.form1.drfTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("desc");
            opener.document.form1.desText.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pro1");
            opener.document.form1.proCodeText.value = XMLAddress1[0].childNodes[0].nodeValue;

    //        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pro2");
    //        opener.document.form1.proText.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("req");
            opener.document.form1.reqQtyText.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("order");
            opener.document.form1.orderQtyTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

    //        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("feet");
    //        opener.document.form1.totalNoOfSQFTTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

    //        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("noimp");
    //        opener.document.form1.noOfImpressionsTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("length");
            opener.document.form1.lengthTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_sq_inch");
            opener.document.form1.totSqInchTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("no_of_ups");
            opener.document.form1.noOfUpsTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("width");
            opener.document.form1.widthTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_sqft");
            opener.document.form1.totSqftTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("foh_margin");
            opener.document.form1.fohMarginTxt.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("color");
            opener.document.form1.colorTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("no_of_imp");
            opener.document.form1.noOfImpTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_margin");
            opener.document.form1.salesMarginTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("waste");
            opener.document.form1.wasteTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("no_of_outs");
            opener.document.form1.noOfOutsTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("commission_per_unit");
            opener.document.form1.commissionPerUnitTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("COST");
            opener.document.form1.unitCostTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rawWaste");
            opener.document.form1.unitWasteTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("jobCost");
            opener.document.form1.unitJobCostTxt.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("selling");
            opener.document.form1.sellingText.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemList");
            opener.document.getElementById("itemList").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
            
            opener.document.getElementById("msg_box").innerHTML = "";
            
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusName");
            opener.document.form1.cusTextName.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inkQty");
            opener.document.form1.inkQty.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inkCost");
            opener.document.form1.inkTotCost.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("factory");
            opener.document.form1.txt_factory.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            opener.document.form1.inkCode.value = "";
            opener.document.form1.inkAvg.value = "";
            opener.document.form1.inkCode.value = "";

            //

//            window.opener.document.getElementById('filebox').style.visibility = "visible";
//
//            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("filebox");
//            window.opener.document.getElementById('filebox').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
//
//            getdt2();
    }else{
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
            opener.document.form1.txt_jobno.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
            opener.document.form1.txt_ccode.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusName");
            opener.document.form1.txt_cname.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusAdd");
            opener.document.form1.txt_caddress.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pro1");
            opener.document.form1.itemCode.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("desc");
            opener.document.form1.itemDesc.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("req");
            opener.document.form1.qty.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("selling");
            opener.document.form1.itemPrice.value = XMLAddress1[0].childNodes[0].nodeValue;
    }
        self.close();
    }
}


function custnoo(custno)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "costing_data.php";
    url = url + "?Command=" + "pass_quott";
    url = url + "&custno=" + custno;




    xmlHttp.onreadystatechange = set_textt;

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}


function set_textt()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.cusText.value = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
    }
}







function custnooo(custno)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "costing_data.php";
    url = url + "?Command=" + "pass_quottt";
    url = url + "&custno=" + custno;




    xmlHttp.onreadystatechange = set_texttt;

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}


function set_texttt()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.proCodeText.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.proText.value = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
    }
}








function getdt2() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "pass_quot";
//    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt2;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}



function assign_dt2() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("filebox");
        document.getElementById('filebox').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }

}



function getcode(cdata, cdata1, cdata2) {


    document.getElementById('areaCodeTxt').value = cdata;
    document.getElementById('areaNameTxt').value = cdata1;
    document.getElementById('mileageTxt').value = cdata2;



}


function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }



    var url = "costing_data.php";

    var para = "Command=" + "save_item";


    para = para + "&code=" + document.getElementById('refText').value;
    para = para + "&date=" + document.getElementById('dateTxt').value;
    para = para + "&drf=" + document.getElementById('drfTxt').value;
    para = para + "&cus=" + document.getElementById('cusText').value;
    para = para + "&cusTextName=" + document.getElementById('cusTextName').value;
    para = para + "&desc=" + document.getElementById('desText').value;
    para = para + "&productCode=" + document.getElementById('proCodeText').value;
    para = para + "&req=" + document.getElementById('reqQtyText').value;

    para = para + "&length=" + document.getElementById('lengthTxt').value;
    para = para + "&totSqInch=" + document.getElementById('totSqInchTxt').value;
    para = para + "&noOfUps=" + document.getElementById('noOfUpsTxt').value;
    para = para + "&width=" + document.getElementById('widthTxt').value;

    para = para + "&totSqft=" + document.getElementById('totSqftTxt').value;
    para = para + "&fohMarginT=" + document.getElementById('fohMarginTxt').value;
    para = para + "&color=" + document.getElementById('colorTxt').value;
    para = para + "&noOfImp=" + document.getElementById('noOfImpTxt').value;

    para = para + "&salesMargin=" + document.getElementById('salesMarginTxt').value;
    para = para + "&wasteT=" + document.getElementById('wasteTxt').value;
    para = para + "&noOfOuts=" + document.getElementById('noOfOutsTxt').value;
    para = para + "&commissionPerUnit=" + document.getElementById('commissionPerUnitTxt').value;
    para = para + "&unitCostTxt=" + document.getElementById('unitCostTxt').value;
    para = para + "&unitWasteTxt=" + document.getElementById('unitWasteTxt').value;
    para = para + "&unitJobCostTxt=" + document.getElementById('unitJobCostTxt').value;
    
    para = para + "&inkQty=" + document.getElementById('inkQty').value;
    para = para + "&inkTotCost=" + document.getElementById('inkTotCost').value;
    para = para + "&txt_factory=" + document.getElementById('txt_factory').value;
    para = para + "&sellingText=" + document.getElementById('sellingText').value;
    
//    alert(para);
//    return;

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", para.length);
    xmlHttp.setRequestHeader("Connection", "close");
    xmlHttp.send(para);
    xmlHttp.send(null);



}

function cancel_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";

    var para = "Command=" + "del_inv";
    para = para + "&code=" + document.getElementById('refText').value;
    
//    alert(para);
//    return;

    xmlHttp.onreadystatechange = cancel_result;
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", para.length);
    xmlHttp.setRequestHeader("Connection", "close");
    xmlHttp.send(para);
    xmlHttp.send(null);



}

function cancel_result() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Cancelled") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Cancelled</span></div>";
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}