const readline = require('readline');

function hitungHari(hariini, harimendatang) {
    let namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    let hariIniIndex = namaHari.findIndex(h => h.toLowerCase() === hariini.toLowerCase());

    if (hariIniIndex === -1) {
        throw new Error("Nama hari tidak valid!");
    }

    if (isNaN(harimendatang) || harimendatang < 0) {
        throw new Error("Jumlah hari harus berupa angka positif!");
    }

    let akandatang = (hariIniIndex + (harimendatang % 7)) % 7;

    console.log("Hari ini adalah hari " + namaHari[hariIniIndex]);
    console.log(harimendatang + " hari setelah " + hariini + " adalah " + namaHari[akandatang]);

    return namaHari[akandatang];
}

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question("Masukkan nama hari ini: ", function(hariini) {
    rl.question("Masukkan jumlah hari yang akan datang: ", function(harimendatang) {
        try {
            hitungHari(hariini, parseInt(harimendatang));
        } catch (err) {
            console.log("Error:", err.message);
        }
        rl.close();
    });
});
