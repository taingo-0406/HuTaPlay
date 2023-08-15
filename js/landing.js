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
            url: "database/check_current_discs.php",
            method: "POST",
            dataType: "json",
            success: function (response) {
                if (response != null) {
                    current_stage = response.current_stage;
                    for (let i = 1; i < current_stage; i++) {
                        $('.stages').append('<span class="circle passed">' + i + '</span>');
                    }
                    if (current_stage < response.max_stage) {
                        $('.stages').append('<a href="access_game.php"> <span class="circle current">' + current_stage + '</span> </a>');
                        $('.stages').append('<span class="circle locked"><i class="fa fa-lock" aria-hidden="true"></i></span>');
                    } else if (current_stage == response.max_stage) {
                        $('.stages').append('<h1> You have finished all stages for now! </h1>');
                    }
                } else {
                    console.log("Error checking current stage.");
                    window.location.href = "index.php";
                }
            },
            error: function () {
                console.log("Error occurred during AJAX request.");
            },
        });
    }
    function checkAvailableGifts() {
        $.ajax({
            url: 'database/check_available_gifts.php',
            type: 'GET',
            success: function (data) {
                gifts = JSON.parse(data);
                console.log(gifts);
                for (i = 0; i < gifts.length; i++) {
                    row = $('<tr></tr>');
                    row.append('<td>' + gifts[i].name + '</td>');
                    row.append('<td>' + gifts[i].cost + '</td>');
                    redeemButton = $('<td><button>Redeem</button></td>');
                    redeemButton.on('click', { gift: gifts[i] }, function (event) {
                        gift = event.data.gift;
                        swal.fire({
                            title: "Are you sure?",
                            text: "Are you sure you want to exchange for " + gift.name + "?",
                            icon: "warning",
                            confirmButtonText: 'OK',
                            showCancelButton: true,
                            cancelButtonText: 'Cancel',
                        })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: 'database/redeem_giftcode.php',
                                        type: 'POST',
                                        data: { gift: gift },
                                        success: function (data) {
                                            response = JSON.parse(data);
                                            Swal.fire({
                                                title: "Success!",
                                                html: "Your gift code is: " + response.code + '<br><br><button id="copyButton">Copy Code</button>',
                                                icon: "success",
                                                didOpen: () => {
                                                    const copyButton = document.querySelector("#copyButton");
                                                    copyButton.addEventListener("click", () => {
                                                        // Create an alert element
                                                        const alertElement = document.createElement("div");
                                                        alertElement.textContent = "Code copied!";
                                                        alertElement.style.position = "absolute";
                                                        alertElement.style.bottom = "10px";
                                                        alertElement.style.right = "10px";
                                                        alertElement.style.padding = "5px 10px";
                                                        alertElement.style.backgroundColor = "#4CAF50";
                                                        alertElement.style.color = "white";
                                                        document.body.appendChild(alertElement);

                                                        // Copy the code to the clipboard
                                                        navigator.clipboard.writeText(response.code);

                                                        // Show the alert for 3 seconds
                                                        setTimeout(() => {
                                                            alertElement.remove();
                                                        }, 3000);

                                                    });
                                                }
                                            });
                                            checkPoints();
                                        },
                                        error: function (data) {
                                            data = JSON.parse(data.responseText);
                                            swal.fire(
                                                'Cancelled!',
                                                data.error,
                                                'error'
                                            )
                                        },
                                    });
                                } else {
                                    swal.fire(
                                        'Cancelled',
                                        'Your exchange has been cancelled',
                                        'info'
                                    )
                                }
                            });
                    });
                    row.append(redeemButton);
                    $('#gifts').append(row);
                }
            }
        });
    }

    function checkCodeExchanged() {
        $.ajax({
            url: 'database/check_code_exchanged.php',
            type: 'GET',
            success: function (data) {
                gifts = JSON.parse(data);
                if (gifts.length === 0) {
                    $('#code-exchanged').html('<tr><td colspan="4">No exchanged codes found.</td></tr>');
                    return;
                }
                for (i = 0; i < gifts.length; i++) {
                    row = $('<tr></tr>');
                    row.append('<td>' + gifts[i].name + '</td>');
                    row.append('<td>' + gifts[i].cost + '</td>');
                    row.append('<td>' + gifts[i].code + '</td>');
                    const copyButton = $('<button>Copy</button>');
                    copyButton.click(function () {
                        code = $(this).parent().prev().text();
                        navigator.clipboard.writeText(code);

                        const alertElement = document.createElement("div");
                        alertElement.textContent = "Code copied!";
                        alertElement.style.position = "absolute";
                        alertElement.style.bottom = "10px";
                        alertElement.style.right = "10px";
                        alertElement.style.padding = "5px 10px";
                        alertElement.style.backgroundColor = "#4CAF50";
                        alertElement.style.color = "white";

                        document.body.appendChild(alertElement);
                        setTimeout(() => {
                            alertElement.remove();
                        }, 3000);
                    });
                    row.append($('<td></td>').append(copyButton));
                    $('#code-exchanged').append(row);
                }
            },
            error: function () {
                $('#code-exchanged').html('<tr><td colspan="4">Error display codes or you did not exchange any yet.</td></tr>');
            }
        });
    }

    checkPoints();
    checkCurrentStage();
    checkAvailableGifts();
    checkCodeExchanged();
});