<?php 
session_start();
if(isset($_SESSION['nome']))
{
    unset($_SESSION['nome']);
}
header("Location: login.php");
die;