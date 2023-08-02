<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.php"); // Redirect to login page
  exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Account Settings UI Design</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>
  <link rel="stylesheet" type="text/css" href="css/landing.css" />
</head>

<body>
  <div class="container">
    <div class="username">

      <!-- <?php echo $_SESSION['email']; ?>
        <div class="dropdown-content">
          <a>Logout</a>
        </div> -->

      <div class="dropdown">
        <h4 class="text-center">Welcome
          <?php echo $_SESSION['fullname']; ?>
          <div class="dropdown_item">
            <?php
            if (isset($_POST['logout'])) {
              session_destroy();
              header('Location: login.php');
            }
            ?>
            <form method="post">
              <input type="submit" name="logout" value="Logout">
            </form>
          </div>
      </div>
      </h4>
    </div>

    <div class="pointandchart">
      <div class="img-circle text-center mb-3">
        <h6 class="text-center current-points"></h6>
        <img src="images/cart_icon.jpg" alt="Image" class="shadow" onclick="showPoint()" />
      </div>
    </div>
    <br />
    <div class="row stages">
      <!-- <span class="circle passed">1</span>
      <a href="access_game.php"> <span class="circle current">2</span> </a>
      <span class="circle locked">🔒</span> -->
    </div>
  </div>

  <div class="popup-result hidden" id="popup-result">
    <h2>You are having</h2>
    <h6 class="text-center current-points"></h6>
    <!--De cai point vao day-->
    <br>
    <table>
      <tr>
        <th>Dutch Lady</th>
        <th>50 Points</th>
        <th><a href="landing.php">Redeem</a></th>
      </tr>
      <tr>
        <th>Yakult</th>
        <th>20 Points</th>
        <th><a href="landing.php">Redeem</a></th>
      </tr>
      <tr>
        <th>Supreme</th>
        <th>50 Points</th>
        <th><a href="landing.php">Redeem</a></th>
      </tr>
    </table>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/landing.js"></script>
  <script>
    function showPoint() {
      $("#popup-result").removeClass("hidden");
    }
  </script>
</body>

</html>