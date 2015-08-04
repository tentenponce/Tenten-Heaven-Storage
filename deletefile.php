<?php
$delfile = $_GET['del_file'];

if(file_exists($delfile)){
	unlink($delfile);
	header("Location: /main.php");
	die();
}
?>