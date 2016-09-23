<?php session_start();?>

<?php 
include 'class.Users.php';
	$usr = new Users('localhost', 'root', '', 'blog');
if($_POST['logout']){
 $usr->userLogout();
	 }
?>


