<!DOCTYPE html>
<html>
<head>

	<?php include("includes/connection.php");
		include("functions/functions.php");
		session_start();
	$logged_user=$_SESSION['user_email'];
	$select_user="select * from users where user_email='$logged_user'";
	$run_user=mysqli_query($con,$select_user);
	$row_user =mysqli_fetch_array($run_user);

	$logged_user_id=$row_user['user_id'];
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
	  	   <input type='datetime-local' name='sdate' required><br><br>
	  	   <input type='submit' name='submit' value='send'>
	     </form>"; 
	      }
	      if(isset($_POST['submit'])){
	      	$msg=htmlentities($_POST['msg']);
	      	$date=htmlentities($_POST['sdate']);

	      	$insert="insert into sched_msg(user_to,user_from,msg_body,msg_date,msg_seen) values ('$user_to','$logged_user_id','$msg','$date','yes')";

	      	$run=mysqli_query($con,$insert);

	      }
?>
  <?php
//retrieving from schedule and comparing with present
   $select ="select * from sched_msg ORDER by msg_date LIMIT 1";
   $run =mysqli_query($con,$select);
   $row=mysqli_fetch_array($run);
   $id=$row['id'];
   $stime=$row['msg_date'];
   $user_to=$row['user_to'];
   $user_from=$row['user_from'];
   $msg_body=$row['msg_body'];
   //$upp="$upload_image";
   	
   $pdate=date("y-m-d H:i");
   if(!$stime==0){
   if(microtime($stime) - microtime($pdate) <= 0){

   	 
   	$insert="insert into user_messages (user_to,user_from,date,msg_body) values('$user_to','$user_from','$stime','$msg_body')";
   	$run =mysqli_query($con,$insert);
   	if($run){
   		$delete="delete from sched_msg where id='$id'";
   		$run_delete=mysqli_query($con, $delete);
   		header("refresh: 1");
   	}
   	else{echo "not updated in posts";}
   }
 }else{
 	exit();
 }



?>
      
	   
	</div>
</div>
</body>
</html>