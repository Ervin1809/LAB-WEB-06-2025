/* ===================== Deck & Utilitas ===================== */
function buatDeck() {
  const deck = [];
  const warna = ['blue', 'green', 'red', 'yellow'];

  for (const w of warna) {
    for (let i = 0; i <= 9; i++) {
      deck.push({ id: `${w}_${i}`, type: 'number', color: w, text: String(i) });
    }
    deck.push({ id: `${w}_plus2`, type: 'action', color: w, text: 'Draw Two' });
    deck.push({ id: `${w}_reverse`, type: 'action', color: w, text: 'Reverse' });
    deck.push({ id: `${w}_skip`, type: 'action', color: w, text: 'Skip' });
  }

  deck.push({ id: 'wild', type: 'wild', text: 'Wild' });
  deck.push({ id: 'plus_4', type: 'wild4', text: 'Wild Draw Four' });

  return deck;
}

function acakKartu(a) {
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
}

function gambarAman(src, className = 'card-img') {
  const img = document.createElement('img');
  img.src = src;
  img.className = className;
  img.onerror = function () {
    this.onerror = null;
    this.src = 'img/card_back.png';
  };
  return img;
}

/* ===================== Keadaan (State) ===================== */
const keadaan = {
  deck: [],
  discard: [],
  player: { hand: [], saidUNO: false },
  bot: { hand: [], saidUNO: false },
  balance: 5000,
  bet: 100,
  turn: null,
  activeColor: null,
  playerDrew: false,
  roundOver: false,
  lastRoundWinner: null
};

/* ===================== DOM Elemen ===================== */
const playerHandEl = document.getElementById('playerHand');
const botHandEl = document.getElementById('botHand');
const topCardEl = document.getElementById('topCard');
const deckEl = document.getElementById('deck');
const logEl = document.getElementById('log');
const balanceEl = document.getElementById('balance');
const betInput = document.getElementById('bet');
const botCountEl = document.getElementById('botCount');
const playerCountEl = document.getElementById('playerCount');
const unoBtn = document.getElementById('unoBtn');
const callUnoBtn = document.getElementById('callUnoBtn');
const skipBtn = document.getElementById('skipBtn');
const activeColorEl = document.getElementById('activeColor');
const notif = document.getElementById('notification');
const overlayFull = document.getElementById('overlayFull');
const overlayBox = document.getElementById('overlayBox');
const wildOverlay = document.getElementById('wildOverlay');

/* ===================== Lapisan Wild ===================== */
function tampilLapisanWild() {
  wildOverlay.style.display = 'flex';
}

function sembunyiLapisanWild() {
  wildOverlay.style.display = 'none';
}

function pilihWarnaWild(color) {
  const played = keadaan.discard[keadaan.discard.length - 1];
  if (played) {
    played.color = color;
    aturWarnaAktif(color);
  }
  sembunyiLapisanWild();

  if (played && played.type === 'wild4') {
    for (let i = 0; i < 4; i++) {
      const c = ambilKartu();
      if (c) keadaan.bot.hand.push(c);
    }
    tulisLog('Bot menarik 4 kartu');
    perbaruiTampilan();
  }

  keadaan.turn = 'bot';
  perbaruiTampilan();
  cekMenang();
  setTimeout(giliranBot, 600);
}

/* ===================== Notifikasi & Warna ===================== */
let notifTimer = null;

function tampilNotifikasi(text, duration = 1800, bg = '#222') {
  if (!notif) return;
  notif.textContent = text;
  notif.style.background = bg;
  notif.style.display = 'block';

  if (notifTimer) clearTimeout(notifTimer);
  if (duration > 0)
    notifTimer = setTimeout(() => {
      notif.style.display = 'none';
      notifTimer = null;
    }, duration);
}

function aturWarnaAktif(color) {
  keadaan.activeColor = color;
  activeColorEl.style.backgroundColor = color || 'transparent';
}

function tulisLog(actionMsg) {
  const nextTurnText = keadaan.turn === 'player' ? 'Giliran Anda' : 'Giliran Bot';
  logEl.innerHTML = `<div>${actionMsg} — ${nextTurnText}</div>`;
}

/* ===================== Mekanisme Kartu ===================== */
function kartuTeratas() {
  return keadaan.discard[keadaan.discard.length - 1];
}

