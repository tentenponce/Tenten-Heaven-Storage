<?php
session_start();
	if (!isset($_SESSION['loggedin'])){
	// User is not logged in, so send user away.
	header("Location:/checklogin.php");
}
$target_dir = "uploads/";
$uploadOk = 1;
$x = count($_FILES["uploadfile"]["name"]);
$y = 0;
$target_file = $target_dir . basename($_FILES["uploadfile"]["name"][$y]);
$fexists = null;

// Check if file already exists
function checkifexists(){
	if (file_exists($GLOBALS['target_file']) && $GLOBALS['fexists'] != null) {
		$GLOBALS['fexists'] = $GLOBALS['fexists'] . ", " . basename($_FILES["uploadfile"]["name"][$GLOBALS['y']]);
		$GLOBALS['uploadOk'] = 0;
	}elseif(file_exists($GLOBALS['target_file'])){
		$GLOBALS['fexists'] = basename($_FILES["uploadfile"]["name"][$GLOBALS['y']]);
		$GLOBALS['uploadOk'] = 0;
	}else{
		$GLOBALS['uploadOk'] = 1;
	}
}
// Check file size
//if ($_FILES["fileToUpload"]["size"] > 500000) {
//   echo "Sorry, your file is too large.";
//    $uploadOk = 0;
//}
while($y < $x){
	$target_file = $target_dir . basename($_FILES["uploadfile"]["name"][$y]);
	
	checkifexists();
	
	if($uploadOk == 1){
		if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"][$y], $target_file)) {
			echo "The file ". basename( $_FILES["uploadfile"]["name"][$y]). " has been uploaded. <BR>";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}else{
		echo "The file ". basename( $_FILES["uploadfile"]["name"][$y]). " was not uploaded. <BR>";
	}
	$y++;
}
?>