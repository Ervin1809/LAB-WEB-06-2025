const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

rl.question("Masukkan hari (Senin-Minggu): ", (hariInput) => {
    let hariIni = hariInput.charAt(0).toUpperCase() + hariInput.slice(1).toLowerCase(); 

    if (!days.includes(hariIni)) {
        console.log("Hari tidak valid!");
        rl.close();
        return;
    }

    rl.question("Masukkan jumlah hari ke depan: ", (jumlahInput) => {
        let jumlahHari = parseInt(jumlahInput);

        if (isNaN(jumlahHari) || jumlahHari < 0) {
            console.log("Jumlah hari harus berupa angka positif!");
            rl.close();
            return;
        }

        let indexHariIni = days.indexOf(hariIni);
        let indexHariBaru = (indexHariIni + jumlahHari) % 7;
        let hasil = days[indexHariBaru];

        console.log(`${jumlahHari} hari setelah ${hariIni.toLowerCase()} adalah ${hasil}`);

        rl.close();
    });
});
