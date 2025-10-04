const readline = require("readline");

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

function hitungDiskon(harga, jenis) {
    let diskon = 0;

    switch (jenis.toLowerCase()) {
        case "elektronik":
            diskon = 0.10;
            break;
        case "pakaian":
            diskon = 0.20;
            break;
        case "makanan":
            diskon = 0.05;
            break;
        default:
            diskon = 0;
            break;
    }

    const potongan = harga * diskon;
    const total = harga - potongan;

    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskon * 100}%`);
    console.log(`Harga setelah diskon: Rp ${total}`);
}

function programDiskon() {
    rl.question("Masukkan harga barang: ", (hargaInput) => {
        const harga = parseFloat(hargaInput);
        if (isNaN(harga) || harga <= 0) {
            console.log("Input harga tidak valid. Harus berupa angka positif.");
            rl.close();
            return;
        }

        rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenis) => {
            hitungDiskon(harga, jenis);
            rl.close();
        });
    });
}
programDiskon();