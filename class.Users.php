<?php
class Users extends Mysqli{
	 
	var $salt = 'superSaltForPasswds';
	function userRegister($array){
		// if($array['login'] == '' || $array['passwd'] == ''){
			// return 'Не заполнено одно из обязательных полей!';
			// exit();
		// }
		$array['sign_up_login'] = strip_tags(htmlspecialchars($array['sign_up_login']));
		$date = date('Y-m-d H:i:s');
		$array['sign_up_password'] = crypt($array['sign_up_password'], $this->salt);
		if($this->query("INSERT INTO `users1` (`login`, `passwd`,`full name`, `email`,`sex`,`date`, `rights`) VALUES ('{$array['sign_up_login']}', '{$array['sign_up_password']}', '{$array['full_name']}', '{$array['email']}', '{$array['sex']}', '{$array['date']}', '1')")){
			return '<script>alert("You`re successfully signed up!");</script>';
		}else{
			return '<script>alert("Some mistakes happened!");</script>';
		}
	}
	
	function userLogin($array){
		// if($array['login'] == '' || $array['passwd'] == ''){
			// return 'Не заполнено одно из обязательных полей!';
			// exit();
		// }
		$array['log_in_login'] = strip_tags(htmlspecialchars($array['log_in_login']));
		$array['log_in_password'] = crypt($array['log_in_password'], $this->salt);
		$query = $this->query("SELECT `id` FROM `users1` WHERE `login` = '{$array['log_in_login']}' AND `passwd` = '{$array['log_in_password']}'");
		if($query->num_rows != 0){
			while($row = $query->fetch_assoc()){
				$id = $row['id'];
			}
			$_SESSION['userID'] = $id;
			setcookie('userLogin', $array['log_in_login'], '0', '/', NULL);
			setcookie('userPass', $array['log_in_password'], '0', '/', NULL);
			return '';
		}else{
			return '<script>alert("Some mistakes happened!");</script>';
		}
	}
	
	function userLogout(){
		session_unset();
	}
	
	function userRights(){
	}
	
	function getUserID(){
		if($_COOKIE['log_in_login'] != '' && $_COOKIE['log_in_password'] != ''){
			$id = $this->query("SELECT `id` FROM `users1` WHERE `login` = '{$_COOKIE['log_in_login']}' AND `passwd` = '{$_COOKIE['log_in_password']}'");
			while($row = $id->fetch_array()){
				return $row['id'];
			}
		}
	}

	function getUserInfoFromHerID($id){
		$query = $this->query("SELECT * FROM `users1` WHERE `id` = '$id'");
		if($query->num_rows != '0'){
			while($row = $query->fetch_assoc()){
				$array = $row;
			}
			return $array;
		}else{
			return false;
		}
	}
	
	function outputMessage($array){
		?><p class="mesinout">Sent messages</p>  <?php
		if($query = $this->query("SELECT messages.message, users1.firstname, users1.secondname, messages.date, users1.id FROM messages JOIN users1 ON messages.to=users1.id AND messages.from = '{$_SESSION['userID']}' ORDER BY messages.id DESC")){
			while($row = $query->fetch_array()){
				$ava =$this->getAvatar($row['id']);
				$_SESSION['12']=$row['id'];
				?><a href="http://localhost/<?=$_SESSION['12']?>"><img src="<?=$ava?>"  ></a><br>
				<?php 
				echo '<p>'.' '.$row['firstname'].' '.'<span class="date">'.$row['date'].'</span></p> <span>'.' '.$row['message'].'</span>';
}
}
} 

	function inputMessage($array){
		?><p class="mesinout">incoming messages</p>  <?php
		if($query = $this->query("SELECT messages.message, users1.firstname, messages.date, users1.secondname,users1.id FROM messages JOIN users1 ON messages.from=users1.id AND messages.to = '{$_SESSION['userID']}' ORDER BY messages.id DESC ")){
			while($row = $query->fetch_array()){
				$ava =$this->getAvatar($row['id']);
				$_SESSION['12']=$row['id'];
				?>       <div class="messages"><a href="http://localhost/<?=$_SESSION['12']?>"><img src="<?=$ava?>"  ></a><br>
				<?php 
				echo '<p>'.' '.$row['firstname'].' '.$row['secondname'].' <span class="date">'.$row['date'].'</span></p><span>'.' '.$row['message'].'</span></div>';
}
}
}

