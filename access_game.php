<?php 
    $current_stage = $_SESSION['current_stage'];
    //check if current stage, if is odd redirect to game1.php, if is even redirect to game2.php
    if($current_stage % 2 == 0){
        header("Location: rubic.html");
    }else{
        header("Location: ToH.php");
    }
?>