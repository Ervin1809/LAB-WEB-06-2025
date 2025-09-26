// Kamu diminta untuk membuat permainan di mana komputer secara acak memilih sebuah angka antara 1 dan 100. Pemain harus menebak angka
// tersebut. Setiap kali pemain memberikan tebakan, komputer memberikan petunjuk apakah angka yang dipilih terlalu tinggi atau terlalu rendah.
// Permainan berlanjut sampai pemain menebak angka yang benar. Program harus menghitung jumlah tebakan yang diperlukan dan menampilkan
// hasilnya.
// Contoh :
// Masukkan salah satu dari angka 1 sampai 100: 85
// Terlalu tinggi! Coba lagi.
// Masukkan salah satu dari angka 1 sampai 100: 72
// Terlalu tinggi! Coba lagi.
// Masukkan salah satu dari angka 1 sampai 100: 20
// Terlalu rendah! Coba lagi.
// Masukkan salah satu dari angka 1 sampai 100: 65
// Terlalu rendah! Coba lagi.
// Masukkan salah satu dari angka 1 sampai 100: 71
// Selamat! kamu berhasil menebak angka 71 dengan benar.
// Sebanyak 5x percobaan

// const readline = require('readline');
// const rl = readline.createInterface({
//     input: process.stdin,
//     output: process.stdout
// })

// rl.question("Masukkan salah satu dari angka 1 sampai 100:", (angkaMasuk) => {
//     let angka = parseInt(angkaMasuk);
//     let angkaRandom = Math.floor(Math.random() * 100) + 1;
//     let percobaan = 0;
//     console.log(angkaRandom);
//     while (angka == angkaRandom){
//         if(angka == angkaRandom){
//             percobaan++;
//             console.log("Selamat! kamu berhasil menebak angka " + angkaRandom + " dengan benar.");
//             console.log("Sebanyak " + percobaan + "x percobaan");
//             break;
//         }else if (angka > angkaRandom){
//             percobaan++;
//             console.log("Terlalu tinggi! Coba lagi.")
//             rl.question("Masukkan salah satu dari angka 1 sampai 100:", (angkaMasuk) => {
//                 angka = parseInt(angkaMasuk);
//             })
//         }else{
//             percobaan++;
//             console.log("Terlalu rendah! Coba lagi.")
//             rl.question("Masukkan salah satu dari angka 1 sampai 100:", (angkaMasuk) => {
//                 angka = parseInt(angkaMasuk);
//             })
//         }
//       break;
//     }
//   }) 


const readline = require("readline");
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;
console.log(target);


function tanya() {
  rl.question("Masukkan salah satu dari angka 1 sampai 100: ", (jawab) => {
    const angka = parseInt(jawab);
    percobaan++;

    if (angka === target) {
      console.log(`Selamat! kamu berhasil menebak angka ${target} dengan benar.`);
      console.log(`Sebanyak ${percobaan}x percobaan`);
      rl.close();
    } else if (angka > target) {
      console.log("Terlalu tinggi! Coba lagi.");
      tanya();
    } else {
      console.log("Terlalu rendah! Coba lagi.");
      tanya();
    }
  });
}

tanya();
