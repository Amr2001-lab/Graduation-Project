// public/script.js

// -----------------------------------
// Modal Functionality for "View Details"
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const modalTriggers = document.querySelectorAll('[data-modal]');
  modalTriggers.forEach(trigger => {
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      showModal();
    });
  });

  function showModal() {
    const overlay = document.createElement('div');
    overlay.classList.add('modal-overlay');

    const modal = document.createElement('div');
    modal.classList.add('modal');

    const closeBtn = document.createElement('span');
    closeBtn.classList.add('modal-close');
    closeBtn.innerHTML = '&times;';
    modal.appendChild(closeBtn);

    const content = document.createElement('div');
    content.classList.add('modal-content');
    content.innerHTML = '<h2>Property Details</h2><p>More details coming soon!</p>';
    modal.appendChild(content);

    overlay.appendChild(modal);
    document.body.appendChild(overlay);

    closeBtn.addEventListener('click', () => overlay.remove());
    overlay.addEventListener('click', e => {
      if (e.target === overlay) overlay.remove();
    });
  }
});

// -----------------------------------
// Inquiry Modal for "Contact Agent"
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const openBtn = document.getElementById('openInquiryModal');
  const overlay = document.getElementById('inquiryModal');
  const closeBtn = document.getElementById('closeInquiryModal');

  if (!openBtn || !overlay || !closeBtn) return;

  openBtn.addEventListener('click', e => {
    e.preventDefault();
    overlay.classList.add('active');
    setTimeout(() => overlay.querySelector('.modal').classList.add('show'), 10);
  });

  closeBtn.addEventListener('click', () => {
    overlay.querySelector('.modal').classList.remove('show');
    setTimeout(() => overlay.classList.remove('active'), 300);
  });

  overlay.addEventListener('click', e => {
    if (e.target === overlay) {
      overlay.querySelector('.modal').classList.remove('show');
      setTimeout(() => overlay.classList.remove('active'), 300);
    }
  });
});

// -----------------------------------
// Live Search (conditional behavior)
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('compare-search-input') || document.getElementById('search-input');
  const resultsDiv = document.getElementById('compare-search-results') || document.getElementById('search-results');
  const searchForm = document.getElementById('compare-search-form') || document.getElementById('search-form');
  let firstSuggestionId = null;

  if (!searchInput) return;

  searchInput.addEventListener('input', function () {
    const q = this.value.trim();
    if (q.length < 2) {
      resultsDiv.innerHTML = '';
      return;
    }
    fetch('/search?q=' + encodeURIComponent(q))
      .then(r => r.json())
      .then(data => {
        resultsDiv.innerHTML = '';
        if (data.length === 0) {
          resultsDiv.innerHTML = '<p style="padding:8px;">No results found</p>';
          return;
        }
        firstSuggestionId = data[0].id;
        const ul = document.createElement('ul');
        ul.classList.add('compare-search-list');

        data.forEach(item => {
          const li = document.createElement('li');
          li.classList.add('compare-search-item');

          if (item.first_image_url) {
            const img = document.createElement('img');
            img.src = '/storage/' + item.first_image_url;
            img.alt = 'Thumb';
            Object.assign(img.style, {
              width: '50px',
              height: '50px',
              objectFit: 'cover',
              marginRight: '10px',
              verticalAlign: 'middle'
            });
            li.appendChild(img);
          }

          const span = document.createElement('span');
          span.textContent = item.street + ' - $' + item.price;
          li.appendChild(span);

          li.addEventListener('click', e => {
            e.preventDefault(); e.stopPropagation();
            const secondary = document.getElementById('compare-secondary-content');
            if (secondary) {
              fetch('/compare/update/' + item.id)
                .then(r => r.text())
                .then(html => {
                  secondary.innerHTML = html;
                  resultsDiv.innerHTML = '';
                });
            } else {
              window.location.href = '/property/' + item.id;
            }
          });
          ul.appendChild(li);
        });

        resultsDiv.appendChild(ul);
      })
      .catch(console.error);
  });

  if (searchForm) {
    searchForm.addEventListener('submit', e => {
      e.preventDefault();
      const query = encodeURIComponent(searchInput.value.trim());
      const secondary = document.getElementById('compare-secondary-content');
      if (firstSuggestionId && secondary) {
        fetch('/compare/update/' + firstSuggestionId)
          .then(r => r.ok ? r.text() : Promise.reject())
          .then(html => {
            secondary.innerHTML = html;
            resultsDiv.innerHTML = '';
          })
          .catch(console.error);
      } else {
        window.location.href = '/search/results?q=' + query;
      }
    });

    document.addEventListener('click', e => {
      if (!searchForm.contains(e.target)) resultsDiv.innerHTML = '';
    });
  }
});

