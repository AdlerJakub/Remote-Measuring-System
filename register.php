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

if(isset($_POST['rpass']))
{
	$allRight= true;
	
	//testing nick
	$nick=$_POST['nick'];
	$permissions=$_POST['permissions'];
	
	if((strlen($nick)< 3) || (strlen($nick) > 20))
	{
		$allRight= false;
		$_SESSION['e_nick'] = "Nickname must be min 3 char, max 20 char length";
	}
	
	if(ctype_alnum($nick)== false)
	{
		$allRight = false;
		$_SESSION['e_nick']= "Nickname must have only alphanumeric symbols!";
	}
	
	//testing password
	$pass=$_POST['pass'];
	$rpass=$_POST['rpass'];
	
	if((strlen($pass)) <4 || (strlen($pass) > 20))  //length
	{
		$allRight = false;
		$_SESSION['e_pass']= "Password must be <4; 20> characters long";
		
	}
	
	if($pass != $rpass) //same passwords
	{
		$allRight = false;
		$_SESSION['e_pass']= "Both passwords must be the same!";
	}
	
	
	$pass_hash=password_hash($pass, PASSWORD_DEFAULT); //hashing passwords
	
	
	//Bot or not bot, that's a question!
	$secret_key="6Lfoz3QUAAAAAMF28ybJmjgTf8OF-breK6PyJ_QL";
	
	$checkbot= file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
	
	$answer= json_decode($checkbot);
	
	if($answer->success == false)
	{
		$allRight = false;
		$_SESSION['e_bot']= "Confirm reCaptcha";
	}
	
	
	//doubled login
	
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT); //we want to throw exceptions, not showing users errors
	
	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); //conenct with DB
		if($polaczenie-> connect_errno!=0)				//checking errors
		{
			throw new Exception(mysqli_connect_errno());
		}	
		else
		{
			//if that nick exists?
			$result=$polaczenie -> query("SELECT id FROM users WHERE nickname = '$nick'");
			
			if(!$result)
			{
				throw new Exception($polaczenie->error);
				
			}
			else
			{
					$email_number= $result-> num_rows;
					if($email_number > 0)
					{
						$allRight = false;
						$_SESSION['e_nick']= "That account already exists!";
					}
				
			}
			
			if($allRight == true)	
			{
				//everything passed, let's register someone
				if($polaczenie->query("INSERT INTO users VALUES (NULL, '$nick', '$pass_hash', '$permissions')"))
				{
					$_SESSION['Operation_success']= true;
					
				}
				else
				{
				throw new Exception($polaczenie->error);					
					
				}
			}
			
			
			
			
				$polaczenie->close();
		}
		
	}
	catch(Exception $e)
	{
		echo'<span style="color:red;">Server error. Contact with administrator</span> <br />';
		//echo $e;
		
	}
		
}

?>



<!DOCTYPE HTML>
<html lang="pl">


<head>
	<meta charset="utf-8" />
	<title>Plotter panel - Remote control-measuring system of nuclear power plant</title>
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
		if(isset($_SESSION['Operation_success']))
		{
			
			echo '<span style="color:red;">New account created!</span>';
			unset($_SESSION['Operation_success']);
		}
	
	?>
	
	<h3>Adding new worker:</h3>
	
	
	
	<form method = "post">
	Nickname: <br /> <input type="text" name="nick"/> <br />
	<?php
		if(isset($_SESSION['e_nick']))
		{
			echo'<div class="error">'.$_SESSION['e_nick'].'</div>';
			unset($_SESSION['e_nick']);
		}
	?>
	Password: <br /> <input type="password" name="pass"/> <br />
	<?php
		if(isset($_SESSION['e_pass']))
		{
			echo'<div class="error">'.$_SESSION['e_pass'].'</div>';
			unset($_SESSION['e_pass']);
		}
	?>
	Repeat password: <br /> <input type="password" name="rpass"/> <br />	<br />
	
	
	Permission: <select name="permissions">
				<option value="1">User</option>
				<option value="2">Admin</option>		
				</select> <br />
	
	<center><div class="g-recaptcha" data-sitekey="6Lfoz3QUAAAAAKOnS-nkfxARQZiM2OZWoX3I7etT"></div></center>
	
	<?php
		if(isset($_SESSION['e_bot']))
		{
			echo'<div class="error">'.$_SESSION['e_bot'].'</div>';
			unset($_SESSION['e_bot']);
		}
	?>
	
	
	
	
	
	
	<input type="submit" value="Register" class="button"/><br />
	</form>
	
	
	
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