console.log('JS file loaded');

document.addEventListener('DOMContentLoaded', function () {
  // -------------------------------
  // Modal Functionality for "View Details" buttons
  // -------------------------------
  const detailButtons = document.querySelectorAll('.btn');

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

    // Close the modal when clicking the close button
    closeButton.addEventListener('click', function () {
      document.body.removeChild(modalOverlay);
    });

    // Close the modal when clicking outside the modal content
    modalOverlay.addEventListener('click', function (e) {
      if (e.target === modalOverlay) {
        document.body.removeChild(modalOverlay);
      }
    });
  }

  // -------------------------------
  // Live Search Functionality with AJAX Compare Update
  // -------------------------------
  const searchInput =
    document.getElementById('compare-search-input') || document.getElementById('search-input');
  const resultsDiv =
    document.getElementById('compare-search-results') || document.getElementById('search-results');
  const searchForm =
    document.getElementById('compare-search-form') || document.getElementById('search-form');

  // Array of property images for thumbnails
  const propertyImages = [
    'https://images.unsplash.com/photo-1592595896551-12b371d546d5?q=80&w=1170&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=1074&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1558036117-15d82a90b9b1?q=80&w=1170&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1170&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1555636222-cae831e670b3?q=80&w=1177&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1613490493576-7fde63acd811?q=80&w=1171&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=1170&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?q=80&w=1170&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1605146769289-440113cc3d00?q=80&w=1170&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?q=80&w=1170&auto=format&fit=crop'
  ];

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

                // Create thumbnail image using a cyclic array based on apartment.id
                const thumbnail = document.createElement('img');
                const index = (apartment.id - 1) % propertyImages.length;
                thumbnail.src = propertyImages[index];
                thumbnail.alt = 'Property Thumbnail';
                thumbnail.style.width = '50px';
                thumbnail.style.height = '50px';
                thumbnail.style.objectFit = 'cover';
                thumbnail.style.marginRight = '10px';
                thumbnail.style.verticalAlign = 'middle';

                // Create a text span for the property details
                const textSpan = document.createElement('span');
                textSpan.textContent = apartment.street + ' - $' + apartment.price;

                li.appendChild(thumbnail);
                li.appendChild(textSpan);

                // When clicking on a suggestion, update the "Second Property" column via AJAX
                li.addEventListener('click', function () {
                  console.log('Clicked apartment id:', apartment.id);
                  fetch('/compare/update/' + apartment.id)
                    .then(response => response.text())
                    .then(html => {
                      const compareSecondaryContent = document.getElementById('compare-secondary-content');
                      if (compareSecondaryContent) {
                        compareSecondaryContent.innerHTML = html; 
                      } else {
                        console.error('compare-secondary-content element not found');
                      }
                      // Clear out the search results dropdown
                      resultsDiv.innerHTML = '';
                    })
                    .catch(error => {
                      console.error('Error fetching comparison property:', error);
                    });
                });

                ul.appendChild(li);
              });

              resultsDiv.appendChild(ul);
            } else {
              resultsDiv.innerHTML =
                '<p class="compare-no-results" style="padding:8px;">No results found</p>';
            }
          })
          .catch(error => console.error('Error fetching search results:', error));
      } else {
        resultsDiv.innerHTML = '';
      }
    });

    // Listen for form submit: if no suggestion is clicked and the user submits the form,
    // load the first suggestion via AJAX or fallback to normal search
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
          // If no suggestions or user didn't pick from them, do a normal redirect to /search
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
});