function ambilKartu() {
  if (keadaan.deck.length === 0) {
    if (keadaan.discard.length <= 1) return null;

    const top = keadaan.discard.pop();
    keadaan.deck = keadaan.discard.splice(0);
    acakKartu(keadaan.deck);
    keadaan.discard = [top];
  }
  return keadaan.deck.pop();
}

function isCardPlayableAgainstTop(card) {
  const top = kartuTeratas();
  if (!top) return true;
  if (card.type === 'wild' || card.type === 'wild4') return true;
  if (card.color && keadaan.activeColor && card.color === keadaan.activeColor) return true;
  if (card.text && top.text && card.text === top.text) return true;
  return false;
}

function pemainPunyaKartuLainBukanWild() {
  const top = kartuTeratas();
  return keadaan.player.hand.some(c => {
    if (!c) return false;
    if (c.type === 'wild4') return false;
    if (c.color && keadaan.activeColor && c.color === keadaan.activeColor) return true;
    if (c.text && top && top.text && c.text === top.text) return true;
    return false;
  });
}

/* ===================== Render UI ===================== */
function renderTanganPemain() {
  playerHandEl.innerHTML = '';
  keadaan.player.hand.forEach((c, idx) => {
    const img = gambarAman(`img/${c.id}.png`);
    img.title = c.id;
    img.addEventListener('click', () => {
      if (keadaan.roundOver) return tampilNotifikasi('Ronde selesai');
      if (keadaan.turn !== 'player') return tampilNotifikasi('Bukan giliran Anda');
      if (!isCardPlayableAgainstTop(c)) return tulisLog('Kartu tidak cocok');
      mainkanKartu('player', idx);
    });
    playerHandEl.appendChild(img);
  });

  playerCountEl.textContent = keadaan.player.hand.length;

  if (keadaan.player.hand.length === 1) {
    unoBtn.disabled = false;
    unoBtn.className = 'btn-blue';
    mulaiTimerUnoPemain();
  } else {
    unoBtn.disabled = true;
    unoBtn.className = 'btn-disabled';
    hapusTimerUnoPemain();
  }
}

function renderTanganBot() {
  botHandEl.innerHTML = '';
  keadaan.bot.hand.forEach(() => botHandEl.appendChild(gambarAman('img/card_back.png')));
  botCountEl.textContent = keadaan.bot.hand.length;
}

function renderKartuTeratas() {
  topCardEl.innerHTML = '';
  const top = kartuTeratas();
  if (top) {
    const img = gambarAman(`img/${top.id}.png`);
    topCardEl.appendChild(img);
    if (top.color) aturWarnaAktif(top.color);
  } else {
    aturWarnaAktif(null);
  }
}

function perbaruiKeadaanDeck() {
  if (keadaan.roundOver || keadaan.turn !== 'player') {
    deckEl.classList.add('deck-disabled');
    deckEl.style.pointerEvents = 'none';
    return;
  }

  const hasPlayable = keadaan.player.hand.some(isCardPlayableAgainstTop);
  if (hasPlayable || keadaan.playerDrew) {
    deckEl.classList.add('deck-disabled');
    deckEl.style.pointerEvents = 'none';
  } else {
    deckEl.classList.remove('deck-disabled');
    deckEl.style.pointerEvents = 'auto';
  }
}

function perbaruiTampilan() {
  renderTanganPemain();
  renderTanganBot();
  renderKartuTeratas();
  balanceEl.textContent = `$${keadaan.balance}`;
  perbaruiKeadaanDeck();

  if (keadaan.turn === 'player' && keadaan.playerDrew) {
    skipBtn.disabled = false;
    skipBtn.className = 'btn-blue';
  } else {
    skipBtn.disabled = true;
    skipBtn.className = 'btn-disabled';
  }

  if (keadaan.bot.hand.length === 1 && !keadaan.bot.saidUNO && !keadaan.roundOver) {
    callUnoBtn.disabled = false;
    callUnoBtn.className = 'btn-blue';
  } else {
    callUnoBtn.disabled = true;
    callUnoBtn.className = 'btn-disabled';
  }
}

/* ===================== Mulai Ronde ===================== */
function tampilLapisan(text) {
  overlayBox.textContent = text;
  overlayFull.style.display = 'flex';
}

