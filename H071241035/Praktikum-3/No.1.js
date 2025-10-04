function countEvenNumber(s, e){
    let count = [];
    for(let i = s; i <= e; i++){
        if( i % 2 == 0){
            count.push(i);
        }
    }
    console.log(`Output : ${count.length} [${count}]`)
}
countEvenNumber(1, 20)