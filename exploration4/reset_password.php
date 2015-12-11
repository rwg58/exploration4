<?php
  //  session_start(); 
//    $error = '';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<?php
    
    //$user_check=$_SESSION['login_user'];

    include 'db.php';
    $connection = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);
        
    $db = mysql_select_db($dbname, $connection);
    if (isset($_POST['passwordDone'])) {
        
        $username = $_POST['username'];
        $newPassword_1=$_POST['newPassword_1'];
        $newPassword_2=$_POST['newPassword_2'];
         
        if ($newPassword_1 == $newPassword_2){
            $new_password = md5(trim($newPassword_2));
            $resetPassword = mysql_query("update newlogin set password='$new_password' where username ='$username'", $connection);
            header("location: reset_successful.php"); 
        
        }else{
            $error = "Password not consistent";
        
        }
    }
    if(isset($_GET['username']) && !empty($_GET['username'])){
        $username = $_GET['username'];
    }
  //  $query = mysql_query("select username, email from newlogin where username='$user_check'", $connection);
//    $array = mysql_fetch_assoc($query);
  //  $name = $array['username'];
    


        mysql_close($connection); 
?>
    <style>
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

   .nav>li{
        margin-left: 20px;
    }
    
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
    </style>
    
<body>
    
    <div class="header">
        <div style="width: 100%; margin: auto; padding: 15px; text-align: right">
                 <ul class="nav navbar-nav" style="float: right;">
                 <li><p><a href="index.php" style="color: white;">Sign in</a></p></li>
                 </ul>
        </div>
    </div>
    
    <!---->

    <form action="reset_password.php" method="post">
        
    <div id="main">
        <div id="subDiv">
            <h2>Password Edit</h2>
            <span class="error"><?php echo $error; ?></span>
            </br>
                <label>Create a password: </label>
                <input id="newPassword_1" name="newPassword_1" placeholder="********" type="password" class="form-control">
                </br>
                <label>Confirm password :</label>
                <input id="newPassword_2" name="newPassword_2" placeholder="********" type="password" class="form-control">
                </br>
                <input type = "hidden" name = "username" value = "<?php echo $username; ?>">
                <input name="passwordDone" type="submit" value="Done" class="form-control btn btn-primary">
        </div>
    </div>
 </form>

</body>
</html>
