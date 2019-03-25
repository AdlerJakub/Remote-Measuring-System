function repeat()
	{
	var today = new Date();
	
	var day = today.getDate();
	var month= today.getMonth()+1;
	var year= today.getFullYear();
	var hours= today.getHours();
	var minutes= today.getMinutes();
	var seconds= today.getSeconds();
	
	if(day <10) day= "0"+day;
	if(month <10) month= "0"+month;
	if(hours <10) hours= "0"+hours;
	if(minutes <10) minutes= "0"+minutes;
	if(seconds <10) seconds= "0"+seconds;
	
	document.getElementById("date").innerHTML = "<font size=7>"+hours+":"+minutes+":"+seconds+"</font><br /><font size=5>"+day+"/"+month+"/"+year+"</font>";
	
	setTimeout("repeat()",1000);
	}
	