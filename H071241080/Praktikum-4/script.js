// ====== VARIABEL DASAR ======
const playerCardsContainer = document.getElementById("player-cards");
const botCardsContainer = document.getElementById("bot-cards");
const discardPile = document.getElementById("discard-pile");
const deckElement = document.getElementById("deck");
const statusText = document.getElementById("game-status");
const balanceDisplay = document.getElementById("balance");
const betInput = document.getElementById("bet");
const activeColorDisplay = document.getElementById("active-color");

// Tombol Aksi
const startBtn = document.getElementById("start-btn");
const passBtn = document.getElementById("pass-btn");
const unoBtn = document.getElementById("uno-btn");
const callUnoBtn = document.getElementById("call-uno-btn");

let colors = ["red", "yellow", "green", "blue"];
let deckCards = [];
let playerCards = [];
let botCards = [];
let discardTop = null;
let activeColor = null;
let balance = 5000;
let currentBet = 0;
let isPlayerTurn = false;
let hasDrawn = false;
let hasUnoCalled = { player: false, bot: false };
let unoTimer = null;
let unoTimerActive = { player: false, bot: false };

// ====== MEMBUAT DECK ======
function generateDeck() {
    let deck = [];
    colors.forEach(color => {
        for (let i = 0; i <= 9; i++) deck.push({ color, value: i });
        ["skip", "reverse", "plus2"].forEach(a => deck.push({ color, value: a }));
    });
    for (let i = 0; i < 4; i++) {
        deck.push({ color: "wild", value: "wild" }, { color: "wild", value: "plus4" });
    }
    return deck.sort(() => Math.random() - 0.5);
}

// ====== RENDER DECK & DISCARD ======
function renderDeck() {
    deckElement.innerHTML = "";
    const img = document.createElement("img");
    img.src = "assets/card_back.png";
    img.alt = "Deck (ambil kartu)";
    img.classList.add("card-image");
    deckElement.appendChild(img);
}

function renderDiscard() {
    discardPile.innerHTML = "";
    const img = document.createElement("img");
    img.src = getCardImage(discardTop);
    img.alt = `Kartu Teratas: ${discardTop.color} ${discardTop.value}`;
    img.classList.add("card-image");
    discardPile.appendChild(img);

    activeColorDisplay.textContent = activeColor;
    activeColorDisplay.style.color = activeColor;
}

// ====== AMBIL GAMBAR KARTU ======
function getCardImage(card) {
    if (!card) return "assets/card_back.png";

    if (card.color === "wild" && card.value === "wild") return "assets/wild.png";
    if (card.color === "wild" && card.value === "plus4") return "assets/plus_4.png";

    if (card.value === "plus2") return `assets/${card.color}_plus2.png`;
    if (card.value === "reverse") return `assets/${card.color}_reverse.png`;
    if (card.value === "skip") return `assets/${card.color}_skip.png`;

    return `assets/${card.color}_${card.value}.png`;
}

// ====== MULAI RONDE ======
startBtn.addEventListener("click", startRound);

function startRound() {
    currentBet = parseInt(betInput.value);
    if (currentBet < 100 || currentBet > balance) {
        alert(`Taruhan tidak valid! Minimal $100, Maksimal $${balance}.`);
        return;
    }

    isPlayerTurn = true;
    hasDrawn = false;
    hasUnoCalled = { player: false, bot: false };
    unoTimerActive = { player: false, bot: false };
    clearUnoTimer();

    deckCards = generateDeck();
    playerCards = deckCards.splice(0, 7);
    botCards = deckCards.splice(0, 7);

    do {
        discardTop = deckCards.pop();
    } while (discardTop.color === "wild");
    activeColor = discardTop.color;

    renderHands();
    renderDeck();
    renderDiscard();
    updateUIForTurn();

    statusText.textContent = "Ronde dimulai! Giliran Anda.";
    startBtn.disabled = true;
    betInput.disabled = true;
}

