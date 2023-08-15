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
  <title>HuTaPlay HomePage</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
  <link rel="stylesheet" type="text/css"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>
  <link rel="stylesheet" type="text/css" href="css/landing.css" />
  <link rel="icon" type="image/png" href="images/hutaplay_icon.png" />
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
              exit;
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
        <button type="button" class="cartbtn" data-toggle="modal" data-target="#exchangeModal">
          <img src="images/cart_icon.png" alt="Image" />
        </button>
        <button type="button" class="historybtn" data-toggle="modal" data-target="#historyModal">
          <img src="images/history_icon.png" alt="Image" />
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
    <div class="modal fade" id="exchangeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
            <table id="gifts">
              <tr>
                <th>Gift</th>
                <th>Cost (points)</th>
                <th><a href="index.php">Exchange</a></th>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Exchange history</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table id="code-exchanged">
              <tr>
                <th>Gift</th>
                <th>Cost (points)</th>
                <th>Code exchanged</th>
                <th>Copy</th>
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

  <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <audio id="audio" controls autoplay>
            <source src="sound/landing.mp3" type="audio/mpeg">
          </audio>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <button class="trophy_btn" onclick="redirectLeaderBoard()">
    <img src="images/trophy_icon.png" alt="Image" />
  </button>

  <button class="setting_btn" data-toggle="modal" data-target="#settingModal">
    <img src="images/setting_icon.png" alt="Image" />
  </button>


  <div class="popup-setting hidden" id="popup-setting">

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/landing.js"></script>
  <script>
    function redirectLeaderBoard() {
      window.location.href = "leaderboard.html"
    }

  </script>

</body>

</html>