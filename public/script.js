console.log('JS file loaded');

document.addEventListener('DOMContentLoaded', function () {
  /* -----------------------------------
     Modal Functionality for "View Details" buttons
     ----------------------------------- */
  // Only attach to elements that explicitly need modal behavior.
  const modalTriggers = document.querySelectorAll('[data-modal]');
  modalTriggers.forEach(trigger => {
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      showModal();
    });
  });

  function showModal() {
    // Create the overlay
    const modalOverlay = document.createElement('div');
    modalOverlay.classList.add('modal-overlay');

    // Create the modal container
    const modal = document.createElement('div');
    modal.classList.add('modal');

    // Create the close button
    const closeButton = document.createElement('span');
    closeButton.classList.add('modal-close');
    closeButton.innerHTML = '&times;';
    modal.appendChild(closeButton);

    // Create the content of the modal
    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');
    modalContent.innerHTML = '<h2>Property Details</h2><p>More details coming soon!</p>';
    modal.appendChild(modalContent);

    // Append modal to overlay and overlay to body
    modalOverlay.appendChild(modal);
    document.body.appendChild(modalOverlay);

    // Close the modal when clicking the close button or clicking outside the modal
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

  // Variable to store the first suggestion's ID as fallback
  let firstSuggestionId = null;

  if (searchInput) {
    // Listen for input changes to perform live search
    searchInput.addEventListener('input', function () {
      const query = this.value.trim();
      console.log('Search input changed:', query);

      if (query.length >= 2) {
        fetch('/search?q=' + encodeURIComponent(query))
          .then(response => response.json())
          .then(data => {
            resultsDiv.innerHTML = '';
            firstSuggestionId = null; // reset for each new query

            if (data.length > 0) {
              // Use the first result as fallback if the user submits the form
              firstSuggestionId = data[0].id;
              const ul = document.createElement('ul');
              ul.classList.add('compare-search-list');

              data.forEach(apartment => {
                const li = document.createElement('li');
                li.classList.add('compare-search-item');

                // Create thumbnail if available
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

                // Create a text span for the property details
                const textSpan = document.createElement('span');
                textSpan.textContent = apartment.street + ' - $' + apartment.price;

                li.appendChild(thumbnail);
                li.appendChild(textSpan);

                // When clicking on a suggestion, either update the compare table or redirect
                li.addEventListener('click', function (e) {
                  e.preventDefault();
                  e.stopPropagation();
                  console.log('Clicked apartment id:', apartment.id);
                  const compareSecondaryContent = document.getElementById('compare-secondary-content');
                  if (compareSecondaryContent) {
                    // On the comparison page: update the table via AJAX
                    fetch('/compare/update/' + apartment.id)
                      .then(response => response.text())
                      .then(html => {
                        compareSecondaryContent.innerHTML = html;
                        resultsDiv.innerHTML = '';
                      })
                      .catch(error => {
                        console.error('Error fetching comparison property:', error);
                      });
                  } else {
                    // On the main page: redirect to the property page
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

    // Listen for form submit: if no suggestion is clicked and the user submits the form,
    // load the first suggestion via AJAX if on the comparison page; otherwise, redirect.
    if (searchForm) {
      searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const typedQuery = encodeURIComponent(searchInput.value.trim());
        const compareSecondaryContent = document.getElementById('compare-secondary-content');

        if (firstSuggestionId && compareSecondaryContent) {
          console.log('Submitting form with first suggestion id:', firstSuggestionId);
          fetch('/compare/update/' + firstSuggestionId)
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not OK');
              }
              return response.text();
            })
            .then(html => {
              compareSecondaryContent.innerHTML = html;
              resultsDiv.innerHTML = '';
            })
            .catch(error => {
              console.error('Error fetching comparison property:', error);
            });
        } else {
          // If not on the comparison page, perform a normal redirect to search results
          window.location.href = '/search/results?q=' + typedQuery;
        }
      });
    }

    // Hide the dropdown when clicking outside the search form
    document.addEventListener('click', function (e) {
      if (searchForm && !searchForm.contains(e.target)) {
        resultsDiv.innerHTML = '';
      }
    });
  }

  /* -----------------------------------
     Bookmark Functionality with AJAX Submission
     ----------------------------------- */
  const bookmarkForms = document.querySelectorAll('form.bookmark-form');

  bookmarkForms.forEach(form => {
    form.addEventListener('submit', function (e) {
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
          // Toggle the button's active state based on whether the bookmark was added
          bookmarkButton.classList.toggle('active', data.added);
          const message = data.added ? 'Bookmark added successfully!' : 'Bookmark removed!';
          showBookmarkNotification(message);
        })
        .catch(error => {
          console.error('Error:', error);
          showBookmarkNotification('Error updating bookmark.');
        });
    });
  });

  function showBookmarkNotification(message) {
    const notification = document.createElement('div');
    notification.textContent = message;
    // Simple notification styling
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.backgroundColor = '#4CAF50';
    notification.style.color = '#fff';
    notification.style.padding = '10px 20px';
    notification.style.borderRadius = '5px';
    notification.style.zIndex = '1000';
    document.body.appendChild(notification);

    // Fade out and remove the notification after 2 seconds
    setTimeout(() => {
      notification.style.transition = 'opacity 0.5s ease';
      notification.style.opacity = '0';
      setTimeout(() => {
        notification.remove();
      }, 500);
    }, 2000);
  }
});
