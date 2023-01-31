window.addEventListener('DOMContentLoaded', () => {
  // 変数宣言
  var firstNumber, secondNumber, operator;
  secondNumber = 0;
  var history = document.getElementById("history");
  const display = document.getElementById('display');
  const number = document.querySelectorAll('.number');
  //数字の表示
  number.forEach(elem => {
    elem.addEventListener('click', event => {
      display.value += event.target.value;
      if (operator) {
        secondNumber += event.target.value;
      }
    });
  });
  //演算子の表示
  const ope = document.querySelectorAll('.operator');
  ope.forEach(elem => {
    elem.addEventListener('click', event => {
      if (!operator) {
        //一つ目の数値を保存
        firstNumber = display.value;
        //演算子を保存
        operator = event.target.value;
        display.value += ' ' + event.target.value + ' ';
      } else {
        alert("演算子を同時に複数利用することはできません！");
      }
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
    result = '';
    reset();
  });

  //一文字削除
  const del = document.getElementById('delete');
  del.addEventListener('click', event => {
    display.value = display.value.substring(0, display.value.length - 3);
  });


  // 演算子ボタンの処理
  function handleEqual() {
    switch (operator) {
      case "+":
        result = parseFloat((parseFloat(firstNumber) + parseFloat(secondNumber)).toFixed(5));
        break;
      case "-":
        result = parseFloat((parseFloat(firstNumber) - parseFloat(secondNumber)).toFixed(5));
        break;
      case "X":
        result = parseFloat((parseFloat(firstNumber) * parseFloat(secondNumber)).toFixed(5));
        break;
      case "/":
        result = parseFloat((parseFloat(firstNumber) / parseFloat(secondNumber)).toFixed(5));
        break
    }
    addHistory();
    reset();
  }

  //リセット
  function reset (){
    display.value = result;
    firstNumber = parseFloat(display.value);
    secondNumber = 0;
    operator = null;
  }


function addHistory(){
  var newValue = firstNumber + ' ' + operator + ' ' + parseFloat(secondNumber.toString().slice(1));
  history.innerHTML += newValue+ "<br>";
}
});

