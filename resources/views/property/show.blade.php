<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $property->city }} Apartment Details</title>
  <meta name="description" content="Explore the details of this {{ $property->city }} apartment – high-quality images, pricing, and property information." />

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('look.css') }}" />
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  <!-- Swiper Slider CSS -->
  <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" />

  <!-- Structured Data for SEO -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SingleFamilyResidence",
    "name": "{{ $property->city }} Apartment Details",
    "description": "Property details for a {{ $property->city }} apartment located at {{ $property->street }}.",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "{{ $property->street }}",
      "addressLocality": "{{ $property->city }}",
      "addressRegion": "FL",
      "postalCode": "{{ $property->postal_code ?? '33319' }}"
    },
    "floorSize": {
      "@type": "QuantitativeValue",
      "value": "{{ $property->size }}",
      "unitCode": "SQF"
    },
    "numberOfRooms": "{{ $property->rooms }}",
    "numberOfBathroomsTotal": "{{ $property->bathrooms }}",
    "price": "{{ $property->price }}"
  }
  </script>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container header-container">
      <div class="logo">
        <a href="/" aria-label="Real Estate Home">
          <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo" />
        </a>
      </div>
      <nav class="main-nav" role="navigation">
        <ul class="nav-left">
          <li><a href="/buy">Buy</a></li>
          <li><a href="/rent">Rent</a></li>
          <li><a href="/sell">Sell</a></li>
          <li><a href="/contact">Contact</a></li>
        </ul>
        <ul class="nav-right">
          @auth
            <li><a href="{{ route('estimate') }}" class="nav-btn">Estimate Property</a></li>
            <li class="user-dropdown">
              <span class="welcome-msg">
                Welcome, {{ Auth::user()->name }} <i class="fas fa-caret-down"></i>
              </span>
              <ul class="dropdown-menu">
                <li><a href="{{ route('profile.show') }}" class="nav-btn">Profile</a></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-btn">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li><a href="{{ route('login.show') }}" class="nav-btn">Login</a></li>
            <li><a href="{{ route('register.show') }}" class="nav-btn">Register</a></li>
          @endauth
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero & Gallery Slider Section with Overlay -->
  <section class="gallery-slider property-hero" aria-label="Property Gallery">
    <div class="swiper-container gallery-top">
      <div class="swiper-wrapper">
        @if(isset($property->images) && count($property->images) > 0)
          @foreach($property->images as $image)
            <div class="swiper-slide">
              <img src="{{ asset('storage/Images/' . $image->image_url) }}" alt="Image of {{ $property->city }} Apartment" />
            </div>
          @endforeach
        @else
          <div class="swiper-slide">
            <img src="{{ asset('storage/Images/' . $property->image_url) }}" alt="Image of {{ $property->city }} Apartment" />
          </div>
        @endif
      </div>
      <div class="swiper-button-next" aria-label="Next Slide"></div>
      <div class="swiper-button-prev" aria-label="Previous Slide"></div>
      <div class="swiper-pagination"></div>
    </div>
    @if(isset($property->images) && count($property->images) > 0)
      <div class="swiper-container gallery-thumbs" aria-label="Property Thumbnails">
        <div class="swiper-wrapper">
          @foreach($property->images as $image)
            <div class="swiper-slide">
              <img src="{{ asset('storage/Images/' . $image->image_url) }}" alt="Thumbnail of {{ $property->city }} Apartment" />
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- Hero Overlay: property title and price -->
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>{{ $property->city }} Apartment</h1>
        <p class="price">${{ number_format($property->price, 2) }}</p>
      </div>
    </div>
  </section>

  <!-- Main Property Details Section -->
  <main class="container property-details-page">
    <div class="property-details-container">
      <div class="property-summary">
        <h2>{{ $property->city }} Apartment Details</h2>
        <div class="key-info">
          <span><i class="fas fa-ruler-combined"></i> {{ $property->size }} sq ft</span>
          <span><i class="fas fa-map-marker-alt"></i> {{ $property->street }}</span>
          <span><i class="fas fa-calendar-alt"></i> {{ $property->age }} years</span>
          <span><i class="fas fa-bed"></i> {{ $property->rooms }} Rooms</span>
          <span><i class="fas fa-bath"></i> {{ $property->bathrooms }} Bathrooms</span>
        </div>
      </div>

      <div class="property-more-details">
        <h3>More Details</h3>
        <ul>
          <li><strong>Seller Contact:</strong> {{ $property->phone ?? 'Not Provided' }}</li>
          <!-- Add additional details as needed -->
        </ul>
      </div>

      <div class="property-actions">
        <div class="card-actions">
          <a href="{{ route('property.compare', $property->id) }}" class="button primary">Compare</a>
          @auth
            @if(Auth::user()->id == $property->seller_id)
              <a href="{{ route('seller.properties.edit', $property->id) }}" class="button secondary">Edit</a>
              <form method="POST" action="{{ route('seller.properties.destroy', $property->id) }}" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="button danger" onclick="return confirm('Are you sure you want to delete this property?')">Delete</button>
              </form>
            @endif
          @endauth
        </div>
      </div>
    </div>
  </main>
  
  <!-- Footer with Social Links -->
  <footer>
    <div class="container">
      <p>&copy; {{ date('Y') }} Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('script.js') }}"></script>

</body>
</html>
