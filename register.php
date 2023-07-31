<!DOCTYPE html>
<html lang="en">

<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.7.0.js"
		integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

	<div class="bg">
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<form class="login100-form validate-form" method="post"
						action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<span class="login100-form-title p-b-26">
							Welcome
						</span>
						<span class="login100-form-title p-b-48">
							<i class="zmdi zmdi-font"></i>
						</span>

						<div class="wrap-input100">
							<input class="input100" type="text" name="fullname" required>
							<span class="focus-input100" data-placeholder="Full name"></span>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
							<input class="input100" type="text" name="email" required>
							<span class="focus-input100" data-placeholder="Email"></span>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Enter password">
							<span class="btn-show-pass">
								<i class="zmdi zmdi-eye"></i>
							</span>
							<input class="input100" type="password" name="password" required>
							<span class="focus-input100" data-placeholder="Password"></span>
						</div>

						<div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn">
								<div class="login100-form-bgbtn"></div>
								<button class="login100-form-btn">
									Register
								</button>
							</div>
						</div>

						<div class="text-center p-t-115">
							<span class="txt1">
								Have an account already?
							</span>

							<a class="txt2" href="login.php">
								Login
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php
		// Include the database connection file
		require_once 'database/database.php';

		// Check if the form is submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$email = $_POST["email"];
			$password = $_POST["password"];
			$fullname = $_POST["fullname"];
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			// Validate email format
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo "<script>alert('Please enter a valid email address.');</script>";
			}
			// Check if the email is already in use
			else {
				$sql = "SELECT * FROM users WHERE email = '$email'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "<script>
					Swal.fire({
						title: 'Error!',
						text: 'Your email has been used by another account.',
						icon: 'error',
						confirmButtonText: 'OK'
					});
					</script>";
				}
				// Validate password length
				elseif (strlen($password) < 6) {
					echo "<script>
					Swal.fire({
						title: 'Error!',
						text: 'Password must be more than 6 characters.',
						icon: 'error',
						confirmButtonText: 'OK'
					});
					</script>";
				}
				// If all validation passes, proceed with registration
				else {
					// Insert the user into the database
					$sql = "INSERT INTO users (email, full_name, password, points, current_stage) VALUES ('$email', '$fullname', '$hashedPassword', 0, 1)";

					if ($conn->query($sql) === TRUE) {
						echo "<script>
						Swal.fire({
							title: 'Success!',
							text: 'Your account has been created.',
							icon: 'success',
							confirmButtonText: '<a href=\'login.php\'>OK</a>',
						})
						</script>";
					} else {
						echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
					}
				}
			}
		}

		// Close the database connection
		$conn->close();
		?>

		<div id="dropDownSelect1"></div>

		<!--===============================================================================================-->
		<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/animsition/js/animsition.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/bootstrap/js/popper.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/select2/select2.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/daterangepicker/moment.min.js"></script>
		<script src="vendor/daterangepicker/daterangepicker.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/countdowntime/countdowntime.js"></script>
		<!--===============================================================================================-->
		<script src="js/main.js"></script>
	</div>
</body>

</html>