$(document).ready(function () {
    let current_stage = 0;
    function checkPoints() {
        $.ajax({
            url: 'database/check_current_points.php',
            type: 'GET',
            success: function (data) {
                // Update the text on the page
                $('.current-points').text('Current points: ' + data);
            }
        });
    }
    function checkCurrentStage() {
        $.ajax({
            url: "../hutaplay/database/check_current_discs.php",
            method: "POST",
            dataType: "json",
            success: function (response) {
                if (response != null) {
                    current_stage = response.current_stage;
                    console.log("Current stage: " + current_stage);
                    //append the current stage to the page
                    for (let i = 1; i < current_stage; i++) {
                        $('.stages').append('<span class="circle passed">' + i + '</span>');
                    }
                    $('.stages').append('<a href="access_game.php"> <span class="circle current">' + current_stage + '</span> </a>');
                    $('.stages').append('<span class="circle locked"><i class="fa fa-lock" aria-hidden="true"></i></span>');
                } else {
                    console.log("Error checking current stage.");
                    window.location.href = "landing.php";
                }
            },
            error: function () {
                console.log("Error occurred during AJAX request.");
            },
        });
    }
    checkPoints();
    checkCurrentStage();
});