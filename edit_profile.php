<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
?>
<html>
<head>
	<?php
		$user = $_SESSION['user_email'];
		$get_user = "select * from users where user_email='$user'";
		$run_user = mysqli_query($con,$get_user);
		$row = mysqli_fetch_array($run_user);

		$user_name = $row['user_name'];
	?>
	<title>edit acount settings</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<body>
<div class="row">
	<div class="col-sm-2">
	</div>
	<div class="col-sm-8">
		<form action="" method="post" enctype="multipart">
			<table class="table table-bordered table">
				<tr align="center">
					<td colspan="6" class="active"><h2>Edit Profile</h2></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">First Name</td>
					<td>
						<input class="form-control" type="text" name="f_name" required value="<?php echo $first_name; ?>">
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Last Name</td>
					<td>
						<input class="form-control" type="text" name="l_name" required value="<?php echo $last_name; ?>">
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Username</td>
					<td>
						<input class="form-control" type="text" name="u_name" required value="<?php echo $user_name; ?>">
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Description</td>
					<td>
						<input class="form-control" type="text" name="describe_user" required value="<?php echo $describe_user; ?>">
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Relationship status</td>
					<td>
						<select class="form-control" name="Relationship">
							<option><?php echo"$Relationship_status"; ?></option>
							<option>engaged</option>
							<option>married</option>
							<option>divorced</option>
							<option>single</option>
							<option>in relationship</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Password</td>
					<td>
						<input class="form-control" type="password" name="u_pass" id="mypass" required value="<?php echo $user_pass; ?>">
						<input type="checkbox" onclick="show_password()"><strong>Show password</strong>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Email</td>
					<td>
						<input class="form-control" type="Email" name="u_email" required value="<?php echo $user_email; ?>">
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Country</td>
					<td>
						<select class="form-control" name="u_country">
							<option><?php echo"$user_country"; ?></option>
							<option>USA</option>
							<option>UK</option>
							<option>dubai</option>
							<option>singapoor</option>
							<option>alaskaa</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Gender</td>
					<td>
						<select class="form-control" name="u_gender">
							<option><?php echo"$user_gender"; ?></option>
							<option>male</option>
							<option>female</option>
							<option>others</option>						
						</select>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Birth day</td>
					<td>
						<input class="form-control input-md" type="date" name="u_birthday" required value="<?php echo $user_birthday; ?>">
					</td>
				</tr>

				<!-- forgot password-->
				<tr>
					<td style="font-weight:bold;">Forgoten password</td>	
					<td>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Turn On</button>
						<div id="myModal" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4>Modal header</h4>
									</div>
									<div class="modal-body">
										<form action="recovery.php?id=<?php echo $user_id; ?>"method="post" id="f">
											<strong>ur best friend?</strong>
											<textarea class="form-control" cols="83" rows="4"name="content" placeholder="some one"></textarea><br><td><input type="submit" name="sub" value="SUBMIT" style="width:100px;"><br><br></td>
											<pre>answer the above question ...it will be askde if u  forgot ur<br> password </pre><br><br>
										</form>
										<?php 
											if(isset($_POST['sub'])){
												$bfn=htmlentities($_POST['content']);

												if($bfn == ""){
													echo "<script>alert('enter something')</script>";
													echo "<script>window.opne('edit_profile.php?i_id=$user_id','_self')</script>";
													exit();
												}else{
													$update = "update users set recovery_account ='$bfn' where user_id='$user_id'";
													$run=mysqli_query($con,$update);
													if($run){
														echo "<script>alert('working')</script>";
													echo "<script>window.opne('edit_profile.php?i_id=$user_id','_self')</script>";

													}else{
														echo "<script>alert('error while updating!')</script>";
													echo "<script>window.opne('edit_profile.php?i_id=$user_id','_self')</script>";

													}
												}
											}
										?>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismis="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr align="center">
					<td colspan="6">
					<input type="submit" class="btn btn-info" name="update" style="width:250px;"value="update">
				    </td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-sm-2">
	</div>
</div>
</body>
</html>
<?php 


if(isset($_POST['update'])){

	$f_name=htmlentities($_POST['f_name']);
	$l_name=htmlentities($_POST['l_name']);
	$u_name=htmlentities($_POST['u_name']);
	$describe_user=htmlentities($_POST['describe_user']);
	$Relationship_status=htmlentities($_POST['Relationship']);
	$u_country=htmlentities($_POST['u_country']);
	$u_pass=htmlentities($_POST['u_pass']);
	$u_email=htmlentities($_POST['u_email']);
	$u_gender=htmlentities($_POST['u_gender']);
	$u_birthday=htmlentities($_POST['u_birthday']);

	$update= "update users set f_name='$f_name',l_name='$l_name',user_name='$u_name',describe_user='$describe_user',Relationship='$Relationship_status',user_country='$u_country',user_pass='$u_pass',user_email='$u_email',user_gender='$u_gender',user_birthday='$u_birthday' ";


	$run=mysqli_query($con,$update);
	 if($run){
		echo "<script>alert('your details updated')</script>";
	    echo "<script>window.opne('edit_profile.php?i_id=$user_id','_self')</script>";

		}
}
?>