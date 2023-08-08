

<!DOCTYPE html>
<html>

<head>
  <title>HuTaPlay Towers of Hanoi</title>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/ToH-style.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>
  <link rel="icon" type="image/png" href="images/hutaplay_icon.png" />
</head>

<body>
  <div id="canvas">
    <div id="title">
      <h1>Towers Of Hanoi - Stage <i class = "current-stage"></i></h1>
      <h3>You need to move all disks in column 1 to column 3 in ascending order</h3>
    </div>
    </br>
    <div class="moves"></div>
    </br>
    </br>
    <div id="towers">
      <div class="t" value="0">
        <ul id="t1" value="0" class="base">
          <ul class="line1">
          </ul>
        </ul>
      </div>
      <div class="t" value="1">
        <ul id="t2" value="1" class="base">
          <ul class="line2"></ul>
        </ul>
      </div>
      <div class="t" value="2">
        <ul id="t3" value="2" class="base">
          <ul class="line3"></ul>
        </ul>
      </div>
    </div>
    </br>
    </br>
    </br>

    <div class="popup-result hidden" id="popup-result">
      <h2>CONGRATULATION!</h2>
      <p>You have solved this level in <i class = "totalmoves"></i></p>
      <p class = "pointtext"></p>
      <!--De cai point vao day-->
      <br>
      <button class="bi bi-house" onclick = "redirectLandingPage()"></button>
      <button class="bi bi-arrow-right-circle-fill" onclick = "redirectRubicPage()"></button>
      <button class="bi bi-trophy-fill" onclick = "redirectLeaderBoard()"></button>
    </div>
<!-- </br>
    <div id="solve">
      <button type="button" class="buttons">Solve</button>
    </div>
-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/call_database.js"></script>
    <script src="js/ToH-script.js"></script>
    <script>
      function redirectLandingPage() {
        window.location.href = "landing.php"
      }
      function redirectRubicPage() {
        window.location.href = "memory_game.php"
      }
      function redirectLeaderBoard() {
        window.location.href="leaderboard.html"
      }
    </script>
  </div>
</body>

</html>