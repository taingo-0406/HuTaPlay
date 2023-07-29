<?php 
    $current_stage = $_SESSION['current_stage'];
    //check if current stage, if is odd redirect to game1.php, if is even redirect to game2.php
    if($current_stage % 2 == 0){
        header("Location: rubic.html");
    }else if ($current_stage % 2 == 1){
        header("Location: ToH.php");
    }else {
        header("Location: login.php");
    }
?>