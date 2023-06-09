<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link rel="stylesheet" type="text/css" href="css/landing.css">
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>HuTaPlay</h1>
            <h1>Welcome <?php echo $_SESSION['email']; ?></h1>
        </div>  
        <!--  -->
    </div>
    <div class="center">
        <div>
            <button onclick="redirectToToh()">Play Tower Of Hanoi</button>
        </div>
        <div>
            <button onclick="redirectToRubic()">Play Rubick</button>
        </div>
        <?php
        if(isset($_POST['logout'])) {
            session_destroy();
            header('Location: login.php');
        }
        ?>

        <form method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>

    <script>
        function redirectToToh() {
            window.location.href = "ToH.html";
        }
        function redirectToRubic() {
            window.location.href = "rubic.html";
        }
    </script>
</body>
</html>