function mulaiRondeBaru() {
  const bet = Number(betInput.value) || 0;

  if (keadaan.balance <= 0) return tampilLapisan('GAME OVER — Saldo habis');
  if (bet < 100) return tampilNotifikasi('Taruhan minimal $100', 1800, '#c0392b');
  if (bet > keadaan.balance) return tampilNotifikasi('Taruhan melebihi saldo', 1800, '#c0392b');

  keadaan.bet = bet;
  keadaan.deck = buatDeck();
  acakKartu(keadaan.deck);

  keadaan.player.hand = [];
  keadaan.bot.hand = [];
  keadaan.discard = [];
  keadaan.player.saidUNO = false;
  keadaan.bot.saidUNO = false;
  keadaan.playerDrew = false;
  keadaan.roundOver = false;

  for (let i = 0; i < 7; i++) {
    keadaan.player.hand.push(ambilKartu());
    keadaan.bot.hand.push(ambilKartu());
  }

  const first = ambilKartu();
  if (first) keadaan.discard.push(first);
  if (first && first.color) aturWarnaAktif(first.color);

  if (keadaan.lastRoundWinner === 'player') keadaan.turn = 'bot';
  else if (keadaan.lastRoundWinner === 'bot') keadaan.turn = 'player';
  else keadaan.turn = Math.random() < 0.5 ? 'player' : 'bot';

  tulisLog(`Ronde dimulai. Giliran ${keadaan.turn === 'player' ? 'Anda' : 'Bot'}`);
  perbaruiTampilan();

  if (keadaan.turn === 'bot') setTimeout(giliranBot, 600);

  // Jika kartu pertama adalah wild
  const firstCard = kartuTeratas();
  if (keadaan.turn === 'player' && firstCard && (firstCard.type === 'wild' || firstCard.type === 'wild4')) {
    tulisLog('Pilih warna untuk kartu pertama');
    tampilLapisanWild();
  }
}

/* ===================== Cek Menang ===================== */
function cekMenang() {
  if (keadaan.player.hand.length === 0) {
    keadaan.lastRoundWinner = 'player';
    keadaan.balance += keadaan.bet;
    keadaan.roundOver = true;
    perbaruiTampilan();
    tampilLapisan(`Anda Menang +$${keadaan.bet}`);
    tulisLog('Anda memenangkan ronde!');
    return true;
  }

  if (keadaan.bot.hand.length === 0) {
    keadaan.lastRoundWinner = 'bot';
    keadaan.balance -= keadaan.bet;
    keadaan.roundOver = true;
    perbaruiTampilan();
    tampilLapisan(`Anda Kalah -$${keadaan.bet}`);
    tulisLog('Bot memenangkan ronde!');
    return true;
  }

  if (keadaan.balance <= 0) {
    keadaan.roundOver = true;
    tampilLapisan('GAME OVER — Saldo habis');
    return true;
  }

  return false;
}

/* ===================== Timer UNO Pemain ===================== */
let playerUnoTimer = null;

function mulaiTimerUnoPemain() {
  hapusTimerUnoPemain();
  playerUnoTimer = setTimeout(() => {
    for (let i = 0; i < 2; i++) {
      const c = ambilKartu();
      if (c) keadaan.player.hand.push(c);
    }
    tampilNotifikasi('Anda lupa tekan UNO! +2 kartu', 2200, '#c0392b');
    keadaan.player.saidUNO = false;
    perbaruiTampilan();
  }, 5000);
}

function hapusTimerUnoPemain() {
  if (playerUnoTimer) {
    clearTimeout(playerUnoTimer);
    playerUnoTimer = null;
  }
}

