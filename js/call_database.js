let memory_size = 0;

function saveRecordToDatabase(moves, current_stage) {
    $.ajax({
        url: "../hutaplay/database/save_play_record.php",
        method: "POST",
        data: {
            points: moves * 5,
            stage_id: current_stage,
        },
        success: function (response) {
            $(".pointtext").text("You have received " + response + " points!");
        },
        error: function () {
            console.log("Error occurred during AJAX request.");
        },
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
                discs = response.toh_disk;
                memory_size = response.memory_size;
            } else {
                console.log("Error checking current stage.");
                // window.location.href = "index.php";
            }
        },
        error: function () {
            console.log("Error occurred during AJAX request.");
            // window.location.href = "index.php";
        },
    });
}
//check current page, if it's memory_game then call checkCurrentStage()
if (window.location.pathname == "/hutaplay/memory_game.php") {
    checkCurrentStage();
}
