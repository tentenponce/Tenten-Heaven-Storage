<HTML>
	<STYLE>
		body {margin:0;
		background-color:#e1e1e1;
		padding-top: 2%;}
      
		form {border:2px solid black;
		padding:20px;
		box-shadow: 0px 5px 15px -5px;
		left: 50%;
    	top: 50%;
    	position: absolute;
    	-webkit-transform: translate3d(-50%, -50%, 0);
    	-moz-transform: translate3d(-50%, -50%, 0);
    	transform: translate3d(-50%, -50%, 0);
    	background-color: #e1e1e1;
			}
			
		#wrongacc {text-align:center;
		font-family:calibri;
		margin:30px 0 0 0;
		paddng:30px 0 0 0;
		background-color:#F44336;
		width: 500px;
		height:30px;
		box-shadow: 5px 5px 10px -5px;
		border-radius: 20px;
		font-weight: bold;}
		
		#submit {background-color: #f1f1f1;
		border-radius: 5px;
		border:1px solid black;
		height:20px;
		box-shadow: 0px 2px 15px -5px;
		transition: all .5s;
		cursor: pointer;}
		
		#submit:hover {background-color:lightblue;}

		#leftsideform , #rightsideform {display:inline-block;}
		#leftsideform {float:left;}
		#rightsideeform {float:right;}
		
		#footer {
		left: 0%;
    	top: 100%;
    	position: absolute;
    	-webkit-transform: translate3d(0%, -100%, 0);
    	-moz-transform: translate3d(0%, -100%, 0);
    	transform: translate3d(0%, -100%, 0);
    	width:100%;}
		
		#source {left: 50%;
			position: absolute;
			-webkit-transform: translate3d(-50%, 0, 0);
			-moz-transform: translate3d(-50%, 0, 0);
			transform: translate3d(-50%, 0, 0);
			text-decoration: none;}
    	
		#copyright {float:right;
		margin: 0 10 10 0;}
     
		#version {float:left;
		margin: 0 0 10 10;}

	</STYLE>
	<BODY>
      <DIV align="center" id="headimg">
        <IMG src="images/error404page.png"></IMG>
      </DIV>
      <FORM name="form1" method="post" action="checklogin.php">
          <DIV id="leftsideform">
            <FONT face="calibri" size="3px">Username: <BR/><BR/>Password: </FONT>
          </DIV>
          <DIV  id="rightsideform">
             <INPUT name="user" type="text" id="username">
            <BR>
            <BR>
            <INPUT name="pass" type="password" id="password">
          </DIV>
          <BR>
          <BR>
          <DIV align="center">
            <INPUT type="submit" id="submit" value="Log In">
          </DIV>
      </FORM>
		<DIV id="footer">
			<FONT id="version" face="calibri">Version 1.0.0</FONT>
			<FONT id="copyright" face="calibri">Copyright Not Found.</FONT>
			<A id="source" href="https://github.com/tentenponce/Tenten-Heaven-Storage">Source: https://github.com/tentenponce/Tenten-Heaven-Storage</A> 
		</DIV>
	</BODY>
</HTML>
<?php
	session_start();
	if (isset($_SESSION['loggedin'])){
	// if the user is log in, skip login. LOL.
		header("Location:/main.php");

	}elseif(!empty($_POST)){
		$host="localhost"; // Host name
		$username="root"; // Mysql username
		$password=""; // Mysql password
		$db_name="tenserver"; // Database name
		$tbl_name="users"; // Table name

		mysql_connect("$host", "$username", "$password")or die("cannot connect");
		mysql_select_db("$db_name")or die("cannot select DB");

		$user = $_POST['user'];
		$pass = $_POST['pass'];

		$user = stripslashes($user);
		$pass = stripslashes($pass);
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		//$sql="SELECT * FROM users WHERE username='" . $user . "' and password='" . $pass . "'";
		$sql="SELECT * FROM $tbl_name WHERE username='$user' and password='$pass'";

		$result = mysql_query($sql);
		$count = mysql_num_rows($result);

		if($count==1 && $user == "tenten"){
			$_SESSION['loggedin'] = 1;
			$_SESSION['admin'] = 1;
			header("Location:/main.php");
		}elseif($count == 1){
			$_SESSION['loggedin'] = 1;
			header("Location:/main.php");
		}else{
			print "
			<DIV align='center'>
        <DIV id='wrongacc'><FONT size='5px'>Username and Password did not matched.</FONT></DIV>
       </DIV>";
		}
	}
?>
