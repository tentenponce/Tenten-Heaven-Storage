<HMTL>
  <STYLE>
    body {margin:0; background-color: #e1e1e1;}
    td {padding: 6 0 6 3;}
    table {border-collapse: collapse;}
    
    #maintb {background:#e1e1e1;
      box-shadow: 0 5px 10px -5px;
      font-family:calibri;
      margin: 3% 5% 3% 5%;}
    
    a.flink {text-decoration: none;
      color: black;}
      
    td, a {display: block;}
    tr:nth-of-type(odd) {background-color: #d6d6d6;}
    
    tr:hover .datas{background-color:#cacaca;}
    
    .status{
      display: none;
      padding: 5px;
      width: 100%;
      color: black;}

    .progress {
      display: none;
      position: fixed;
      width: 99%;
      border: 1px solid black;
      padding: 5px;
      border-radius: 3px;
      top: 88%;
      height:10%;
      -webkit-transition: display 1s;
      -moz-transition: display 1s;
      transition: display 1s;}
    
    .bar{
      background: #F44336;
      height: 100%;
      width: 0%;
      -webkit-transition: width .3s;
      -moz-transition: width .3s;
      transition: width .3s;}
      
    .percent {
      position: absolute;
      display: inline-block;
      top: 6px;
      left: 48%;
      color: black;
      font-family: calibri;
      font-size: 50px;
      text-shadow: 5px 5px 15px -5px;
      font-weight:bold;
    }
    
    #header {height: 50px;
      background-color: #F44336;
      box-shadow:0px 3px 20px -5px;}
      
    #logo {border-radius:100px;
      float:left;
      height: 30px;
      width: 30px;
      border:1px solid black;
      box-shadow: 1px 1px 5px;
      margin: 8px 15px 0 15px;}
      
    #inputfile {
		display:inline-block;
		margin: 7px 5px 0 7px;}
      
    .tenbutton {background-color: #f1f1f1;
		border-radius: 5px;
		padding: 5px 10px 5px 10px;
		box-shadow: 0px 5px 15px -5px;
		cursor: pointer;
		border: 1px solid black;
		transition: all .5s;}
		
	.tenbutton:hover {background-color: lightblue;}
	 
     #logout {float:right;
      color: black;
      text-decoration: none;
      margin: 7px 15px 0 0;}
   </STYLE>
  <BODY>
      <DIV id="header">
        <FORM action="getfile.php" method="post" enctype="multipart/form-data">
		<?php
			session_start();
			if(!empty($_SESSION['admin'])){
				print "<DIV id='inputfile' class='tenbutton'>
					<INPUT type='file' name='uploadfile[]' multiple='true' style='cursor:pointer;'>
				</DIV>
				<INPUT type='submit' value='OK' class='tenbutton'>";
			}
		?>
          <a href="logout.php" id="logout" class="tenbutton" onclick="return confirm('Logout?')">Logout</a>
        </FORM>
      </DIV>
      <DIV id="maintb">
        <DIV style="padding:15 0 15 0; background-color:#d1d1d1; text-align:center;">
          <FONT size="6" face="calibri" style="font-weight:bold">Tenten's Heaven Storage</FONT>
        </DIV>
        <TABLE width="100.1%">
          <TR style="background-color:#F44336; font-weight:bold;">
            <TD width="40%">File Name</TD>
            <TD width="20%">Type</TD>
            <TD width="20%">Size</TD>
            <TD width="20%">Date Modified</TD>
          </TR>
        </TABLE>
        <DIV style="max-height:300px; height:200px; overflow-x:hidden; overflow-y:auto;">
          <TABLE width="100%" align="center">
          <?php
            
            if (!isset($_SESSION['loggedin'])){
              // check if user is not log in, for the user to log in.
              header("Location:/checklogin.php");
            }else{
              $path = "uploads";
              $dh = opendir($path);
              $i=1;
              while (($file = readdir($dh)) !== false) {
                if($file != "." && $file != ".."){
                  $extn = pathinfo($file, PATHINFO_EXTENSION);
                  $size = formatSizeUnits((filesize($path . "/" . $file)));
                  $datemod = date("M j Y g:i A",filemtime($path . "/" .$file));
                  switch ($extn){
                    case "png": $extn="PNG Image"; break;
                    case "jpg": $extn="JPEG Image"; break;
                    case "svg": $extn="SVG Image"; break;
                    case "gif": $extn="GIF Image"; break;
                    case "ico": $extn="Windows Icon"; break;
                    
                    case "txt": $extn="Text File"; break;
                    case "log": $extn="Log File"; break;
                    case "htm": $extn="HTML File"; break;
                    case "php": $extn="PHP Script"; break;
                    case "js": $extn="Javascript"; break;
                    case "css": $extn="Stylesheet"; break;
                    case "pdf": $extn="PDF Document"; break;
                    
                    case "zip": $extn="ZIP Archive"; break;
                    case "bak": $extn="Backup File"; break;
                    
                    default: $extn=strtoupper($extn) ." File"; break;
                  }
                  print "<TR>
                            <TD width='40.8%' class='datas'><A class='flink' href='$path/$file' target='_BLANK'>$file</A></TD>
                            <TD width='20.3%' class='datas'><A class='flink' href='$path/$file' target='_BLANK'>$extn</A></TD>
                            <TD width='20.3%' class='datas'><A class='flink' href='$path/$file' target='_BLANK'>$size</A></TD>
                            <TD width='13%' class='datas'><A class='flink' href='$path/$file' target='_BLANK'>$datemod</A></TD>
							<TD width='2.6%' class='datas'><A class='flink' href='download.php?download_file=$file' onclick='return confirm(\"Download $file?\")'><IMG width='20px' height='20px' src='images/download_button.png'></IMG></TD>";
				if(!empty($_SESSION['admin'])){
					print  "<TD width='0%' class='datas'><A class='flink' href='deletefile.php?del_file=$path/$file' onclick='return confirm(\"Delete $file?\");'><IMG width='20px' height='20px' src='images/delete_button.png'</A></TD>";
				}
				print "</TR>";
                  $i++;
                }
              }
              closedir($dh);
            }
            
            function formatSizeUnits($bytes){
              if ($bytes >= 1073741824){
                  $bytes = number_format($bytes / 1073741824, 2) . ' GB';
              }elseif ($bytes >= 1048576){
                  $bytes = number_format($bytes / 1048576, 2) . ' MB';
              }elseif ($bytes >= 1024){
                  $bytes = number_format($bytes / 1024, 2) . ' KB';
              }elseif ($bytes > 1){
                  $bytes = $bytes . ' bytes';
              }elseif ($bytes == 1){
                  $bytes = $bytes . ' byte';
              }else{
                  $bytes = '0 bytes';
              }
              
              return $bytes;
            }
          ?>
        </TABLE>
      </DIV>
    </DIV>
    <div class="container">	
	</BODY>
	<div class="status"></div>
	<div class="progress">
		<div class="bar"></div >
		<div class="percent">0%</div >
	</div>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.form.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</HTML>