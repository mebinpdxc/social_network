<!DOCTYPE html>
<html>
<head>

	<?php include("includes/connection.php");
	 ?>

	<title>schedule message</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<body>
<div class="row">
	<div class="col-sm-4">
		<?php 
			$user="select * from users";

			$run_user=mysqli_query($con, $user);
			while($row_user = mysqli_fetch_array($run_user)){

				$user_id = $row_user['user_id'];
				$user_name = $row_user['user_name'];
				$first_name = $row_user['f_name'];
				$last_name = $row_user['l_name'];
				$user_image = $row_user['user_image'];


				echo "
					<div class='container-fluid'>
						<a href='schedule_msg.php?u_id=$user_id' style='text-decoration: none;cursor: pointer; color: #3897F0;'>
							<img class='img-circle' src='users/$user_image' width='90px' height='90px' title='$user_name' ><strong>&nbsp $first_name $last_name</strong><br><br>
						</a>
					</div>
				";
			}
		?>

	</div>
	<div class="col-sm-8">

		<?php  
			if(isset($_GET['u_id'])){
			$user_to=$_GET['u_id'];
			$select="select * from users where user_id=$user_to";
			$run=mysqli_query($con,$select);
			$row=mysqli_fetch_array($run);
			$user_image=$row['user_image'];
			$first_name=$row['f_name'];
			$last_name=$row['l_name'];
		echo "
		  <img class='img-circle' src='users/$user_image' width='90px' height='90px' title='$user_name' ><strong>&nbsp $first_name $last_name</strong><br><br>
	     <form action='' method='post'>
	  	   <textarea name='msg' required></textarea><br><br>
	  	   <input type='datetime-local' name='date' required><br><br>
	  	   <input type='submit' name='submit' value='send'>
	     </form>"; 
	      }
?>
      <?php

			  $user=$_SESSION["user_email"];
		      $select_user="select * from users where user_email='$user'";
		      $run_user=mysqli_query($con,$select_user);
		      $row_user=mysqli_fetch_array($run_user);

             $user_from= $row_user['user_id'];

            if(isset($_POST['submit']))
            {
            	
	       	$msg=htmlentities($_POST['msg']);
	     	$date=htmlentities($_POST['date']);

	     	$insert="insert into sched_msg(user_to,user_from,msg_body,msg_seen,msg_date) values ('$user_to','$user_from','$msg','yes','$date')";

	     	$run=mysqli_query($con,$insert);
	     	if($run){
	     		echo "succes";
	     	}
	     }
	   ?>
	</div>
</div>
</body>
</html>