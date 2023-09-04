<?php session_start();?>
<html>
    <body>
        <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
                body {
                margin: 40px;
                }

                .wrapper {
                display: grid;
                grid-template-columns: 100px 100px 100px 100px;
                grid-gap: 10px;
                background-color: #fff;
                color: #444;
                }

                .box {
                background-color: #444;
                color: #fff;
                border-radius: 5px;
                padding: 10px;
                font-size: 150%;
                }

                </style>
        </head>

            <?php
    include  "connect.php";
    $msg="";
    $pin1=$pin2=$pin3=$pin4="";
    $pin5=$pin6=$pin7=$pin8="";
    $pin9=$pin10=$pin11=$pin12="";
    $pin13=$pin14=$pin15=$pin16="";
    $actual_pin_for_login = "";
    ?>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        if(isset($_POST["verify_button"])){
            try{
                $stmt =  $conn->prepare(strtolower("SELECT * from tb_user WHERE user_email = ?"));
                $stmt->bind_param("s", $email); 
                $email = sanitize($_POST["email"]);
                $stmt->execute();
                if($stmt->fetch()){
                    $_SESSION["user_email"] = $email;
                    $msg = "Please Select Your PIN From Grid";  
                    $stmt->close();
                    $stmt =  $conn->prepare(strtolower("SELECT * FROM tb_user WHERE user_email = ? LIMIT 1")); 
                    $stmt->bind_param("s", $email2); 
                    $email2 = sanitize($_SESSION['user_email']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $value = $result->fetch_object();
                    $user_pin = sanitize($value->user_pin);
                    $user_incremental_factor = sanitize($value->user_incremental_factor);
                    $login_attempts = sanitize($value->login_attempts);
                    $actual_pin_for_login = $user_pin+($user_incremental_factor*$login_attempts);

                    $stmt->close();
                }
                else{
                    $stmt->close();
                    $conn->close();
                    $msg="Invalid Email!";
                }
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
        /////////////////////////////////////////////////
        if(isset($_POST["login_button"])){
            $stmt =  $conn->prepare(strtolower("SELECT * FROM tb_user where user_email=? LIMIT 1")); 
            $stmt->bind_param("s", $email); 
            $email = sanitize($_SESSION['user_email']);
            $stmt->execute();
            $result = $stmt->get_result();
            $value = $result->fetch_object();
            $user_pin = sanitize($value->user_pin);
            $user_incremental_factor = sanitize($value->user_incremental_factor);
            $login_attempts = sanitize($value->login_attempts);
            $stmt->close();
            //code below calculates actual pin based incremental factor and login attemmpts
            $actual_pin_for_login = $user_pin+($user_incremental_factor*$login_attempts); 
            if($_POST['pin']==$actual_pin_for_login){
                $stmt = $conn->prepare(strtolower("UPDATE tb_user SET login_attempts = ? WHERE user_email = ?"));
                    $stmt->bind_param('ss',
                    $new_login_attempts,
                    $email3
                    );
                    $new_login_attempts=$login_attempts+1; // increment login_attempt by 1
                    $email3=sanitize($_SESSION["user_email"]); 
                    $stmt->execute();
                    $count = $stmt->affected_rows;
                    $stmt->close();
                    $conn->close();
                echo "<script> location.href='welcome.php'; </script>";
            }
            else{
                $msg="Invalid PIN!";
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }
           // pin=pin+(fac*attempt)
        }
    }
    ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <input style="width:25%" type="text" class="form-control" name="email" placeholder="email" required />
        <br/>
        <button name="verify_button" class="btn btn-primary">Veirfy Email</button><br/>

    </form>
    <h5><?php echo $msg;?> </h5>
    <div id="grid" class="wrapper">
    <div class="box a"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box b"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box c"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box d"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box e"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box f"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box g"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box h"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box i"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box j"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box k"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box l"><a style="color:white;text-decoration:none" href=""><?php echo $actual_pin_for_login;?></a></div>
    <div class="box m"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box n"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box o"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
    <div class="box p"><a style="color:white;text-decoration:none" href=""><?php echo rand(0,9)."".rand(0,9)."".rand(0,9);?></a></div>
</div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <input style="width:25%" class="form-control" id="pin" name="pin" readonly placeholder="PIN" />
        <br/>
        <button name="login_button" class="btn btn-primary">Login >>></button><br/>

    </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){
    $pin_selected = "";
  $("a").click(function(){
    event.preventDefault();
    $pin_selected = $(this).text();
    $("#pin").val($pin_selected);
    //alert($pin_selected);
  });
});
</script>
</body>
</html>

