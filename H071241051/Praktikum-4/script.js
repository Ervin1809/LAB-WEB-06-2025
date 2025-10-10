document.addEventListener('DOMContentLoaded', () => {
    // === Elemen-elemen dari HTML ===
    const playerHandElement = document.getElementById('player-hand');
    const computerHandElement = document.getElementById('computer-hand');
    const deckElement = document.getElementById('deck');
    const discardPileElement = document.getElementById('discard-pile');
    const gameOverModal = document.getElementById('game-over-modal');
    const winnerMessage = document.getElementById('winner-message');
    const playAgainBtn = document.getElementById('play-again-btn');
    const playerBalanceElement = document.getElementById('player-balance');
    const bettingModal = document.getElementById('betting-modal');
    const bettingTitle = document.getElementById('betting-title');
    const betAmountInput = document.getElementById('bet-amount');
    const placeBetBtn = document.getElementById('place-bet-btn');
    const betMessage = document.getElementById('bet-message');
    const colorPickerModal = document.getElementById('color-picker-modal');
    const colorChoices = document.querySelector('.color-choices');

    // === Variabel State Permainan ===
    let deck = [], playerHand = [], computerHand = [], discardPile = [];
    let isPlayerTurn = true, playerBalance = 5000, currentBet = 0;
    const MINIMUM_BET = 1000;
    const MAXIMUM_BET = 5000;
    let drawPenalty = 0;
    let chosenColor = null;

    // --- FUNGSI BARU: SANG WASIT PENGATUR GILIRAN ---
    function processNextTurn(lastPlayer, playedCard) {
        const isSkipCard = ['skip', 'reverse'].includes(playedCard.value);
        const isDrawCard = ['plus2', 'plus_4'].includes(playedCard.value);

        if (lastPlayer === 'player') {
            if (isSkipCard) {
                // Pemain main kartu skip, giliran pemain lagi
                console.log("Computer's turn is skipped. Your turn again!");
                isPlayerTurn = true; // Tetap di giliran pemain
            } else if (isDrawCard) {
                // Pemain main kartu plus, komputer harus menghadapinya
                console.log("Player played a draw card. Computer's turn to respond or draw.");
                isPlayerTurn = false;
                setTimeout(computerTurn, 1200);
            } else {
                // Kartu normal, giliran komputer
                isPlayerTurn = false;
                setTimeout(computerTurn, 1200);
            }
        } else { // Giliran komputer sebelumnya
            if (isSkipCard) {
                // Komputer main kartu skip, giliran komputer lagi
                console.log("Your turn is skipped. Computer plays again!");
                isPlayerTurn = false;
                setTimeout(computerTurn, 1200);
            } else if (isDrawCard) {
                // Komputer main kartu plus, pemain harus menghadapinya
                console.log("Computer played a draw card. Your turn to respond or draw.");
                isPlayerTurn = true;
            } else {
                // Kartu normal, giliran pemain
                isPlayerTurn = true;
            }
        }
    }

    // --- FUNGSI INTI PERMAINAN YANG SUDAH DIPERBAIKI ---

    function playerPlayCard(cardIndex) {
        if (!isPlayerTurn) return;
        const card = playerHand[cardIndex];
        const topCard = discardPile[discardPile.length - 1];

        if (isCardPlayable(card, topCard)) {
            chosenColor = null;
            discardPile.push(playerHand.splice(cardIndex, 1)[0]);
            renderAll();

            if (checkForWinner(playerHand, "You")) return;

            const isAction = ['plus2', 'plus_4', 'wild', 'skip', 'reverse'].includes(card.value);
            if (isAction) {
                handleActionCard(card, true);
            }

            if (card.value !== 'wild' && card.value !== 'plus_4') {
                processNextTurn('player', card);
            }
        } else {
            alert("You can't play that card!");
        }
    }

    function computerTurn() {
        if (isPlayerTurn) return;
        const topCard = discardPile[discardPile.length - 1];
        let cardToPlayIndex = -1;

        if (drawPenalty > 0) {
            cardToPlayIndex = computerHand.findIndex(card => card.value === 'plus2' || card.value === 'plus_4');
        } else {
            cardToPlayIndex = computerHand.findIndex(card => isCardPlayable(card, topCard));
        }

        if (cardToPlayIndex !== -1) {
            const card = computerHand.splice(cardToPlayIndex, 1)[0];
            discardPile.push(card);
            console.log(`Computer plays: ${card.color} ${card.value}`);

            const isAction = ['plus2', 'plus_4', 'wild', 'skip', 'reverse'].includes(card.value);
            if (isAction) {
                handleActionCard(card, false);
            }
            renderAll();
            if (checkForWinner(computerHand, "Computer")) return;

            // PERBAIKAN: Selalu panggil processNextTurn setelah komputer main
            processNextTurn('computer', card);

        } else {
            console.log("Computer must draw.");
            if (drawPenalty > 0) {
                drawCards(computerHand, drawPenalty);
                drawPenalty = 0;
                // Setelah draw penalti, giliran komputer selesai dan dilewati
                console.log("Computer drew penalty cards. Your turn.");
                isPlayerTurn = true;
            } else {
                drawCards(computerHand, 1);
                // Setelah draw normal, giliran tetap selesai
                isPlayerTurn = true;
            }
            renderAll();
        }
    }

    deckElement.addEventListener('click', () => {
        if (!isPlayerTurn) return;
        if (drawPenalty > 0) {
            alert(`You must draw ${drawPenalty} cards.`);
            drawCards(playerHand, drawPenalty);
            drawPenalty = 0;
            // Giliran Anda selesai dan dilewati setelah mengambil kartu penalti
            isPlayerTurn = false;
            setTimeout(computerTurn, 1200);
        } else {
            drawCards(playerHand, 1);
            // Setelah ambil kartu biasa, giliran tetap selesai
            isPlayerTurn = false;
            setTimeout(computerTurn, 1200);
        }
        renderAll();
    });

    colorChoices.addEventListener('click', (e) => {
        if (e.target.classList.contains('color-btn')) {
            chosenColor = e.target.dataset.color;
            colorPickerModal.style.display = 'none';
            console.log(`You chose ${chosenColor}`);
            // Setelah memilih warna, giliran diberikan ke lawan
            processNextTurn(isPlayerTurn ? 'player' : 'computer', discardPile[discardPile.length - 1]);
        }
    });

    // --- FUNGSI BANTU LAINNYA ---
    function isCardPlayable(card, topCard) { if (drawPenalty > 0) { return card.value === 'plus2' || card.value === 'plus_4' } if (chosenColor) { return card.color === chosenColor || card.color === 'wild' } return card.color === 'wild' || card.color === topCard.color || card.value === topCard.value }
    function handleActionCard(card, playedByPlayer) { chosenColor = null; switch (card.value) { case 'plus2': drawPenalty += 2; break; case 'plus_4': drawPenalty += 4; if (playedByPlayer) { setTimeout(() => colorPickerModal.style.display = 'flex', 500) } else { chosenColor = computerChooseColor(); console.log(`Computer chose ${chosenColor}`) } break; case 'wild': if (playedByPlayer) { setTimeout(() => colorPickerModal.style.display = 'flex', 500) } else { chosenColor = computerChooseColor(); console.log(`Computer chose ${chosenColor}`) } break; } }
    function computerChooseColor() { const c = { red: 0, green: 0, blue: 0, yellow: 0 }; computerHand.forEach(card => { if (card.color !== 'wild') c[card.color]++ }); let b = 'red', m = 0; for (const color in c) { if (c[color] > m) { m = c[color]; b = color } } return b }
    function renderAll() { renderHand(playerHand, playerHandElement, true); renderHand(computerHand, computerHandElement, false); renderDiscardPile() }
    function beginRound() { deck = createDeck(); shuffleDeck(deck); playerHand = []; computerHand = []; discardPile = []; isPlayerTurn = true; drawPenalty = 0; chosenColor = null; drawCards(playerHand, 7); drawCards(computerHand, 7); let firstCardIndex = deck.findIndex(card => !['plus2', 'plus_4', 'wild', 'skip', 'reverse'].includes(card.value)); discardPile.push(deck.splice(firstCardIndex, 1)[0]); renderAll() }
    function createDeck() { const c = ['red', 'yellow', 'green', 'blue'], v = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'plus2']; let d = []; c.forEach(co => { v.forEach(va => { d.push({ color: co, value: va }); if (va !== '0') d.push({ color: co, value: va }) }) }); for (let i = 0; i < 4; i++) { d.push({ color: 'wild', value: 'wild' }); d.push({ color: 'wild', value: 'plus_4' }) } return d }
    function shuffleDeck(d) { for (let i = d.length - 1; i > 0; i--) { const j = Math.floor(Math.random() * (i + 1));[d[i], d[j]] = [d[j], d[i]] } }
    function drawCards(h, n) { for (let i = 0; i < n; i++) { if (deck.length === 0) refillDeck(); if (deck.length > 0) h.push(deck.pop()) } }
    function renderHand(h, e, p) { e.innerHTML = ''; h.forEach((c, i) => { const d = document.createElement('div'); d.classList.add('card'); let img; if (c.value === 'wild' && c.color === 'wild') img = 'assets/wild.png'; else if (c.value === 'plus_4' && c.color === 'wild') img = 'assets/plus_4.png'; else img = `assets/${c.color}_${c.value}.png`; if (p) { d.style.backgroundImage = `url('${img}')`; d.dataset.cardIndex = i; d.addEventListener('click', () => playerPlayCard(i)) } else { d.classList.add('back') } e.appendChild(d) }) }
    function renderDiscardPile() { if (discardPile.length > 0) { const t = discardPile[discardPile.length - 1]; let i; if (chosenColor) { discardPileElement.style.boxShadow = `0 0 20px 5px ${chosenColor}`; } else { discardPileElement.style.boxShadow = ''; } if (t.value === 'wild' && t.color === 'wild') i = 'assets/wild.png'; else if (t.value === 'plus_4' && t.color === 'wild') i = 'assets/plus_4.png'; else i = `assets/${t.color}_${t.value}.png`; discardPileElement.style.backgroundImage = `url('${i}')`; discardPileElement.className = 'card' } }
    function refillDeck() { const t = discardPile.pop(); deck = [...discardPile]; shuffleDeck(deck); discardPile = [t] }
    function checkForWinner(h, p) { if (h.length === 0) { let w = 0; if (p === "You") { w = currentBet * 2; playerBalance += w; winnerMessage.textContent = `You Win! 🎉 You won $${w}!` } else { winnerMessage.textContent = `Computer Wins! You lost $${currentBet}.` } updateBalanceDisplay(); gameOverModal.style.display = 'flex'; return true } return false }
    function updateBalanceDisplay() { playerBalanceElement.textContent = playerBalance }
    function startGame() { playerHandElement.innerHTML = ''; computerHandElement.innerHTML = ''; discardPileElement.style.backgroundImage = 'none'; betMessage.textContent = ''; betAmountInput.value = MINIMUM_BET; if (playerBalance < MINIMUM_BET) { bettingTitle.textContent = "Game Over"; betMessage.textContent = "Your balance is too low to continue."; placeBetBtn.disabled = true; betAmountInput.disabled = true } else { bettingTitle.textContent = "Place Your Bet"; placeBetBtn.disabled = false; betAmountInput.disabled = false } bettingModal.style.display = 'flex' }
    placeBetBtn.addEventListener('click', () => { const b = parseInt(betAmountInput.value); if (isNaN(b) || b < MINIMUM_BET) { betMessage.textContent = `Minimum bet is $${MINIMUM_BET}.`; return } if (b > MAXIMUM_BET) { betMessage.textContent = `Maximum bet is $${MAXIMUM_BET}.`; return } if (b > playerBalance) { betMessage.textContent = 'You do not have enough balance.'; return } currentBet = b; playerBalance -= currentBet; updateBalanceDisplay(); bettingModal.style.display = 'none'; beginRound() });
    playAgainBtn.addEventListener('click', () => { gameOverModal.style.display = 'none'; startGame() });

    updateBalanceDisplay();
    startGame();
});