<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Memory Game</title>
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
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
    </div>
    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/call_database.js"></script>
    <script src="js/memory_game.js"></script>
  </body>
</html>