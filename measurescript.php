<?php
session_start();
//exec('calc.exe');



$message = exec('C:\Users\Jakub\AppData\Local\Programs\Python\Python37-32\run.py');
print_r($message);



$_SESSION['message']= '<span style="color:lime;">Measure registered! <br /></span>';
//header('Location: measure.php');

?>