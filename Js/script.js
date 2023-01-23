function setNextValue(nextValue) {
    //localStorage.setItem("CapsNum", nextValue);
    document.getElementById("quantity").value = nextValue;
  }

function PlusCaps() {
	var nextValue = parseInt(document.getElementById("quantity").value) + 1;
    console.log(nextValue);
    setNextValue(nextValue);
}

function MinusCaps() {
    var nextValue = parseInt(document.getElementById("quantity").value) - 1;
    console.log(nextValue);
    setNextValue(nextValue);
}