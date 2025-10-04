const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const hari = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];

rl.question("Masukkan hari : ", (hariAwal) => {
  rl.question("Masukkan hari yang akan datang : ", (jumlahHari) => {
    hariAwal = hariAwal.toLowerCase();

    let indexAwal = hari.indexOf(hariAwal);
    let sisa = jumlahHari % 7;
    let indexHasil = (indexAwal + sisa) % 7;
    let hariTujuan = hari[indexHasil];

    console.log(`output: ${jumlahHari} hari setelah ${hariAwal} adalah ${hariTujuan}`);

    rl.close();
  });
});
