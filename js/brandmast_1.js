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

function close_form()
{
	self.close();	
}

function setbrand()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			var url="brandmast_data_1.php";			
			url=url+"?Command="+"setbrand";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;

			//alert(url);
					
			xmlHttp.onreadystatechange=setbrandresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);		
}

function setbrandresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	 
		 
	
		
	}
}

function update_brand_list()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="brandmast_data.php";			
			url=url+"?Command="+"search_brand";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;

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
	 
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
	}
}





function save_bank()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			var url="brandmast_data_1.php";			
			url=url+"?Command="+"save_bank";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;
			 
			
			//alert(url);
			
		
			
			xmlHttp.onreadystatechange=salessaveresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}



function salessaveresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
		document.getElementById('barnd_name').value="";
		 
	}
}




function bankno(barnd_name, mclass, mact, delinrate)
{   
	
			document.getElementById('barnd_name').value =barnd_name;
			 
			
		
	
}

function delete_bank()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			var url="brandmast_data_1.php";			
			url=url+"?Command="+"delete_bank";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;
		
			
			
			
		
			
			xmlHttp.onreadystatechange=bankdeletresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}

function bankdeletresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
		document.getElementById('barnd_name').value ='';
		 
		alert("Deleted");
		
	}
	
}







function new_item()
{
		document.getElementById('barnd_name').value ='';
	 
}