	function redAllPostsv1($id){
		$query = $this->query("SELECT * FROM `tab4` WHERE `id1` = '{$_SESSION['userID']}'");     
		$row = $query->fetch_array();
		?>
		<p class="redinfop">Выбери новую аву :</p>
		<form method="post" enctype="multipart/form-data" class="redpost">
		<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
			<!-- Название элемента input определяет имя в массиве $_FILES -->
			<p>Ава :</p>
			<input name="userfile" type="file"  /><br> 
			<p>Статья  :</p>
			<textarea name="newarticle" cols="43" rows="8"  ><?=$row['article']?></textarea><br> <br>
			<input type="submit" value="Обновить" name="jsarticle" /><br><br>
		</form>
		<?php
		$this->query(" INSERT INTO `tab4`( `article` ) VALUES('') "); 
		$newarticle=$_POST['newarticle'];
		if($newarticle !=''){
			$this->query("UPDATE `tab4` SET `article` = '$newarticle' WHERE `id1` = '$id' ");
  }    
		if(isset($_POST['jsarticle'])){
			echo '<script>window.location.reload();</script>';
}
  }

	function getAllPostsv1($id){
		$query = $this->query("SELECT * FROM `tab4` WHERE `id1` = '$id'");     
		$row = $query->fetch_array();
		printf('<div class="newinfo">'.$row['user'].'<span>Article:</span><br><p class="art"><i>'.$row['article'].'</i></p></div><br>');
    //return $rv; //vuvod infu
  }

	function redInfo(){
	$query = $this->query("SELECT * FROM `users1` WHERE `id` = '{$_SESSION['userID']}'");     
  	$row = $query->fetch_array();
	?><p class="redinfop">Введи новые данные :</p><div class="redinfo">
	<form method="post" >
		<p >Имя:</p><input type="text" name="firstname" value="<?=$row['firstname']?>" required ><br>
		<p >Фамилия:</p><input type="text" name="secondname" value="<?=$row['secondname']?>" required ><br>
		<p >Email:</p> <input type="email" name="email" value="<?=$row['email']?>" required ><br>
		<p >Дата рождения :</p><input type="date" name="date" value="<?=$row['date']?>"required ><br><br>
		<input type="submit" name="js" ><br><br><br><br>
	</form> 
	</div>
	<?php
		if($_POST['firstname'] !='' || $_POST['secondname'] !='' ||$_POST['email'] !='' ||$_POST['email'] != ''||$_POST['date'] !='' ){
			$array['firstname']=$_POST['firstname'] ;
			$array['secondname'] = $_POST['secondname'];
			$array['email'] = $_POST['email'];
			$array['date'] = $_POST['date'];
		if($this->query("UPDATE `users1` SET `firstname` = '{$array['firstname']}', `secondname` = '{$array['secondname']}', `email` = '{$array['email']}', `date` = '{$array['date']}' WHERE `id` = '{$_SESSION['userID']}'")){
			//echo 'Інформація успішно оновлена';
	}

}
		if(isset($_POST['js'])){
			echo '<script>window.location.reload();</script>';
}
}

	function getRandomName($length = 16){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
		return $randomString;
}

