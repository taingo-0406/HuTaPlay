<?php
session_start();
if (isset($_SESSION['email'])) {
	header("Location: landing.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>HuTaPlay Login Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.7.0.js"
		integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/hutaplay_icon.png" />
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
							<img src="images/hutaplay_icon.png" alt="Image" />
						</span>

						<div class="wrap-input100" data-validate="Valid email is: a@b.c">
							<input class="input100" type="text" name="email">
							<span class="focus-input100" data-placeholder="Email"></span>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Enter password">
							<span class="btn-show-pass">
								<i class="zmdi zmdi-eye"></i>
							</span>
							<input class="input100" type="password" name="password">
							<span class="focus-input100" data-placeholder="Password"></span>
						</div>

						<div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn">
								<div class="login100-form-bgbtn"></div>
								<button class="login100-form-btn">
									Login
								</button>
							</div>
						</div>

						<div class="text-center p-t-115">
							<span class="txt1">
								Don’t have an account?
							</span>

							<a class="txt2" href="register.php">
								Sign Up
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
			$email = preg_replace('/\+[^@]*/', '', $email);

			// Validate email and password combination using prepared statement
			$sql = "SELECT * FROM users WHERE email = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {
				$user = $result->fetch_assoc();
				$hashed_password = $user['password'];

				if (password_verify($password, $hashed_password)) {
					// Login successful, create session only if session is not already set
					if (!isset($_SESSION['email'])) {
						$_SESSION['email'] = $email;
						$_SESSION['user_id'] = $user['id'];
						$_SESSION['fullname'] = $user['full_name'];
						$_SESSION['current_stage'] = $user['current_stage'];
						$_SESSION['role'] = $user['role'];
					}

					// Close the statement and the database connection
					$stmt->close();
					$conn->close();

					// Redirect the user to landing.php
					header("Location: landing.php");
					exit; // Stop further execution
				}
			}

			// Close the statement
			$stmt->close();

			// Email and password do not match
			echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Your email and/or password is incorrect.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
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