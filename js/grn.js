function GetXmlHttpObject()
	{
		var xmlHttp=null;	
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp=new XMLHttpRequest();			
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");				
			  }
			 catch (e)
			  {
				 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");			
			  }
		 }
		return xmlHttp;		
}

function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}

function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}

function print_inv()
{
	/*xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
 
 	var url="ord_data.php";			
	url=url+"?Command="+"check_print";
  
    xmlHttp.onreadystatechange=passprintresult;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);*/
	
	var url="rep_grn.php";			
	url=url+"?invno="+document.getElementById('grnno').value;
	url=url+"&tax="+document.getElementById('tax').value;
	url=url+"&invoiceno="+document.getElementById('invno').value;
	url=url+"&invtot="+document.getElementById('invtot').value;
	
	
	window.open(url);
	
	
	
}

function passprintresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//if (xmlHttp.responseText==1){
			var url="rep_ord.php";			
			url=url+"?ordno="+document.getElementById('salesord1').value;
			window.open(url);
  	//	} else {
	//		alert("Order is not available");  
  	//	}
	}
}

function invno(invno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			if (stname=="grn"){
				var url="search_inv_data.php";			
				url=url+"?Command="+"pass_grn";
				url=url+"&invno="+invno;
				
				//alert(url);
				xmlHttp.onreadystatechange=passinvresult_grn;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
			} else if (stname=="crn"){
				var url="search_inv_data.php";			
				url=url+"?Command="+"pass_crn";
				url=url+"&invno="+invno;
				
				//alert(url);
				xmlHttp.onreadystatechange=passinvresult_crn;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
			} else {
				var url="search_inv_data.php";			
				url=url+"?Command="+"pass_invno";
				url=url+"&invno="+invno;
				url=url+"&custno="+opener.document.form1.firstname_hidden.value;
				url=url+"&brand="+opener.document.form1.brand.value;
				url=url+"&department="+opener.document.form1.department.value;
				
				
				xmlHttp.onreadystatechange=passinvresult;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
			}
			//alert(url);
					
			
		
	
}

function calc_tot()
{
	var subtot1=(parseFloat(document.getElementById("rate").value)*parseFloat(document.getElementById("qty").value));
	var disc1=subtot1*(parseFloat(document.getElementById("discount").value)/100);
	var subtot2=subtot1-disc1;
	var disc2=subtot2*(parseFloat(document.getElementById("discount2").value)/100);
	var subtot=subtot2-disc2;
	
	//alert(subtot);
	document.getElementById("discount_amt").value=disc1;
	document.getElementById("discount_amt2").value=disc2;
	document.getElementById("subtot_new").value=subtot;
	
}

function passinvresult_grn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");
		opener.document.form1.salesrep.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
		opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");	
		var objSalesrep = opener.document.getElementById("brand");
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");	
		var objSalesrep = opener.document.getElementById("department");
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TYPE");
		if (XMLAddress1[0].childNodes[0].nodeValue == "CR"){
			opener.document.form1.paymethod_0.checked=true;
		} else {
			opener.document.form1.paymethod_1.checked=true;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("VAT");
		if (XMLAddress1[0].childNodes[0].nodeValue == "1"){
			opener.document.form1.vatgroup_0.checked=true;
		} else {
			opener.document.form1.vatgroup_1.checked=true;
		}
		
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DISCOU");
	//	opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GRAND_TOT");
	//	opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcou");
		opener.document.form1.mcou.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		self.close();
	}
	
}



