<?php 
    session_start();

    $current_stage = $_SESSION['current_stage'];
    if($current_stage % 2 == 0){
        header("Location: memory_game.html");
    }else if ($current_stage % 2 == 1){
        header("Location: ToH.php");
    }else {
        header("Location: login.php");
    }
?>