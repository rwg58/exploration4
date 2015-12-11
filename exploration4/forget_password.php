<?php

    if (isset($_POST['continue'])) {
    
    if (empty($_POST['email'])) {
        $error = "Please enter a valid email.";
    }
    else
    
    {
        $email=$_POST['email'];

        include 'db.php';
        $connection = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);

        $email = stripslashes($email);
        $email = mysql_real_escape_string($email);
        
       // $md5_password = md5(trim($password));
        

        $db = mysql_select_db($dbname, $connection);

        $query = mysql_query("select username from newlogin where email='$email'", $connection);
        $rows = mysql_num_rows($query);
        $new_query = mysql_fetch_assoc($query);

        $username =$new_query['username'];
        
   //     $m = rand(0,1000);
     //   $hash = md5($m);
        
    //    $squery = mysql_query("update newlogin set password='$hash' where email='$email'", $connection);
        
        if($rows > 0){
                $to = $email; 
                $subject = "Reset your password";  
                $message = "
 
                        Please use the username and password, 

 
                        Please click this link to reset your password:
                        http://muresearch.missouri.edu/DEVELOPERS/ruirui/reset_password.php?username=$username
 
                    "; 
                     
                $headers = "From: Admin\r\n";

                if (mail($to, $subject, $message, $headers)){
                
                    $error = "Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.";
                    $email='';
            
                }
        }else{
            $error = "The account does not exsit, please register";
        
        }
                
        mysql_close($connection); 
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<style>

#subDiv {
    width:380px;
    float:left;
    border-radius:2px;
    border:2px solid #ccc;
    padding:10px 40px 25px;
    margin-top:70px;
}
#main {
    width:960px;
    margin:50px auto;

}
    .header{
        position: relative;
        height:60px;
        z-index:2;
        margin:0 auto;
        padding:0 40px;
        background:#222;
        background: -moz-linear-gradient(0% 100% 90deg, #2b5797, #2b5797);
        background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#2b5797), to(#2b5797));
        border:1px solid #111;
        -webkit-border-radius:4px 4px 0 0;
        -moz-border-radius:4px 4px 0 0;
        border-radius:4px 4px 0 0;
        -moz-box-shadow:inset 0 1px 0 0 #383838, 0 1px 6px 0  rgba(0,0,0,0.2);
        -webkit-box-shadow:inset 0 1px 0 0 #383838, 0 1px 4px 0  rgba(0,0,0,0.2);
    

    } 
    
</style>

<body>
    <form action="forget_password.php" method="post">
    <div class="header">
        <div style="width: 100%; margin: auto; padding-top: 15px; text-align: left">
            <a href="index.php"><span class="glyphicon glyphicon-chevron-left" style="color: white;"></span></a>
	    
        </div>
    </div>
    <div id="main">
        
        <div id="subDiv">
            <h2>Password assistance</h2>
            <p>Enter the email address associated with your account, then click continue. We'll send you a link to page where you can easily create a new password.</p>
            <span class="error"><?php echo $error; ?></span>
            </br>
                <label>Email :</label>
                <input id="email" name="email" placeholder="email" type="email" class="form-control" >
                </br>
                <input name="continue" type="submit" value=" Continue " class="form-control btn btn-primary">
 
            </form>
        </div>
    </div>

</body>
</html>
