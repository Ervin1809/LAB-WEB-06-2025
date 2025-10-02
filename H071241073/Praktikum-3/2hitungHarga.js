const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function hitungDiskon(harga, jenis) {
  let diskon = 0;

  switch (jenis.toLowerCase()) {
    case 'elektronik':
      diskon = 0.10;
      break;
    case 'pakaian':
      diskon = 0.20;
      break;
    case 'makanan':
      diskon = 0.05;
      break;
    default:
      diskon = 0;
  }

  let potongan = harga * diskon;
  let hargaAkhir = harga - potongan;

  return { diskon, hargaAkhir };
}

rl.question('Masukkan harga barang: ', (hargaInput) => {
  let harga = parseFloat(hargaInput);

  if (isNaN(harga) || harga <= 0) {
    console.log("Harga harus berupa angka positif!");
    rl.close();
    return;
  }

  rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ', (jenis) => {
    let { diskon, hargaAkhir } = hitungDiskon(harga, jenis);

    console.log(`\nHarga awal: Rp ${harga}`);
    console.log(`\nDiskon: ${diskon * 100}%`);
    console.log(`\nHarga setelah diskon: Rp ${hargaAkhir}`);
    rl.close();
    
  });
});
