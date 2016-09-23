<?php session_start();?>
<?php include 'head.php';?> 
<?php include 'sidebar.php';?>
<?php 
	include 'class.Users.php'; //щоб можна було викликати ф-ї нижче
	$usr = new Users('localhost', 'root', '', 'blog');
?>
<div id="wrapper">
		<p id="title">My friends</p>
<?php
	$usr->newApplication($_SESSION['userID']);
	if(isset($_POST['decline'])){
		$usr->declineTheApplication($_SESSION['userID'],$_POST);
		echo '<script>window.location.reload();</script>';
	}
	if(isset($_POST['accept'])){
		$usr->acceptTheApplication($_SESSION['userID'],$_POST);
		echo '<script>window.location.reload();</script>';
	}
	$usr->myFriends($_SESSION['userID']);
	$usr->myFriends1($_SESSION['userID']);
?>
</div>
<?php #include 'footer.php';?>