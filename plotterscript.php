<?php
	session_start();
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie-> connect_errno!=0)				//checking errors
			{
			echo "Error".$polaczenie->connect_errno;
			exit();
			}
			
			$query= 'SELECT id, value, date FROM '.$_SESSION["var"];
			//echo $query;
			$result = mysqli_query($polaczenie, $query) or die("Data not found."); 
			
			
			echo "{ \"cols\": [ {\"id\":\"\",\"label\":\"Name-Label\",\"pattern\":\"\",\"type\":\"string\"}, {\"id\":\"\",\"label\":\"Value\",\"pattern\":\"\",\"type\":\"number\"} ], \"rows\": [ ";
			$total_rows = mysqli_num_rows($result);
		  $row_num = 0;
		  while($row = mysqli_fetch_array($result)){
			$row_num++;
			if ($row_num == $total_rows){
			  echo "{\"c\":[{\"v\":\"" . $row['id'] . "-" . $row['date'] . "\",\"f\":null},{\"v\":" . $row['value'] . ",\"f\":null}]}";
			} else {
			  echo "{\"c\":[{\"v\":\"" . $row['id'] . "-" . $row['date'] . "\",\"f\":null},{\"v\":" . $row['value'] . ",\"f\":null}]}, ";
			}
		  }
		  echo " ] }";
				
			$polaczenie->close();
			
			
		
			
	
	
	
?>