function ret_deduct(key, e, mcou, box)
{	
	
  // if(e.keyCode==13){
	  
	  
	  var chkinvno="0";
	  
	if (document.getElementById('chkinvno').checked==true){
		if (box=='retqty'){
			chkinvno="1";
		}
		if (box=='discou4'){
			chkinvno="4";
		}
	} else {
		chkinvno="2";
	
	}
	
	
	if (chkinvno=="1"){	
	
	   
	   var qtybox='qty'+key;
	   var preretbox='preret'+key;
	   var retbox='ret'+key;
	   var discbox='disc'+key;
	   var discbox2='disc2'+key;
	   var discbox3='disc3'+key;
	   var discbox4='disc4'+key;
	   var subtotbox='subtot'+key;
	   var pricebox='price'+key;
	   
	   var valqty = document.getElementById(qtybox).value;
	   var valpreret =document.getElementById(preretbox).value;
	   var valret = document.getElementById(retbox).value;
	   var valdisc = document.getElementById(discbox).value;
	   var valdisc2 = document.getElementById(discbox2).value;
	    var valdisc3 = document.getElementById(discbox3).value;
	    var valdisc4 = document.getElementById(discbox4).value;
	   var valprice = document.getElementById(pricebox).value;
	  
	   var totret=parseFloat(valpreret)+parseFloat(valret);
	  
	  if (valqty>=totret){
	   
	   document.getElementById('subtot').value=0;
	   document.getElementById('totdiscount').value=0;
	   document.getElementById('tax').value=0;
	   document.getElementById('invtot').value=0;
	   
	   valqty=parseFloat(valqty.replace(/,/gi, ""));
	   valpreret=parseFloat(valpreret.replace(/,/gi, ""));
	   valret=parseFloat(valret.replace(/,/gi, ""));
	   valdisc=parseFloat(valdisc.replace(/,/gi, ""));
	   valdisc2=parseFloat(valdisc2.replace(/,/gi, ""));
	   valdisc3=parseFloat(valdisc3.replace(/,/gi, ""));
	   valdisc4=parseFloat(valdisc4.replace(/,/gi, ""));
	   valprice=parseFloat(valprice.replace(/,/gi, ""));
	   
	   	sb1=valret*valprice;
		dis1=sb1*valdisc/100;
		sb2=sb1-dis1;
		dis2=sb2*valdisc2/100;
		sb3=sb2-dis2;
		dis3=sb3*valdisc3/100;
                sb4=sb3-dis3;
                dis4=sb4*valdisc4/100;
		
		dis=dis1+dis2+dis3+dis4;
			//document.getElementById(subtotbox).value=(valret*valprice)-((valret*valprice)*valdisc/100);
			//setting item subtotal
			document.getElementById(subtotbox).value=sb1-dis;
			
			var i=1;
			var valsubtot=0;
			var valdisctot=0;
			var valdisctot1=0;
			var valdisctot2=0;
			var valdisctot3=0;
			var valdisctot4=0;
			while (i<=mcou){
				
				var subtotitembox='subtot'+i;
				var discitembox='disc'+i;
				var discitembox2='disc2'+i;
				var discitembox3='disc3'+i;
				var discitembox4='disc4'+i;
				valsubtot=valsubtot+parseFloat(document.getElementById(subtotitembox).value);
				
				var discount;
				var discount2;
				var discount3;
				var discount4;
				if (document.getElementById(discitembox).value==0){
					discount=0;
				} else {
					discount=document.getElementById(discitembox).value;	
				}
				if (document.getElementById(discitembox2).value==0){
					discount2=0;
				} else {
					discount2=document.getElementById(discitembox2).value;	
				}
				if (document.getElementById(discitembox3).value==0){
					discount3=0;
				} else {
					discount3=document.getElementById(discitembox3).value;	
				}
				if (document.getElementById(discitembox4).value==0){
					discount4=0;
				} else {
					discount4=document.getElementById(discitembox4).value;	
				}
				//valdisctot=valdisctot+parseFloat(discount)*parseFloat(document.getElementById(subtotitembox).value)/100;
				subtot1=valret*valprice;
				
				valdisctot1=valdisctot1+(subtot1)*valdisc/100;
				subtot2=subtot1-valdisctot1;
				
				valdisctot2=valdisctot2+(subtot2)*valdisc2/100;
				subtot3=subtot2-valdisctot2;
				
				valdisctot3=valdisctot3+(subtot3)*valdisc3/100;
                                subtot4=subtot3-valdisc3;
                                
                                valdisctot4=valdisctot4+(subtot4)*valdisc4/100;
				
				valdisctot=valdisctot1+valdisctot2+valdisctot3+valdisctot4;
				i=i+1;
			}
			document.getElementById('subtot').value=valsubtot;
			document.getElementById('totdiscount').value=valdisctot;
			var before_vat=parseFloat(document.getElementById('subtot').value);
			
			if (document.getElementById('vatgroup_1').checked==false){
				
				var d = document.getElementById('invdate').value;
				//a=d.getTime();
				//alert(a);
			//	a="2014-12-31";
			//	var dateOne = new Date(a); 
			//	var dateTwo = new Date(d); 
				//alert(dateOne);
				//alert(dateTwo);
			//	if (dateTwo<=dateOne){
					
			//		after_vat=parseFloat(before_vat)+(parseFloat(before_vat)*12/100);	
			//		document.getElementById('tax').value=parseFloat(after_vat)/1.11;	
			//		document.getElementById('invtot').value=after_vat;
			//	} else {
					document.getElementById('tax').value=(parseFloat(before_vat)*15)/100;		
					document.getElementById('invtot').value=parseFloat(before_vat)+parseFloat(document.getElementById('tax').value);
			//	}
				
				//alert(before_vat);
				
			} else {
				document.getElementById('tax').value=0;
				document.getElementById('invtot').value=before_vat;	
			}
	   } else {
			alert("Insufficient Quantity");   
			document.getElementById(retbox).value="";
	   }
	 }
	  
	
	if (chkinvno=="4"){	
	   var qtybox='qty'+key;
           //////
	   var preretbox='preret'+key;
	   var retbox='ret'+key;
           /////
	   var discbox='disc'+key;
	   var discbox2='disc2'+key;
	   var discbox3='disc3'+key;
	   var discbox4='disc4'+key;
	   var costbox='cost'+key;
	   var subtotbox='subtot'+key;
	   var pricebox='price'+key;
	   
	   var valqty = document.getElementById(qtybox).value;
           ///unused///
	   var valpreret =document.getElementById(preretbox).value;
	   var valret = document.getElementById(retbox).value;
           ///unused//
	   var valdisc = document.getElementById(discbox).value;
	   var valdisc2 = document.getElementById(discbox2).value;
	    var valdisc3 = document.getElementById(discbox3).value;
	    var valdisc4 = document.getElementById(discbox4).value;
	    var valcost = document.getElementById(costbox).value;
	   var valprice = document.getElementById(pricebox).value;
	  
	   var totret=parseFloat(valpreret)+parseFloat(valret);
	  
	   ///////////
	   document.getElementById('subtot').value=0;
	   document.getElementById('totdiscount').value=0;
	   document.getElementById('tax').value=0;
	   document.getElementById('invtot').value=0;
	   
	   valqty=parseFloat(valqty.replace(/,/gi, ""));
           //unused//
	   valpreret=parseFloat(valpreret.replace(/,/gi, ""));
	   valret=parseFloat(valret.replace(/,/gi, ""));
           //unused///
	   valdisc=parseFloat(valdisc.replace(/,/gi, ""));
	   valdisc2=parseFloat(valdisc2.replace(/,/gi, ""));
	   valdisc3=parseFloat(valdisc3.replace(/,/gi, ""));
	   valdisc4=parseFloat(valdisc4.replace(/,/gi, ""));
	   valcost=parseFloat(valcost.replace(/,/gi, ""));
	   valprice=parseFloat(valprice.replace(/,/gi, ""));
	   
	   	sb1=valqty*valprice;
		dis1=sb1*valdisc/100;
		sb2=sb1-dis1;
		dis2=sb2*valdisc2/100;
		sb3=sb2-dis2;
		dis3=sb3*valdisc3/100;
                sb4=sb3-dis3;
                dis4=sb4*valdisc4/100;
		
		dis=dis1+dis2+dis3+dis4;
                
                afterDis = sb1-dis;
			//document.getElementById(subtotbox).value=(valret*valprice)-((valret*valprice)*valdisc/100);
			
                        //test: under cost
//                        var cost = 5;
//                        var subt = 4;
//                        
                        if((afterDis/valqty) >= valcost){
                        
			document.getElementById(subtotbox).value=sb1-dis;
			
			var i=1;
			var valsubtot=0;
			var valdisctot=0;
			var valdisctot1=0;
			var valdisctot2=0;
			var valdisctot3=0;
			var valdisctot4=0;
			while (i<=mcou){
				var subtotitembox='subtot'+i;
				var discitembox='disc'+i;
				var discitembox2='disc2'+i;
				var discitembox3='disc3'+i;
				var discitembox4='disc4'+i;
				valsubtot=valsubtot+parseFloat(document.getElementById(subtotitembox).value);
				
				var discount;
				var discount2;
				var discount3;
				var discount4;
				if (document.getElementById(discitembox).value==0){
					discount=0;
				} else {
					discount=document.getElementById(discitembox).value;	
				}
				if (document.getElementById(discitembox2).value==0){
					discount2=0;
				} else {
					discount2=document.getElementById(discitembox2).value;	
				}
				if (document.getElementById(discitembox3).value==0){
					discount3=0;
				} else {
					discount3=document.getElementById(discitembox3).value;	
				}
				if (document.getElementById(discitembox4).value==0){
					discount4=0;
				} else {
					discount4=document.getElementById(discitembox4).value;	
				}
				//valdisctot=valdisctot+parseFloat(discount)*parseFloat(document.getElementById(subtotitembox).value)/100;
				subtot1=valqty*valprice;
				
				valdisctot1=valdisctot1+(subtot1)*valdisc/100;
				subtot2=subtot1-valdisctot1;
				
				valdisctot2=valdisctot2+(subtot2)*valdisc2/100;
				subtot3=subtot2-valdisctot2;
				
				valdisctot3=valdisctot3+(subtot3)*valdisc3/100;
                                subtot4=subtot3-valdisc3;
                                
                                valdisctot4=valdisctot4+(subtot4)*valdisc4/100;
				
				valdisctot=valdisctot1+valdisctot2+valdisctot3+valdisctot4;
				i=i+1;
			}
			document.getElementById('subtot').value=valsubtot;
			document.getElementById('totdiscount').value=valdisctot;
			var before_vat=parseFloat(document.getElementById('subtot').value);
			
			if (document.getElementById('vatgroup_1').checked==false){
				
				var d = document.getElementById('invdate').value;
				//a=d.getTime();
				//alert(a);
			//	a="2014-12-31";
			//	var dateOne = new Date(a); 
			//	var dateTwo = new Date(d); 
				//alert(dateOne);
				//alert(dateTwo);
			//	if (dateTwo<=dateOne){
					
			//		after_vat=parseFloat(before_vat)+(parseFloat(before_vat)*12/100);	
			//		document.getElementById('tax').value=parseFloat(after_vat)/1.11;	
			//		document.getElementById('invtot').value=after_vat;
			//	} else {
					document.getElementById('tax').value=(parseFloat(before_vat)*15)/100;		
					document.getElementById('invtot').value=parseFloat(before_vat)+parseFloat(document.getElementById('tax').value);
			//	}
				
				//alert(before_vat);
				
			} else {
				document.getElementById('tax').value=0;
				document.getElementById('invtot').value=before_vat;	
			}
                        ////////////////
                    }else{
//                        alert("under cost!" +" "+afterDis + " @ " + valqty + " @ " + valcost);
                        alert("under cost!");
                        document.getElementById(discbox4).value = 0.00;
                    } 

	 }
	  
	  
	if (chkinvno=="2"){	
	  
	   var qtybox='qty'+key;
	   var preretbox='preret'+key;
	   var retbox='ret'+key;
	   var discbox='disc'+key;
	   var subtotbox='subtot'+key;
	   var pricebox='price'+key;
	   
	   if (document.getElementById(qtybox).value==""){
		   document.getElementById(qtybox).value=0;
	   }
	   
	   if (document.getElementById(preretbox).value==""){
		   document.getElementById(preretbox).value=0;
	   }
	   
	   if (document.getElementById(retbox).value==""){
		   document.getElementById(retbox).value=0;
	   }
	   
	   if (document.getElementById(discbox).value==""){
		   document.getElementById(discbox).value=0;
	   }
	   
	   if (document.getElementById(pricebox).value==""){
		   document.getElementById(pricebox).value=0;
	   }
	   
	   var valqty = document.getElementById(qtybox).value;
	   var valpreret =document.getElementById(preretbox).value;
	   var valret = document.getElementById(retbox).value;
	   var valdisc = document.getElementById(discbox).value;
	   var valprice = document.getElementById(pricebox).value;
	   

	   document.getElementById('subtot').value=0;
	   document.getElementById('totdiscount').value=0;
	   document.getElementById('tax').value=0;
	   document.getElementById('invtot').value=0;
	   
	   valqty=parseFloat(valqty.replace(/,/gi, ""));
	   valpreret=parseFloat(valpreret.replace(/,/gi, ""));
	   valret=parseFloat(valret.replace(/,/gi, ""));
	   valdisc=parseFloat(valdisc.replace(/,/gi, ""));
	   valprice=parseFloat(valprice.replace(/,/gi, ""));
	   
			document.getElementById(subtotbox).value=(valret*valprice)-((valret*valprice)*valdisc/100);
			
			var i=1;
			var valsubtot=0;
			var valdisctot=0;
			
			while (i<=mcou){
				var subtotitembox='subtot'+i;
				var discitembox='disc'+i;
				valsubtot=valsubtot+parseFloat(document.getElementById(subtotitembox).value);
				
				var discount;
				if (document.getElementById(discitembox).value==0){
					discount=0;
				} else {
					discount=document.getElementById(discitembox).value;	
				}
				//valdisctot=valdisctot+parseFloat(discount)*parseFloat(document.getElementById(subtotitembox).value)/100;
				valdisctot=valdisctot+(valret*valprice)*valdisc/100;
				i=i+1;
			}
			document.getElementById('subtot').value=valsubtot;
			document.getElementById('totdiscount').value=valdisctot;
			var before_vat=parseFloat(document.getElementById('subtot').value);
			
			if (document.getElementById('vatgroup_1').checked==false){
				
				document.getElementById('tax').value=(before_vat*15)/100;	
				
				//alert(before_vat);
				document.getElementById('invtot').value=parseFloat(before_vat)+parseFloat(document.getElementById('tax').value);
				
				
			} else {
				document.getElementById('tax').value=0;
				document.getElementById('invtot').value=before_vat;	
			}
	   
			
	}
	
	if (chkinvno=="0"){
		alert("Can't Edit");	
	}
   //}
}


