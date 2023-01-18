// window.open('http://google.com');
window.addEventListener('DOMContentLoaded', () => {
    // Declare variables for first number, second number and operator
    var firstNumber, secondNumber, operator;
    secondNumber = 0;
    const display = document.getElementById('display');
    const number = document.querySelectorAll('.number');
    //数字の表示
    number.forEach(elem => {
        elem.addEventListener('click', event => {
            display.value += event.target.value;
            if(operator != null){
                secondNumber += event.target.value;
                console.log(operator);
                console.log(secondNumber);
            }
        });
    });
    //演算子の表示
    const ope = document.querySelectorAll('.operator');
    ope.forEach(elem => {
        elem.addEventListener('click', event => {
            //一つ目の数値を保存
            firstNumber = display.value;
            console.log(firstNumber);
            //演算子を保存
            operator = event.target.value;
            display.value += ' ' + event.target.value + ' ';
        });
    });

    const squared = document.getElementById('square');
    squared.addEventListener('click', event => {
        display.value = parseFloat(display.value) * parseFloat(display.value);
        operator = null;
        firstNumber = display.value;
    });
    const root = document.getElementById('root');
    root.addEventListener('click', event => {
        display.value = Math.sqrt(parseFloat(display.value));
        operator = null;
        firstNumber = display.value;
    });
    //イコールの処理・演算確定
    const equals = document.getElementById('equals'); 
    equals.addEventListener("click", handleEqual);
    //リセット
    const clear = document.getElementById('clear');
    clear.addEventListener('click', event => {
        display.value = '';
        firstNumber = parseFloat(display.value);
        secondNumber = 0;
        operator = null;
    });

    const del = document.getElementById('delete');
    del.addEventListener('click', event => {
        operator = null;
        secondNumber = 0;
        display.value = display.value.substring(0, display.value.length - 3);
    });

// // Function to handle operator button clicks
// function handleOperator(event) {
//     operator = event.target.innerHTML; // Get the operator from the button's innerHTML
//     firstNumber = Number(display.value); // Get the first number from the text box
//     display.value = ""; // Clear the text box for the second number
// }

// Function to handle equal button clicks
function handleEqual() {
    switch (operator) {
        case "+":
            result = parseFloat(firstNumber) + parseFloat(secondNumber);
            break;
        case "-":
            result = parseFloat(firstNumber) - parseFloat(secondNumber);
            break;
        case "X":
            result = parseFloat(firstNumber) * parseFloat(secondNumber);
            break;
        case "÷":
            result = parseFloat(firstNumber) / parseFloat(secondNumber);
            break２
    }
    secondNumber = 0;
    operator = null;
    display.value = result;
    firstNumber = display.value; 
}

// // Attach event listeners to the operator buttons
// var operatorButtons = document.getElementsByClassName("operator");
// for (var i = 0; i < operatorButtons.length; i++) {
//     operatorButtons[i].addEventListener("click", handleOperator);
// }

});

