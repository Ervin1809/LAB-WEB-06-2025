const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question("Masukkan harga barang: ", (hargaInput) => {
    let harga = parseFloat(hargaInput); 

    if (isNaN(harga) || harga <= 0) {
        console.log("Input harga harus berupa angka yang valid!");
        rl.close();
        return;
    }

    rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenisInput) => {
        let jenis = jenisInput.toLowerCase(); 
        let diskonPersen = 0;

        if (jenis === "elektronik") {
            diskonPersen = 10;
        } else if (jenis === "pakaian") {
            diskonPersen = 20;
        } else if (jenis === "makanan") {
            diskonPersen = 5;
        } else if (jenis === "lainnya") {
            diskonPersen = 0;
        } else {
            console.log("Jenis barang tidak valid! Pilih: Elektronik, Pakaian, Makanan, atau Lainnya.");
            rl.close();
            return;
        }

        let potongan = harga * (diskonPersen / 100);
        let hargaAkhir = harga - potongan;

        console.log(`Harga awal: Rp ${harga}`);
        console.log(`Diskon: ${diskonPersen}%`);
        console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);

        rl.close();
    });
});