function calc_inv_tot()
{
	
			var i=1;
			var valsubtot=0;
			var valdisctot=0;
			mcou=parseFloat(document.getElementById("mcou").value);
			while (i<=mcou){
				var subtotitembox='subtot'+i;
				var discitembox='disc'+i;
				
				valsubtot=valsubtot+parseFloat(document.getElementById(subtotitembox).value);
				
				var discount;
				if (document.getElementById(discitembox).value==0){
					discount=0;
				} else {
					discount=document.getElementById(discitembox).value;	
				}
				//valdisctot=valdisctot+parseFloat(discount)*parseFloat(document.getElementById(subtotitembox).value)/100;
				valdisctot=valdisctot+(valret*valprice)*valdisc/100;
				i=i+1;
			}
			document.getElementById('subtot').value=valsubtot;
			document.getElementById('totdiscount').value=valdisctot;
			var before_vat=parseFloat(document.getElementById('subtot').value);
			
			if (document.getElementById('vatgroup_1').checked==false){
				document.getElementById('tax').value=(before_vat*15)/100;
				//alert(before_vat);
				document.getElementById('invtot').value=parseFloat(before_vat);
			} else {
				document.getElementById('tax').value=0;
				document.getElementById('invtot').value=before_vat;	
			}	
}

function enable_disable()
{
	if (document.getElementById('chkinvno').checked==true){
		document.getElementById('department').disabled=true;
		document.getElementById('salesrep').disabled=true;
		document.getElementById('costcenter').disabled=true;
		document.getElementById('brand').disabled=true;
		document.getElementById('item_code').disabled=true;
		document.getElementById('searchitem').disabled=true;
		document.getElementById('qty').disabled=true;
		document.getElementById('rate').disabled=true;
		document.getElementById('discount').disabled=true;
		document.getElementById('discount2').disabled=true;
		document.getElementById('subtot_new').disabled=true;
		document.getElementById('additem_tmp').disabled=true;
		document.getElementById('vatgroup_0').disabled=true;
		document.getElementById('vatgroup_1').disabled=true;
		document.getElementById('vatgroup_2').disabled=true;
		document.getElementById('vatgroup_3').disabled=true;
		
		var mcou=parseFloat(document.getElementById('mcou').value);
		var i=1;
		while (mcou>i){
			
			stkno="stkno"+i;
			descript="descript"+i;
			price="price"+i;
			qty="qty"+i;
			preretqty="preret"+i;
			retqty="ret"+i;
			disc="disc"+i;
			disc2="disc2"+i;
			subtot="subtot"+i;
						
			document.getElementById(stkno).disabled=true;
			document.getElementById(descript).disabled=true;
			document.getElementById(price).disabled=true;
			document.getElementById(qty).disabled=true;
			document.getElementById(preretqty).disabled=true;
			document.getElementById(retqty).disabled=true;
			document.getElementById(disc).disabled=true;
			document.getElementById(disc2).disabled=true;
			document.getElementById(subtot).disabled=true;
			
			i=i+1;
		}
		
	} else {
		document.getElementById('department').disabled=false;
		document.getElementById('salesrep').disabled=false;
		document.getElementById('costcenter').disabled=false;
		document.getElementById('brand').disabled=false;
		document.getElementById('item_code').disabled=false;
		document.getElementById('searchitem').disabled=false;
		document.getElementById('qty').disabled=false;
		document.getElementById('rate').disabled=false;
		document.getElementById('discount').disabled=false;
		document.getElementById('discount2').disabled=false;
		document.getElementById('subtot_new').disabled=false;
		document.getElementById('additem_tmp').disabled=false;	
		document.getElementById('vatgroup_0').disabled=false;
		document.getElementById('vatgroup_1').disabled=false;
		document.getElementById('vatgroup_2').disabled=false;
		document.getElementById('vatgroup_3').disabled=false;
		
		var mcou=parseFloat(document.getElementById('mcou').value);
		var i=1;
		while (mcou>i){
			
			stkno="stkno"+i;
			descript="descript"+i;
			price="price"+i;
			qty="qty"+i;
			preretqty="preret"+i;
			retqty="ret"+i;
			disc="disc"+i;
			disc2="disc2"+i;
			subtot="subtot"+i;
						
			
			document.getElementById(price).disabled=false;
			document.getElementById(qty).disabled=false;
			document.getElementById(preretqty).disabled=false;
			document.getElementById(retqty).disabled=false;
			document.getElementById(disc).disabled=false;
			document.getElementById(disc2).disabled=false;
			document.getElementById(subtot).disabled=false;
			
			i=i+1;
		}
	}
}

