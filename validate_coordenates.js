
let pointAField = document.getElementById("point_A");
let pointBField = document.getElementById("point_B");
pointAField.addEventListener("input", validateInput);
pointBField.addEventListener("input", validateInput);
//validate input
function validateInput() {
  valid = [true, true]
  msg = document.getElementById("msg");
  msg2 = document.getElementById("msg2");
  //validate point a 
  let point_A = document.getElementById("point_A").value;
  console.log(point_A);
  let message = "";

  if (isValidCoordinates(point_A)) {
    //if coordinates are valid and in decimal format
    message = '✔';
    msg.classList.remove('wrong');
    msg.classList.add('correct');
  } else {
    valid[0] = false;
    // convert coordinates to decimal to check if the coordinates were in a valid ddmmss format
    point_A = convertToDecimal(point_A);
    if (isValidCoordinates(point_A)) {
      //if coordinates are valid in ddmmss format
      message = '✔';
      msg.classList.add('correct');
    } else {
      message = '✘';
      msg.classList.add('wrong')
    }
  }
  msg.innerHTML = message;
  //validate point b
  let point_B = document.getElementById("point_B").value;
  if (isValidCoordinates(point_B)) {
    //if coordinates are valid and in decimal format
    message = '✔';
    msg2.classList.remove('wrong');
    msg2.classList.add('correct')
  } else {
    valid[1] = false;
    // convert coordinates to decimal to check if the coordinates were in a valid ddmmss format
    point_B = convertToDecimal(point_B);
    if (isValidCoordinates(point_B)) {
      //if coordinates are valid in ddmmss format
      message = '✔';
      //set format in invisible box to save to db
      msg2.classList.add('correct')
    } else {
      message = '✘';
      msg2.classList.add('wrong')
    }
  }
  msg2.innerHTML = message;

  //座標が正しければボタンを有効にする
  checkInput();
}


//check if input is valid coordinates
function isValidCoordinates(coordinates) {
  var pattern = /^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/;
  if (!pattern.test(coordinates)) {
    console.log("wrong pattern");
    return false;
  }
  var parts = coordinates.split(",");
  var lat = parseFloat(parts[0]);
  var lng = parseFloat(parts[1]);
  if (lat < -90 || lat > 90) {
    console.log("wrong latitude value");
    return false;
  }
  if (lng < -180 || lng > 180) {
    console.log("wrong longitude value");
    return false;
  }
  return true;
}

//round decimals of decimal coordinates
function roundDecimal(coordinates) {
  coordinates = coordinates.split(',');
  console.log(coordinates[0]);
  var lat = parseFloat(coordinates[0]);
  var lng = parseFloat(coordinates[1]);
  return (lat.toFixed(6) + ',' + lng.toFixed(6));
}

//convert degrees minutes seconds coordinates to decimal format
function convertToDecimal(coordinates) {
  var pattern = /^(\d{1,2})\D+(\d{1,2})\D+(\d{1,2}\.\d+)\D+([NS])\D+(\d{1,3})\D+(\d{1,2})\D+(\d{1,2}\.\d+)\D+([EW])$/;
  var parts = pattern.exec(coordinates);
  if (!parts) {
    return null;
  }
  var latDegrees = parseFloat(parts[1]);
  var latMinutes = parseFloat(parts[2]);
  var latSeconds = parseFloat(parts[3]);
  var latHemisphere = parts[4];
  var lngDegrees = parseFloat(parts[5]);
  var lngMinutes = parseFloat(parts[6]);
  var lngSeconds = parseFloat(parts[7]);
  var lngHemisphere = parts[8];
  var lat = latDegrees + (latMinutes / 60) + (latSeconds / 3600);
  var lng = lngDegrees + (lngMinutes / 60) + (lngSeconds / 3600);
  if (latHemisphere === "S") {
    lat = lat * -1;
  }
  if (lngHemisphere === "W") {
    lng = lng * -1;
  }
  return (lat.toFixed(6) + "," + lng.toFixed(6));
}

function checkInput() {
  var submitBtn = document.getElementById("submitBtn");
  if (valid[0] && valid[1]) {
    submitBtn.disabled = false;
  } else {
    submitBtn.disabled = true;
  }
}