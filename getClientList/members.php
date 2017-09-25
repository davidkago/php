<?php  

//session start
    session_start();
    require('connect.php');
            // check  if the form is submitted or not.
            // if the form is submitted
            if (isset($_POST['username']) and isset($_POST['password'])){
                //assign  values to vars.
                $username = $_POST['username'];
                $password = $_POST['password'];
                // Check if  values are existing in the database or not
                $query = "SELECT * FROM `user` WHERE username='$username' and password='$password'";
                 
                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                $count = mysqli_num_rows($result);
    



            //if  posted values are equal to the database values, then session will be created for the user.
            if ($count == 1){
            $_SESSION['username'] = $username;
            }else{
            //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
            $fmsg = "Invalid Login Credentials.";
            }
            }
            //3.1.4 if the user is logged in Greets the user with message
            if (isset($_SESSION['username'])){
            $username = $_SESSION['username'];
            echo "<h1> Welcome " . $username . "</h1>
            ";
            echo "<h2> Search for clients using id or name </h2><hr /> 
            ";
?>

    <!-- run search script here -->

<form  method="POST">
Search: <input type="text" name="search" placeholder=" Search here ... "/>
<input type="submit" value="Submit" />
</form>

<?PHP

//START SEARCH SCRIPT
            $host = "localhost";
            $user = "app_user";
            $password = "@Pr0c3ss2017";
            $database_name = "clientlist";
            $pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));

            // Search from MySQL  table

            $search=$_POST['search'];
            $query = $pdo->prepare("select * from table_clientlist where id LIKE '%$search%' OR name LIKE '%$search%'  LIMIT 0 , 10");
            $query->bindValue(1, "%$search%", PDO::PARAM_STR);
            $query->execute();

            // Display search result
         if (!$query->rowCount() == 0) 
         {
		 		echo "Search found :<br/>";
				echo "<table style=\"font-family:arial;color:#333333;\">";	
                echo "<tr><td style=\"border-style:solid;border-width:1px;border-color:#98bf21;background:#98bf21;\">Client ID</td><td style=\"border-style:solid;border-width:1px;border-color:#98bf21;background:#98bf21;\">Client Name</td></tr>";				
                    while ($results = $query->fetch()) 
                    {
				echo "<tr><td style=\"border-style:solid;border-width:1px;border-color:#98bf21;\">";			
                echo $results['id'];
				echo "</td><td style=\"border-style:solid;border-width:1px;border-color:#98bf21;\">";
                echo $results['name'];
				
				echo "</td></tr>";				
                    }
				echo "</table>";		
        } 
        else 
        {
            echo 'Nothing found';
        } 


//END OF SEARCH  WOOHOO!-->
echo "<hr /> <a href='logout.php'>Logout</a>";


}else{

//When user has not logged in, then show this -->>>>vvvvvvvvvvv

?>

<html>
    <head>
	   <title>User Login Using PHP & MySQL</title>
	
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

                <link rel="stylesheet" href="styles.css" >

<!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

<body>

    <div class="container">
        <form class="form-signin" method="POST">
            <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
             <h2 class="form-signin-heading">Please Login</h2>
                <div class="input-group">
	               <span class="input-group-addon" id="basic-addon1">@</span>
	                   <input type="text" name="username" class="form-control" placeholder="Username" required>
	           </div>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a>
      </form>
    </div>

</body>

</html>
<?php } ?>