// -----------------------------------
// Bookmark Functionality
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const grid = document.getElementById('apartment-grid');
  if (!grid) return;

  grid.addEventListener('submit', function (e) {
    const form = e.target.closest('form.bookmark-form');
    if (!form) return;
    e.preventDefault();
    const btn = form.querySelector('.bookmark-btn-only');
    const data = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
        'Accept': 'application/json'
      },
      body: data
    })
    .then(r => r.json())
    .then(json => {
      btn.classList.toggle('active', json.added);
      const msg = json.added ? 'Bookmark added!' : 'Bookmark removed!';
      showNotification(msg);
    })
    .catch(() => showNotification('Error updating bookmark.'));
  });

  function showNotification(text) {
    const n = document.createElement('div');
    n.textContent = text;
    Object.assign(n.style, {
      position: 'fixed',
      top: '20px',
      right: '20px',
      backgroundColor: '#4CAF50',
      color: '#fff',
      padding: '10px 20px',
      borderRadius: '5px',
      zIndex: 1000
    });
    document.body.appendChild(n);
    setTimeout(() => {
      n.style.transition = 'opacity 0.5s ease';
      n.style.opacity = '0';
      setTimeout(() => n.remove(), 500);
    }, 2000);
  }
});

// -----------------------------------
// AJAX Pagination
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const pagination = document.getElementById('pagination');
  if (!pagination) return;

  pagination.addEventListener('click', function (e) {
    const btn = e.target.closest('button');
    if (!btn) return;
    let page;
    if (btn.classList.contains('next-page')) {
      const active = pagination.querySelector('.page-number.active');
      const curr = active ? parseInt(active.dataset.page) : 1;
      page = curr + 1;
    } else {
      page = parseInt(btn.dataset.page);
    }

    const params = new URLSearchParams(window.location.search);
    params.set('page', page);
    const url = window.location.pathname.replace(/\/properties\/\d+\/edit$/, '') + '?' + params;

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(r => r.ok ? r.text() : Promise.reject())
      .then(html => {
        const temp = document.createElement('div');
        temp.innerHTML = html;
        const newGrid = temp.querySelector('#apartment-grid');
        const newPag = temp.querySelector('#pagination');
        if (newGrid) document.getElementById('apartment-grid').innerHTML = newGrid.innerHTML;
        if (newPag) pagination.innerHTML = newPag.innerHTML;
      })
      .catch(console.error);
  });
});

// -----------------------------------
// Swiper Setup & Tour Locking
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  let thumbs, topSwiper;

  if (document.querySelector('.gallery-thumbs')) {
    thumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 10,
      slidesPerView: 5,
      freeMode: true,
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
    });
  }

  topSwiper = new Swiper('.gallery-top', {
    spaceBetween: 10,
    loop: false,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    thumbs: { swiper: thumbs },
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    noSwiping: true,
    noSwipingClass: 'swiper-no-swiping',
  });

  topSwiper.on('slideChange', () => {
    const slide = topSwiper.slides[topSwiper.activeIndex];
    if (slide.querySelector('iframe')) {
      topSwiper.autoplay.stop();
      topSwiper.allowTouchMove = false;
    } else {
      topSwiper.allowTouchMove = true;
      topSwiper.autoplay.start();
    }
  });
});

// -----------------------------------
// Image Filename Preview
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const imagesInput = document.getElementById('images');
  const namesDiv = document.getElementById('selected-images-names');

  if (!imagesInput || !namesDiv) return;
  imagesInput.addEventListener('change', function () {
    const files = Array.from(this.files).map(f => f.name).join(', ');
    namesDiv.textContent = files ? 'Selected files: ' + files : '';
  });
});

// -----------------------------------
// Remove Existing Images
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.remove-image-btn').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.dataset.imageId;
      const container = this.closest('.current-image-item');
      if (!confirm('Remove this image?')) return;

      fetch(`/seller/images/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
      })
      .then(r => {
        if (r.ok) return container.remove();
        return Promise.reject();
      })
      .catch(() => alert('Error removing image.'));
    });
  });
});

// -----------------------------------
// Remove Virtual Tour via AJAX
// -----------------------------------
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('removeTourBtn');
  if (!btn) return;

  btn.addEventListener('click', function () {
    if (!confirm('Remove the virtual tour?')) return;

    const id = this.closest('form').action.match(/properties\/(\d+)\/update/)[1];
    fetch(`/seller/properties/${id}/tour`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      }
    })
    .then(r => {
      if (r.ok) {
        document.getElementById('currentTourContainer').remove();
      } else {
        throw new Error();
      }
    })
    .catch(() => alert('Error removing tour.'));
  });
});
