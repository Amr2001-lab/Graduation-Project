// public/script.js

;(function () {
  'use strict';

  /* ====================================================================
   * GLOBAL TOAST HELPER
   * ==================================================================== */
  function showNotification(text, opts = {}) {
    const { type = 'success', duration = 2500 } = opts;
    const colors = { success: '#4caf50', info: '#2196f3', error: '#f44336' };

    if (
      window.__lastNotifText === text &&
      Date.now() - (window.__lastNotifTime || 0) < 600
    ) return; // debounce duplicates
    window.__lastNotifText = text;
    window.__lastNotifTime = Date.now();

    const toast = Object.assign(document.createElement('div'), { textContent: text });
    Object.assign(toast.style, {
      position: 'fixed', top: '20px', right: '20px',
      background: colors[type] || colors.success,
      color: '#fff', borderRadius: '6px',
      padding: '10px 18px', fontSize: '14px', fontFamily: 'system-ui, sans-serif',
      boxShadow: '0 2px 8px rgba(0,0,0,.25)', zIndex: 10000,
      opacity: '0', transform: 'translateY(-10px)',
      transition: 'opacity .25s ease, transform .25s ease'
    });

    document.body.appendChild(toast);
    requestAnimationFrame(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
    });

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(-10px)';
      toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }, duration);
  }
  window.showNotification = showNotification; // expose for other scripts

  /* ====================================================================
   * MODALS — view details
   * ==================================================================== */
  function initModals() {
    document.querySelectorAll('[data-modal]').forEach(trigger => {
      trigger.addEventListener('click', e => {
        e.preventDefault();
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';

        const modal = document.createElement('div');
        modal.className = 'modal';

        const close = Object.assign(document.createElement('span'), {
          innerHTML: '&times;', className: 'modal-close'
        });
        modal.appendChild(close);

        const content = Object.assign(document.createElement('div'), {
          className: 'modal-content',
          innerHTML: '<h2>Property Details</h2><p>More details coming soon!</p>'
        });
        modal.appendChild(content);

        overlay.appendChild(modal);
        document.body.appendChild(overlay);

        const remove = () => overlay.remove();
        close.addEventListener('click', remove);
        overlay.addEventListener('click', evt => { if (evt.target === overlay) remove(); });
      });
    });
  }

  /* ====================================================================
   * INQUIRY MODAL ("Contact Agent")
   * ==================================================================== */
  function initInquiryModal() {
    const open  = document.getElementById('openInquiryModal');
    const layer = document.getElementById('inquiryModal');
    const close = document.getElementById('closeInquiryModal');
    if (!open || !layer || !close) return;

    open.addEventListener('click', e => {
      e.preventDefault();
      layer.classList.add('active');
      setTimeout(() => layer.querySelector('.modal').classList.add('show'), 10);
    });

    const hide = () => {
      layer.querySelector('.modal').classList.remove('show');
      setTimeout(() => layer.classList.remove('active'), 300);
    };
    close.addEventListener('click', hide);
    layer.addEventListener('click', e => { if (e.target === layer) hide(); });
  }

  /* ====================================================================
   * Live Search (conditional behavior)
   * ==================================================================== */
  function initLiveSearch() {
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
  }

  /* ====================================================================
   * BOOKMARK TOGGLE
   * ==================================================================== */
  function initBookmarkToggle() {
    const grid = document.getElementById('apartment-grid');
    if (!grid) return;

    grid.addEventListener('submit', e => {
      const form = e.target.closest('form.bookmark-form');
      if (!form) return;
      e.preventDefault();

      const btn  = form.querySelector('.bookmark-btn-only');
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
          showNotification(json.added ? 'Bookmark added!' : 'Bookmark removed!',
                           { type: json.added ? 'success' : 'info' });
        })
        .catch(() => showNotification('Error updating bookmark.', { type: 'error' }));
    });
  }

  /* ====================================================================
   * AJAX Pagination
   * ==================================================================== */
  function initAjaxPagination() {
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
      // Adjust URL path for pagination if necessary, ensure it works on non-edit pages
      const baseUrl = window.location.pathname.replace(/\/properties\/\d+\/edit$/, '');
      const url = baseUrl.replace(/\/page\/\d+$/, '') + '?' + params; // Handle existing page in path

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
  }

  /* ====================================================================
   * Swiper Setup & Tour Locking
   * ==================================================================== */
  function initSwiperSetup() {
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

    // Ensure Swiper library is loaded before initializing
    if (typeof Swiper === 'undefined') {
        console.error('Swiper library not found. Make sure it is loaded before script.js');
        return;
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
  }

  /* ====================================================================
   * Image Filename Preview
   * ==================================================================== */
  function initImageFilenamePreview() {
    const imagesInput = document.getElementById('images');
    const namesDiv = document.getElementById('selected-images-names');

    if (!imagesInput || !namesDiv) return;
    imagesInput.addEventListener('change', function () {
      const files = Array.from(this.files).map(f => f.name).join(', ');
      namesDiv.textContent = files ? 'Selected files: ' + files : '';
    });
  }

  /* ====================================================================
   * REMOVE IMAGE (AJAX)
   * ==================================================================== */
  function initRemoveImage() {
    document.querySelectorAll('.remove-image-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id      = btn.dataset.imageId;
        const wrapper = btn.closest('.current-image-item');
        if (!id || !confirm('Remove this image?')) return;

        fetch(`/seller/images/${id}`, {
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
          .then(res => {
            if (!res.ok) throw new Error();
            wrapper.remove();
            showNotification('Image removed!', { type: 'success' });
          })
          .catch(() => showNotification('Error removing image.', { type: 'error' }));
      });
    });
  }

    /* ====================================================================
     * Remove Virtual Tour via AJAX
     * ==================================================================== */
    function initRemoveVirtualTour() {
        const btn = document.getElementById('removeTourBtn');
        if (!btn) return;

        btn.addEventListener('click', function () {
            if (!confirm('Remove the virtual tour?')) return;

            // Use a more robust way to find the property ID from the form action
            const form = this.closest('form');
            if (!form) {
                console.error('Could not find the parent form for removeTourBtn.');
                return;
            }
            const match = form.action.match(/\/properties\/(\d+)\/update/);
            if (!match || !match[1]) {
                 console.error('Could not extract property ID from form action:', form.action);
                 return;
            }
            const id = match[1];


            fetch(`/seller/properties/${id}/tour`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
                .then(r => {
                    if (r.ok) {
                        const currentTourContainer = document.getElementById('currentTourContainer');
                        if (currentTourContainer) {
                            currentTourContainer.remove();
                             showNotification('Virtual tour removed!', { type: 'success' });
                        } else {
                             showNotification('Virtual tour removed (container not found).', { type: 'info' });
                        }
                    } else {
                        // Attempt to read error response if available
                        return r.text().then(text => { throw new Error(`HTTP error ${r.status}: ${text}`); });
                    }
                })
                .catch(error => {
                    console.error('Error removing tour:', error);
                    showNotification('Error removing tour.', { type: 'error' });
                });
        });
    }


  /* ====================================================================
   * DOM READY BOOTSTRAP
   * ==================================================================== */
  document.addEventListener('DOMContentLoaded', () => {
    initModals();
    initInquiryModal();
    initLiveSearch(); // Added Live Search initialization
    initBookmarkToggle();
    initAjaxPagination(); // Added AJAX Pagination initialization
    initSwiperSetup(); // Added Swiper Setup initialization
    initImageFilenamePreview(); // Added Image Filename Preview initialization
    initRemoveImage();
    initRemoveVirtualTour(); // Added Remove Virtual Tour initialization
    /* add any other initialisers you need here */
  });
})();