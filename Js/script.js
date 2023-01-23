function setNextValue(nextValue) {
    //localStorage.setItem("CapsNum", nextValue);
    document.getElementById("quantity").value = nextValue;
  }

function PlusCaps() {
	var nextValue = parseInt(document.getElementById("quantity").value) + 1;
    console.log(nextValue);
    if (nextValue > 10)
        nextValue = 10;
    setNextValue(nextValue);
}

function MinusCaps() {
    var nextValue = parseInt(document.getElementById("quantity").value) - 1;
    console.log(nextValue);
    setNextValue(nextValue);
}