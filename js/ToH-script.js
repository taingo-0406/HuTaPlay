$(document).ready(function () {
  var towers = [
      [[], $(".line1")],
      [[], $(".line2")],
      [[], $(".line3")],
    ],
    moves = 0,
    discs = null,
    current_stage = null,
    hold = null;
  function clear() {
    towers[0][1].empty();
    towers[1][1].empty();
    towers[2][1].empty();
  }

  function drawdiscs() {
    clear();
    for (var i = 0; i < 3; i++) {
      if (!jQuery.isEmptyObject(towers[i][0])) {
        for (var j = 0; j < towers[i][0].length; j++) {
          towers[i][1].append(
            $(
              "<li id='disc" +
                towers[i][0][j] +
                "' value='" +
                towers[i][0][j] +
                "'></li>"
            )
          );
        }
      }
    }
  }

  function init() {
    clear();
    towers = [
      [[], $(".line1")],
      [[], $(".line2")],
      [[], $(".line3")],
    ];
    moves = 0;
    hold = null;
    for (var i = discs; i > 0; i--) towers[0][0].push(i);
    drawdiscs();
    $(".moves").text(moves + " moves");
  }

  function handle(tower) {
    if (hold === null) {
      if (!jQuery.isEmptyObject(towers[tower][0])) {
        hold = tower;
        towers[hold][1].children().last().css("margin-top", "-170px");
      }
    } else {
      var move = moveDisc(hold, tower);
      moves += 1;
      $(".moves").text(moves + " moves");
      if (move == 1) {
        drawdiscs();
      } else {
        alert("You can't place a bigger disc on a smaller one");
      }
      hold = null;
    }

    // if (solved()) $(".moves").text("Solved with " + moves + " moves!");
    if (solved()) {
      // console.log(moves);
      $("#popup-result").removeClass("hidden");
      saveRecordToDatabase();
    }
  }

  function moveDisc(a, b) {
    var from = towers[a][0];
    var to = towers[b][0];
    if (from.length === 0) return 0;
    else if (to.length === 0) {
      to.push(from.pop());
      return 1;
    } else if (from[from.length - 1] > to[to.length - 1]) {
      return 0;
    } else {
      to.push(from.pop());
      return 1;
    }
  }

  function saveRecordToDatabase() {
    $.ajax({
      url: "../hutaplay/database/save_play_record.php",
      method: "POST",
      data: {
        points: moves * 5,
        stage_id: current_stage,
      },
      success: function (response) {
        // Handle the success response
        console.log("Play record saved successfully.");
        console.log(moves);
      },
      error: function () {
        console.log("Error occurred during AJAX request.");
      },
    });
  }

  function solved() {
    if (
      jQuery.isEmptyObject(towers[0][0]) &&
      jQuery.isEmptyObject(towers[1][0]) &&
      towers[2][0].length == discs
    )
      return 1;
    else return 0;
  }

  $(".t").click(function () {
    handle($(this).attr("value"));
  });

  function startGame() {
    $.ajax({
      url: "../hutaplay/database/check_current_discs.php",
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response != null) {
          discs = response.toh_disk;
          current_stage = response.current_stage;
          $(".current-stage").text(current_stage);
          init();
        } else {
          console.log("Error checking current stage.");
          window.location.href = "landing.php";
        }
      },
      error: function () {
        console.log("Error occurred during AJAX request.");
        window.location.href = "landing.php";
      },
    });
  }

  startGame();
});
