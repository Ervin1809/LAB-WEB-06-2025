const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function hitungHargaSetelahDiskon(harga, jenisBarang) {
  let diskon = 0;
  switch (jenisBarang.toLowerCase()) {
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
  const potonganHarga = harga * diskon;
  return harga - potonganHarga;
}

rl.question('Masukkan harga barang: ', (hargaInput) => {
  const harga = parseFloat(hargaInput);

  if (isNaN(harga) || harga < 0) {
    console.log('\nError: Harga yang dimasukkan tidak valid. Harap masukkan angka positif.');
    rl.close();
    return;
  }

  rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ', (jenisInput) => {
    const hargaAkhir = hitungHargaSetelahDiskon(harga, jenisInput);
    console.log(`\nHarga akhir setelah diskon adalah: Rp${hargaAkhir.toLocaleString('id-ID')}`);
    rl.close();
  });
});