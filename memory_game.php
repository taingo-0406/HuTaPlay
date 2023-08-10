<?php
    session_start();
    if ($_SESSION['current_stage'] % 2 == 1 || !isset($_SESSION['email'])) {
        header('Location: ToH.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HuTaPlay Memory Game</title>
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="images/hutaplay_icon.png" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/memory_game.css" />
  </head>
  <body>
    <div class="wrapper">
      <div class="stats-container">
        <div id="moves-count"></div>
        <div id="time"></div>
      </div>
      <div class="game-container"></div>
      <button id="stop" class="hide">Stop Game</button>
    </div>
    <div class="controls-container">
      <p id="result"></p>
      <button id="start">Start Game</button>
      <button class="bi bi-house" onclick = "redirectLandingPage()"></button>
      <button class="bi bi-arrow-right-circle-fill" onclick = "redirectRubicPage()"></button>
      <button class="bi bi-trophy-fill" onclick = "redirectLeaderBoard()"></button>
    </div>

    <audio controls autoplay class="audio1">
      <source src="sound/babyshark_memory.mp3" type="audio/mpeg">
    </audio>
    <audio controls class="audio2">
      <source src="sound/winsoundeffect.mp3" type="audio/mpeg">
    </audio>
    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/call_database.js"></script>
    <script src="js/memory_game.js"></script>
    <script>
      function redirectLandingPage() {
        window.location.href = "landing.php"
      }
      function redirectRubicPage() {
        window.location.href = "ToH.php"
      }
      function redirectLeaderBoard() {
        window.location.href="leaderboard.html"
      }
    </script>
  </body>
</html>