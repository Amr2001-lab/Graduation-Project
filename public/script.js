console.log('JS file loaded');

document.addEventListener('DOMContentLoaded', function () {
  /* -----------------------------------
     Modal Functionality for "View Details" buttons
  ----------------------------------- */
  const modalTriggers = document.querySelectorAll('[data-modal]');
  modalTriggers.forEach(trigger => {
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      showModal();
    });
  });

  function showModal() {
    const modalOverlay = document.createElement('div');
    modalOverlay.classList.add('modal-overlay');

    const modal = document.createElement('div');
    modal.classList.add('modal');

    const closeButton = document.createElement('span');
    closeButton.classList.add('modal-close');
    closeButton.innerHTML = '&times;';
    modal.appendChild(closeButton);

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');
    modalContent.innerHTML = '<h2>Property Details</h2><p>More details coming soon!</p>';
    modal.appendChild(modalContent);

    modalOverlay.appendChild(modal);
    document.body.appendChild(modalOverlay);

    closeButton.addEventListener('click', () => modalOverlay.remove());
    modalOverlay.addEventListener('click', function (e) {
      if (e.target === modalOverlay) {
        modalOverlay.remove();
      }
    });
  }

  /* -----------------------------------
     Live Search Functionality with Conditional Behavior
  ----------------------------------- */
  const searchInput = document.getElementById('compare-search-input') || document.getElementById('search-input');
  const resultsDiv = document.getElementById('compare-search-results') || document.getElementById('search-results');
  const searchForm = document.getElementById('compare-search-form') || document.getElementById('search-form');
  let firstSuggestionId = null;

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      const query = this.value.trim();
      console.log('Search input changed:', query);

      if (query.length >= 2) {
        fetch('/search?q=' + encodeURIComponent(query))
          .then(response => response.json())
          .then(data => {
            resultsDiv.innerHTML = '';
            firstSuggestionId = null;

            if (data.length > 0) {
              firstSuggestionId = data[0].id;
              const ul = document.createElement('ul');
              ul.classList.add('compare-search-list');

              data.forEach(apartment => {
                const li = document.createElement('li');
                li.classList.add('compare-search-item');

                const thumbnail = document.createElement('img');
                if (apartment.image_url) {
                  thumbnail.src = '/storage/Images/' + apartment.image_url;
                  thumbnail.alt = 'Property Thumbnail';
                  thumbnail.style.width = '50px';
                  thumbnail.style.height = '50px';
                  thumbnail.style.objectFit = 'cover';
                  thumbnail.style.marginRight = '10px';
                  thumbnail.style.verticalAlign = 'middle';
                }

                const textSpan = document.createElement('span');
                textSpan.textContent = apartment.street + ' - $' + apartment.price;

                li.appendChild(thumbnail);
                li.appendChild(textSpan);

                li.addEventListener('click', function (e) {
                  e.preventDefault();
                  e.stopPropagation();
                  console.log('Clicked apartment id:', apartment.id);
                  const compareSecondaryContent = document.getElementById('compare-secondary-content');
                  if (compareSecondaryContent) {
                    fetch('/compare/update/' + apartment.id)
                      .then(response => response.text())
                      .then(html => {
                        compareSecondaryContent.innerHTML = html;
                        resultsDiv.innerHTML = '';
                      })
                      .catch(error => console.error('Error fetching comparison property:', error));
                  } else {
                    window.location.href = '/property/' + apartment.id;
                  }
                });

                ul.appendChild(li);
              });

              resultsDiv.appendChild(ul);
            } else {
              resultsDiv.innerHTML = '<p class="compare-no-results" style="padding:8px;">No results found</p>';
            }
          })
          .catch(error => console.error('Error fetching search results:', error));
      } else {
        resultsDiv.innerHTML = '';
      }
    });

    if (searchForm) {
      searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const typedQuery = encodeURIComponent(searchInput.value.trim());
        const compareSecondaryContent = document.getElementById('compare-secondary-content');

        if (firstSuggestionId && compareSecondaryContent) {
          console.log('Submitting form with first suggestion id:', firstSuggestionId);
          fetch('/compare/update/' + firstSuggestionId)
            .then(response => {
              if (!response.ok) throw new Error('Network response was not OK');
              return response.text();
            })
            .then(html => {
              compareSecondaryContent.innerHTML = html;
              resultsDiv.innerHTML = '';
            })
            .catch(error => console.error('Error fetching comparison property:', error));
        } else {
          window.location.href = '/search/results?q=' + typedQuery;
        }
      });
    }

    document.addEventListener('click', function (e) {
      if (searchForm && !searchForm.contains(e.target)) {
        resultsDiv.innerHTML = '';
      }
    });
  }

  /* -----------------------------------
     Bookmark Functionality using Event Delegation
  ----------------------------------- */
  const apartmentGrid = document.getElementById('apartment-grid');
  if (apartmentGrid) {
    apartmentGrid.addEventListener('submit', function (e) {
      const form = e.target.closest('form.bookmark-form');
      if (form) {
        e.preventDefault();
        const formData = new FormData(form);
        const bookmarkButton = form.querySelector('.bookmark-btn-only');

        fetch(form.action, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
          },
          body: formData
        })
          .then(response => {
            if (!response.ok) throw new Error('Network response was not OK');
            return response.json();
          })
          .then(data => {
            bookmarkButton.classList.toggle('active', data.added);
            const message = data.added ? 'Bookmark added successfully!' : 'Bookmark removed!';
            showBookmarkNotification(message);
          })
          .catch(error => {
            console.error('Error:', error);
            showBookmarkNotification('Error updating bookmark.');
          });
      }
    });
  }

  function showBookmarkNotification(message) {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.backgroundColor = '#4CAF50';
    notification.style.color = '#fff';
    notification.style.padding = '10px 20px';
    notification.style.borderRadius = '5px';
    notification.style.zIndex = '1000';
    document.body.appendChild(notification);

    setTimeout(() => {
      notification.style.transition = 'opacity 0.5s ease';
      notification.style.opacity = '0';
      setTimeout(() => notification.remove(), 500);
    }, 2000);
  }

  /* -----------------------------------
     Pagination Functionality via AJAX (Preserving Filters)
  ----------------------------------- */
  const paginationContainer = document.getElementById('pagination');
  if (paginationContainer) {
    paginationContainer.addEventListener('click', function (e) {
      const btn = e.target.closest('button');
      if (!btn) return;
      console.log('Clicked a pagination button:', btn);
      let page;
      if (btn.classList.contains('next-page')) {
        const activeBtn = paginationContainer.querySelector('.page-number.active');
        const currentPage = activeBtn ? parseInt(activeBtn.getAttribute('data-page')) : 1;
        page = currentPage + 1;
      } else {
        page = parseInt(btn.getAttribute('data-page'));
      }
      console.log('Loading page:', page);

      // Get current filters from the URL and add the page parameter
      const params = new URLSearchParams(window.location.search);
      params.set('page', page);
      const fetchUrl = homeUrl + "?" + params.toString();
      console.log("Fetching URL:", fetchUrl);

      fetch(fetchUrl, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(response => {
          if (!response.ok) throw new Error('Network response was not OK');
          return response.text();
        })
        .then(html => {
          const tempDiv = document.createElement('div');
          tempDiv.innerHTML = html;

          // Replace the listing grid
          const newGrid = tempDiv.querySelector('#apartment-grid');
          if (newGrid) {
            document.getElementById('apartment-grid').innerHTML = newGrid.innerHTML;
          } else {
            console.error('Apartment grid not found in response.');
          }

          // Update the pagination controls
          const newPagination = tempDiv.querySelector('#pagination');
          if (newPagination && paginationContainer) {
            paginationContainer.innerHTML = newPagination.innerHTML;
          } else {
            console.error('Pagination not found in response.');
          }
        })
        .catch(error => console.error('Error loading page:', error));
    });
  }
});
