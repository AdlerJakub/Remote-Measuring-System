<?php
	session_start();
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name); //conenct with DB
	
	if($polaczenie-> connect_errno!=0)				//checking errors
	{
		echo "Error".$polaczenie->connect_errno;
	}
	else
	{
	$login= $_POST['nick'];
	$haslo= $_POST['pass'];
	
	$login= htmlentities($login, ENT_QUOTES, "UTF-8");
	
	$secret_key="6Lfoz3QUAAAAAMF28ybJmjgTf8OF-breK6PyJ_QL";
	
	$checkbot= file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
	
	$answer= json_decode($checkbot);
	
	if($answer->success==false)
	{
	$_SESSION['error_captcha'] = '<span style="color:red">Confirm reCaptcha!</span>';
	header('Location: index.php');
	exit();
	}	
	if($answer->success==true)
	{
		
		unset($_SESSION['error_captcha']);
		
	}
		if($result=@$polaczenie->query(sprintf("SELECT * FROM users WHERE nickname='%s'",mysqli_real_escape_string($polaczenie, $login))))
		{
			$users_number=$result->num_rows; // tells us if that user exists
			if($users_number > 0)
			{
				$dane=$result->fetch_assoc(); 				//copy for us row of the logged user
				
				if(password_verify($haslo, $dane['password']))
				{
				
					$_SESSION['online'] = true; 				//telling us, that someone is logged in, using in index.php
					
					$_SESSION['id'] = $dane['id'];
					$_SESSION['nickname']= $dane['nickname'];		//throw them to SESSION table
					$_SESSION['password']= $dane['password'];
					$_SESSION['permissions']= $dane['permissions'];
					$permissions= $dane['permissions'];
					$result -> free(); 							//make free our temporary variable
					unset($_SESSION['error_lp']);					//delete "wrong password" comment
					if($permissions == 2) 						// choosing between admin and user
					{
						header('Location: admin.php');
					}
					else
					{
							header('Location: user.php');
					}
				
				}
				else
				{
					$_SESSION['error_lp'] = '<span style="color:red">Incorrect login or password!</span>';
					header('Location: index.php');	
				}
			}
			else
			{
				$_SESSION['error_lp'] = '<span style="color:red">Incorrect login or password!</span>';
				header('Location: index.php');	
			}
		}
		
	$polaczenie->close();	
	}
	
	
	
	
	echo '<a href="index.php"> Main page </a>';
?>