	function uploadImage($_FILES){
		$blacklist = array(".php", ".phtml", ".php3", ".php4");
		foreach ($blacklist as $item) {
			if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
				echo "We do not allow uploading PHP files\n";
  		}
 	}
		$randName = $this->getRandomName();
		$rasshirenie = explode('.', $_FILES['userfile']['name']);
		$rasshirenie = $rasshirenie['1'];
		$imgpatch = 'http://localhost/pic/'.$randName.'.'.$rasshirenie;
		$uploadfile = 'C:\\OpenServer\\domains\\localhost\\pic\\'.$randName.'.'.$rasshirenie;
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			return $imgpatch;
		} else {
			return false;
 	}
}

	function updateAvatar($file, $id){
		$image = $this->uploadImage($file);
		if($image){
			$query = $this->query("SELECT `userID` FROM `avatars` WHERE `userID` = '{$id}'");
		if($query->num_rows < 1){
			$this->query("INSERT INTO `avatars` (`userID`, `imageLink`) VALUES ('{$id}', '{$image}')");
		}else{
			$this->query("UPDATE `avatars` SET `imageLink` = '{$image}' WHERE `userID` = '{$id}'");
        }
			return 'Аватар успешно обновлён!';
		}else{
			return 'Не всё прошло так гладко...';
    }
}

	function getAvatar($id){
		$query = $this->query("SELECT `imageLink`, `userID` FROM `avatars` WHERE `userID` = '{$id}'");
		if($query->num_rows >= 1){
			while($row = $query->fetch_assoc()){
				$img = $row['imageLink'];
				$id = $row['userID'];
        }
		}else{
			return 'http://blog.sokov.org/wp-content/uploads/2012/05/404.jpg';
   }
		return $img;
}

	function searchUsers($array) {
		$array['searchData'] = strip_tags(htmlspecialchars($array['searchData']));
		$probel = strpos($array['searchData'], ' ');
			if($array['searchData'] == ''){
				return 'Print something';
			}
		//$ns = explode(' ',$array['searchData']);
			if($probel == false){
				echo 'Print name AND surname';
				// if($query = $this->query("SELECT * FROM `users1` WHERE `firstname` LIKE '%{$array['searchData']}%' OR `secondname` LIKE '%{$array['searchData']}%'")){
					// if($query->num_rows == '0'){
						// echo '<p class="nofound">Not found</p>';
				// }
						// while($row = $query->fetch_array()) {
							// if($row['id'] !== $_SESSION['userID']){
								// $ddd=$row['id'];
								// $_SESSION['creator'] = $row['id'];
								// $ava =$this->getAvatar($ddd);
								// ?>      
								<!--<div class="messages"><a href="http://localhost/<?=$ddd?>"><img src="<?=$ava?>"  ></a><br>-->
								 <?php 
								// echo ''.$row['firstname'].' '.$row['secondname'].'<br><br><br><br><br><br></div>';
    // 
							// if($row['id'] == $_SESSION['userID']){
								// echo '<p class="nofound">Никого не найдено</p>';}
			
						// }
// } 	

			}else{
				//if($query = $this->query("SELECT * FROM `users1` WHERE `firstname` LIKE '%".$ns[0]."%' AND `secondname` LIKE '%".$ns[1]."%'")){
				if($query = $this->query("SELECT * FROM `users1` WHERE `full name` LIKE '%{$array['searchData']}%'")){
					if($query->num_rows == '0'){
						echo '<p class="nofound">Not found</p>';
					}
							while($row = $query->fetch_array()) {
								if($row['id'] !== $_SESSION['userID']){
									$ddd=$row['id'];
									$_SESSION['creator'] = $row['id'];
									$ava =$this->getAvatar($ddd);
									?>      
									<div class="messages"><a href="http://localhost/<?=$ddd?>"><img src="<?=$ava?>"  ></a><br>
									<?php 
									echo ''.$row['firstname'].' '.$row['secondname'].'<br><br><br><br><br><br></div>';
								}else{
									echo '<p id="notfound">Not found</p>';
								}if($row['id'] == $_SESSION['userID']){
									echo '<p id="notound">Not found</p>';}
							}
				}
			}
	}

	function writeMessage($array){
		$message = $_POST['message'];
		$date = date('Y-m-d H:i:s');
			if($query = $this->query("INSERT INTO `messages` (`from`, `to`, `message`, `date`) VALUES ('{$_SESSION['userID']}', '{$_SESSION['12']}', '{$message}', '{$date}')")) {
//echo 'Повідомлення відправлено!';
			}else{
//echo 'Повідомлення не відправлено';

}
}

	function checkIfFriend($array){
		$query=$this->query("SELECT `id` FROM `friends` WHERE `from`='{$_SESSION['userID']}' AND `to`='{$_SESSION['12']}' AND `status`='1' OR `from`='{$_SESSION['12']}' AND `to`='{$_SESSION['userID']}' AND `status`='1'");
		if($query->num_rows != '0'){
			?>
			<form method="POST" id="delete">
				<input type="submit" name="deletefromfriends" value="Удалить из друзей">
			</form>
			<?php
  
			}else{
				$query=$this->query("SELECT `id` FROM `friends` WHERE `from`='{$_SESSION['userID']}' AND `to`='{$_SESSION['12']}' AND `status`='0' OR `from`='{$_SESSION['12']}' AND `to`='{$_SESSION['userID']}' AND `status`='0'");
			if($query->num_rows == '0'){	
				?> 
				<div class="myinfo">
				<form method="POST">
					<input type="submit" name="addtofriends" value="Добавить в друзья" class="addtofriends">
				</form></div><?php
}
}
}
	
	function addFriends($array){
		if($query = $this->query("INSERT INTO `friends`(`from`, `to`, `status`) VALUES ('{$_SESSION['userID']}', '{$_SESSION['12']}', '0')")){
//echo 'Ваша заявка надіслана';
}
}

	function myFriends($array){
		if($query = $this->query("SELECT friends.from, users1.firstname, users1.secondname,users1.id FROM friends JOIN users1 ON friends.from=users1.id AND friends.to = '{$_SESSION['userID']}' WHERE `status` = '1'")){
			while($row = $query->fetch_array()){
				$ava =$this->getAvatar($row['id']);
				$_SESSION['12']=$row['id'];
				?>     <div class="messages"> <a href="http://localhost/<?=$_SESSION['12']?>"><img src="<?=$ava?>" ></a><br>
				<?php 
				echo '<p>'.$row['firstname'].' '.$row['secondname'].'</p><br></div>';
}
}
}

	function myFriends1($array){  
		if($query = $this->query("SELECT friends.to, users1.firstname, users1.secondname,users1.id FROM friends JOIN users1 ON friends.to=users1.id AND friends.from = '{$_SESSION['userID']}' WHERE `status` = '1'")){
			while($row = $query->fetch_array()){
				$ava =$this->getAvatar($row['id']);
				$_SESSION['12']=$row['id'];
				?>      <div class="messages"> <a href="http://localhost/<?=$_SESSION['12']?>"><img src="<?=$ava?>" ></a><br>
				<?php 
				echo '<p>'.$row['firstname'].' '.$row['secondname'].'</p><br></div>';
}
}
}

	function newApplication($array){ 
		if($query = $this->query("SELECT friends.from, users1.firstname, users1.secondname,users1.id FROM friends JOIN users1 ON friends.from=users1.id AND friends.to = '{$_SESSION['userID']}' WHERE `status` = '0'")){
			while($row = $query->fetch_array()){
				$ava =$this->getAvatar($row['id']);
				$_SESSION['12']=$row['id'];
				?><div id="new_application"> <a href="http://localhost/<?=$_SESSION['12']?>"><img src="<?=$ava?>" ></a><br>
				<?php 			
				echo '<p>'.$row['full name'].'</p><br></div>';?>
				<form method="POST"  action="Friends.php" id="friends_form">
					<input type="submit" name="accept" value="ACCEPT">
					<input type="submit" name="decline" value="DECLINE">
				</form>
<?php
}
} 
}

	function acceptTheApplication($array){
		if($query = $this->query("UPDATE `friends` SET `status` = '1' WHERE `to` = '{$_SESSION['userID']}'")){
}
}

	function declineTheApplication($array){
		if($query = $this->query("UPDATE `friends` SET `status` = '', `to` = '', `from` = '', `id` = '' WHERE `to` = '{$_SESSION['userID']}' AND `status` = '0'")){	
	}
}

	function getUserDataFromID($userID){
		$query = $this->query("SELECT * FROM `users1` WHERE `id` = '{$userID}'");
		while($row = $query->fetch_assoc()){
			$array = $row;
    }
		return $array;
  }

	function deleteFriends($array){
		if($this->query("DELETE FROM `friends` WHERE (`to` = '{$_SESSION['userID']}' AND `from` = '{$_SESSION['12']}' AND `status` = '1') OR (`from` = '{$_SESSION['userID']}' AND `to` = '{$_SESSION['12']}' AND `status` = '1')")){
			echo 'Друга успішно видалено';
		}else{
		
			echo 'Не вдалося добавити друга'; 		
	}
  }
 
	function deleteProfile($array){
		if($query = $this->query("DELETE FROM `users1` WHERE `id` = '{$_SESSION['userID']}'")){
			echo 'Профіль успішно видалено';
		}else{
			echo 'нічьо не видалилось(((';
}
}

	function wallWrite($array){
		$wall = $_POST['wall'];
		$date = date('Y-m-d H:i:s');
			if($query = $this->query("INSERT INTO `stena` (`from`, `to`, `mes`, `date`) VALUES ('{$_SESSION['userID']}', '{$_SESSION['12']}', '{$wall}', '{$date}')")) {
		echo '<script>alert("Comment was successfully add!")</script>';
			}else{
		echo '<script>alert("Some mistakes happened!")</script>';

}
}

	function stenaOut($array){
		$query = $this->query("SELECT stena.mes, stena.date, users1.full name, users1.id FROM stena JOIN users1 ON stena.from = users1.id AND stena.to = '{$_SESSION['userID']}' ORDER BY stena.id DESC ");     
			while($row = $query->fetch_assoc()){
				$ava =$this->getAvatar($row['id']);
				$_SESSION['12']=$row['id'];
				?>
				<a href="http://localhost/<?=$_SESSION['12']?>"><img src="<?=$ava?>"></a>
				<?php 
				echo '<script>alert("OK!")</script>';
				echo '<div id="wrapper">'.$row['full name'].' '.$row['date'].' '.$row['mes'].'</div>';

  }
}

	function stenaIN($array){
		$query = $this->query("SELECT stena.mes, stena.date,  users1.full name, users1.id FROM stena JOIN users1 ON stena.from = users1.id AND stena.to = '{$_SESSION['12']}' ORDER BY stena.id DESC ");     
			while($row = $query->fetch_assoc()){
				$ava =$this->getAvatar($row['id']);
				$_SESSION['12']=$row['id'];
				?>  
				<a href="http://localhost/<?=$_SESSION['12']?>"><img src="<?=$ava?>"></a>
				<?php 
				echo '<script>alert("OK!")</script>';
				echo '<div id="wrapper">'.$row['full name'].' '.$row['date'].' '.$row['mes'].'</div>';
  }
}
}
?>