function custno_ind()
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_grn";
				url=url+"&custno="+document.getElementById('firstname_hidden').value; 
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_grn;
			 
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function passcusresult_grn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		document.getElementById('firstname_hidden').value=XMLAddress1[0].childNodes[0].nodeValue;;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");	
		document.getElementById('firstname').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
		var add1=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
		var add2=XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('cus_address').value=add1+" "+add2;
		
		
	}
}

function add_address()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="inv_data.php";			
			url=url+"?Command="+"add_address";
			url=url+"&customerid="+document.getElementById('firstname_hidden').value;
			//alert(url);
			xmlHttp.onreadystatechange=showarmyresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showarmyresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		document.getElementById('cus_address').value= xmlHttp.responseText;
	}
}

function note_update()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			document.getElementById('txtnote').value=document.getElementById('txtnote').value+document.getElementById('txt_new').value;
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"note_update";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&txtnote="+document.getElementById('txtnote').value;
			//alert(url);
			xmlHttp.onreadystatechange=result_note_update;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	

}

function result_note_update()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert("ok");
		//var txt_cuscode=document.getElementById('txt_cuscode').value
		//custno(txt_cuscode, "cust_mast");
		
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('cus_address').value= xmlHttp.responseText;
	}
}

function calc1()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			
		if (document.getElementById('qty').value<=document.getElementById('stklevel').value){
			var str=document.getElementById('rate').value;
			var n=str.replace(/,/gi, ""); 
			
			var subtotal=parseFloat(n)*parseFloat(document.getElementById('qty').value);
			var dis=0;
			var dis1=0;
			var dis2=0;
			var dis3=0;
			var disper=0;
			var dis1f=0;
			var dis2f=0;
			var dis3f=0;
			
			
			if ((document.getElementById('discount1').value != '') && (document.getElementById('discount1').value != "0") && (document.getElementById('discount1').value != "0.00")){
				dis1=subtotal*document.getElementById('discount1').value/100;
				disper=document.getElementById('discount1').value;
				
			}
			dis1f=dis1.toFixed(2);
			subtotal=subtotal-dis1f;
			
			if ((document.getElementById('discount2').value != '')&&(document.getElementById('discount2').value != "0")&&(document.getElementById('discount2').value != "0.00")){
				dis2=subtotal*document.getElementById('discount2').value/100;
				disper=100-(100-document.getElementById('discount2').value)*(100-document.getElementById('discount1').value)/100;
				
			}
			dis2f=dis2.toFixed(2);
			subtotal=subtotal-dis2f;
			
			if ((document.getElementById('discount3').value != '')&&(document.getElementById('discount3').value != "0")&&(document.getElementById('discount3').value != "0.00")){
				dis3=subtotal*document.getElementById('discount3').value/100;
				disper=100-(100-document.getElementById('discount3').value)*(100-document.getElementById('discount2').value)*(100-document.getElementById('discount1').value)/100;
				
			}
			dis3f=dis3.toFixed(2);
			subtotal=subtotal-dis3f;
			
			dis=parseFloat(dis1f)+parseFloat(dis2f)+parseFloat(dis3f);
			
			document.getElementById('discount').value=dis;
			document.getElementById('discountper').value=disper;
			document.getElementById('subtotal').value= subtotal.toFixed(2);
		} else {
			alert("Insufficient Quantity");	
		}
		
	
}

function calc2()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			document.getElementById('subtotal').value=document.getElementById('subtotal').value-document.getElementById('discount').value;
			
		
	
}

function add_tmp()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="grn_data.php";			
			url=url+"?Command="+"add_tmp";
			url=url+"&invno="+document.getElementById('invno').value;
			
			url=url+"&itemcode="+document.getElementById('item_code').value;
			
			url=url+"&item="+document.getElementById('itemd').value;
			
			if (document.getElementById('vatgroup_1').checked==true){
				vatgrp="non";
			} else {
				vatgrp="vat";
			} 
				
			url=url+"&vatgrp="+vatgrp;
			
			url=url+"&rate="+document.getElementById('rate').value;
			url=url+"&qty="+document.getElementById('qty').value;
			url=url+"&discount="+document.getElementById('discount').value;
			url=url+"&discount2="+document.getElementById('discount2').value;
			url=url+"&discount_amt="+document.getElementById('discount_amt').value;
			url=url+"&discount_amt2="+document.getElementById('discount_amt2').value;
			
			url=url+"&subtot_new="+document.getElementById('subtot_new').value;
			url=url+"&brand="+document.getElementById('brand').value;
			url=url+"&mcou="+document.getElementById('mcou').value;
			//alert(url);
			
			xmlHttp.onreadystatechange=showarmyresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showarmyresultdel()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcou");	
		document.getElementById('mcou').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("valdisc");	
		document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totsubtot");	
		document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("taxtot");	
		document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("nettot");	
		document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		document.getElementById('chkinvno').checked=true;
		
		/*XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_dis");	
		document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tax");	
		document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("taxname");	
		document.getElementById('taxname').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invtot");	
		document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		
		
		//document.getElementById('invno').value="";
		document.getElementById('item_code').value="";
		document.getElementById('itemd').value="";
		document.getElementById('rate').value="";
		document.getElementById('qty').value="";
		document.getElementById('discount').value="0";
		document.getElementById('discount_amt').value="";
		document.getElementById('subtot_new').value="";
		
		calc_inv_tot();
	}
}




function shownavyresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("navy_table");	
		document.getElementById('tblnavy').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function del_item(code)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="inv_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&code="+code;
			//alert(url);
			
			xmlHttp.onreadystatechange=itemresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function itemresultdel()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function clear_customer(){
	location.reload();
	/*document.getElementById('txt_cuscode').value="";
	document.getElementById('txtCNAME').value="";
	document.getElementById('txtBADD1').value="";
	document.getElementById('txtBADD2').value="";
	document.getElementById('txtTEL').value="";
	document.getElementById('txttel2').value="";
	document.getElementById('txtFAX').value="";
	document.getElementById('TXTEMAIL').value="";
	document.getElementById('DTbankgrdate').value="";
	document.getElementById('DTOPDATE').value="";
	document.getElementById('txtcper').value="";
	document.getElementById('txtACCno').value="";
	document.getElementById('txtcrlimt').value="";
	document.getElementById('txtbal').value="";
	document.getElementById('txtover').value="";
	document.getElementById('txtvatno').value="";
	document.getElementById('txtcat').value="";
	document.getElementById('txttype').value="";
	document.getElementById('txtarea').value="";
	document.getElementById('TXT_REP').value="";
	document.getElementById('txtBRAND_NAME11').value="";
	document.getElementById('creditlim').innerHTML="";
	document.getElementById('txtlimit').value="";
	document.getElementById('cmbCAt').value="";
	document.getElementById('txtBRAND_NAME11').value="";*/

}

