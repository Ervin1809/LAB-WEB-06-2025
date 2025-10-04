function countEvenNumbers(start, end) {
    if (typeof start !== 'number' || typeof end !== 'number') {
        throw new Error("Error: Kedua input harus berupa angka.");
    }

    if (start > end) {
        throw new Error("Error: Nilai 'start' tidak boleh lebih besar dari 'end'.");
    }

    if (start < 0){
        throw new Error("Error: Nilai 'start' tidak boleh negatif.")
    }

    let count = [];
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            count.push(i);
        }
    }

    return {
        total: count.length,
        numbers: count
    };
}

try {
    const result1 = countEvenNumbers(-5, 10);
    console.log(`Jumlah bilangan genap: ${result1.total}`, result1.numbers); 

    const result2 = countEvenNumbers(20, 10);
    console.log(result2);

} catch (error) {
    console.error(error.message); 
}

try {
    const result3 = countEvenNumbers("satu", 10);
    console.log(result3);

} catch (error) {
    console.error(error.message); 
}