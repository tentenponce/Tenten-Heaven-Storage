<html>
<head>
<title>Hello Tenten!</title>
</head>
<body>
<?php
session_start();
if ($_SESSION['loggedin'] != 1){
    // User is not logged in, so send user away.
    header("Location:/checklogin.php");
}else{
	header("Location:/main.php");
}
?>
</body>
</html>