const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const hari = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

rl.question("Masukkan hari: ", (hariInput) => {
  const indexHari = hari.indexOf(hariInput.toLowerCase());
  if (indexHari === -1) {
    console.log("Hari tidak valid!");
    rl.close();
    return;
  }

  rl.question("Masukkan jumlah hari yang akan datang: ", (nInput) => {
    let n = parseInt(nInput);
    if (isNaN(n) || n < 0) {
      console.log("Jumlah hari harus angka positif!");
      rl.close();
      return;
    }

    let hasil = (indexHari + n) % 7;
    console.log(`${n} hari setelah ${hariInput} adalah ${hari[hasil]}`);
    rl.close();
  });
});
