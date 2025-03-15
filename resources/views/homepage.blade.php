<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Real Estate Listings</title>
  <link rel="stylesheet" href="{{ asset('look.css') }}" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="/">
          <img
            src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg"
            alt="Real Estate Logo"
          />
        </a>
      </div>

      <nav class="main-nav">
        <ul class="nav-left">
          <li><a href="#">Buy</a></li>
          <li><a href="#">Rent</a></li>
          <li><a href="#">Sell</a></li>
          <li><a href="#">Contact</a></li>
        </ul>

        <ul class="nav-right">
          @auth
            <li>
              <a href="{{ route('estimate') }}" class="nav-btn">Estimate Property</a>
            </li>
          @endauth

          @if(Auth::check())
            <li class="user-dropdown">
              <span class="welcome-msg">
                Welcome, {{ Auth::user()->name }}
                <i class="fas fa-caret-down"></i>
              </span>
              <ul class="dropdown-menu">
                <li>
                  <a href="{{ route('profile.show') }}" class="nav-btn">Profile</a>
                </li>
                <li>
                  <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-btn">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li>
              <a href="{{ route('login.show') }}" class="nav-btn">Login</a>
            </li>
            <li>
              <a href="{{ route('register.show') }}" class="nav-btn">Register</a>
            </li>
          @endif
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>Find Your Dream Home</h1>
        <p>Search from thousands of listings across the country.</p>
        <form id="search-form" action="{{ route('search.index') }}" method="GET" class="search-form" autocomplete="off">
          <input type="text" name="q" id="search-input" placeholder="Enter address or price">
          <button type="submit">
            <i class="fas fa-search"></i> Search
          </button>
        </form>
        <div id="search-results" style="border: none;"></div>
      </div>
    </div>
  </section>

  <section class="filters">
    <div class="container">
      <form id="filter-form" action="{{ route('home') }}" method="GET">
        <div class="filter-item">
          <label for="price">Price Range</label>
          <select name="price" id="price">
            <option value="" {{ request('price') == "" ? 'selected' : '' }}>Any Price</option>
            <option value="0-200000" {{ request('price') == "0-200000" ? 'selected' : '' }}>Under $200K</option>
            <option value="200000-400000" {{ request('price') == "200000-400000" ? 'selected' : '' }}>$200K - $400K</option>
            <option value="400000-600000" {{ request('price') == "400000-600000" ? 'selected' : '' }}>$400K - $600K</option>
            <option value="600000-1000000" {{ request('price') == "600000-1000000" ? 'selected' : '' }}>$600K - $1M</option>
            <option value="1000000-" {{ request('price') == "1000000-" ? 'selected' : '' }}>Over $1M</option>
        </select>
        </div>
        <div class="filter-item">
          <label for="location">Location</label>
          <input type="text" name="location" id="location" placeholder="e.g. Los Angeles" value="{{ request('location') }}">
        </div>
        <div class="filter-item">
          <label for="age">Building Age</label>
          <select name="age" id="age">
            <option value="" {{ request('age') == "" ? 'selected' : '' }}>Any Age</option>
            <option value="0-5" {{ request('age') == "0-5" ? 'selected' : '' }}>0-5 years</option>
            <option value="6-10" {{ request('age') == "6-10" ? 'selected' : '' }}>6-10 years</option>
            <option value="11-20" {{ request('age') == "11-20" ? 'selected' : '' }}>11-20 years</option>
            <option value="21+" {{ request('age') == "21+" ? 'selected' : '' }}>21+ years</option>
        </select>
        </div>
        <div class="filter-item">
          <label for="rooms">Rooms</label>
          <select name="rooms" id="rooms">
            <option value="" {{ request('rooms') == "" ? 'selected' : '' }}>Any</option>
            <option value="1" {{ request('rooms') == "1" ? 'selected' : '' }}>1</option>
            <option value="2" {{ request('rooms') == "2" ? 'selected' : '' }}>2</option>
            <option value="3" {{ request('rooms') == "3" ? 'selected' : '' }}>3</option>
            <option value="4" {{ request('rooms') == "4" ? 'selected' : '' }}>4+</option>
        </select>
        </div>
        <button type="submit" class="filter-btn">
          Filter
        </button>
      </form>
    </div>
  </section>

  <main class="container listings">
    <h2>Featured Listings</h2>
    @if($apartment->isEmpty())
      <p style="text-align: center;">No apartments available at the moment.</p>
    @else
      <div id="apartment-grid" class="grid">
        @foreach($apartment as $variable)
          <div class="card">
            <div class="card-image">
              <img
                src="{{ $variable->images === null ? 'https://via.placeholder.com/400x300.png?text=No+Image' : (optional($variable->images->first())->image_url ? asset('storage/Images/' . optional($variable->images->first())->image_url) : 'https://via.placeholder.com/400x300.png?text=No+Image') }}"
              />
            </div>
            <div class="card-content">
              <h3>{{ $variable->street }} ({{ $variable->city }})</h3>
              <p class="price">${{ number_format($variable->price, 2) }}</p>
              <ul>
                <li><strong>Size:</strong> {{ $variable->size ?? 'N/A' }} sq ft</li>
                <li><strong>Rooms:</strong> {{ $variable->rooms ?? 'N/A' }}</li>
                <li><strong>Bathrooms:</strong> {{ $variable->bathrooms ?? 'N/A' }}</li>
                <li><strong>Age:</strong> {{ $variable->age ?? 'N/A' }} years</li>
              </ul>
              @if($variable->phone)
                <p><strong>Contact Phone:</strong> {{ $variable->phone }}</p>
              @endif
              <div class="card-actions" style="margin-top: 10px; text-align: center;">
                <a href="{{ route('property.show', $variable->id) }}" class="btn">View</a>
                @auth
                  <form action="{{ route('bookmarks.store') }}" method="POST" class="bookmark-form" style="display: inline-block;">
                    @csrf
                    <input type="hidden" name="apartment_id" value="{{ $variable->id }}">
                    <button type="submit" class="bookmark-btn-only @if(auth()->user()->bookmarkedApartments->contains($variable->id)) active @endif">
                      <svg viewBox="0 0 24 24">
                        <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"></path>
                      </svg>
                    </button>
                  </form>
                @endauth
              </div>
            </div>
          </div>
        @endforeach
      </div>
          <div id="pagination" class="pagination">
            <span class="pagination-text">Pages:</span>
            @for ($page = 1; $page <= $apartment->lastPage(); $page++)
              <button
                class="page-number {{ $page == $apartment->currentPage() ? 'active' : '' }}"
                data-page="{{ $page }}"
              >
                {{ $page }}
              </button>
            @endfor
            {{-- Show "Next" only if not on the last page --}}
            @if ($apartment->currentPage() < $apartment->lastPage())
              <button
                class="next-page"
                data-page="{{ $apartment->currentPage() + 1 }}"
              >
                Next
              </button>
            @endif
          </div>
      @endif
  </main>

  <footer>
    <div class="container">
      <p>&copy; {{ date('Y') }} Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>

  <script>
    var homeUrl = "{{ route('home') }}";
  </script>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>