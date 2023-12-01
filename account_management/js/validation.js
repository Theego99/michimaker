const nameElement = document.querySelector('input[name="name"]');
const emailElement = document.querySelector('input[name="email"]');
const passwordElement = document.querySelector('input[name="password"]');
const confirmElement = document.querySelector('input[name="password_confirmation"]');
const submitElement = document.querySelector('input[name="submit"]');
const inputElement = document.querySelectorAll('input');

inputElement.forEach( inputElement => inputElement.addEventListener('change', event => {
  removeErrors();

  if (nameElement.value === '') {
    showError(nameElement, '入力してください');
  }

  if (!emailElement.value.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
    showError(emailElement, '正しいメールアドレスを入力してください');
  }
  if (confirmElement.value !== passwordElement.value) {
    showError(confirmElement, 'パスワードは一致しません');
  }
  if (passwordElement.value.length < 8) {
    showError(passwordElement, 'パスワードは8文字以上にしてください');
  }
  if (existsError()) {
    event.preventDefault();
    submitElement.disabled = true;
  } else {
    submitElement.disabled = false;
  }
}));

function showError(element, message) {
  const errorElement = document.createElement('p');
  errorElement.classList.add('message-error');
  errorElement.innerText = message;
  element.closest('label').append(errorElement);
  console.log(errorElement);
}

function removeErrors() {
  const errors = document.querySelectorAll('.message-error');
  errors.forEach(error => error.remove());
}

function existsError() {
  const errors = document.querySelectorAll('.message-error');
  return errors.length > 0;
}