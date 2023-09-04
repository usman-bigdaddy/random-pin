<html>
	<head>
	  <title>COM315-PHP!</title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>
	<?php
 include  "connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
	if(isset($_POST["reg_button"])){
		$stmt =  $conn->prepare(strtolower("INSERT INTO tb_user VALUES (?, ?, ?,?)"));
        $stmt->bind_param("ssss", $email, $pin,$fac, $login_attempts); 
        $email = $_POST["email"];
        $pin=$_POST["pin"];
        $fac=$_POST["fac"];
		$login_attempts="0";
		$stmt->execute();
		$count = $stmt->affected_rows;
		$stmt->close();
		$conn->close();
		if($count>0){
			echo "<script> location.href='login.php'; </script>";
		}
		else{
			$msg="We could not Register you.Please Try Again"; 
			echo "<script type='text/javascript'>alert('Error');</script>";
		}
	}
}
?>
	<form style="width:50%; margin:50" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" required class="form-control" placeholder="Email" name="email">
  </div>
  <div class="form-group">
    <label for="pwd">PIN(3-digit PIN):</label>
    <input type="password" required minlength="3" maxlength="3" placeholder="eg. 123" class="form-control" name="pin">
  </div>
  <div class="form-group">
    <label for="pwd">Incremental Factor(0-9):</label>
    <input type="number" required placeholder="0-9" minlength="1" maxlength="1" class="form-control" name="fac">
  </div>

  <button type="submit" name="reg_button" class="btn btn-primary">Register</button>
</form>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</body>
</html>

