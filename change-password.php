<?php session_start();?>
<html>
	<head>
	  <title></title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>
    <a href="welcome.php">Click to go to home page</h1></a>
    <?php
$errMsg=$successMsg="";
include  "connect.php";
 if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    if(isset($_POST["edit_password_button"])){
        if($_POST['confp']!=$_POST['newp']){
            //echo "<script>alert('same message');</script>";
            $errMsg="PIN Mismatch<br/>";
            //echo "<script type='text/javascript'>alert(Password Mismatch)</script>";
        }
        else{
            $email = $_SESSION["user_email"];
            $conn = new mysqli($servername, $username, $password, $dbname);
            $stmt =  $conn->prepare(strtolower("SELECT user_pin FROM tb_user WHERE user_email=? AND user_pin=?"));
            $stmt->bind_param("ss", $email, $pas);
            $pas =sanitize($_POST["oldp"]);
            $stmt->execute();
            if($stmt->fetch()){
                $stmt->close();
                $stmt =  $conn->prepare(strtolower("update tb_user set user_pin =?,login_attempts=? WHERE user_email=?"));
                $stmt->bind_param('sss',$newp,$login_attempts,$email);
                $newp=sanitize($_POST["newp"]);
                $login_attempts="0";
                $stmt->execute();
                $count = $stmt->affected_rows;
                $stmt->close();
                $conn->close();
                $successMsg = "PIN Changed<br/>";
            }
            else{ 
                $stmt->close();
                $conn->close();
                $errMsg="Invalid PIN<br/>";
            }
        }
    }
} 
?>
	<form style="width:50%; margin:50" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <div class="form-group">
    <label for="email">Old PIN (3-digit PIN):</label>
    <small>Please note that the PIN here is your original PIN used during registration Phase</small>
    <input required type="password" minlength="3" maxlength="3" name="oldp" class="form-control" placeholder="eg. 123">
  </div>
  <div class="form-group">
    <label for="pwd">New PIN(3-digit PIN):</label>
    <input type="password" name="newp" required minlength="3" maxlength="3" placeholder="eg. 123" class="form-control" >
  </div>
  <div class="form-group">
    <label for="pwd">Confirm PIN(3-digit PIN):</label>
    <input type="password" name="confp" required minlength="3" maxlength="3" placeholder="eg. 123" class="form-control" >
  </div>
  <span style="color:red"> <?php echo $errMsg;?></span>
<span style="color:green"> <?php echo $successMsg;?></span>
  <button type="submit" name="edit_password_button" class="btn btn-primary">Update PIN</button>
</form>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</body>
</html>

