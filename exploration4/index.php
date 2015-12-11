<?php
session_start(); 
$error=''; 
?>
<?php

if(!empty($_SESSION['login_user'])){
    header("location: profile.php");
}


    if (isset($_POST['Login'])) {
    
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    }
    else
    
    {
        $username=$_POST['username'];
        $password=$_POST['password'];

        include 'db.php';
        $connection = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);

        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);
        
        $md5_password = md5(trim($password));
        

        $db = mysql_select_db($dbname, $connection);

        $query = mysql_query("select * from newlogin where password='$md5_password' AND username='$username'", $connection);
        $rows = mysql_num_rows($query);
        
        $select_status = mysql_fetch_assoc($query);

        $login_status =$select_status['status'];
        
        if ($rows == 1 && $login_status == 1) {
            
            $_SESSION['login_user']=$username; 
            header("location: successful.php"); 
        } 
        else if ($rows == 1 && $login_status == 0){
            $error = "Your account has not been actived";
        
        }
        
        else if ($rows == 0)
        {
            
            $error = "Username or Password is invalid";
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

#login {
    width:380px;
    float:left;
    border-radius:2px;
    border:2px solid #ccc;
    padding:10px 40px 25px;
    margin-top:70px;
}
#main {
  
    width:960px;
    margin:auto;
    position: fixed;
        top: 10%;
        left: 35%;

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
    <form action="index.php" method="post">
    <div class="header">
        <div style="width: 100%; margin: auto; padding-top: 15px; text-align: left">
            <span class="glyphicon glyphicon-chevron-left" style="color: white;"></span>
        </div>
    </div>
    <div id="main">
        
        <div id="login">
            <h2>Login</h2>
            
                <label>Username :</label>
                <input id="name" name="username" placeholder="username" type="text" class="form-control" value="<?php echo $username; ?>">
                </br>
                <div>
                    <label>Password :</label>
                    <p style="float: right;"><a href="forget_password.php">Forget your password?</a></p>
                </div>
                <input id="password" name="password" placeholder="password" type="password" class="form-control">
                </br>
                <span class="error"><?php echo $error; ?></span>
                </br>
                <a href="register.php" style="margin-right: 15px; margin-left: 15px">Create account</a>
                <input name="Login" type="submit" value=" Login " class="btn btn-primary" style=" width: 115px; float: right">
                
               
            </form>
        </div>
    </div>

</body>
</html>