function new_customer()
{
	clear_customer();
}

function save_customer()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"save_customer";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&txtCNAME="+document.getElementById('txtCNAME').value;
			url=url+"&txtBADD1="+document.getElementById('txtBADD1').value;
			url=url+"&txtBADD2="+document.getElementById('txtBADD2').value;
			url=url+"&txtTEL="+document.getElementById('txtTEL').value;
			url=url+"&txttel2="+document.getElementById('txttel2').value;
			url=url+"&txtFAX="+document.getElementById('txtFAX').value;
			url=url+"&TXTEMAIL="+document.getElementById('TXTEMAIL').value;
			url=url+"&DTbankgrdate="+document.getElementById('DTbankgrdate').value;
			url=url+"&DTOPDATE="+document.getElementById('DTOPDATE').value;
			url=url+"&txtcper="+document.getElementById('txtcper').value;
			url=url+"&txtACCno="+document.getElementById('txtACCno').value;
			url=url+"&txtcrlimt="+document.getElementById('txtcrlimt').value;
			url=url+"&txtbal="+document.getElementById('txtbal').value;
			url=url+"&txtover="+document.getElementById('txtover').value;
			url=url+"&txtvatno="+document.getElementById('txtvatno').value;
			url=url+"&txtcat="+document.getElementById('txtcat').value;
			url=url+"&txttype="+document.getElementById('txttype').value;
			url=url+"&txtarea="+document.getElementById('txtarea').value;
			url=url+"&TXT_REP="+document.getElementById('TXT_REP').value;
			url=url+"&txtInc="+document.getElementById('txtInc').value;
			url=url+"&chkgarant="+document.getElementById('chkgarant').value;
			url=url+"&txtMsg="+document.getElementById('txtMsg').value;

		
			xmlHttp.onreadystatechange=save_customer_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function save_customer_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function delete_customer()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"delete_customer";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			

		
			xmlHttp.onreadystatechange=delete_customer_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function delete_customer_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function save_inv(inv_status)
{   
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	  if (document.getElementById('grnno').value!=""){
		//if (document.getElementById('txtstoRef').value!=""){
			
			var paymethod;
			
			var url="grn_data.php";	
                        
			var params="Command="+"save_item";
                        
                        if(inv_status == "GRN"){
			params=params+"_grn";
                        }else if(inv_status == "CAJ"){
                        params=params+"_caj";   
                        }
                        if (document.getElementById('paymethod_0').checked==true){
				paymethod="CR";
			} else if (document.getElementById('paymethod_1').checked==true){
				paymethod="CA";
			}
			params=params+"&paymethod="+paymethod;
			params=params+"&grnno="+document.getElementById('grnno').value;
			
			params=params+"&rno="+document.getElementById('rno').value;
			params=params+"&grndate="+document.getElementById('grndate').value;
			params=params+"&cusno="+document.getElementById('firstname_hidden').value;
			params=params+"&cusname="+document.getElementById('firstname').value;
			params=params+"&invno="+document.getElementById('invno').value;
			params=params+"&invdate="+document.getElementById('invdate').value;
			params=params+"&salesrep="+document.getElementById('salesrep').value;
			params=params+"&brand="+document.getElementById('brand').value;
			params=params+"&department="+document.getElementById('department').value;
			params=params+"&serialno="+document.getElementById('serialno').value;
			params=params+"&costcenter="+document.getElementById('costcenter').value;
			params=params+"&txtstoRef="+document.getElementById('txtstoRef').value;
			
			var vatmethod;
			
			if (document.getElementById('vatgroup_0').checked==true){
				vatmethod="1";
			} else if (document.getElementById('vatgroup_1').checked==true){
				vatmethod="0";
			} else if (document.getElementById('vatgroup_2').checked==true){
				vatmethod="2";
			} else if (document.getElementById('vatgroup_3').checked==true){
				vatmethod="1";
			}
			
			params=params+"&vatmethod="+vatmethod;
			
			var i=1;
			
			while (document.getElementById('mcou').value>i){
				
				var stkno="stkno"+i;
				var descript="descript"+i;
				var price="price"+i;
				var qty="qty"+i;
				var preretqty="preret"+i;
				var retqty="ret"+i;
				var disc="disc"+i;
				var disc2="disc2"+i;
				var disc3="disc3"+i;
				var disc4="disc4"+i;
				var subtot="subtot"+i;
				
				params=params+"&"+stkno+"="+document.getElementById(stkno).value;
				params=params+"&"+descript+"="+document.getElementById(descript).value;
				params=params+"&"+price+"="+document.getElementById(price).value;
				params=params+"&"+qty+"="+document.getElementById(qty).value;
				params=params+"&"+preretqty+"="+document.getElementById(preretqty).value;
				params=params+"&"+retqty+"="+document.getElementById(retqty).value;
				
				params=params+"&"+disc+"="+document.getElementById(disc).value;
				params=params+"&"+disc2+"="+document.getElementById(disc2).value;
				params=params+"&"+disc3+"="+document.getElementById(disc3).value;
				params=params+"&"+disc4+"="+document.getElementById(disc4).value;
				params=params+"&"+subtot+"="+document.getElementById(subtot).value;
				
				i=i+1;
			}
			params=params+"&mcou="+document.getElementById('mcou').value;
			
			params=params+"&subtot="+document.getElementById('subtot').value;
			params=params+"&totdiscount="+document.getElementById('totdiscount').value;
			params=params+"&tax="+document.getElementById('tax').value;
			params=params+"&invtot="+document.getElementById('invtot').value;
		
			xmlHttp.open("POST", url, true);

			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.setRequestHeader("Content-length", params.length);
			xmlHttp.setRequestHeader("Connection", "close");			
			
			xmlHttp.onreadystatechange=salessaveresult;

                        xmlHttp.send(params);
		//} else {
		//	alert("Please Insert Sto.Ref.");	
		//}
	  } else {
			alert("Please Click New...");  
	  }
		
}


