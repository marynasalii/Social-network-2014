<?php include 'sidebar.php';?>

<div id="wrapper">
<?php 
$userData = $usr->getUserDataFromID($userID);
if($userData){
	$ava = $usr->getAvatar($userID);
?>
<div id="avatar"><img src="<?=$ava?>" alt="<?=$userData['full name']?>"></div>
<div id="myinfo">
	<p id="title"><?=$userData['full name']?></p>
	<p>Email: <?=$userData['email']?></p>
	<p>Sex: <?=$userData['sex']?></p>
	<p>Date of birth: <?=$userData['date']?></p>
	
	<form method="POST" enctype="multipart/form-data" class="sendform"> 
		<p>Leave your message here:</p>
		<textarea name="wall" required></textarea><br> 
		<input type="submit" name="wallsubmit" class="submitbutton" value="send"/><br>
	</form>
</div>

<?php       
if($_SESSION['userID'] != $userID){?>
    <form method="POST" class="sendform">
        <textarea type="text" name="message" required></textarea>
        <input type="submit" name="sendbutton" value="send" class="submitbutton">
    </form> 
<?php
	$_SESSION['12']=$userID;
	$usr->checkIfFriend($_SESSION['userID'],$_SESSION['12']);
}
	
 if(isset($_POST['sendbutton'])){
	$_SESSION['12']=$userID;
	$usr->writeMessage($_SESSION['userID'], $_SESSION['12'], $_POST['message']);
}

if(isset($_POST['addtofriends'])){
	$_SESSION['12']=$userID;
	$usr->addFriends($_SESSION['userID'], $_SESSION['12']);
	echo '<script>window.location.reload();</script>';
}

if(isset($_POST['deletefromfriends'])){
	$usr->deleteFriends($_SESSION['userID'],$_POST);
	echo '<script>window.location.reload();</script>';
}

if($_SESSION['userID'] == $userID){  
?>
	<form method="POST">
		<input type="submit" name="deleteprofile" value="delete profile" class="submitbutton">
	</form>	
<?php
if(isset($_POST['deleteprofile'])){
	$usr->deleteProfile($_POST);
	echo '<script>window.location.reload(index.php);</script>';
}
}
$usr->getAllPostsv1($userID);
?>

<?php
if(isset($_POST['wallsubmit'])){
	$_SESSION['12']=$userID;
	$usr->wallWrite($_SESSION['userID'], $_SESSION['12'], $_POST['wall']);
	echo '<script>window.location.reload(index.php);</script>';
}

$usr->stenaIn($_POST);
if($_SESSION['userID'] == $userID){  
	$usr->stenaOut($_POST);
}
}
?>
</div>
