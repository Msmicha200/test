'use strict';

document.addEventListener('DOMContentLoaded', () => {
  const pagination = document.querySelector('.pagination-buttons');
  const notes = document.querySelector('.notes-container');

  pagination.addEventListener('click', event => {
    const { target } = event;

    if (target.classList.contains('pagination-btn')) {
    pushState('page', target.dataset.page);

    fetch(`/getAdminNotes${getParams()}`)
    .then(data => data.text())
    .then(res => {
      const selected = document.querySelector('.selected-page');
      
      if (selected) {
        selected.classList.remove('selected-page');
      }

      pushState('page', target.dataset.page);
      target.classList.add('selected-page');
      notes.innerHTML = res;
    });
    }
  });

  notes.addEventListener('submit', event => {
    event.preventDefault();

    const { target } = event;
    const data = new FormData(target);

    fetch('/updateNote', {
      method: 'POST',
      body: data
    })
    .then(data => data.json())
    .then(res => {
      if (res.status == 'ok') {
        const elem = target.querySelector('textarea');

        elem.classList.add('success');
        
        elem.classList.add('success');
        setTimeout(() => {
          elem.classList.remove('success');
        }, 2000);
      }

      if (res.status == 'bad') {
        for(const error of res.errors) {
          const elem = target.querySelector(`[name=${error}]`);

          elem.classList.add('error');
          setTimeout(() => {
            elem.classList.remove('error');
          }, 2000);
        }
      }

      if (res.status == 'auth') {
        window.location.href = '/main';
      }
    });
  });
});
