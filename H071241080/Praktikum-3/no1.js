function countEvenNumbers(start, end) {

    if (typeof start !== "number" || typeof end !== "number" || isNaN(start) || isNaN(end)) {
        console.log("Input harus berupa angka.");
        return;
    }

    if (start > end) {
        console.log("Nilai awal harus kurang dari nilai akhir.");
        return;
    }

    if (start < 0) {
        console.log("Nilai awal tidak boleh negatif.");
        return;
    }

    let genap = [];

    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            genap.push(i);
        }
    }

    console.log(genap.length, genap);
}

countEvenNumbers(-5, 10);