function grn(grn)
{   
	//alert(grn);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="grn_data.php";			
			url=url+"?Command="+"pass_grnno";
			url=url+"&grn="+grn;
		
	
			xmlHttp.onreadystatechange=pass_grnno_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function pass_grnno_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");	
		opener.document.form1.grnno.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");	
		opener.document.form1.grndate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");	
		opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_NAME");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("INVOICENO");	
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DDATE");	
		opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");	
		opener.document.form1.salesrep.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");	
		opener.document.form1.brand.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");	
		opener.document.form1.department.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DIS");	
		opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_net");	
		opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GRAND_TOT");	
		opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		opener.document.form1.mcou.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vat");	
		var vat = XMLAddress1[0].childNodes[0].nodeValue;
		
		if (vat=="1"){
			opener.document.form1.vatgroup_0.checked=true;
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtvat");	
			opener.document.form1.tax.value = XMLAddress1[0].childNodes[0].nodeValue;
		} else {
			opener.document.form1.vatgroup_1.checked=true;	
			opener.document.form1.tax.value=0;
		}
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_dis");	
		opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stoRef");	
		opener.document.form1.txtstoRef.value = XMLAddress1[0].childNodes[0].nodeValue;
		
                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cancel");	
		if ((XMLAddress1[0].childNodes[0].nodeValue)=="1"){
			window.opener.document.getElementById('cancelid').innerHTML = "CANCELED";
			//window.opener.document.getElementById('cmdprint').disabled = true;
			
		} else {
			window.opener.document.getElementById('cancelid').innerHTML ="";	
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");	
	//	document.getElementById('invno').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}



function salessaveresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		if (xmlHttp.responseText=="no"){
			alert("Please Login Again !!!");	
		} else {
			alert(xmlHttp.responseText);
			print_inv();
			location.reload(true);
		}
		//if (xmlHttp.responseText!="Already Exist"){
		//	setTimeout("location.reload(true);",500);
		//}
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	}
}

function close_form()
{
	self.close();	
}

function cancel_inv(inv_status)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		//alert(inv_status);
	
	
			
			var url="grn_data.php";			
			url=url+"?Command="+"cancel_inv";
					
			url=url+"&grnno="+document.getElementById('grnno').value;
			url=url+"&rno="+document.getElementById('rno').value;
			url=url+"&grndate="+document.getElementById('grndate').value;
			url=url+"&cusno="+document.getElementById('firstname_hidden').value;
			url=url+"&cusname="+document.getElementById('firstname').value;
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&invdate="+document.getElementById('invdate').value;
			url=url+"&salesrep="+document.getElementById('salesrep').value;
			url=url+"&brand="+document.getElementById('brand').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&serialno="+document.getElementById('serialno').value;
			url=url+"&costcenter="+document.getElementById('costcenter').value;
			
		
			
			var i=1;
			while (document.getElementById('mcou').value>i){
				var stkno="stkno"+i;
				var descript="descript"+i;
				var price="price"+i;
				var qty="qty"+i;
				var preretqty="preret"+i;
				var retqty="ret"+i;
				var disc="disc"+i;
				var subtot="subtot"+i;
				
				url=url+"&"+stkno+"="+document.getElementById(stkno).value;
				url=url+"&"+descript+"="+document.getElementById(descript).value;
				url=url+"&"+price+"="+document.getElementById(price).value;
				url=url+"&"+qty+"="+document.getElementById(qty).value;
				url=url+"&"+preretqty+"="+document.getElementById(preretqty).value;
				url=url+"&"+retqty+"="+document.getElementById(retqty).value;
				url=url+"&"+disc+"="+document.getElementById(disc).value;
				url=url+"&"+subtot+"="+document.getElementById(subtot).value;
				
				i=i+1;
			}
			url=url+"&mcou="+document.getElementById('mcou').value;
			
			url=url+"&subtot="+document.getElementById('subtot').value;
			url=url+"&totdiscount="+document.getElementById('totdiscount').value;
			url=url+"&tax="+document.getElementById('tax').value;
			url=url+"&invtot="+document.getElementById('invtot').value;
		
			//alert(url);
			if(inv_status = "GRN"){
			xmlHttp.onreadystatechange=grncancelresult;
                        }else if(inv_status = "CAJ"){
                        xmlHttp.onreadystatechange=cajcancelresult;    
                        }
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}


function grncancelresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
		new_inv("GRN");
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	}
}

function cajcancelresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
		new_inv("CAJ");
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	}
}


function new_inv(inv_status)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var paymethod;
			
			document.getElementById('firstname_hidden').value="";
			document.getElementById('firstname').value="";
			document.getElementById('cus_address').value="";
			
			document.getElementById('salesrep').value="";
						
			var objbrand = document.getElementById("brand");
			objbrand.options[0].selected=true;
			
			document.getElementById('invno').value="";
			document.getElementById('paymethod_0').checked=true;
			
			var objdepartment = document.getElementById("department");
			objdepartment.options[0].selected=true;
			
			document.getElementById('serialno').value="";
			
			var objbrand = document.getElementById("costcenter");
			objbrand.options[0].selected=true;
			
			document.getElementById('paymethod_0').checked=true;
			document.getElementById('vatgroup_0').value=true;
			
			document.getElementById('itemdetails').innerHTML="";
			document.getElementById('subtot').value="";
			document.getElementById('totdiscount').value="";
			document.getElementById('tax').value="";
			document.getElementById('invtot').value="";
			
			document.getElementById('chkinvno').checked=true;
			//document.getElementById('invdate').value=Date();
			
			var url="grn_data.php";			
			url=url+"?Command="+"new_inv";
                        if(inv_status == "GRN"){
			url=url+"_grn";
                        }else if(inv_status == "CAJ"){
                        url=url+"_caj";   
                        }                        
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	//document.getElementById('grnno').value=xmlHttp.responseText;	
	
	if (xmlHttp.responseText=="no"){
		alert("Please Login Again !!!");
	} else {
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");	
		document.getElementById('grnno').value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rno");	
		document.getElementById('rno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cdate");	
		document.getElementById('grndate').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('firstname_hidden').focus();
	}
	
}



