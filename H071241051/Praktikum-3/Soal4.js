const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const nomorRahasia = Math.floor(Math.random() * 100) + 1;
let jumlahTebakan = 0;

console.log("Saya sudah memilih sebuah angka antara 1 dan 100. Silakan tebak!");

function mulaiTebak() {
  rl.question('Masukkan salah satu dari angka 1 sampai 100: ', (jawaban) => {
    const tebakan = parseInt(jawaban);

    if (isNaN(tebakan)) {
      console.log('Input tidak valid. Harap masukkan sebuah angka.');
      mulaiTebak();
      return;
    }

    if (tebakan < 1 || tebakan > 100) {
      console.log('Tebakan di luar rentang. Harap masukkan angka antara 1 dan 100.');
      mulaiTebak();
      return;
    }
    
    jumlahTebakan++;

    if (tebakan < nomorRahasia) {
      console.log('Terlalu rendah! Coba lagi.');
      mulaiTebak();
    } else if (tebakan > nomorRahasia) {
      console.log('Terlalu tinggi! Coba lagi.');
      mulaiTebak();
    } else {
      console.log(`Selamat! kamu berhasil menebak angka ${nomorRahasia} dengan benar.`);
      console.log(`Sebanyak ${jumlahTebakan}x percobaan.`);
      rl.close();
    }
  });
}

mulaiTebak();