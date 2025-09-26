function countEvenNumbers(start, end) {
    let count = [];
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            count.push(i);
        }
    }
    console.log(count.length, count);
} 

countEvenNumbers(1, 10);

