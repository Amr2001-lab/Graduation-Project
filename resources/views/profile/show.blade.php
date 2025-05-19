<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ Auth::user()->name }}’s Dashboard – Real Estate Listings</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('look.css') }}" />
  <link rel="stylesheet" href="{{ asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css') }}">
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="{{ route('home') }}">
          <img src="{{ asset('storage/Images/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg') }}" alt="Real Estate Logo">
        </a>
      </div>
      <nav class="main-nav">
        <ul class="nav-left">
          @auth
            <li>
              <a href="{{ route('property.create') }}">
                <i class="fa-solid fa-plus-circle"></i> Add Listing
              </a>
            </li>
          @endauth
        </ul>
        <ul class="nav-right">
          @auth
            <li>
              <a href="{{ route('estimate') }}" class="nav-btn">
                <i class="fa-solid fa-chart-line"></i> Estimate Property
              </a>
            </li>
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn">
                  <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
              </form>
            </li>
          @endauth
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <p>Manage your profile, bookmarks, and listings below.</p>
      </div>
    </div>
  </section>

  <main class="container dashboard" style="padding: 40px 0;">

    <section class="user-info" style="margin-bottom: 40px;">
      <h2>My Profile</h2>
      <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
      <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    </section>
    <section class="listings" style="margin-bottom: 60px;">
      <h2>My Bookmarked Properties</h2>
      @if($bookmarks->isEmpty())
        <p style="text-align:center;">You have not bookmarked any properties yet.</p>
      @else
        <div id="apartment-grid" class="grid">
          @foreach($bookmarks as $bookmark)
            @php $apt = $bookmark->apartment; @endphp
            <div class="card">
              <div class="card-image">
                <img src="{{ optional($apt->images->first())->image_url
                    ? asset('storage/Images/' . $apt->images->first()->image_url)
                    : 'https://via.placeholder.com/400x300.png?text=No+Image' }}"
                     alt="Property">
              </div>
              <div class="card-content">
                <p class="price">${{ number_format($apt->price, 2) }}</p>
                <div class="key-info">
                  <span><i class="fa-solid fa-ruler"></i> {{ $apt->size ?? 'N/A' }} sq ft</span>
                  <span><i class="fa-solid fa-bed"></i> {{ $apt->rooms ?? 'N/A' }} Rooms</span>
                  <span><i class="fa-solid fa-bath"></i> {{ $apt->bathrooms ?? 'N/A' }} Baths</span>
                  <span><i class="fa-solid fa-calendar-days"></i> {{ $apt->age ?? 'N/A' }} yrs</span>
                  <p class="posted-time">Posted {{ $apt->posted_time }}</p>
                </div>
                <h3><i class="fas fa-map-marker-alt"></i>&nbsp;{{ $apt->street }}, {{ $apt->city }}</h3>
                <div class="card-actions" style="margin-top:10px; text-align:center;">
                  <a href="{{ route('property.show', $apt->id) }}" class="btn">View</a>
                  <form action="{{ route('bookmarks.store') }}" method="POST" class="bookmark-form" style="display:inline-block;">
                    @csrf
                    <input type="hidden" name="apartment_id" value="{{ $apt->id }}">
                    <button type="submit" class="bookmark-btn-only active" title="Remove Bookmark">
                      <svg viewBox="0 0 24 24"><path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>

    <section class="listings">
      <h2>My Listings</h2>
      @if($properties->isEmpty())
        <p style="text-align:center;">You have not listed any properties yet.</p>
      @else
        <div id="apartment-grid" class="grid">
          @foreach($properties as $property)
            <div class="card">
              <div class="card-image">
                <img src="{{ optional($property->images->first())->image_url
                    ? asset('storage/Images/' . $property->images->first()->image_url)
                    : 'https://via.placeholder.com/400x300.png?text=No+Image' }}"
                     alt="Property">
              </div>
              <div class="card-content">
                <p class="price">${{ number_format($property->price, 2) }}</p>
                <div class="key-info">
                  <span><i class="fa-solid fa-ruler"></i> {{ $property->size ?? 'N/A' }} sq ft</span>
                  <span><i class="fa-solid fa-bed"></i> {{ $property->rooms ?? 'N/A' }} Rooms</span>
                  <span><i class="fa-solid fa-bath"></i> {{ $property->bathrooms ?? 'N/A' }} Baths</span>
                  <span><i class="fa-solid fa-calendar-days"></i> {{ $property->age ?? 'N/A' }} yrs</span>
                  <p class="posted-time">Posted {{ $property->posted_time }}</p>
                </div>
                <h3><i class="fas fa-map-marker-alt"></i>&nbsp;{{ $property->street }}, {{ $property->city }}</h3>
                <div class="card-actions" style="margin-top:10px; text-align:center;">
                  <a href="{{ route('seller.properties.edit', $property->id) }}" class="btn">Edit</a>
                  <form action="{{ route('seller.properties.destroy', $property->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>
  </main>

  <footer>
    <div class="container">
      <p>&copy; {{ date('Y') }} Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>

  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
