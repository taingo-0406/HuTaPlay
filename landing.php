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
  <link rel="stylesheet" type="text/css"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>
  <link rel="stylesheet" type="text/css" href="css/landing.css" />
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
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
        <button type="button" data-toggle="modal" data-target="#exampleModal">
          <img src="images/cart_icon.png" alt="Image" />
        </button>
      </div>
    </div>
    <br />
    <div class="row stages">
      <!-- <span class="circle passed">1</span>
      <a href="access_game.php"> <span class="circle current">2</span> </a>
      <span class="circle locked">🔒</span> -->
    </div>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Exchange points</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h6 class="text-center current-points"></h6>
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
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
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