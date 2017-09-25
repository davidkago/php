<?php

	$connection = mysqli_connect('localhost', 'app_user', '@Pr0c3ss2017');
		if (!$connection)
			{
    			die("Database Connection Failed" . mysqli_error($connection));
			}
	$select_db = mysqli_select_db($connection, 'clientlist');
			if (!$select_db)
			{
    			die("Database Selection Failed" . mysqli_error($connection));
			}



?>