<!DOCTYPE html>
<html lang="en">
<head>
	<title>LOGIN</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="util.css">
	<link rel="stylesheet" type="text/css" href="main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg.jpg');">
			<div class="wrap-login100 p-t-120 p-b-30">
				<form action="login_auth.php" method="post" name="form_login" class="login100-form validate-form">
					<?php 
						if(isset($_SESSION['eror'])){
					?>
						<div class='container'>	
							<div class = 'alert alert-danger'>
								<span>
									<center>Mungkin Akun Anda Salah Atau Belum Divalidasi</center>
								</span>
							</div> 
						</div>
					<?php 
						unset($_SESSION['eror']);
						}
					?>
					<div class="login100-form-avatar">
						<img src="images/basket.png" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						<h1>ephone</h1>
					</span>
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button type="submit" name="btn_login" class="login100-form-btn">
							Login
						</button>
					</div>
					<?php 
						if(isset($_SESSION['username'])){
					?>
					<div class="text-center w-full">
						<a class="txt1" href="logout.php">
							Log Out
							<i class="fa fa-long-arrow-right"></i>						
						</a>
					</div>
					<?php
						} else {
					?>
					<?php
						}
					?>
					<div class="text-center w-full p-t-10">
    					<a class="txt1" href="daftar.php">
        					Belum punya akun? Daftar di sini.
    					</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script> 
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
