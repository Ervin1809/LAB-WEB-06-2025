const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const angkaRahasia = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;

function tanya() {
  rl.question("Masukkan salah satu dari angka 1 sampai 100: ", (jawaban) => {
    let tebak = parseInt(jawaban);
    if (isNaN(tebak) || tebak < 1 || tebak > 100) {
      console.log("Masukkan angka valid antara 1-100!");
      tanya();
      return;
    }

    percobaan++;
    if (tebak === angkaRahasia) {
      console.log(`Selamat! Kamu berhasil menebak angka ${angkaRahasia} dengan benar.`);
      console.log(`Sebanyak ${percobaan}x percobaan.`);
      rl.close();
    } else if (tebak > angkaRahasia) {
      console.log("Terlalu tinggi! Coba lagi.");
      tanya();
    } else {
      console.log("Terlalu rendah! Coba lagi.");
      tanya();
    }
  });
}

tanya();