/* ===================== Mainkan Kartu ===================== */
function mainkanKartu(who, idx) {
  if (keadaan.roundOver || keadaan.turn !== who) return;

  const hand = who === 'player' ? keadaan.player.hand : keadaan.bot.hand;
  const card = hand[idx];
  if (!card) return;

  if (!isCardPlayableAgainstTop(card)) return tulisLog('Kartu tidak cocok');

  if (card.type === 'wild4' && who === 'player' && pemainPunyaKartuLainBukanWild()) {
    tampilNotifikasi('Tidak boleh main +4 jika masih punya kartu yang cocok', 2000, '#c0392b');
    return;
  }

  const played = hand.splice(idx, 1)[0];
  keadaan.discard.push(played);
  keadaan.playerDrew = false;

  // Wild
  if (played.type === 'wild' || played.type === 'wild4') {
    if (who === 'player') {
      tulisLog('Pilih warna untuk kartu Wild');
      tampilLapisanWild();
      return;
    } else {
      const choose = keadaan.bot.hand.find(c => c.color)?.color || 'red';
      played.color = choose;
      aturWarnaAktif(choose);

      if (played.type === 'wild4') {
        for (let i = 0; i < 4; i++) {
          const c = ambilKartu();
          if (c) keadaan.player.hand.push(c);
        }
        tulisLog('Anda menarik 4 kartu');
      }
    }
  }

  // Kartu aksi
  if (played.type === 'action') {
    const target = who === 'player' ? 'bot' : 'player';

    if (played.text === 'Skip' || played.text === 'Reverse') {
      keadaan.turn = target === 'player' ? 'bot' : 'player';
      tulisLog(`${target === 'player' ? 'Anda' : 'Bot'} dilewati! (${played.text})`);
      perbaruiTampilan();
      cekMenang();
      if (keadaan.turn === 'bot') setTimeout(giliranBot, 600);
      return;
    }

    if (played.text === 'Draw Two') {
      for (let i = 0; i < 2; i++) {
        const c = ambilKartu();
        if (target === 'player' && c) keadaan.player.hand.push(c);
        else if (target === 'bot' && c) keadaan.bot.hand.push(c);
      }
      tulisLog(`${target === 'player' ? 'Anda' : 'Bot'} menarik 2 kartu!`);
      if (target === 'bot') keadaan.turn = 'player';
      perbaruiTampilan();
      cekMenang();
      if (keadaan.turn === 'bot') setTimeout(giliranBot, 600);
      return;
    }
  }

  keadaan.turn = who === 'player' ? 'bot' : 'player';
  tulisLog(`${who === 'player' ? 'Anda' : 'Bot'} main ${played.id}`);
  perbaruiTampilan();
  cekMenang();

  if (keadaan.turn === 'bot') setTimeout(giliranBot, 600);
}

/* ===================== Bot (sederhana) ===================== */
function giliranBot() {
  if (keadaan.roundOver || keadaan.turn !== 'bot') return;

  const hand = keadaan.bot.hand;
  for (let i = 0; i < hand.length; i++) {
    if (isCardPlayableAgainstTop(hand[i])) {
      mainkanKartu('bot', i);
      return;
    }
  }

  const c = ambilKartu();
  if (c) {
    hand.push(c);
    tulisLog('Bot menarik kartu');
    perbaruiTampilan();
  }

  const last = hand[hand.length - 1];
  if (last && isCardPlayableAgainstTop(last)) {
    setTimeout(() => mainkanKartu('bot', hand.length - 1), 500);
    return;
  }

  keadaan.turn = 'player';
  tulisLog('Giliran Anda');
  perbaruiTampilan();
}

/* ===================== Event Listeners ===================== */
document.getElementById('startRound').addEventListener('click', mulaiRondeBaru);

deckEl.addEventListener('click', () => {
  if (keadaan.turn !== 'player' || keadaan.playerDrew) return;
  const c = ambilKartu();
  if (c) {
    keadaan.player.hand.push(c);
    keadaan.playerDrew = true;
    tulisLog('Anda menarik kartu');
    perbaruiTampilan();

    if (isCardPlayableAgainstTop(c))
      tampilNotifikasi('Kartu baru bisa dimainkan atau lewati giliran', 2000, '#f39c12');
  }
});

skipBtn.addEventListener('click', () => {
  if (keadaan.turn !== 'player') return;
  keadaan.turn = 'bot';
  keadaan.playerDrew = false;
  tulisLog('Anda melewati giliran');
  perbaruiTampilan();
  setTimeout(giliranBot, 500);
});

unoBtn.addEventListener('click', () => {
  keadaan.player.saidUNO = true;
  tampilNotifikasi('UNO!');
  unoBtn.disabled = true;
  unoBtn.className = 'btn-disabled';
  hapusTimerUnoPemain();
});

callUnoBtn.addEventListener('click', () => {
  if (!keadaan.bot.saidUNO && keadaan.bot.hand.length === 1) {
    for (let i = 0; i < 2; i++) {
      const c = ambilKartu();
      if (c) keadaan.bot.hand.push(c);
    }
    tampilNotifikasi('Bot lupa UNO! +2 kartu', 2000, '#c0392b');
    keadaan.bot.saidUNO = true;
    perbaruiTampilan();
  }
});

overlayFull.addEventListener('click', () => {
  overlayFull.style.display = 'none';
});
