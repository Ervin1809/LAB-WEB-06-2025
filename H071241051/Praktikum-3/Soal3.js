const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const daftarHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

rl.question('Masukkan hari : ', (hariIni) => {
  const hariAwalLower = hariIni.toLowerCase();
  const indexHariAwal = daftarHari.indexOf(hariAwalLower);

  if (indexHariAwal === -1) {
    console.log(`\nError: Nama hari "${hariIni}" tidak valid.`);
    rl.close();
    return;
  }

  rl.question('Masukkan hari yang akan datang : ', (jumlahHariInput) => {
    const jumlahHari = parseInt(jumlahHariInput, 10);

    if (isNaN(jumlahHari) || jumlahHari < 0) {
      console.log('\nError: Jumlah hari harus berupa angka positif.');
      rl.close();
      return;
    }

    const indexHariDepan = (indexHariAwal + jumlahHari) % 7;
    const namaHariDepan = daftarHari[indexHariDepan];
    const hasilAkhir = namaHariDepan.charAt(0).toUpperCase() + namaHariDepan.slice(1);

    console.log(`\nOutput : ${jumlahHari} hari setelah ${hariAwalLower} adalah ${hasilAkhir}`);
    rl.close();
  });
});