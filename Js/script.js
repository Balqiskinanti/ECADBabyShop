function increment() {
    console.log("Plus");
    let currentValue = parseInt(event.target.previousElementSibling.value);
    if (currentValue < 10) {
        event.target.previousElementSibling.value = currentValue + 1;
    }
}

function decrement() {
    console.log("Minus");
    let currentValue = parseInt(event.target.nextElementSibling.value);
    if (currentValue > 1) {
        event.target.nextElementSibling.value = currentValue - 1;
    }
}