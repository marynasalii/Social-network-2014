<?php
	session_start();
	include 'head.php';
	error_reporting("E_ALL");
	include 'class.Users.php';
	$usr = new Users('localhost', 'root', '', 'blog');
	if($_POST['sign_up']){
		$state = $usr->userRegister($_POST);
	}elseif($_POST['log_in']){
		$state = $usr->userLogin($_POST);
	}elseif($_POST['logout']){
		$usr->userLogout();
	}
             
	if($_SESSION['userID'] == ''){ 
		include 'registration_head.php'; ?>
		<div class="container"> 
			<ul class="rslides">
				<li><img src="images/first_img.jpg" alt="first img"></li>
				<li><img src="images/second_img.jpg" alt="second img"></li>
				<li><img src="images/third_img.jpg" alt="third img"></li>
			</ul>
			<div id="main">
			<div id="forms">
				<div id="sign_up_form">
						<h2>Join us today</h2>
					<form method="POST">
						<fieldset>
							<label for="full_name">Enter your full name</label>
							<input type="text" name="full_name" id="full_name" required>
						</fieldset>
						<fieldset>
							<label for="sign_up_login">Enter your login here</label>
							<input type="text" name="sign_up_login" id="login" required>
						</fieldset>
						<fieldset>
							<label for="sign_up_password">Create the password</label>
							<input type="password" name="sign_up_password" id="password" required><br>
						</fieldset>
						<fieldset>
							<label for="email">Your mail</label>
							<input type="email" name="email" required><br>
						</fieldset>
						<fieldset>
							<label for="sex">Choose your sex</label>
							<input type="radio" name="sex" value="Man">Man    
							<input type="radio" name="sex" value="Woman">Woman    
						</fieldset>
						<fieldset>
							<label for="date">Choose the date of birth</label>
							<input type="date" name="date" required><br>
						</fieldset>
						<fieldset>
							<input type="submit" name="sign_up" value="Sign up">
						</fieldset>
					</form> 
				</div>	
				<div id="log_in_form">	
					<form method="POST">
						<fieldset>
							<label for="log_in_login">Not new? Log in</label>	
							<input type="text" name="log_in_login" placeholder="enter your login" required><br>
						</fieldset>
						<fieldset>
							<input type="password" name="log_in_password" placeholder="enter your password" required><br>
						</fieldset>
						<fieldset>
							<input type="submit" name="log_in" value="Log in"><br><br>
						</fieldset>
					</form>
				</div>
				</div>
				<div id="welcome">
					<h1>Welcome to my social network!</h1>
					<h3>I`ve got more practise in programming.</h3>
				</div>
			</div>
		</div>
	
	<?php }else{ ?>
		<?php include 'userProfilePage.php';?>        <!-- ТУТ ВИВОДИТЬСЯ СТОРІНКА ПРОФІЛЯ-->
		<?php
		$_SERVER['REQUEST_URI'] = urldecode($_SERVER['REQUEST_URI']);
		$url = explode('/', $_SERVER['REQUEST_URI']);
		$query = $usr->query("SELECT  `id` FROM `users1`");
		$i = '0';
		while($row = $query->fetch_assoc()){
			$array['id'][$i] = $row['id'];
			$i++;
		}
		$userID = preg_replace('/^id/', '', $url['1']);
		if($userID == ''){
			$userID = $_SESSION['userID'];
		}
		if(in_array($userID, $array['id'])){
			$userData = $usr->getUserDataFromID($userID);
			$page = 'userProfilePage.php';
		}else{
			switch($url['1']){
				case 'video':
					$page = 'video.php';
					break;
				default:
					$page = 'home.php';
					break;
			}
		}
			include $page;
		
		}
	
if($userID == ''){
//include 'user.php';
//include 'sidebar.php';
}else{
include 'userProfilePage.php';
}

echo $users;	
echo $state;
?>

<?php
if($_SESSION['userID'] != ''){
include 'footer.php';
}
?>