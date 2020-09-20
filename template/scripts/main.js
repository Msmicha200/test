'use strict';

document.addEventListener('DOMContentLoaded', () => {
  const nav = document.querySelector('.menu');
  const pagination = document.querySelector('.pagination-buttons');
  const notes = document.querySelector('.notes-container');

  pagination.addEventListener('click', event => {
    const { target } = event;

    if (target.classList.contains('pagination-btn')) {
    pushState('page', target.dataset.page);

    fetch(`/notesPage${getParams()}`)
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

  nav.addEventListener('click', event => {
    const { target } = event;
    const { sortdir } = target.dataset;
    const { sorton } = target.dataset;

    if (target.classList.contains('btn')) {
      if (target.classList.contains('sorted')) {

      }
      else {
        const sorted = document.querySelector('.sorted');

        if (sorted) {
          sorted.classList.remove('sorted');
        }

        target.classList.add('sorted');
      }
      
      sortdir == 'asc' ? 
        target.dataset.sortdir = 'desc' : target.dataset.sortdir = 'asc';

      pushState('sortDirection', sortdir);
      pushState('sortOn', sorton);


      fetch(`/notesPage${getParams()}`)
      .then(data => data.text())
      .then(res => {
        const selected = document.querySelector('.selected-page');
        notes.innerHTML = res;
      });
    }
  });

  const clear = form => {
    const inputs = form.querySelectorAll('input');
    const areas = form.querySelectorAll('textarea');

    for (const input of inputs) {
      input.value = '';
    }

    for (const area of areas) {
      area.value = '';
    }
  };


  const accept = document.getElementById('accept-note');

  accept.addEventListener('click', () => {
    const form = document.forms.newNote;
    let result = validate(form);

    if (result != false) {
      fetch('/addNote', {
        method: 'POST',
        body: result
      })
      .then(prom => prom.json())
      .then(data => {
        if (data.status == 'bad') {
          for(const error of data.errors) {
            const elem = form.querySelector(`[name=${error}]`);

            elem.classList.add('error');
            setTimeout(() => {
              elem.classList.remove('error');
            }, 2000);
          }
        }

        if (data.status == 'ok') {
          const notes = document.querySelector('.notes-container');
          const pages = document.querySelectorAll('.btn.pagination-btn');
          const paginationContainer = document.querySelector('.pagination-buttons');

          if (pages.length < data.pagesCount) {
            const btn = document.createElement('button');

            btn.classList.add('pagination-btn', 'btn');
            btn.setAttribute('data-page', data.pagesCount);
            btn.textContent = data.pagesCount;
            paginationContainer.append(btn);
          }

          clear(form);
          
          if (notes.children.length - 1 && notes.children.length == 3) {
            notes.removeChild(notes.children[notes.children.length - 1]);
          }
          notes.insertAdjacentHTML('afterbegin', data.html);
        }
      });
    }
  });

});
