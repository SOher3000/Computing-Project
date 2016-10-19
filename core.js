/*function increaseDay() {
	alert('next');
	document.write();
	
<?php	$adjstdCalDate =  new DateTime($CalDate);
						$adjstdCalDate->add(new DateInterval("P1D"));
						$CalDate = $adjstdCalDate->format("Y-m-d");
						echo $CalDate;?>
	
}

function nextDay(date)
{
var xmlhttp;
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getcustomer.asp?q="+str,true);
xmlhttp.send();
}


/*
function nextMonth(date) {
	alert("Month "+ date);
	//var element=document.getElementById(note);
	//element.style.display="block";
	//hideChord(note);
};

function nextYear(date) {
	alert("Year "+date);
	//var element=document.getElementById(note);
	//element.style.display="block";
	//hideChord(note);
};*/

function hideshadow() {
	//alert('mouseover!');
	//var div = Document.getElementById(this);
	//div.removeClass('shadow');
	
	var element=document.getElementById(note);
	element.style.display="block";
	element.removeClass('shadow');
}
/*

var HallType = 'old'

if (HallType = 'old') {
	var div= $('#'+[ABCDEFGHIJKLMNOPQRSTUVWXYZ#&]+'1');
	div.removeClass('hidden');
	} 
	

	*/
	
	
	
	

/*function loadImage(image) {
		$('#images').removeClass('hidden');
		$("#images").html("<img src='"+image+"'/>");
}
	 
function unloadImage() {
		var div= $("#images");
		div.addClass("hidden");
		$("#images").html();
}*/
	 