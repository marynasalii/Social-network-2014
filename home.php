<?php session_start();?>
<?php include 'header.php';?>

<?php 

include 'class.Users.php';
	$usr = new Users('localhost', 'root', '', 'blog');

?>
<div class="wraper" >
<form method="POST">
			<input type="submit" name="logout" value="logout">
			
		</form> 
<?php
include 'user.php';
?>


</div>
<?php include 'footer.php';?>