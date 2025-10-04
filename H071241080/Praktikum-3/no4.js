const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const angkaAcak = Math.floor(Math.random() * 100) + 1;
let jumlahTebakan = 0;


function tanyaTebakan() {
    rl.question('Masukkan salah satu dari angka 1 sampai 100: ', (input) => {
        const tebakan = parseInt(input);
        jumlahTebakan++;

        if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
            console.log('Input tidak valid! Masukkan angka antara 1 sampai 100.');
            tanyaTebakan();
        } else if (tebakan > angkaAcak) {
            console.log('Terlalu tinggi! Coba lagi.');
            tanyaTebakan();
        } else if (tebakan < angkaAcak) {
            console.log('Terlalu rendah! Coba lagi.');
            tanyaTebakan();
        } else {
            console.log(`Selamat! Anda menebak angka yang benar (${angkaAcak}) dalam ${jumlahTebakan} tebakan.`);
            rl.close();
        }
    });
}

tanyaTebakan();