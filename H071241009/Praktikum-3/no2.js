const readline = require('readline');

function hitungHarga(jenis, harga) {
    if (isNaN(harga) || harga <= 0) {
        throw new Error("Input harga tidak valid! Masukkan angka lebih dari 0.");
    }

    let persenDiskon = 0;
    const jenisLower = jenis.toLowerCase();

    if (jenisLower === "elektronik") {
        persenDiskon = 0.10; 
    } else if (jenisLower === "pakaian") {
        persenDiskon = 0.20; 
    } else if (jenisLower === "makanan") {
        persenDiskon = 0.05; 
    } else if (jenisLower === "lainnya") {    
        persenDiskon = 0;
    } else {
        throw new Error("Jenis barang tidak valid! Pilih: elektronik, pakaian, makanan, atau lainnya.");
    }

    const totalDiskon = harga * persenDiskon;
    const hargaAkhir = harga - totalDiskon;

    console.log(`\nHarga Awal: Rp ${harga}`);
    console.log(`Diskon: ${persenDiskon * 100}%`);
    console.log(`Harga Setelah Diskon: Rp ${hargaAkhir}`);
}

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question("Masukkan harga barang: ", (harga) => {
    rl.question("Masukkan jenis barang (elektronik, pakaian, makanan, lainnya): ", (jenis) => {
        try {
            hitungHarga(jenis, parseFloat(harga));
        } catch (err) {
            console.error("Error:", err.message);
        }
        rl.close();
    });
});