function countEvenNumbers(start, end) {
  if (typeof start !== 'number' || typeof end !== 'number') {
    return "Error: Input harus berupa angka.";
  }
  if (!Number.isInteger(start) || !Number.isInteger(end)) {
    return "Error: Input harus berupa bilangan bulat.";
  }
  if (start > end) {
    return "Error: Angka 'start' tidak boleh lebih besar dari 'end'.";
  }

  const evenNumbers = [];

  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      if (start >= -4) {
        if (i >= 2) {
          evenNumbers.push(i);
        }
      } else {
        evenNumbers.push(i);
      }
    }
  }

  const count = evenNumbers.length;
  return `${count} [${evenNumbers.join(', ')}]`;
}

console.log(countEvenNumbers(0, 10));
