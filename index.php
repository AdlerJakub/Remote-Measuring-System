<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="pl">


<head>
	<meta charset="utf-8" />
	<title>Main page - Remote control-measuring system of nuclear power plant</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src='timer.js'></script>	
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link rel="stylesheet" href="css/fontello.css" type="text/css"/>	
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower|Lato" rel="stylesheet">

</head>

<body onload="repeat();">
	<div id= "container">
	<div id="header">
		<div id="logo">
			<i class="icon-fork"></i>
			<i class="icon-plug"></i><br />
			<i class="icon-chart-line"></i>
			<i class="icon-thermometer-2"></i>
		</div>
		<div id="slogan">	
			Measure? Sure!	
		</div>	
		<div id="date"></div>	
		<div style="clear:both"> </div>
	</div>
	
	<div class="content">
		
		<h2>Welcome in the most usefull measurement service!</h2>
		
		<table>
		<td align="left" valign="top">
		<h3>Here you can: </h3> </br>
		- operate your remote measuring devices </br>
		- collect results of measurement </br>
		- plot different charts </br>
		- manage permissions and accounts of your workers </br>
		</td>
		<td>
		<img src="tester.png" height=300px  width= 220px></img>
		
		</td>
		</table>
		
		
		
	</div>
	
	
	<div class="nav">
	
		
		<form action="login.php" method="post">
		
			<div class="rectangle-orange">
			<h4>Log in:</h4>
			Nickname:<br>
			<input type="text" name="nick"/>
			<br />
			<br />
			Password:<br />
			<input type= "password" name="pass"/>
			<br />
			<br />
			</div>
			
			
			<div class="g-recaptcha" data-sitekey="6Lfoz3QUAAAAAKOnS-nkfxARQZiM2OZWoX3I7etT"></div>
			<?php
		if(isset($_SESSION['error_lp']))
		{
			echo $_SESSION['error_lp'];
		}
		?>
			<?php
			if(isset($_SESSION['error_captcha']))
			{
			echo $_SESSION['error_captcha'];
			}
			?>
			
			
			
			
			<input type= "submit" value="Log in" class="button"/>
			<br />		
		</form>
	
	</div>
	<div style="clear:both"> </div>
	<div id="footer">
	All rights reserved. Copyright &copy 2018 by Mateusz Wiśniewski and Jakub Adler
	</div>
	
	</div>
</body>

</html>