function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="grn_data.php";			
			url=url+"?Command="+"search_inv";
			
			if (document.getElementById('invno').value!=""){
				url=url+"&mstatus=invno";
			} else if (document.getElementById('customername').value!=""){
				url=url+"&mstatus=customername";
			}
			
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&customername="+document.getElementById('customername').value;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=showinvresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function showinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function update_cust_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"search_custom";
			
			if (document.getElementById('cusno').value!=""){
				url=url+"&mstatus=cusno";
			} else if (document.getElementById('customername').value!=""){
				url=url+"&mstatus=customername";
			}
			
			url=url+"&cusno="+document.getElementById('cusno').value;
			url=url+"&customername="+document.getElementById('customername').value;
			url=url+"&stname="+stname;
			
					
			xmlHttp.onreadystatechange=showcustresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showcustresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function update_item_list()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"search_item";
			url=url+"&itno="+document.getElementById('itno').value;
			url=url+"&itemname="+document.getElementById('itemname').value;
			
			if (document.getElementById('itno').value!=""){
				url=url+"&mstatus=itno";
			} else if (document.getElementById('itemname').value!=""){
				url=url+"&mstatus=itemname";
			}
					
			xmlHttp.onreadystatechange=showitemresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showitemresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function assignbrand()
{
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			var url="search_inv_data.php";			
			url=url+"?Command="+"assign_brand";
			url=url+"&brand="+document.getElementById('brand').value;
			url=url+"&salesrep="+document.getElementById('salesrep').value;
			url=url+"&txt_cuscode="+document.getElementById('firstname_hidden').value;
		
			//alert(url);
					
			xmlHttp.onreadystatechange=barand_details_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function barand_details_result()
{
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
	document.getElementById('creditlimit').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
	document.getElementById('balance').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	document.getElementById('discount1').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
	document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
}


function assignbrand_search(brand, salesrep, txt_cuscode)
{
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			var url="search_inv_data.php";			
			url=url+"?Command="+"assign_brand";
			url=url+"&brand="+brand;
			url=url+"&salesrep="+salesrep;
			url=url+"&txt_cuscode="+txt_cuscode;
		
			//alert(url);
					
			xmlHttp.onreadystatechange=barand_details_result_search;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function barand_details_result_search()
{
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
	opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
	opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
	window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	
}


function invno(invno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			if (stname=="crn"){
				var url="search_inv_data.php";			
				url=url+"?Command="+"pass_crn";
				url=url+"&invno="+invno;
				
				alert(url);
				xmlHttp.onreadystatechange=passinvresult_crn;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
			} else {
				var url="search_inv_data.php";			
				url=url+"?Command="+"pass_invno";
				url=url+"&invno="+invno;
				url=url+"&custno="+opener.document.form1.firstname_hidden.value;
				url=url+"&brand="+opener.document.form1.brand.value;
				url=url+"&department="+opener.document.form1.department.value;
				
				
				xmlHttp.onreadystatechange=passinvresult;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
			}
			//alert(url);
					
			
		
	
}

function passinvresult_crn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
		opener.document.form1.inv_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
		opener.document.form1.cus_code.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_NAME");
		opener.document.form1.cus_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");	
		var objSalesrep = opener.document.getElementById("salesrep");
		
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");	
		var objSalesrep = opener.document.getElementById("department");
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
		opener.document.form1.inv_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_amt");
		opener.document.form1.invamount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TOTPAY");
		opener.document.form1.totpay.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance");
		opener.document.form1.invbal.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");	
		var objSalesrep = opener.document.getElementById("brand");
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		self.close();
	}
	
}

function passinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_crecash");	
		
		if(XMLAddress1[0].childNodes[0].nodeValue=='CR')
		{
			opener.document.form1.paymethod_0.checked=true;
		
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='CA')
		{
			opener.document.form1.paymethod_1.checked=true;
			
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customecode");	
		opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;
		var txt_cuscode=XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno1");	
		opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno2");	
		opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;
	

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesrep");	
		var objSalesrep = opener.document.getElementById("salesrep");
		
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		//alert(objSalesrep.length);

		

	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesorder1");	
	//	opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;

	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesorder2");	
	//	opener.document.form1.salesord2.value = XMLAddress1[0].childNodes[0].nodeValue;

		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dte_deliverdate");	
		opener.document.form1.dte_dor.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno1");	
		opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;
		opener.document.form1.orderno1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno2");	
		opener.document.form1.orderdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_credit");	
	//	opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_balance");	
	//	opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_department");	
		var objDepartment = opener.document.getElementById("department");
		
		var i=0;
		while (i<objDepartment.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objDepartment.options[i].value)
			{
				objDepartment.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_brand");	
		var objBrand = opener.document.getElementById("brand");
		
		var i=0;
		var brand=XMLAddress1[0].childNodes[0].nodeValue;
		while (i<objBrand.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objBrand.options[i].value)
			{
				objBrand.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vat");	
		
		if(XMLAddress1[0].childNodes[0].nodeValue=='vat')
		{
			opener.document.form1.vatgroup_0.checked=true;
		
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='svat')
		{
			opener.document.form1.vatgroup_2.checked=true;
			
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='evat')
		{
			opener.document.form1.vatgroup_3.checked=true;
			
		} else {
			opener.document.form1.vatgroup_1.checked=true;
		}
		
		//else if(XMLAddress1[0].childNodes[0].nodeValue=='svat')
		//{
		//	opener.document.form1.vatgroup_2.checked=true;
			
		//}
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount1");	
	//	opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount2");	
	//	opener.document.form1.discount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_subtotal");	
		opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount");	
		opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_tax");	
		opener.document.form1.tax.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_invoiceval");	
		opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
		opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
		opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis1");	
		opener.document.form1.discount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis2");	
		opener.document.form1.discount3.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.credper.value = 65;
		//window.opener.document.getElementById("test").innerHTML="TESTNBMSVMS"
		//opener.document.forminv.invno.value = "123";
		//myWindow.opener.document.invno.value = "123";
		self.close();
		//alert(myWindow.opener.document.getElementById('invno').value);
		//forminv.getElementById('invno').value="125";
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function ass_lim(credit_lim, rep, credit, balance, cat, brand)
{
	document.getElementById('txtlimit').value=credit_lim;
	
	
		var objSalesrep = document.getElementById("Com_rep");
		
		var i=0;
		objSalesrep.options[i].selected=true;
		while (i<objSalesrep.length)
		{
			if (rep == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		var objBrand = document.getElementById("cmbbrand");
		
		var i=0;
		objBrand.options[i].selected=true;
		while (i<objBrand.length)
		{
			if (brand == objBrand.options[i].value)
			{
				objBrand.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		var objCat = document.getElementById("cmbCAt");
		
		var i=0;
		objCat.options[i].selected=true;
		while (i<objCat.length)
		{
			if (cat == objCat.options[i].value)
			{
				objCat.options[i].selected=true;
				
			}
			i=i+1;
		}
		
}

function custno(custno, stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			if (stname=="cust_mast"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cusno_cust_mast";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_cust_mast;
			} else if (stname=="rep_mast_general"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_repno_cust_mast";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_rep_mast;
			} else if (stname=="rep_mast_general_s"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_repno_cust_mast";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_rep_mast_s;
			} else if (stname=="cash_rec"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cus_cash_rec";
				url=url+"&custno="+custno;
				url=url+"&refno="+opener.document.form1.salesrep.value;
				xmlHttp.onreadystatechange=passcusresult_cash_rec;
			} else if (stname=="crn"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_crn";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_crn;
			} else {
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cusno";
				url=url+"&custno="+custno;
				url=url+"&brand="+opener.document.form1.brand.value;
				url=url+"&salesrep="+opener.document.form1.salesrep.value;
				xmlHttp.onreadystatechange=passcusresult;
			}
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function passcusresult_crn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		opener.document.form1.cus_code.value=XMLAddress1[0].childNodes[0].nodeValue;;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");	
		opener.document.form1.cus_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
		var add1=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
		var add2=XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.cus_address.value =add1+" "+add2;
		
		self.close();
	}
}

function passcusresult_cash_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		opener.document.form1.hiddencount.value=XMLAddress1[0].childNodes[0].nodeValue;;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		//alert( XMLAddress1[0].childNodes[0].nodeValue);
		window.opener.document.getElementById('inv_details').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		self.close();
		//opener.document.form1.txtdetar.focus();
	}
}

function setord()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="inv_data.php";			
	url=url+"?Command="+"setord";
	url=url+"&custno="+document.getElementById('firstname_hidden').value;
	//url=url+"&salesord1="+document.getElementById('salesord1').value;
	url=url+"&salesrep="+document.getElementById('salesrep').value;
	url=url+"&brand="+document.getElementById('brand').value;
	url=url+"&department="+document.getElementById('department').value;
//alert(url);
	xmlHttp.onreadystatechange=setord_result_inv;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function setord_result_inv(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
		document.getElementById('creditlimit').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		document.getElementById('balance').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

	}
		
		
}

function passcusresult_rep_mast_s()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		opener.document.form1.txt_cuscode_s.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.form1.txt_cusname_s.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.txtdetar_s.value = "";
		
		
		self.close();
		opener.document.form1.txtdetar.focus();
	}
}

function passcusresult_rep_mast()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.form1.txt_cusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.txtdetar.value = "";
		
		
		self.close();
		opener.document.form1.txtdetar.focus();
	}
}



