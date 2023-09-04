<?php session_start();?>
<html>
	<head>
	  <title></title>	</head>
	<body>

    <h1>Welcome <?php echo  $_SESSION["user_email"];?></h1>
    <a href="change-password.php">Click here to change PIN</h1></a>
  
	</body>
</html>

