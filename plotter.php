<?php
session_start();
if(!isset($_SESSION['online']))
	{
	header('Location: index.php');
	exit();
	}
require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie-> connect_errno!=0)				//checking errors
			{
			echo "Error".$polaczenie->connect_errno;
			exit();
			}
			
			$query= 'SELECT name FROM devices';
			$result = mysqli_query($polaczenie, $query) or die("Data not found.");
			$total_rows = mysqli_num_rows($result);
			$i=0;
			while($row = mysqli_fetch_array($result)){
			$lista[$i]=$row["name"];
			$i++;
			
		  }
			
	$polaczenie->close();
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">


<head>
	<meta charset="utf-8" />
	<title>Plotter panel - Remote control-measuring system of nuclear power plant</title>
	<script src='timer.js'></script>	
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link rel="stylesheet" href="css/fontello.css" type="text/css"/>	
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower|Lato" rel="stylesheet">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>	
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>	
	<script type="text/javascript" src="plotter.js"></script>
	
	
	
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
		
		<form method="post" >
		Select variable to plot:
		<select name="measureVariable">
				<option value="current">Current</option>
				<option value="voltage">Voltage</option>
				<option value="resistance">Resistance</option>
				<option value="capacity">Capacity</option>
				<option value="diodevoltage">DiodeVoltage</option>
				<option value="bptransistorgain">BPTransistorGain</option>
		</select>
		Select timeaxis to plot:
		<select name="timeaxis">
				<option value="td">today</option>
				<option value="week">1 week</option>
				<option value="month">1 month</option>
				<option value="year">1 year</option>
		</select>
		<br />
		From device(s):
		<select name="device_id">
		<?php
			for($i=0; $i< $total_rows; $i++)
			{
				echo '<option value='.$i.'>'.$lista[$i].'</option>';
				
				
			}
				?>
		</select>
		<br />	
		<br />
		<input type= "submit" value="Plot!" class="button"/>
		</form>
		
		
		
		<?php
		
		if(isset($_POST["timeaxis"]))
		{
			$_SESSION["var"] = $_POST["measureVariable"];
			$_SESSION["time"] = $_POST["timeaxis"];
			echo '<center><div id="chart_div"></div></center>';
			
		}
		
		?>
		
	</div>
	
	
	<div class="nav">
		
		<a href="measure.php"> <div class= "orange-menu"><i class="icon-download"></i><br />Take the measurement</div></a>
		<a href="plotter.php"> <div class= "orange-menu"><i class="icon-chart-bar"></i><br />Plot the chart</div></a>
		<?php	
		if(isset($_SESSION['online']) && $_SESSION['permissions'] == 2)
		{
		echo '<a href= "register.php"> <div class= "orange-menu"><i class="icon-user-plus"></i><br />Add user</div></a>';
		echo '<a href= "adddevice.php"> <div class= "orange-menu"><i class="icon-plug"></i><br />Add device</div></a>';
		}		
		?>
		<a href= "logout.php"><div class= "orange-menu"><i class="icon-logout"></i><br />Log out</div></a>
		
	</div>
	
	<div style="clear:both"> </div>
	<div id="footer">
	All rights reserved. Copyright &copy 2018 by Mateusz Wiśniewski and Jakub Adler
	</div>
	</div>
	
	
</body>

</html>