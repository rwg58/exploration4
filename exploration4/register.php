<?php
    session_start(); 
    $error='';

?>
<?php
    
    if (isset($_POST['CreateAccount'])) {
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['username']) || empty($_POST['password_1']) || empty($_POST['password_2']) || empty($_POST['email'])) 
        {
            $error = "Please enter all information required";
        }
        else{
        
        $firstname=$_POST['firstname'];
        $middlename=$_POST['middlename'];
        $lastname=$_POST['lastname'];
        $username=$_POST['username'];
        $password_1=$_POST['password_1'];
        $password_2=$_POST['password_2'];
        $email=$_POST['email'];
        

        include 'db.php';
        $connection = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);

        $firstname = stripslashes($firstname);
        $middlename = stripslashes($middlename);
        $lastname = stripslashes($lastname);
        $username = stripslashes($username);
        $password_1 = stripslashes($password_1);
        $password_2 = stripslashes($password_2);
        $email = stripslashes($email);
        
        $firstname = mysql_real_escape_string($firstname);
        $middlename = mysql_real_escape_string($middlename);
        $lastname = mysql_real_escape_string($lastname);
        $username = mysql_real_escape_string($username);
        $password_1 = mysql_real_escape_string($password_1);
        $password_2 = mysql_real_escape_string($password_2);
        $email = mysql_real_escape_string($email);
        
        $password = md5(trim($password_2));
            
        $db = mysql_select_db($dbname, $connection);
            
        $check_username_exist = mysql_query("SELECT * FROM newlogin WHERE username = '$username'");
        $rows = mysql_num_rows($check_username_exist);
            
   
        if ($rows > 0)
        {
            $error = "The username has already existed, please try another";
        
        }else{
            
  
            if ($password_1 == $password_2){
                
                $query = "INSERT INTO newlogin (firstname, middlename, lastname, username, password, email) VALUES ('$firstname', '$middlename', '$lastname', '$username', '$password', '$email')";
                
                $data = mysql_query($query);
                
                $select_id=mysql_query("SELECT id FROM newlogin WHERE username='$username'", $connection);
                $id_row = mysql_fetch_assoc($select_id);
                
                $id =$id_row['id'];
                $hash = md5(trim($id));
                $insert_hash_id=mysql_query("UPDATE newlogin SET hash = '$hash' WHERE id='$id'", $connection);
                
                if (!empty($data)){
                $to = $email; 
                $subject = "Verification";  
                $message = "
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: $username
Password: $password_2
------------------------
 
Please click this link to activate your account:
http://muresearch.missouri.edu/DEVELOPERS/ruirui/verify.php?hash=$hash&email=$email
 
"; 
                     
                $headers = "From: Admin\r\n";

                if (mail($to, $subject, $message, $headers)){
                
                    $verify_info = "Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.";
                    $firstname='';
                    $middlename='';
                    $lastname='';
                    $username='';
                    $password_1='';
                    $password_2='';
                    $email='';
            
                }
                }
            
               // $_SESSION['login_user']=$username; 
            //    header("location: profile.php"); 
                
            }
            else{
                $error = "Password are not consistent";
            }
                    mysql_close($connection); 
        }
        }
        }
       
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<style>
    
    #user_register{
        width: 300px;
        heigh: 800px;
        margin: 100px;
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
    <div class="header">
        <div style="width: 100%; margin: auto; padding: 15px; text-align: right">
                 <ul class="nav navbar-nav" style="float: right;">
                 <li><p><a href="index.php" style="color: white;">Sign in</a></p></li>
                 </ul>
        </div>
    </div>
        <form action="register.php" method="POST">
        <div id = "user_register">
            <span class="error"><?php echo $error; ?></span>
            <span class="error"><?php echo $verify_info; ?></span>
		<div class="form-group" >
            <label for="username" class="control-label">Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First" value="<?php echo $firstname;?>">
			</br>
            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle(optional)" value="<?php echo $middlename;?>">
            </br>
			<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last" value="<?php echo $lastname;?>">
        </div>
        <div class="form-group" >
            <label for="username" class="control-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="pawprint" value="<?php echo $username;?>">
        </div>
        <div class="form-group" >
            <label for="password" class="control-label">Create a password</label>
            <input type="password" class="form-control" id="password_1" name="password_1" placeholder="password" value="<?php echo $password_1;?>">
        </div>
        <div class="form-group" >
            <label for="password" class="control-label">Confirm password</label>
            <input type="password" class="form-control" id="password_2" name="password_2" placeholder="password" value="<?php echo $password_2;?>">
        </div>
        <div class="form-group" >
            <label for="email" class="control-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" value="<?php echo $email;?>">
        </div>
        
        <div>
            
            <input type="submit" class="btn btn-primary" id="newAccount" name="CreateAccount">
        
        </div>
        </div>
        </form>
    </body>
    
</html>
