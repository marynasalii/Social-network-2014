<?php session_start();?>
<?php include 'head.php';?>
<?php include 'sidebar.php';?>
<?php 
	include 'class.Users.php';
	$usr = new Users('localhost', 'root', '', 'blog');
?>
<div id="wrapper">
	<form method="GET" id="search">
		<p id="title">all your friends are already here</p>
		<input type="text" name="searchData" placeholder="print here" required> 
		<input type="submit" name="search" value="search">
	</form>
<?php

	$usr->searchUsers($_GET,$_SESSION['userID']);
	if(isset($_POST['addtofriends'])){
		$usr->checkIfFriend($_SESSION['userID'], $_SESSION['creator']);
	}
?>
</div>
<?php #include 'footer.php';?>