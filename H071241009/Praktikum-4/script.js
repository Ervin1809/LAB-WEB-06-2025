document.addEventListener('DOMContentLoaded', () => {
    const playerHandElement = document.getElementById('player-hand');
    const botHandElement = document.getElementById('bot-hand');
    const discardPileElement = document.getElementById('discard-pile');
    const deckElement = document.getElementById('deck');
    const unoButton = document.getElementById('uno-button');
    const statusMessage = document.getElementById('status-message');
    const passTurnBtn = document.getElementById('pass-turn-btn');
    const callUnoBtn = document.getElementById('call-uno-btn');
    
    const bettingModal = document.getElementById('betting-modal');
    const gameOverModal = document.getElementById('game-over-modal');
    const colorPickerModal = document.getElementById('color-picker-modal');
    const startRoundBtn = document.getElementById('start-round-btn');
    const restartGameBtn = document.getElementById('restart-game-btn');
    const betAmountInput = document.getElementById('bet-amount');
    const playerBalanceDisplay = document.getElementById('player-balance');
    const currentBalanceDisplay = document.getElementById('current-balance-display');

    let deck = [];
    let playerHand = [];
    let botHand = [];
    let discardPile = [];
    let currentPlayer = 'player';
    let playerBalance = 5000;
    let currentBet = 0;
    let unoCallTimer;
    let botForgotUno = false; 

    function createDeck() {
        const colors = ['red', 'yellow', 'green', 'blue'];
        const values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'drawTwo'];
        let createdDeck = [];
        for (const color of colors) {
            for (const value of values) {
                createdDeck.push({ color, value });
                if (value !== '0') {
                    createdDeck.push({ color, value });
                }
            }
        }
        for (let i = 0; i < 4; i++) {
            createdDeck.push({ color: 'black', value: 'wild' });
            createdDeck.push({ color: 'black', value: 'wildDrawFour' });
        }
        return createdDeck;
    }

    function shuffleDeck(deckToShuffle) {
        for (let i = deckToShuffle.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [deckToShuffle[i], deckToShuffle[j]] = [deckToShuffle[j], deckToShuffle[i]];
        }
    }

    function dealCards() {
        playerHand = [];
        botHand = [];
        for (let i = 0; i < 7; i++) {
            playerHand.push(deck.pop());
            botHand.push(deck.pop());
        }
    }
    
    function startGame() {
        bettingModal.classList.remove('active');
        gameOverModal.classList.remove('active');
        deck = createDeck();
        shuffleDeck(deck);
        dealCards();
        discardPile = [];
        
        let firstCard = deck.pop();
        while (firstCard.color === 'black') {
            deck.push(firstCard);
            shuffleDeck(deck);
            firstCard = deck.pop();
        }
        discardPile.push(firstCard);
        updateUI();
        startPlayerTurn();
    }

    function updateUI() {
        renderHand(playerHand, playerHandElement, true);
        renderHand(botHand, botHandElement, false);
        renderDiscardPile();
        playerBalanceDisplay.innerText = playerBalance;
        currentBalanceDisplay.innerText = playerBalance;
        betAmountInput.max = playerBalance;
    }

    function renderHand(hand, element, isPlayer) {
        element.innerHTML = '';
        hand.forEach((card) => {
            let cardElement;
            if (isPlayer) {
                cardElement = createCardElement(card);
                cardElement.addEventListener('click', () => {
                    const cardIndex = playerHand.findIndex(c => c === card);
                    playerPlayCard(cardIndex);
                });
            } else {
                cardElement = document.createElement('div');
                cardElement.classList.add('card', 'back');
            }
            element.appendChild(cardElement);
        });
    }

    function renderDiscardPile() {
        discardPileElement.innerHTML = '';
        if (discardPile.length > 0) {
            const topCard = discardPile[discardPile.length - 1];
            const cardElement = createCardElement(topCard);
            cardElement.style.cursor = 'default';
            if (topCard.activeColor) {
                 cardElement.style.border = `4px solid ${topCard.activeColor}`;
                 cardElement.style.borderRadius = '12px';
            }
            discardPileElement.appendChild(cardElement);
        }
    }
    
    const valueToFilenameMap = {
        '0': '0', '1': '1', '2': '2', '3': '3', '4': '4', '5': '5', '6': '6', '7': '7', '8': '8', '9': '9',
        'reverse': '10', 'skip': '11', 'drawTwo': '12', 'wild': '13', 'wildDrawFour': '14'
    };

    function createCardElement(card) {
        const cardDiv = document.createElement('div');
        cardDiv.classList.add('card');
        if (card) {
            const fileValue = valueToFilenameMap[card.value];
            let fileName;
            if (card.color === 'black') {
                fileName = `wild${fileValue}.png`;
            } else {
                fileName = `${card.color}${fileValue}.png`;
            }
            cardDiv.style.backgroundImage = `url('asset/${fileName}')`;
            cardDiv.style.backgroundSize = 'cover';
        }
        return cardDiv;
    }
    
    function updateStatus(message) {
        statusMessage.textContent = message;
    }

    function refillDeck() {
        if (discardPile.length <= 1) {
            updateStatus("Not enough cards. Game is a draw!");
            return false;
        }
        updateStatus("Deck is empty! Shuffling...");
        const topCard = discardPile.pop();
        deck = [...discardPile];
        discardPile = [topCard];
        shuffleDeck(deck);
        return true;
    }
    
    function isCardPlayable(card, topCard) {
        if (!topCard) return true;
        const effectiveColor = topCard.activeColor || topCard.color;
        if (card.color === 'black') return true;
        return card.color === effectiveColor || card.value === topCard.value;
    }

    function playerPlayCard(cardIndex) {
        if (currentPlayer !== 'player' || cardIndex < 0) return;
        
        passTurnBtn.disabled = true;
        if (botForgotUno) {
            botForgotUno = false;
            callUnoBtn.disabled = true;
        }

        const card = playerHand[cardIndex];
        const topCard = discardPile[discardPile.length - 1];
        if (card.value === 'wildDrawFour') {
            const hasOtherPlayableCard = playerHand.some(c => c.value !== 'wildDrawFour' && isCardPlayable(c, topCard));
            if (hasOtherPlayableCard) {
                updateStatus("You can't play Wild +4. You have another playable card.");
                return;
            }
        }
        if (isCardPlayable(card, topCard)) {
            playerHand.splice(cardIndex, 1);
            discardPile.push(card);
            updateUI();
            handleCardEffect(card, 'player');
        } else {
            updateStatus("Invalid card. Try another or draw from the deck.");
        }
    }
    
    function drawCard(player) {
        if (deck.length === 0) { 
            if(!refillDeck()) return; 
        }
        const drawnCard = deck.pop();
        if(!drawnCard) return;

        if (player === 'player') {
            playerHand.push(drawnCard);
            updateUI();
            const topCard = discardPile[discardPile.length - 1];
            if (isCardPlayable(drawnCard, topCard)) {
                updateStatus("You drew a playable card. Play it or pass.");
                passTurnBtn.disabled = false;
            } else {
                updateStatus("You drew a card. Bot's turn.");
                setTimeout(endTurn, 1000);
            }
        } else {
            botHand.push(drawnCard);
            updateUI();
        }
    }

    deckElement.addEventListener('click', () => {
        if (currentPlayer === 'player') {
            const topCard = discardPile[discardPile.length - 1];
            const canPlay = playerHand.some(card => isCardPlayable(card, topCard));
            if (!canPlay) {
                drawCard('player');
            } else {
                updateStatus("You have a playable card. You don't need to draw.");
            }
        }
    });

    function handleCardEffect(card, playedBy) {
        if ((playedBy === 'player' && playerHand.length === 0) || (playedBy === 'bot' && botHand.length === 0)) { 
            endRound(playedBy); 
            return; 
        }
        
        unoButton.disabled = playerHand.length !== 1;
        if (playerHand.length === 1 && playedBy === 'player') { startUnoTimer(); }
        
        if (botHand.length === 1 && playedBy === 'bot') {
            botForgotUno = true;
        } else if (playedBy === 'bot') {
            botForgotUno = false;
        }

        const isPlayerTurn = playedBy === 'player';
        switch (card.value) {
            case 'skip':
            case 'reverse':
                updateStatus(`Turn skipped! ${isPlayerTurn ? 'Your' : "Bot's"} turn again.`);
                isPlayerTurn ? startPlayerTurn() : startBotTurn();
                return;
            case 'drawTwo':
                updateStatus(`+2 played! ${isPlayerTurn ? 'Your' : "Bot's"} turn again.`);
                if (deck.length < 2) refillDeck();
                const targetHand = isPlayerTurn ? botHand : playerHand;
                targetHand.push(deck.pop(), deck.pop());
                if(isPlayerTurn) botForgotUno = false; 
                updateUI();
                isPlayerTurn ? startPlayerTurn() : startBotTurn();
                return;
            case 'wild':
                if (isPlayerTurn) { colorPickerModal.classList.add('active'); } 
                else {
                    const chosenColor = getMostCommonColorInBotHand();
                    discardPile[discardPile.length - 1].activeColor = chosenColor;
                    updateStatus(`Bot chose ${chosenColor}.`);
                    updateUI(); 
                    endTurn();
                }
                return;
            case 'wildDrawFour':
                if (deck.length < 4) refillDeck();
                const victimHand = isPlayerTurn ? botHand : playerHand;
                victimHand.push(deck.pop(), deck.pop(), deck.pop(), deck.pop());
                if(isPlayerTurn) botForgotUno = false;
                updateUI();
                if (isPlayerTurn) { colorPickerModal.classList.add('active'); } 
                else {
                    const chosenColor = getMostCommonColorInBotHand();
                    discardPile[discardPile.length - 1].activeColor = chosenColor;
                    updateStatus(`Bot played Wild+4 and chose ${chosenColor}.`);
                    updateUI(); 
                    endTurn();
                }
                return;
        }
        endTurn();
    }
    
    function startPlayerTurn() {
        currentPlayer = 'player';
        passTurnBtn.disabled = true; 
        callUnoBtn.disabled = !botForgotUno;
        const topCard = discardPile[discardPile.length - 1];
        const canPlay = playerHand.some(card => isCardPlayable(card, topCard));
        if (canPlay) {
            updateStatus("Your turn. Play a card!");
        } else {
            updateStatus("No playable cards. Click the deck to draw.");
        }
    }

    function startBotTurn() {
        currentPlayer = 'bot';
        updateStatus("Bot's turn...");
        setTimeout(() => {
            const topCard = discardPile[discardPile.length - 1];
            const playableCards = botHand.filter(card => isCardPlayable(card, topCard));
            let bestCardToPlay = playableCards.find(card => card.value !== 'wildDrawFour');
            let cardToPlayIndex;
            if (bestCardToPlay) {
                cardToPlayIndex = botHand.findIndex(card => card === bestCardToPlay);
            } else if (playableCards.length > 0) {
                cardToPlayIndex = botHand.findIndex(card => card.value === 'wildDrawFour');
            }
            if (cardToPlayIndex > -1) {
                const card = botHand.splice(cardToPlayIndex, 1)[0];
                discardPile.push(card);
                updateUI();
                handleCardEffect(card, 'bot');
            } else {
                drawCard('bot');
                const drawnCard = botHand[botHand.length - 1];
                if (isCardPlayable(drawnCard, topCard)) {
                    setTimeout(() => {
                        const card = botHand.pop();
                        discardPile.push(card);
                        updateUI();
                        handleCardEffect(card, 'bot');
                    }, 1000);
                } else {
                    setTimeout(endTurn, 1000);
                }
            }
        }, 1500);
    }

    function endTurn() {
        currentPlayer === 'player' ? startBotTurn() : startPlayerTurn();
    }

    function getMostCommonColorInBotHand() {
        const colorCount = { red: 0, yellow: 0, green: 0, blue: 0 };
        botHand.forEach(card => {
            if (card.color !== 'black') { colorCount[card.color]++; }
        });
        let mostCommon = Object.keys(colorCount).reduce((a, b) => colorCount[a] > colorCount[b] ? a : b, 'red');
        if (colorCount[mostCommon] === 0) {
            const colors = ['red', 'yellow', 'green', 'blue'];
            return colors[Math.floor(Math.random() * colors.length)];
        }
        return mostCommon;
    }
    
    function startUnoTimer() {
        clearTimeout(unoCallTimer);
        updateStatus("You have one card left! Press UNO!");
        unoCallTimer = setTimeout(() => {
            if (playerHand.length === 1) { 
                updateStatus("You forgot to press UNO! Penalty +2 cards.");
                if (deck.length < 2) refillDeck();
                if (deck.length >= 2) { playerHand.push(deck.pop(), deck.pop()); }
                updateUI();
                unoButton.disabled = true;
            }
        }, 5000);
    }

    unoButton.addEventListener('click', () => {
        if (playerHand.length === 1) {
            clearTimeout(unoCallTimer);
            unoButton.disabled = true;
            const lastCard = playerHand[0];
            const topCard = discardPile[discardPile.length - 1];
            if (isCardPlayable(lastCard, topCard)) {
                updateStatus("UNO! Mainkan kartu terakhirmu untuk menang!");
            } else {
                updateStatus("UNO! Kartumu tidak cocok, kamu harus mengambil kartu.");
            }
        }
    });

    startRoundBtn.addEventListener('click', () => {
        const bet = parseInt(betAmountInput.value);
        if (bet >= 100 && bet <= playerBalance) {
            currentBet = bet;
            playerBalance -= currentBet;
            startGame();
        } else {
            alert("Invalid bet amount. Must be between $100 and your current balance.");
        }
    });
    
    restartGameBtn.addEventListener('click', () => {
        playerBalance = 5000; 
        bettingModal.classList.add('active');
        gameOverModal.classList.remove('active');
        updateUI();
    });

    function endRound(winner) {
        let message = '';
        if (winner === 'player') {
            playerBalance += currentBet * 2;
            message = `You won the round! You win $${currentBet}.`;
        } else {
            message = `Bot won the round! You lose $${currentBet}.`;
        }
        updateStatus(message);
        currentBet = 0;
        botForgotUno = false;
        updateUI();
        setTimeout(() => {
            if (playerBalance <= 0) {
                gameOverModal.classList.add('active'); 
            } else {
                bettingModal.classList.add('active');
            }
        }, 2500);
    }

    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const chosenColor = btn.dataset.color;
            const topCard = discardPile[discardPile.length - 1];
            if (topCard) {
                topCard.activeColor = chosenColor;
            }
            colorPickerModal.classList.remove('active');
            updateUI();
            updateStatus(`You chose ${chosenColor}.`);
            endTurn();
        });
    });

    passTurnBtn.addEventListener('click', () => {
        if (currentPlayer === 'player') {
            updateStatus("You passed your turn. Bot's turn.");
            passTurnBtn.disabled = true;
            setTimeout(endTurn, 500);
        }
    });

    callUnoBtn.addEventListener('click', () => {
        if (botForgotUno) {
            updateStatus("You called UNO! Bot gets a +2 penalty.");
            if (deck.length < 2) refillDeck();
            if (deck.length >= 2) {
                botHand.push(deck.pop(), deck.pop());
            }
            botForgotUno = false;
            callUnoBtn.disabled = true;
            updateUI();
        }
    });
});
