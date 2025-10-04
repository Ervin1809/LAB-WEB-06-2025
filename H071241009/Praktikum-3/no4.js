const readline = require('readline');

const angkaRahasia = Math.floor(Math.random() * 100) + 1;
let jumlahPercobaan = 0;

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

console.log("Komputer telah memilih sebuah angka antara 1 dan 100. Coba tebak!");
console.log("Ketik 'keluar' kapan saja untuk berhenti bermain.");

function mulaiTebak() {
    rl.question("Masukkan tebakan Anda (atau ketik 'keluar' untuk berhenti): ", (jawaban) => {
        if (jawaban.toLowerCase() === 'keluar') {
            console.log(`\nAnda telah memilih untuk berhenti. Angka yang benar adalah ${angkaRahasia}.`);
            rl.close();
            return; 
        }

        jumlahPercobaan++; 
        
        try {
            const tebakan = parseInt(jawaban);

            if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
                throw new Error("Input tidak valid! Masukkan angka antara 1 sampai 100.");
            }

            if (tebakan === angkaRahasia) {
                console.log(`Selamat! Anda berhasil menebak angka ${angkaRahasia} dengan benar.`);
                console.log(`Anda menebak sebanyak ${jumlahPercobaan} kali.`);
                rl.close(); 
            } else {
                if (tebakan > angkaRahasia) {
                    console.log("Terlalu tinggi! Coba lagi.");
                } else {
                    console.log("Terlalu rendah! Coba lagi.");
                }
                mulaiTebak(); 
            }
        } catch (err) {
            console.log("Error:", err.message);
            mulaiTebak(); 
        }
    });
}

mulaiTebak();