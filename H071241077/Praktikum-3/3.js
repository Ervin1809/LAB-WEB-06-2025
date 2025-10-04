const readline = require("readline");

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const hari = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

function hitungHari(hariIni, jumlahHari) {
    hariIni = hariIni.toLowerCase();

    if (!hari.includes(hariIni)) {
        console.log("Nama hari tidak valid!");
        return;
    }

    const indexHariIni = hari.indexOf(hariIni);
    const indexHariBaru = (indexHariIni + (jumlahHari % 7)) % 7;

    console.log(`${jumlahHari} hari setelah ${hariIni} adalah ${hari[indexHariBaru].charAt(0).toUpperCase() + hari[indexHariBaru].slice(1)}`);
}

function programHari() {
    rl.question("Masukkan hari: ", (hariInput) => {
        rl.question("Masukkan hari yang akan datang: ", (jumlahInput) => {
            const jumlahHari = parseInt(jumlahInput);
            if (isNaN(jumlahHari) || jumlahHari < 0) {
                console.log("Jumlah hari harus angka positif!");
            } else {
                hitungHari(hariInput, jumlahHari);
            }
            rl.close();
        });
    });
}
programHari();
