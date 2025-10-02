function countEvenNumbers(start, end) {
    if (typeof start !== 'number' || typeof end !== 'number' || isNaN(start) || isNaN(end)) {
        throw new Error("Error: Kedua input harus berupa angka.");
    }

    if (start > end) {
        throw new Error("Error: Nilai 'start' tidak boleh lebih besar dari 'end'.");
    }

    if (start < 0) {
        throw new Error("Error: Nilai 'start' tidak boleh negatif.");
    }

    let evenNumbers = [];
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            evenNumbers.push(i);
        }
    }

    return {
        total: evenNumbers.length,
        numbers: evenNumbers
    };
}

// Contoh penggunaan fungsi yang benar
try {
    const result1 = countEvenNumbers(2, 10);
    console.log(`Jumlah bilangan genap: ${result1.total}`, result1.numbers); 
} catch (error) {
    console.error(error.message);
}

// Error Handling fungsi dengan inputan nilai min
try {
    const result2 = countEvenNumbers(-5, 10);
    console.log(result2);
} catch (error) {
    console.error(error.message);
}

// Error Handling fungsi dengan inputan nilai start < end
try {
    const result3 = countEvenNumbers(20, 10);
    console.log(result3);
} catch (error) {
    console.error(error.message);
}

// Error Handling fungsi dengan inputan bukan angka
try {
    const result4 = countEvenNumbers("satu", 10);
    console.log(result4);
} catch (error) {
    console.error(error.message);
}
