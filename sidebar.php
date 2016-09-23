<?php session_start();?>
	<div class="container">
		<div id="sidebar">
			<nav>
				<ul>
					<li><a href="http://localhost/<?=$_SESSION['userID']?>">my page</a></li>
					<li><a href="friends.php">friends</a></li>
					<li><a href="#">photos</a></li>
					<li><a href="#">messages</a></li>
					<li><a href="#">settings</a></li>
					<li><a href="search.php">search</a></li>
					<hr>
				</ul>
				<form method="POST" action="index.php">
					<input type="submit" name="logout" value="log out">
				</form>
			</nav>
		</div> <!-- end sidebar -->
		<div id="wrapper">
		</div> <!-- end wrapper -->
	</div> <!-- end container -->