'use strict';

document.addEventListener('DOMContentLoaded', () => {
  const loginBtn = document.querySelector('.login-button');
  
  loginBtn.addEventListener('click', () => {
    const form = document.forms.login;
    const data = new FormData(form);
    fetch('/check', {
      method: 'POST',
      body: data
    })
    .then(data => data.json())
    .then(data => {
      if (data.result == 'ok') {
        window.location.href = '/admin';
      }
      else {
        const inputs = form.querySelectorAll('input');

        for (const input of inputs) {
          input.classList.add('error');
          setTimeout(() => {
            input.classList.remove('error');
          }, 2000);
        }
      }
    })
  });
});
