<?php

class Blog extends Mysqli{

function getAllPostsv1($id){
	$query = $this->query("SELECT * FROM `tab4` WHERE `id1` = '$id'");     
  	$row = $query->fetch_array();
    $rv = printf(''.$row['user'].'<p>Личная информация:<br><i>'.$row['article'].'</i><br>');
    return $rv;
   }


function redAllPostsv1($id){
echo $id;
	?>
	<form method="post" >
	<textarea name="newarticle"></textarea><br> 
	<input type="submit" value="enter" name="button2">
	</form>
	<?php
		$newarticle=$_POST['newarticle'];
	$this->query("UPDATE `tab4` SET `article` = '$newarticle' WHERE `id` = '$id' ");    

	?>

     <form enctype="multipart/form-data"  method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file" />
    <input type="submit" value="Send File"  />
    </form>
    <?php     
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
    $uploadfile = 'D:\\Winginx\\home\\localhost\\public_html\\pic\\'.$randName.'.'.$rasshirenie;

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
   $query = $this->query("SELECT `imageLink` FROM `avatars` WHERE `userID` = '{$id}'");
   if($query->num_rows >= 1){
        while($row = $query->fetch_assoc()){
          $img = $row['imageLink'];
        }
    }else{
       return 'http://blog.sokov.org/wp-content/uploads/2012/05/404.jpg';
   }
    return $img;
}
}
?>