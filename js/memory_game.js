$(document).ready(function () {
  const moves = document.getElementById("moves-count");
  const timeValue = document.getElementById("time");
  const startButton = document.getElementById("start");
  const stopButton = document.getElementById("stop");
  const gameContainer = document.querySelector(".game-container");
  const result = document.getElementById("result");
  const controls = document.querySelector(".controls-container");
  let cards;
  let interval;
  let firstCard = false;
  let secondCard = false;
  const items = [];

  function getMemoryImages() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: '../hutaplay/database/admin/check_all_memory_images.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          // Loop through the image data
          for (let i = 0; i < data.length; i++) {
            // Get the id and image data from the current object
            const id = data[i].id;
            const image = data[i].image;

            // Create a new object with the id and image data
            const item = { name: id, image: 'data:image/jpeg;base64,' + image };

            // Add the new object to the items array
            items.push(item);
          }

          // Resolve the promise with the items array
          resolve(items);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // Reject the promise with the error
          reject(errorThrown);
        }
      });
    });
  }

  //Initial Time
  let seconds = 0,
    minutes = 0;
  //Initial moves and win count
  let movesCount = 0,
    winCount = 0;

  //For timer
  const timeGenerator = () => {
    seconds += 1;
    //minutes logic
    if (seconds >= 60) {
      minutes += 1;
      seconds = 0;
    }
    //format time before displaying
    let secondsValue = seconds < 10 ? `0${seconds}` : seconds;
    let minutesValue = minutes < 10 ? `0${minutes}` : minutes;
    timeValue.innerHTML = `<span>Time:</span>${minutesValue}:${secondsValue}`;
  };

  //For calculating moves
  const movesCounter = () => {
    movesCount += 1;
    moves.innerHTML = `<span>Moves:</span>${movesCount}`;
  };

  //Pick random objects from the items array
  const generateRandom = (items, size = memory_size) => {
    //temporary array
    let tempArray = [...items];
    //initializes cardValues array
    let cardValues = [];
    //size should be double (4*4 matrix)/2 since pairs of objects would exist
    size = (size * size) / 2;
    //Random object selection
    for (let i = 0; i < size; i++) {
      const randomIndex = Math.floor(Math.random() * tempArray.length);
      cardValues.push(tempArray[randomIndex]);
      //once selected remove the object from temp array
      tempArray.splice(randomIndex, 1);
    }
    return cardValues;
  };


  const matrixGenerator = (cardValues, size = memory_size) => {
    gameContainer.innerHTML = "";
    cardValues = [...cardValues, ...cardValues];
    //simple shuffle
    cardValues.sort(() => Math.random() - 0.5);
    for (let i = 0; i < size * size; i++) {
      /*
          Create Cards
          before => front side (contains question mark)
          after => back side (contains actual image);
          data-card-values is a custom attribute which stores the names of the cards to match later
        */
      gameContainer.innerHTML += `
     <div class="card-container" data-card-value="${cardValues[i].name}">
        <div class="card-before">?</div>
        <div class="card-after">
        <img src="${cardValues[i].image}" class="image"/></div>
     </div>
     `;
    }
    //Grid
    gameContainer.style.gridTemplateColumns = `repeat(${size},auto)`;

    //Cards
    cards = document.querySelectorAll(".card-container");
    cards.forEach((card) => {
      card.addEventListener("click", () => {
        setTimeout(() => {
          card.disabled = false;
        }, 2000);
        //If selected card is not matched yet then only run (i.e already matched card when clicked would be ignored)
        if (!card.classList.contains("matched")) {
          //flip the cliked card
          card.classList.add("flipped");
          //if it is the firstcard (!firstCard since firstCard is initially false)
          if (!firstCard) {
            //so current card will become firstCard
            firstCard = card;
            //current cards value becomes firstCardValue
            firstCardValue = card.getAttribute("data-card-value");
          } else {
            //increment moves since user selected second card
            movesCounter();
            //secondCard and value
            secondCard = card;
            let secondCardValue = card.getAttribute("data-card-value");
            if (firstCardValue == secondCardValue) {
              //if both cards match add matched class so these cards would beignored next time
              firstCard.classList.add("matched");
              secondCard.classList.add("matched");
              //set firstCard to false since next card would be first now
              firstCard = false;
              //winCount increment as user found a correct match
              winCount += 1;
              //check if winCount ==half of cardValues
              if (winCount == Math.floor(cardValues.length / 2)) {
                // Stop audio1
                const audio1 = document.querySelector(".audio1");
                audio1.pause();
                audio1.currentTime = 0; // Reset playback position to the beginning

                // Play audio2
                const audio2 = document.querySelector(".audio2");
                audio2.play();

                saveRecordToDatabase(movesCount, 1);
                result.innerHTML = `<h2>You Won</h2>
            <h4>Moves: ${movesCount}</h4>
            <h4 class = "pointtext"></h4>`;
                startButton.style.display = "none";
                stopGame();
              }
            } else {
              //if the cards dont match
              //flip the cards back to normal
              let [tempFirst, tempSecond] = [firstCard, secondCard];
              firstCard = false;
              secondCard = false;
              let delay = setTimeout(() => {
                tempFirst.classList.remove("flipped");
                tempSecond.classList.remove("flipped");
              }, 900);
            }
          }
        }
      });
    });
  };

  //Start game
  startButton.addEventListener("click", () => {
    movesCount = 0;
    seconds = 0;
    minutes = 0;
    //controls amd buttons visibility
    controls.classList.add("hide");
    stopButton.classList.remove("hide");
    startButton.classList.add("hide");
    //Start timer
    interval = setInterval(timeGenerator, 1000);
    //initial moves
    moves.innerHTML = `<span>Moves:</span> ${movesCount}`;
    initializer();
  });

  //Stop game
  stopButton.addEventListener(
    "click",
    (stopGame = () => {
      controls.classList.remove("hide");
      stopButton.classList.add("hide");
      startButton.classList.remove("hide");
      clearInterval(interval);
    })
  );

  const initializer = async () => {
    try {
      await getMemoryImages();
      result.innerText = "";
      winCount = 0;
      let cardValues = generateRandom(items);
      matrixGenerator(cardValues);
    } catch (error) {
      console.error(error);
    }
  };

});
