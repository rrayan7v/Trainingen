function binarySearch(array, target, low, high) {
    if (low > high) {
        return -1; 
    }

    let mid = Math.floor((low + high) / 2);

    if (array[mid] === target) {
        return mid; 
    } else if (array[mid] > target) {
        return binarySearch(array, target, low, mid - 1); 
    } else {
        return binarySearch(array, target, mid + 1, high); 
    }
}

let pietje = Array.from({length: 10000}, (_, i) => i + 1);
let search = 6789; 

console.time("Binaire zoektijd");
let result = binarySearch(pietje, search, 0, pietje.length - 1);
console.timeEnd("Binaire zoektijd");

if (result !== -1) {
    console.log("Gevonden index:", result);
} else {
    console.log("Getal niet gevonden");
}
