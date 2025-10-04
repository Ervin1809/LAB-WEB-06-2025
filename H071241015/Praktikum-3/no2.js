const readline = require('readline');

function hitungHarga(jenis, harga) {
    let jenisBarang = jenis.toLowerCase();
    let HargaBarang = harga;

    if (isNaN(HargaBarang) || HargaBarang <= 0) {
        throw new Error("Input harga tidak valid! Masukkan angka lebih dari 0.");
    }

    if (jenisBarang === "elektronik") {
        let diskon = 0.1 * HargaBarang;
        let totalHarga = HargaBarang - diskon;
        console.log("Harga awal: Rp " + HargaBarang);
        console.log("Diskon: 10%");
        console.log("Harga setelah diskon: Rp " + totalHarga);
    }
    else if (jenisBarang === "pakaian") {
        let diskon = 0.2 * HargaBarang;
        let totalHarga = HargaBarang - diskon;
        console.log("Harga awal: Rp " + HargaBarang);
        console.log("Diskon: 20%");
        console.log("Harga setelah diskon: Rp " + totalHarga);
    }
    else if (jenisBarang === "makanan") {
        let diskon = 0.05 * HargaBarang;
        let totalHarga = HargaBarang - diskon;
        console.log("Harga awal: Rp " + HargaBarang);
        console.log("Diskon: 5%");
        console.log("Harga setelah diskon: Rp " + totalHarga);
    }
    else {
        throw new Error("Jenis barang tidak valid! Pilih: elektronik, pakaian, atau makanan.");
    }
}

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question("Masukkan harga barang: ", function(harga) {
    rl.question("Masukkan jenis barang (elektronik, pakaian, makanan): ", function(jenis) {
        try {
            hitungHarga(jenis, parseFloat(harga));
        } catch (err) {
            console.log("Error:", err.message);
        }
        rl.close();
    });
});

