<?php
         
            include 'db.php';
            $connection = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);

            $db = mysql_select_db($dbname, $connection);
            
            if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    
            $email = mysql_escape_string($_GET['email']); 
            $hash = mysql_escape_string($_GET['hash']); 
                 
            $search = mysql_query("SELECT * FROM newlogin WHERE email='$email' AND hash='$hash' AND status=0", $connection); 
                
            $id_row = mysql_fetch_assoc($search);               
            
            $id =$id_row['id'];
                
            $match  = mysql_num_rows($search);
                 
            if($match == 1){
                
                mysql_query("UPDATE newlogin SET status=1 WHERE id='$id' AND status=0");
                header("location: index.php"); 
            
            }else{
                
                echo "<div>The url is either invalid or you already have activated your account.</div>";
    }
                mysql_close($connection);
                 
}           

?>
