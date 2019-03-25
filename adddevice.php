<?php
session_start();
if(!isset($_SESSION['online']))
	{
	header('Location: index.php');
	exit();
	}
if(isset($_SESSION['online']) && $_SESSION['permissions'] != 2)
{
	header('Location: index.php');
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">


<head>
	<meta charset="utf-8" />
	<title>Add device - Remote control-measuring system of nuclear power plant</title>
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
		<?php
		
		
		echo "Welcome, ".$_SESSION['nickname']." !";
		
		
		
		?>
		
		<form method="post">
		
			
			Device name: <br />
			<input type="text" name="nazwa" />
			<br />Write description here:
			<textarea name="description" cols="80" rows="5"></textarea>

			
			
			<input type= "submit" value="Add!" class="button"/>
			
			<?php
			if(isset($_POST["description"]))
			{
				require_once "connect.php";

			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie-> connect_errno!=0)				//checking errors
			{
			echo "Error".$polaczenie->connect_errno;
			exit();
			}
			$description=$_POST["description"];
			$name=$_POST["nazwa"];
			$polaczenie->query("INSERT INTO devices VALUES (NULL, '$description', '$name')");
				
			
			$polaczenie->close();
			unset($_POST["description"]);
			unset($_POST["nazwa"]);
			unset($description);
			unset($name);
			}
			
			
			?>
			
			
			
			<br />		
		</form>
		
		
		
		
		
	</div>
	
	
	<div class="nav">
		
		<a href="measure.php"> <div class= "orange-menu"><i class="icon-download"></i><br />Take the measurement</div></a>
		<a href="plotter.php"> <div class= "orange-menu"><i class="icon-chart-bar"></i><br />Plot the chart</div></a>		
		<a href= "register.php"> <div class= "orange-menu"><i class="icon-user-plus"></i><br />Add user</div></a>
		<a href= "adddevice.php"> <div class= "orange-menu"><i class="icon-plug"></i><br />Add device</div></a>
		<a href= "logout.php"><div class= "orange-menu"><i class="icon-logout"></i><br />Log out</div></a>
		
	</div>
	<div id="footer">
	All rights reserved. Copyright &copy 2018 by Mateusz Wiśniewski and Jakub Adler
	</div>
	</div>
	
	
</body>

</html>