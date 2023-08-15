var tabs = document.querySelectorAll(".lboard_tabs ul li");
var today = document.querySelector(".today");
var month = document.querySelector(".month");
var year = document.querySelector(".year");
var items = document.querySelectorAll(".lboard_item");

tabs.forEach(function (tab) {
	tab.addEventListener("click", function () {
		var currenttab = tab.getAttribute("data-li");

		tabs.forEach(function (tab) {
			tab.classList.remove("active");
		})

		tab.classList.add("active");

		items.forEach(function (item) {
			item.style.display = "none";
		})

		if (currenttab == "today") {
			today.style.display = "block";
		}
		else if (currenttab == "month") {
			month.style.display = "block";
		}
		else {
			year.style.display = "block";
		}

	})
})

function renderLeaderboard(stage) {
	// Send an AJAX request to the check_stage_leaderboard.php file
	$.ajax({
		url: `database/check_stage_leaderboard.php?stage=${stage}`,
		type: "GET",
		dataType: "json",
		success: function (data) {
			// Generate the leaderboard content
			let content = `<div class="lboard_item ${stage}" style="display:block;">`;
			data.forEach((item, index) => {
				console.log(item);
				content += `<div class="lboard_mem"><div class="name_bar"><p><span>${index + 1}.</span> ${item.full_name}</p></div><div class="points">${item.points} points</div></div>`;
			});
			content += `</div>`;
			document.querySelector(".lboard_wrap").innerHTML = content;
		},
		error: function (xhr, status, error) {
			document.querySelector(".lboard_wrap").innerHTML = '<h1>No one play this stage yet</h1>';
		}
	});
}

function displayAllStages() {
	$.ajax({
		url: "database/check_all_stages.php",
		type: "GET",
		dataType: "json",
		success: function (data) {
			// Get the number of stages from the data
			const numStages = data;
			// Generate the stage select options
			let options = "";
			for (let i = 1; i <= numStages; i++) {
				options += `<option value="${i}">Stage ${i}</option>`;
			}

			// Update the stage select element with the generated options
			$("#stage-select").html(options);

			renderLeaderboard(1);

		},
		error: function (xhr, status, error) {
			console.error(error);
		}
	});
}

// Handle stage selection from the dropdown menu
document.querySelector("#stage-select").addEventListener("change", event => {
	renderLeaderboard(event.target.value);
});

displayAllStages();