// ====== RENDER KARTU PEMAIN & BOT ======
function renderHands() {
    playerCardsContainer.innerHTML = "";
    botCardsContainer.innerHTML = "";

    playerCards.forEach((card, index) => {
        const div = document.createElement("div");
        div.classList.add("card");
        const img = document.createElement("img");
        img.src = getCardImage(card);
        img.alt = `${card.color} ${card.value}`;
        img.classList.add("card-image");
        div.appendChild(img);
        div.addEventListener("click", () => playCard(index));
        playerCardsContainer.appendChild(div);
    });

    botCards.forEach(() => {
        const div = document.createElement("div");
        div.classList.add("card", "back");
        const img = document.createElement("img");
        img.src = "assets/card_back.png";
        img.alt = "Kartu Belakang";
        div.appendChild(img);
        botCardsContainer.appendChild(div);
    });
}

// ====== LOGIKA TURN ======
function updateUIForTurn() {
    passBtn.disabled = !isPlayerTurn || !hasDrawn;
    unoBtn.disabled = !isPlayerTurn || playerCards.length !== 1;
    callUnoBtn.disabled = !isPlayerTurn || botCards.length !== 1 || !unoTimerActive.bot;
    deckElement.classList.toggle("clickable", isPlayerTurn && !hasDrawn);
    playerCardsContainer.classList.toggle("clickable", isPlayerTurn);

    document.getElementById("player-card-count").textContent = playerCards.length;
    document.getElementById("bot-card-count").textContent = botCards.length;
}

// ====== CEK KARTU YANG BISA DIMAINKAN ======
function canPlay(card) {
    return (
        card.color === activeColor ||
        card.value === discardTop.value ||
        card.color === "wild"
    );
}

function hasPlayableNonWildPlus4() {
    return playerCards.some(
        c => (c.color === activeColor || c.value === discardTop.value) && c.value !== "plus4"
    );
}

// ====== MAIN KARTU ======
function playCard(index) {
    if (!isPlayerTurn) return;

    const chosenCard = playerCards[index];
    
    // Validasi Wild +4
    if (chosenCard.value === "plus4" && hasPlayableNonWildPlus4()) {
        statusText.textContent = "Tidak bisa memainkan Wild +4! Masih ada kartu lain yang cocok.";
        return;
    }
    
    if (!canPlay(chosenCard)) {
        statusText.textContent = "Kartu tidak cocok! Pilih kartu lain atau ambil kartu.";
        return;
    }

    clearUnoTimer();
    discardTop = chosenCard;
    playerCards.splice(index, 1);
    hasDrawn = false;

    if (playerCards.length === 0) {
        playerWin();
        return;
    }

    // Check UNO for player
    if (playerCards.length === 1 && !hasUnoCalled.player) {
        statusText.textContent = "Kamu punya 1 kartu! Tekan UNO dalam 5 detik!";
        setUnoTimer("player");
    }

    renderHands();
    applyCardEffect(chosenCard, "player");
}

// ====== AMBIL KARTU ======
deckElement.addEventListener("click", handleDrawCard);

function handleDrawCard() {
    if (!isPlayerTurn || hasDrawn || deckCards.length === 0) return;

    const drawnCard = deckCards.pop();
    playerCards.push(drawnCard);
    hasDrawn = true;

    renderHands();
    renderDeck();

    statusText.textContent = "Kamu mengambil 1 kartu. Pilih untuk memainkannya atau Lewati Giliran.";
    passBtn.disabled = false;
    updateUIForTurn();
}

// ====== LEWATI GILIRAN ======
passBtn.addEventListener("click", () => {
    if (!isPlayerTurn || !hasDrawn) return;
    
    clearUnoTimer();
    isPlayerTurn = false;
    hasDrawn = false;
    statusText.textContent = "Kamu melewati giliran. Giliran Bot...";
    updateUIForTurn();
    setTimeout(botPlay, 1000);
});

