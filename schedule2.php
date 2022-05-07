<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh" content="10">
	<title></title>
	<meta charset="utf-8" http-equiv="refresh" content="10">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<body>
  <div class="row">
	<div id="insert_post" class="col-sm-12">
		<center>
		<form action="" method="post" id="f" enctype="multipart/form-data">
		<textarea class="form-control" id="content" rows="4" name="content" placeholder="What's in your mind?"></textarea><br>
		<label class="btn btn-warning" id="upload_image_button">Select Image
		<input type="file" name="upload_image" size="30">
		</label>
		<input type="datetime-local" name="sdate">
		<button id="btn-post" class="btn btn-success" name="sub">Post</button>
		</form>
		<?php insertPost(); ?>
		</center>
	</div>
</div>

</body>
</html>


<?php
 error_reporting(0);
$con = mysqli_connect("localhost","root","","social_network") or die("Connection was not established");

//function for inserting post

function insertPost(){
	if(isset($_POST['sub'])){
		//global $user_id;
		$con = mysqli_connect("localhost","root","","social_network");

		$sdate = htmlentities($_POST['sdate']);
		$content = htmlentities($_POST['content']);
		$upload_image = $_FILES['upload_image']['name'];
		$image_tmp = $_FILES['upload_image']['tmp_name'];
		$random_number = rand(1, 100);

         
        if(strlen($content) > 250){
			echo "<script>alert('Please Use 250 or less than 250 words!')</script>";
			echo "<script>window.open('schedule2.php', '_self')</script>";
		}else{
			if(strlen($upload_image) >= 1 && strlen($content) >= 1){
					
					move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
			    move_uploaded_file($image_tmp, "scheduleposts/$upload_image.$random_number");
			    $insert = "insert into schedule (user_id,post_content,upload_image,post_date,tschedule) values ('2','No','$upload_image.$random_number',NOW(),'$sdate')";

				$run = mysqli_query($con, $insert);

				if($run){
					echo "<script>alert('Your Post updated a moment ago!')</script>";
					echo "<script>window.open('home.php', '_self')</script>";

					$update = "update users set posts='yes' where user_id='2'";
					$run_update = mysqli_query($con, $update);
				}

				exit();
			}else{
				if($upload_image=='' && $content == ''){
					echo "<script>alert('Error Occured while uploading!')</script>";
					echo "<script>window.open('home.php', '_self')</script>";
				}else{
					if($content==''){
						move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
						move_uploaded_file($image_tmp, "scheduleposts/$upload_image.$random_number");
						$insert = "insert into schedule (user_id,post_content,upload_image,post_date,tschedule) values ('2','No','$upload_image.$random_number',NOW(),'$sdate')";
						$run = mysqli_query($con, $insert);

						if($run){
							echo "<script>alert('Your Post updated a moment ago!')</script>";
							echo "<script>window.open('home.php', '_self')</script>";

							$update = "update users set posts='yes' where user_id='2'";
							$run_update = mysqli_query($con, $update);
						}

						exit();
					}else{
						$insert = "insert into schedule (user_id, post_content, post_date,tschedule) values('2', '$content', NOW(),'$sdate')";
						$run = mysqli_query($con, $insert);

						if($run){
							echo "<script>alert('Your Post updated a moment ago!')</script>";
							echo "<script>window.open('home.php', '_self')</script>";

							$update = "update users set posts='yes' where user_id='2'";
							$run_update = mysqli_query($con, $update);
						}
					}
				}
			}
		}
	}
}
//retrieving from schedule and comparing with present
   $select ="select * from schedule ORDER by tschedule LIMIT 1";
   $run =mysqli_query($con,$select);
   $row=mysqli_fetch_array($run);
   $post_id=$row['post_id'];
   $stime=$row['tschedule'];
   $user_id=$row['user_id'];
   $upload_image=$row['upload_image'];
   $post_content =$row['post_content'];
   //$upp="$upload_image";
   	
   $pdate=date("y-m-d H:i");
   if(!$stime==0){
   if(microtime($stime) - microtime($pdate) <= 0){

   	 
   	$insert="insert into posts (user_id,post_content,upload_image,post_date) values('$user_id','$post_content','$upload_image','$stime')";
   	$run =mysqli_query($con,$insert);
   	if($run){
   		$delete="delete from schedule where post_id='$post_id'";
   		$run_delete=mysqli_query($con, $delete);
   		header("refresh: 1");
   	}
   	else{echo "not updated in posts";}
   }
 }else{
 	exit();
 }



?>