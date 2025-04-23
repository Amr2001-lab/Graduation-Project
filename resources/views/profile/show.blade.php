<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $user->name }}'s Profile - Real Estate Listings</title>
  <!-- Link to your main CSS file -->
  <link rel="stylesheet" href="{{ asset('look.css') }}">
  <!-- Font Awesome for icons -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
</head>
<body>
  <!-- Header (reuse from main page) -->
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="/">
          <img src="storage/Images/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo">
        </a>
      </div>
  
      <!-- Main Navigation -->
      <nav class="main-nav">
        <ul class="nav-left">
          <li><a href="/buy">Buy</a></li>
          <li><a href="/rent">Rent</a></li>
          <li><a href="/sell">Sell</a></li>
          <li><a href="/contact">Contact</a></li>
        </ul>
  
        <ul class="nav-right">
          @if(Auth::check() && Auth::user()->role === 'seller')
            <li>
              <a href="{{ route('property.create') }}" class="nav-btn">List New Property</a>
            </li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="nav-btn">Logout</button>
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  
  <!-- Hero Section -->
  <section class="hero" style="height:300px; background: url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?q=80&w=996&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA==') no-repeat center center/cover;">
    <div class="hero-overlay" style="background: rgba(0,0,0,0.5);">
      <div class="hero-content">
        <h1>Welcome, {{ $user->name }}!</h1>
      </div>
    </div>
  </section>

  <!-- Main Profile Content -->
  <main class="container profile-content" style="padding: 40px 0;">
    <section class="user-details" style="margin-bottom: 40px;">
      <h2>My Profile</h2>
      <p><strong>Name:</strong> {{ $user->name }}</p>
      <p><strong>Email:</strong> {{ $user->email }}</p>
    </section>

    <!-- Bookmarked Properties Section -->
    <section class="bookmarked-properties" style="margin-bottom: 40px;">
      <h2>My Bookmarked Properties</h2>
      @if($bookmarks->isEmpty())
        <p>You haven't bookmarked any properties yet.</p>
      @else
        <div class="grid">
          @foreach($bookmarks as $bookmark)
            <div class="card">
              @php
                $mainImage = $bookmark->apartment->main_image;
                $imgSrc = $mainImage 
                          ? asset('storage/Images/' . $mainImage->image_url)
                          : 'https://via.placeholder.com/400x250.png?text=No+Image';
              @endphp
              <img src="{{ $imgSrc }}" alt="Property Image">
              <div class="card-content">
                <h3>{{ $bookmark->apartment->city }} Apartment</h3>
                <p class="price">${{ number_format($bookmark->apartment->price, 2) }}</p>
                <ul>
                  <li><strong>Size:</strong> {{ $bookmark->apartment->size }} sq ft</li>
                  <li><strong>Address:</strong> {{ $bookmark->apartment->street }}</li>
                </ul>
                <a href="{{ route('property.show', $bookmark->apartment->id) }}" class="btn">View Details</a>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>
    
    <!-- Listed Properties Section -->
    <section class="listed-properties">
      <h2>My Listed Properties</h2>
      @if($properties->isEmpty())
        <p>You haven't listed any properties yet.</p>
      @else
        <div class="grid">
          @foreach($properties as $property)
            <div class="card">
              @php
                $mainImage = $property->main_image;
                $imgSrc = $mainImage 
                          ? asset('storage/Images/' . $mainImage->image_url)
                          : 'https://via.placeholder.com/400x250.png?text=No+Image';
              @endphp
              <img src="{{ $imgSrc }}" alt="Property Image">
              <div class="card-content">
                <h3>{{ $property->city }} Apartment</h3>
                <p class="price">${{ number_format($property->price, 2) }}</p>
                <ul>
                  <li><strong>Size:</strong> {{ $property->size }} sq ft</li>
                  <li><strong>Address:</strong> {{ $property->street }}</li>
                </ul>
                <a href="{{ route('property.show', $property->id) }}" class="btn">View Details</a>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>
  </main>

  <!-- Footer (reuse from main page) -->
  <footer>
    <div class="container">
      <p>&copy; {{ date('Y') }} Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- Include the external JavaScript file -->
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