// ====== LOGIKA KARTU AKSI ======
function applyCardEffect(card, currentPlayer) {
    let nextPlayer = currentPlayer === "player" ? "bot" : "player";
    let continuesTurn = false;

    if (card.value === "plus2") {
        let target = nextPlayer === "player" ? playerCards : botCards;
        for (let i = 0; i < 2; i++) {
            if (deckCards.length > 0) target.push(deckCards.pop());
        }
        statusText.textContent = `${currentPlayer === "player" ? "Kamu" : "Bot"} main +2! ${nextPlayer === "player" ? "Kamu" : "Bot"} ambil 2 kartu dan giliran dilewati.`;
        activeColor = card.color;
        continuesTurn = true;
        
    } else if (card.value === "plus4") {
        let target = nextPlayer === "player" ? playerCards : botCards;
        for (let i = 0; i < 4; i++) {
            if (deckCards.length > 0) target.push(deckCards.pop());
        }
        
        if (currentPlayer === "player") {
            activeColor = getValidColorFromPlayer("Pilih warna baru setelah +4:");
        } else {
            activeColor = chooseBestColor(botCards);
        }
        
        statusText.textContent = `${currentPlayer === "player" ? "Kamu" : "Bot"} main +4! ${nextPlayer === "player" ? "Kamu" : "Bot"} ambil 4 kartu. Warna jadi ${activeColor}.`;
        continuesTurn = true;
        
    } else if (card.value === "skip" || card.value === "reverse") {
        activeColor = card.color;
        statusText.textContent = `${currentPlayer === "player" ? "Kamu" : "Bot"} main ${card.value.toUpperCase()}! ${nextPlayer === "player" ? "Kamu" : "Bot"} dilewati.`;
        continuesTurn = true;
        
    } else if (card.value === "wild") {
        if (currentPlayer === "player") {
            activeColor = getValidColorFromPlayer("Pilih warna baru:");
        } else {
            activeColor = chooseBestColor(botCards);
        }
        statusText.textContent = `${currentPlayer === "player" ? "Kamu" : "Bot"} main Wild! Warna jadi ${activeColor}.`;
        continuesTurn = false;
        
    } else {
        // Number card
        activeColor = card.color;
        statusText.textContent = `${currentPlayer === "player" ? "Kamu" : "Bot"} main ${card.color} ${card.value}.`;
        continuesTurn = false;
    }

    renderHands();
    renderDiscard();
    updateUIForTurn();

    // Handle turn flow
    if (continuesTurn) {
        if (currentPlayer === "player") {
            isPlayerTurn = true;
            statusText.textContent += " Giliranmu lagi!";
            updateUIForTurn();
        } else {
            isPlayerTurn = false;
            statusText.textContent += " Giliran Bot lagi!";
            setTimeout(botPlay, 1500);
        }
    } else {
        if (currentPlayer === "player") {
            isPlayerTurn = false;
            statusText.textContent += " Giliran Bot...";
            setTimeout(botPlay, 1500);
        } else {
            isPlayerTurn = true;
            statusText.textContent += " Giliranmu!";
            updateUIForTurn();
        }
    }
}

// ====== HELPER FUNCTIONS FOR COLOR SELECTION ======
function getValidColorFromPlayer(message) {
    let validColors = ["red", "yellow", "green", "blue"];
    let chosenColor = null;
    
    while (!chosenColor) {
        let input = prompt(`${message}\nKetik: red, yellow, green, atau blue`, "red");
        
        // If user cancels, default to red
        if (input === null) {
            return "red";
        }
        
        // Convert to lowercase and trim
        input = input.toLowerCase().trim();
        
        // Check if valid
        if (validColors.includes(input)) {
            chosenColor = input;
        } else {
            alert(`Warna tidak valid! Harus salah satu: red, yellow, green, blue\nKamu ketik: "${input}"`);
        }
    }
    
    return chosenColor;
}

function chooseBestColor(cards) {
    let colorCounts = {};
    colors.forEach(c => colorCounts[c] = 0);
    
    cards.forEach(card => {
        if (card.color !== "wild" && colors.includes(card.color)) {
            colorCounts[card.color]++;
        }
    });
    
    let maxCount = Math.max(...Object.values(colorCounts));
    if (maxCount === 0) return colors[Math.floor(Math.random() * colors.length)];
    
    return Object.keys(colorCounts).find(c => colorCounts[c] === maxCount);
}

// ====== UNO LOGIC ======
function setUnoTimer(player) {
    clearUnoTimer();
    unoTimerActive[player] = true;
    
    unoTimer = setTimeout(() => {
        if (player === "player" && !hasUnoCalled.player && playerCards.length === 1) {
            handleUnoPenalty("player");
        } else if (player === "bot" && !hasUnoCalled.bot && botCards.length === 1) {
            handleUnoPenalty("bot");
        }
        unoTimerActive[player] = false;
    }, 5000);
}

