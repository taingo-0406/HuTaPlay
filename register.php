<?php
session_start();
if (isset($_SESSION['email'])) {
	header("Location: index.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>HuTaPlay Register Page</title>
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
			} else {
				// Check if the email is already in use using prepared statement
				$sql = "SELECT * FROM users WHERE email = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Your email has been used by another account.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    </script>";
				} else {
					// Validate password length
					if (strlen($fullname) > 64) {
						echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Name must be less than 64 characters.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        </script>";
					} elseif (strlen($password) < 6) {
						echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Password must be more than 6 characters.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        </script>";
					} elseif (strlen($password) > 32) {
						echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Password must be less than 32 characters.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        </script>";
					} else {
						// Insert the user into the database using prepared statement
						$insertSql = "INSERT INTO users (email, full_name, password, points, current_stage, role) VALUES (?, ?, ?, 0, 1, 'user')";
						$insertStmt = $conn->prepare($insertSql);
						$insertStmt->bind_param("sss", $email, $fullname, $hashedPassword);

						if ($insertStmt->execute()) {
							echo "<script>
							Swal.fire({
								title: 'Success!',
								text: 'Your account has been created.',
								icon: 'success',
								confirmButtonText: 'OK',
								showConfirmButton: true,
								allowOutsideClick: false, // Disable clicking outside the alert
								allowEscapeKey: false, // Disable using the Esc key
								allowEnterKey: true, // Enable using the Enter key to confirm
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = 'login.php'; // Redirect to login.php
								}
							});
							</script>";
						} else {
							echo "<script>alert('Error');</script>";
						}
					}
				}

				// Close the prepared statement
				$stmt->close();
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