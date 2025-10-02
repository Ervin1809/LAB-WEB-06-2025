function countEvenNumbers(start, end) {
    if (typeof start !== "number" || typeof end !== "number") {
        throw new Error("Harus Berupa Angka!");

    }
    if (start > end) {
        throw new Error("end harus lebih besar dari start!")
    }
    if (start < 0) {
        throw new Error("start harus berupa angka positif!")
    }
    let evenNumbers=[]
    for (let i= start; i <= end; i++){
        if (i % 2 === 0) {
                evenNumbers.push(i);
        }
    }
    console.log(`Hasil penjumlahan bilangan genap adalah ${evenNumbers.length}[${evenNumbers.join(",")}] `);
    return evenNumbers.length
}  

try {
    const fungsi1 = countEvenNumbers(-5, 10);
    console.log(fungsi1);
} catch (Error) {
    console.error(Error.message);
}