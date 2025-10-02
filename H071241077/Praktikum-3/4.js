const readline = require("readline");

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

console.log("Tebak angka antara 1 sampai 100!");

function gameTebakAngka() {
    const target = Math.floor(Math.random() * 100) + 1;
    let percobaan = 0;

    function tanyaTebakan() {
      
        rl.question("Masukkan salah satu dari angka 1 sampai 100: ", (input) => {
            const tebakan = parseInt(input);
            if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
                console.log("Input harus berupa angka antara 1 dan 100.");
                return tanyaTebakan();
            }

            percobaan++;

            if (tebakan < target) {
                console.log("Terlalu rendah! Coba lagi.");
                tanyaTebakan();
            } else if (tebakan > target) {
                console.log("Terlalu tinggi! Coba lagi.");
                tanyaTebakan();
            } else {
                console.log(`Selamat! Kamu menebak angka ${target} dengan benar.`);
                console.log(`Jumlah percobaan: ${percobaan}x`);
                rl.close();
            }
        });
    }

    tanyaTebakan();
}
gameTebakAngka();