<div id="sidebar"></div>
<div id="wrapper>"
<?php 
$userData = $usr->getUserInfoFromHerID($_SESSION['userID']);
if($userData){
	$ava = $usr->getAvatar($_SESSION['userID']);
	?>
<div class="myimg">	
	
	<br>
	<img src="<?=$ava?>" alt="<?=$userData['firstname']?>">
	<br>
</div>
<div class="myinfo">
<p></p>
	<p><b><?=$userData['firstname']?> <?=$userData['secondname']?></b></p>
	<p><span>Мыло : </span><?=$userData['email']?></p>
	<p><span>Пол : </span><?=$userData['sex']?></p>
	<p><span>Дата рождения : </span><?=$userData['date']?></p>
	<br>
	<br>
</div>
	<?php
	$usr->getAllPostsv1($_SESSION['userID']);
}
?>
</div>