function clearUnoTimer() {
    if (unoTimer) {
        clearTimeout(unoTimer);
        unoTimer = null;
    }
    unoTimerActive = { player: false, bot: false };
}

function handleUnoPenalty(player) {
    let hand = player === "player" ? playerCards : botCards;
    
    if (hand.length === 1) {
        if (deckCards.length >= 2) {
            hand.push(deckCards.pop(), deckCards.pop());
        } else {
            while (deckCards.length > 0) hand.push(deckCards.pop());
        }
        
        statusText.textContent = `${player === "player" ? "Kamu" : "Bot"} lupa bilang UNO! Penalti +2 kartu.`;
        hasUnoCalled[player] = false;
        renderHands();
        updateUIForTurn();
    }
    
    clearUnoTimer();
}

unoBtn.addEventListener("click", () => {
    if (!isPlayerTurn || playerCards.length !== 1) {
        statusText.textContent = "Tekan UNO hanya jika kamu punya 1 kartu!";
        return;
    }
    
    clearUnoTimer();
    hasUnoCalled.player = true;
    statusText.textContent = "Kamu bilang UNO! ✓";
    updateUIForTurn();
});

callUnoBtn.addEventListener("click", () => {
    if (!isPlayerTurn) return;
    
    if (botCards.length === 1 && unoTimerActive.bot && !hasUnoCalled.bot) {
        handleUnoPenalty("bot");
        statusText.textContent = "Kamu memanggil UNO pada Bot! Bot kena penalti +2!";
    } else {
        statusText.textContent = "Tidak bisa memanggil UNO sekarang!";
    }
    updateUIForTurn();
});

// ====== KEMENANGAN ======
function endGame(winner) {
    clearUnoTimer();
    
    let message = "";
    if (winner === "player") {
        balance += currentBet;
        message = `🎉 Kamu menang ronde ini! +$${currentBet}`;
    } else {
        balance -= currentBet;
        message = `😢 Bot menang ronde ini. -$${currentBet}`;
    }

    balanceDisplay.textContent = balance;
    statusText.textContent = message;

    startBtn.disabled = false;
    betInput.disabled = false;
    isPlayerTurn = false;
    hasDrawn = false;
    updateUIForTurn();

    if (balance <= 0) {
        statusText.textContent = "💀 Game Over! Saldo habis. Reload halaman untuk mulai ulang.";
        balance = 5000;
        balanceDisplay.textContent = balance;
    }
}

function playerWin() {
    endGame("player");
}

function botWin() {
    endGame("bot");
}

// ====== BOT BERMAIN ======
function botPlay() {
    if (deckCards.length === 0) {
        statusText.textContent = "Deck habis! Game berakhir seri.";
        return;
    }

    // Bot calls UNO if has 1 card
    if (botCards.length === 1 && !hasUnoCalled.bot) {
        hasUnoCalled.bot = true;
        statusText.textContent = "Bot bilang UNO! 🔔";
        setTimeout(() => botPlayContinue(), 1000);
        return;
    }
    
    botPlayContinue();
}

function botPlayContinue() {
    let playable = botCards.find(canPlay);

    if (playable) {
        clearUnoTimer();
        
        discardTop = playable;
        botCards.splice(botCards.indexOf(playable), 1);

        if (botCards.length === 0) {
            botWin();
            return;
        }

        // Set UNO timer for bot if down to 1 card
        if (botCards.length === 1 && !hasUnoCalled.bot) {
            setUnoTimer("bot");
        }

        renderHands();
        applyCardEffect(playable, "bot");
        
    } else {
        const drawnCard = deckCards.pop();
        botCards.push(drawnCard);
        renderHands();

        if (canPlay(drawnCard)) {
            statusText.textContent = "Bot menarik kartu dan memainkannya...";
            setTimeout(() => {
                discardTop = drawnCard;
                botCards.splice(botCards.indexOf(drawnCard), 1);
                
                if (botCards.length === 0) {
                    botWin();
                    return;
                }
                
                renderHands();
                applyCardEffect(drawnCard, "bot");
            }, 1000);
        } else {
            statusText.textContent = "Bot menarik kartu tapi tidak bisa bermain. Giliranmu!";
            isPlayerTurn = true;
            updateUIForTurn();
        }
    }
}

// Initialize balance display
balanceDisplay.textContent = balance;