function passcusresult_cust_mast()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("blacklist");
		
		if (XMLAddress1[0].childNodes[0].nodeValue=="1"){
			opener.document.form1.check1.checked = true;
		} else {
			opener.document.form1.check1.checked = false;
		}
		
		opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");	
		opener.document.form1.txtCNAME.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
		opener.document.form1.txtBADD1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
		opener.document.form1.txtBADD2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPBAL");	
	//	opener.document.form1.txt_crelimi.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE1");	
		opener.document.form1.txtTEL.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE2");	
		opener.document.form1.txttel2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CONT");	
		opener.document.form1.txtcper.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUR_BAL");	
		opener.document.form1.txtbal.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LIMIT");	
		opener.document.form1.txtcrlimt.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PEN");	
		opener.document.form1.txtover.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("FAX");	
		opener.document.form1.txtFAX.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acno");	
		opener.document.form1.txtACCno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMAIL");	
		opener.document.form1.TXTEMAIL.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CAT");	
		opener.document.form1.txtcat.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rep");	
		opener.document.form1.TXT_REP.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatno");	
		opener.document.form1.txtvatno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPDATE");	
		opener.document.form1.DTOPDATE.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("area");	
		opener.document.form1.txtarea.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_TYPE");	
		opener.document.form1.txttype.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("note");	
		opener.document.form1.txtnote.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("temp_limit");	
		//opener.document.form1.txt_tmeplimit.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_gr_date");	
		opener.document.form1.DTbankgrdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");	
		opener.document.form1.txtMsg.value = XMLAddress1[0].childNodes[0].nodeValue;
					
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		window.opener.document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_lim");	
		opener.document.form1.txtcrlimt.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
		opener.document.form1.salesrep.focus();
	
		
	}
}

function update_limit()
{  
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"update_limit";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&rep="+document.getElementById('Com_rep').value;
			url=url+"&brand="+document.getElementById('cmbbrand').value;
			url=url+"&txtlimit="+document.getElementById('txtlimit').value;
			url=url+"&cmbCAt="+document.getElementById('cmbCAt').value;
			url=url+"&stopinv="+document.getElementById('check1').checked;
			
			xmlHttp.onreadystatechange=passitresult_update_limit;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
}

function passitresult_update_limit()
{
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totcr");	
	document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_table");	
	//alert(XMLAddress1[0].childNodes[0].nodeValue);
	document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    
	alert("Updated");

}

function delete_limit()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"delete_limit";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&rep="+document.getElementById('Com_rep').value;
			url=url+"&brand="+document.getElementById('cmbbrand').value;
			url=url+"&txtlimit="+document.getElementById('txtlimit').value;
			url=url+"&cmbCAt="+document.getElementById('cmbCAt').value;
			url=url+"&stopinv="+document.getElementById('check1').checked;
			
			xmlHttp.onreadystatechange=passitresult_delete_limit;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
}

function passitresult_delete_limit()
{
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totcr");	
	document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_table");	
	document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    
	alert("Deleted");

}

function passcusresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno");	
		opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_svatno");	
		opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		if ((opener.document.form1.vat1.value == '') && (opener.document.form1.vat2.value == '')) {
			opener.document.form1.vatgroup_1.checked=true;
		} else if ((opener.document.form1.vat1.value != '') && (opener.document.form1.vat2.value == '')){
			opener.document.form1.vatgroup_0.checked=true;
		} else if ((opener.document.form1.vat1.value != '') && (opener.document.form1.vat2.value != '')){
			opener.document.form1.vatgroup_2.checked=true;
		} 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
		opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
		//opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

		
		self.close();
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_message");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_message");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message_que");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			var ans=confirm(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_return");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		
		
		opener.document.form1.salesrep.focus();
	
		
	}
}

function itno(itno)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"pass_itno";
			url=url+"&itno="+itno;
			url=url+"&brand="+opener.document.form1.brand.value;
			url=url+"&department="+opener.document.form1.department.value;
			
			var vatmethod="";
			if (opener.document.form1.vatgroup_0.checked==true){
				vatmethod="vat";
			} else if (opener.document.form1.vatgroup_1.checked==true){
				vatmethod="non";
			} else if (opener.document.form1.vatgroup_2.checked==true){
				vatmethod="svat";
			} else if (opener.document.form1.vatgroup_3.checked==true){
				vatmethod="evat";
			}
			
			url=url+"&vatmethod="+vatmethod;
			
			url=url+"&discount1="+opener.document.form1.discount1.value;
			url=url+"&discount2="+opener.document.form1.discount2.value;
			url=url+"&discount3="+opener.document.form1.discount3.value;
			
			//alert(url);
			xmlHttp.onreadystatechange=passitresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
	
}

function passitresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");	
		opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");	
		opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");	
		opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		opener.document.form1.stklevel.value = XMLAddress1[0].childNodes[0].nodeValue;
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	//	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;

		
		self.close();
		opener.document.form1.qty.focus();
		
	
		
	}
}

function chk_opener()
{
	//alert("ok");
	//self.close();	
	//opener.document.form1.invno.value = document.bull.lon.value;
	opener.document.form1.invno.value = "123";
}




function tmp_crelimit()
{ 
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"tmp_crelimit";
			url=url+"&Com_rep1="+document.getElementById('Com_rep1').value;
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&cmbbrand1="+document.getElementById('cmbbrand1').value;
			url=url+"&txt_templimit="+document.getElementById('txt_templimit').value;
			//alert(url);
			
			if (document.getElementById('check1').checked==true)
			{
				var mcheck=1;
			} else {
				var mcheck=0;
			}
			url=url+"&check1="+mcheck;
			
				
			xmlHttp.onreadystatechange=result_tmp_crelimit;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function result_tmp_crelimit()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
	}
}

