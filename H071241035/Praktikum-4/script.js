document.addEventListener("DOMContentLoaded", () => {
  const loadingScreen = document.getElementById("loading-screen");

  window.addEventListener("load", () => {
    setTimeout(() => {
      loadingScreen.style.opacity = "0";
      setTimeout(() => {
        loadingScreen.style.display = "none";
      }, 1000);
    }, 2000);
  });

  const playerHandDiv = document.getElementById("player-hand");
  const botHandDiv = document.getElementById("bot-hand");
  const discardPileDiv = document.getElementById("discard-pile");
  const deckPileDiv = document.getElementById("deck-pile");
  const statusMessageDiv = document.getElementById("status-message");
  const unoButton = document.getElementById("uno-button");
  const playerBalanceSpan = document.getElementById("player-balance");
  const betAmountInput = document.getElementById("bet-amount");
  const playButton = document.getElementById("play-button");
  const gameBoard = document.getElementById("game-board");
  const botTurnSpan = document.getElementById("bot-turn");
  const playerTurnSpan = document.getElementById("player-turn");

  const colorSelector = document.getElementById("color-selector");
  const gameOverModal = document.getElementById("game-over-modal");
  const restartGameBtn = document.getElementById("restart-game-btn");
  const winScreen = document.getElementById("win-screen");
  const coinAnimationContainer = document.getElementById(
    "coin-animation-container"
  );

  let deck = [];
  let playerHand = [];
  let botHand = [];
  let discardPile = [];
  let currentPlayer = "player";
  let currentColor = "";
  let currentValue = "";
  let playerBalance = 5000;
  let currentBet = 0;
  let unoCalled = false;
  let unoTimer;
  let waitingForColorChoice = false;
  let hasDrawnThisTurn = false;

  const delay = (ms) => new Promise((res) => setTimeout(res, ms));

  function getCardImageName(card) {
    switch (card.value) {
      case "skip":
        return `${card.color}_skip.png`;
      case "reverse":
        return `${card.color}_reverse.png`;
      case "draw2":
        return `${card.color}_+2.png`;
      case "wild":
        return "wild.png";
      case "wild4":
        return "wild_+4.png";
      default:
        return `${card.color}${card.value}.png`;
    }
  }

  function initializeGame() {
    playerBalance = 5000;
    updateBalanceDisplay();
    betAmountInput.disabled = false;
    playButton.disabled = false;
    unoButton.classList.add("hidden");
  }

  async function startRound() {
    betAmountInput.disabled = true;
    playButton.disabled = true;

    playerHandDiv.innerHTML = "";
    botHandDiv.innerHTML = "";

    deck = [];
    playerHand = [];
    botHand = [];
    discardPile = [];
    currentPlayer = "player";
    unoCalled = false;
    hasDrawnThisTurn = false;

    createDeck();
    shuffleDeck();
    dealCards();
    flipFirstCard();

    updateTurnIndicator();
    await animateDealing();

    if (currentPlayer === "bot") {
      statusMessageDiv.textContent = "Bot starts the turn.";
      setTimeout(botTurn, 1200);
    } else {
      statusMessageDiv.textContent = "Your turn to play!";
    }
  }

  async function animateDealing() {
    for (let i = 0; i < 7; i++) {
      let playerCardEl = document.createElement("img");
      playerCardEl.src = "assets/back.png";
      playerCardEl.className = "dealing-card";
      playerCardEl.style.setProperty("--i", i);
      gameBoard.appendChild(playerCardEl);
      await delay(10);
      playerCardEl.classList.add("deal-to-player");
      await delay(150);

      let botCardEl = document.createElement("img");
      botCardEl.src = "assets/back.png";
      botCardEl.className = "dealing-card";
      botCardEl.style.setProperty("--i", i);
      gameBoard.appendChild(botCardEl);
      await delay(10);
      botCardEl.classList.add("deal-to-bot");
      await delay(150);
    }

    await delay(500);
    document.querySelectorAll(".dealing-card").forEach((card) => card.remove());
    renderAll();
  }

  function createDeck() {
    const colors = ["red", "green", "blue", "yellow"];
    const values = [
      "0",
      "1",
      "2",
      "3",
      "4",
      "5",
      "6",
      "7",
      "8",
      "9",
      "skip",
      "reverse",
      "draw2",
    ];
    for (const color of colors) {
      for (const value of values) {
        deck.push({ color, value });
        if (value !== "0") deck.push({ color, value });
      }
    }
    for (let i = 0; i < 4; i++) {
      deck.push({ color: "wild", value: "wild" });
      deck.push({ color: "wild", value: "wild4" });
    }
  }

  function shuffleDeck() {
    for (let i = deck.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [deck[i], deck[j]] = [deck[j], deck[i]];
    }
  }

  function dealCards() {
    for (let i = 0; i < 7; i++) {
      playerHand.push(deck.pop());
      botHand.push(deck.pop());
    }
  }

  function drawCard(player) {
    if (deck.length === 0) {
      const topCard = discardPile.pop();
      deck = [...discardPile];
      shuffleDeck();
      discardPile = [topCard];
    }
    const card = deck.pop();
    if (player === "player") playerHand.push(card);
    else botHand.push(card);
  }

  function flipFirstCard() {
    let firstCard = deck.pop();
    while (firstCard.color === "wild") {
      deck.push(firstCard);
      shuffleDeck();
      firstCard = deck.pop();
    }
    discardPile.push(firstCard);
    currentColor = firstCard.color;
    currentValue = firstCard.value;

    const opponent = "player";
    switch (firstCard.value) {
      case "draw2":
        drawCard(opponent);
        drawCard(opponent);
        switchTurn("bot");
        break;
      case "skip":
      case "reverse":
        switchTurn("bot");
        break;
      default:
        break;
    }
  }

  function isPlayable(card) {
    if (card.value === "wild4") {
      const hasMatchingColorCard = playerHand.some(
        (c) => c.color === currentColor
      );
      return !hasMatchingColorCard;
    }
    if (card.color === "wild") {
      return true;
    }
    return card.color === currentColor || card.value === currentValue;
  }

  async function playCard(cardIndex, cardElement) {
    const card = playerHand[cardIndex];
    if (currentPlayer !== "player" || !isPlayable(card)) {
      statusMessageDiv.textContent = "You can't play this card!";
      return;
    }

    playerHand.splice(cardIndex, 1);
    discardPile.push(card);

    await animateCardPlay(cardElement, cardElement.getBoundingClientRect());

    currentColor = card.color;
    currentValue = card.value;

    renderAll();
    handleCardEffect(card, "player");

    if (playerHand.length === 0) {
      endRound("player");
      return;
    }

    if (playerHand.length === 1) {
      startUnoTimer("player");
    } else {
      clearUnoTimer();
    }

    if (!waitingForColorChoice && currentPlayer === "bot") {
      setTimeout(botTurn, 1200);
    }
  }

  async function animateCardPlay(cardElement, startRect) {
    const discardPileRect = discardPileDiv.getBoundingClientRect();
    const animatedCard = cardElement.cloneNode();
    animatedCard.classList.add("playing-card");
    animatedCard.style.left = `${startRect.left}px`;
    animatedCard.style.top = `${startRect.top}px`;
    gameBoard.appendChild(animatedCard);

    await delay(10);

    animatedCard.style.transform = `translate(${
      discardPileRect.left - startRect.left
    }px, ${discardPileRect.top - startRect.top}px) rotate(360deg) scale(1.1)`;
    animatedCard.style.opacity = 0.8;

    await delay(500);
    animatedCard.remove();
  }

  function handleCardEffect(card, playedBy) {
    const opponent = playedBy === "player" ? "bot" : "player";
    switch (card.value) {
      case "draw2":
        drawCard(opponent);
        drawCard(opponent);
        statusMessageDiv.textContent = `${opponent.toUpperCase()} draws 2 cards!`;
        switchTurn(opponent);
        break;
      case "skip":
        statusMessageDiv.textContent = `${opponent.toUpperCase()}'s turn is skipped!`;
        // In a 2-player game, this means the current player plays again.
        if (playedBy === "bot") setTimeout(botTurn, 1200);
        break;
      case "reverse":
        statusMessageDiv.textContent = `Game direction reversed!`;
        // In a 2-player game, this acts like a skip.
        if (playedBy === "bot") setTimeout(botTurn, 1200);
        break;
      case "wild":
        if (playedBy === "player") {
          waitingForColorChoice = true;
          colorSelector.classList.remove("hidden");
          statusMessageDiv.textContent = "Choose a color.";
        } else {
          const colors = ["red", "green", "blue", "yellow"];
          const chosenColor = colors[Math.floor(Math.random() * colors.length)];
          currentColor = chosenColor;
          statusMessageDiv.textContent = `Bot changed color to ${chosenColor.toUpperCase()}!`;
          switchTurn(opponent);
        }
        break;
      case "wild4":
        drawCard(opponent);
        drawCard(opponent);
        drawCard(opponent);
        drawCard(opponent);
        if (playedBy === "player") {
          waitingForColorChoice = true;
          colorSelector.classList.remove("hidden");
          statusMessageDiv.textContent = "Choose a color.";
        } else {
          const colors = ["red", "green", "blue", "yellow"];
          const chosenColor = colors[Math.floor(Math.random() * colors.length)];
          currentColor = chosenColor;
          statusMessageDiv.textContent = `Bot changed color to ${chosenColor.toUpperCase()}!`;
          switchTurn(opponent);
        }
        break;
      default:
        switchTurn(opponent);
        break;
    }
  }

  function switchTurn(nextPlayer) {
    currentPlayer = nextPlayer;
    if (currentPlayer === "player") {
      hasDrawnThisTurn = false;
    }
    updateTurnIndicator();
  }

  function updateTurnIndicator() {
    if (currentPlayer === "player") {
      playerTurnSpan.classList.add("active");
      botTurnSpan.classList.remove("active");
      if (!waitingForColorChoice) {
        statusMessageDiv.textContent = "Your turn!";
      }
    } else {
      botTurnSpan.classList.add("active");
      playerTurnSpan.classList.remove("active");
      statusMessageDiv.textContent = "Bot's turn!";
    }
  }

  function changeColor(color) {
    currentColor = color;
    colorSelector.classList.add("hidden");
    waitingForColorChoice = false;

    statusMessageDiv.textContent = `Color changed to ${color.toUpperCase()}!`;
    switchTurn("bot");

    setTimeout(botTurn, 1200);
  }

  function botTurn() {
    if (currentPlayer !== "bot") return;
    statusMessageDiv.textContent = "Bot is thinking...";

    setTimeout(() => {
      let cardIndex = -1;

      cardIndex = botHand.findIndex(
        (c) => c.color === currentColor || c.value === currentValue
      );

      if (cardIndex === -1) {
        cardIndex = botHand.findIndex((c) => c.value === "wild");
      }

      if (cardIndex === -1) {
        // Check if bot can play wild4 (no card with matching color)
        const canPlayWild4 = !botHand.some((c) => c.color === currentColor);
        if (canPlayWild4) {
          cardIndex = botHand.findIndex((c) => c.value === "wild4");
        }
      }

      if (cardIndex !== -1) {
        const card = botHand.splice(cardIndex, 1)[0];
        discardPile.push(card);
        currentColor = card.color;
        currentValue = card.value;

        const botCardEl = botHandDiv.querySelector("img");
        animateCardPlay(botCardEl, botCardEl.getBoundingClientRect()).then(
          () => {
            renderAll();
            handleCardEffect(card, "bot");
            if (botHand.length === 0) {
              endRound("bot");
              return;
            }
            if (botHand.length === 1)
              statusMessageDiv.textContent = "Bot called UNO!";

            if (currentPlayer === "player") {
              statusMessageDiv.textContent = "Your turn!";
            }
          }
        );
      } else {
        drawCard("bot");
        renderAll();
        const drawnCard = botHand[botHand.length - 1];

        if (isPlayableBot(drawnCard)) {
          statusMessageDiv.textContent = "Bot drew a card and is playing it.";
          setTimeout(() => {
            botHand.pop();
            discardPile.push(drawnCard);
            currentColor = drawnCard.color;
            currentValue = drawnCard.value;
            renderAll();
            handleCardEffect(drawnCard, "bot");
            if (currentPlayer === "player") {
              statusMessageDiv.textContent = "Your turn!";
            }
          }, 1000);
        } else {
          statusMessageDiv.textContent = "Bot drew a card and passed.";
          switchTurn("player");
        }
      }
    }, 1000);
  }

  function isPlayableBot(card) {
    if (card.value === "wild4") {
      // Official rule: Can only be played if you don't have a card of the current color.
      const hasMatchingColorCard = botHand.some(
        (c) => c.color === currentColor
      );
      return !hasMatchingColorCard;
    }
    return (
      card.color === currentColor ||
      card.value === currentValue ||
      card.color === "wild"
    );
  }

  function startUnoTimer(player) {
    unoButton.classList.remove("hidden");
    unoCalled = false;

    unoTimer = setTimeout(() => {
      if (!unoCalled) {
        statusMessageDiv.textContent = `${player.toUpperCase()} forgot to call UNO! Penalty +2 cards.`;
        drawCard(player);
        drawCard(player);
        renderAll();
      }
      clearUnoTimer();
    }, 5000);
  }

  function clearUnoTimer() {
    clearTimeout(unoTimer);
    unoButton.classList.add("hidden");
  }

  function showWinAnimation() {
    winScreen.classList.remove("hidden");
    coinAnimationContainer.innerHTML = "";

    for (let i = 0; i < 50; i++) {
      const coin = document.createElement("div");
      coin.classList.add("falling-coin");
      coin.style.left = `${Math.random() * 100}vw`;
      coin.style.animationDuration = `${Math.random() * 2 + 3}s`;
      coin.style.animationDelay = `${Math.random() * 2}s`;
      coinAnimationContainer.appendChild(coin);
    }

    setTimeout(() => {
      winScreen.classList.add("hidden");
      betAmountInput.disabled = false;
      playButton.disabled = false;
    }, 6000);
  }

  unoButton.addEventListener("click", () => {
    if (playerHand.length === 1 && !unoCalled) {
      statusMessageDiv.textContent = "You called UNO!";
      unoCalled = true;
      clearUnoTimer();
    }
  });

  function renderAll() {
    renderHand(playerHand, playerHandDiv, true);
    renderHand(botHand, botHandDiv, false);
    renderDiscardPile();
    updateBalanceDisplay();
  }

  function renderHand(hand, element, isPlayer) {
    element.innerHTML = "";

    if (!isPlayer) {
      element.dataset.cardCount = hand.length;
    }

    hand.forEach((card, index) => {
      const cardImg = document.createElement("img");
      if (isPlayer) {
        cardImg.src = `assets/${getCardImageName(card)}`;
        cardImg.alt = `${card.color} ${card.value}`;
      } else {
        cardImg.src = `assets/back.png`;
        cardImg.alt = `Bot card`;
      }
      cardImg.classList.add("card");

      const rotation = (index - (hand.length - 1) / 2) * 4;
      cardImg.style.transform = `rotate(${rotation}deg)`;

      if (isPlayer) {
        if (isPlayable(card) && currentPlayer === "player") {
          cardImg.classList.add("playable");
        }
        cardImg.addEventListener("click", (e) => playCard(index, e.target));
      }
      element.appendChild(cardImg);
    });

    if (isPlayer) {
      if (hand.length > 12) {
        element.classList.add("two-rows");
      } else {
        element.classList.remove("two-rows");
      }
    }
  }

  function renderDiscardPile() {
    discardPileDiv.innerHTML = "";
    if (discardPile.length > 0) {
      const topCard = discardPile[discardPile.length - 1];
      const cardImg = document.createElement("img");
      cardImg.src = `assets/${getCardImageName(topCard)}`;
      cardImg.alt = `${topCard.color} ${topCard.value}`;
      cardImg.classList.add("card");
      discardPileDiv.appendChild(cardImg);
      if (topCard.color === "wild") {
        discardPileDiv.style.boxShadow = `0 0 20px 8px ${currentColor}`;
      } else {
        discardPileDiv.style.boxShadow = "none";
      }
    }
  }

  function updateBalanceDisplay() {
    playerBalanceSpan.textContent = `$${playerBalance}`;
    betAmountInput.max = playerBalance;
  }

  function endRound(winner) {
    if (winner === "player") {
      playerBalance += currentBet;
      statusMessageDiv.textContent = `Congratulations! You won $${currentBet}!`;
      showWinAnimation();
    } else {
      playerBalance -= currentBet;
      statusMessageDiv.textContent = `Too bad, you lost $${currentBet}. Place your bet for the next round.`;
      betAmountInput.disabled = false;
      playButton.disabled = false;
    }
    updateBalanceDisplay();

    unoButton.classList.add("hidden");

    if (playerBalance <= 0) {
      gameOverModal.classList.remove("hidden");
      betAmountInput.disabled = true;
      playButton.disabled = true;
    }
  }

  playButton.addEventListener("click", () => {
    const bet = parseInt(betAmountInput.value);
    if (bet >= 100 && bet <= playerBalance) {
      currentBet = bet;
      startRound();
    } else {
      alert(`Invalid bet. Please enter between $100 and $${playerBalance}.`);
    }
  });

  restartGameBtn.addEventListener("click", () => {
    gameOverModal.classList.add("hidden");
    initializeGame();
    statusMessageDiv.textContent = "Place your bet and press PLAY!";
  });

  document.querySelectorAll(".color-btn").forEach((button) => {
    button.addEventListener("click", (e) => {
      if (waitingForColorChoice) {
        changeColor(e.target.dataset.color);
      }
    });
  });

  deckPileDiv.addEventListener("click", () => {
    if (currentPlayer === "player" && !waitingForColorChoice) {
      if (hasDrawnThisTurn) {
        statusMessageDiv.textContent = "You passed your turn.";
        switchTurn("bot");
        setTimeout(botTurn, 1200);
        return;
      }

      const canPlay = playerHand.some((card) => isPlayable(card));
      if (canPlay) {
        statusMessageDiv.textContent =
          "You have a playable card! You cannot draw.";
        document.querySelectorAll(".playable").forEach((c) => {
          c.style.animation = "shake 0.5s";
          setTimeout(() => (c.style.animation = ""), 500);
        });
        return;
      }

      drawCard("player");
      hasDrawnThisTurn = true;
      renderAll();
      const drawnCard = playerHand[playerHand.length - 1];

      if (isPlayable(drawnCard)) {
        statusMessageDiv.textContent =
          "You drew a playable card. Play it or click the deck again to pass.";
      } else {
        statusMessageDiv.textContent =
          "You drew a non-playable card. Turn passes to bot.";
        setTimeout(() => {
          switchTurn("bot");
          setTimeout(botTurn, 1200);
        }, 1500);
      }
    }
  });

  initializeGame();
});
