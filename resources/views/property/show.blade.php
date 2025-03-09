<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $property->city }} Apartment Details</title>
  <!-- Link to the same CSS file for consistent styling -->
  <link rel="stylesheet" href="{{ asset('look.css') }}">
  <!-- Font Awesome (if needed) -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
</head>
<body>
  <!-- Header (reuse from the homepage) -->
  <header>
    <div class="container header-container">
      <div class="logo">
        <a href="/">
          <img
            src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg"
            alt="Real Estate Logo"
          >
        </a>
      </div>
      <nav class="main-nav">
        <ul class="nav-left">
          <li><a href="/buy">Buy</a></li>
          <li><a href="/rent">Rent</a></li>
          <li><a href="/sell">Sell</a></li>
          <li><a href="/contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>
  

  @php
    $imageUrl = $property->image_url ? asset('storage/Images/' . $property->image_url) : 'https://via.placeholder.com/400x300.png?text=No+Image';
  @endphp

  <!-- Optional Hero/Banner for Detail Page -->
  <section class="hero" style="height:300px; background: url('{{ $imageUrl }}') no-repeat center center/cover;">
    <div class="hero-overlay" style="background: rgba(0,0,0,0.5);">
      <div class="hero-content">
        <h1>{{ $property->city }} Apartment</h1>
      </div>
    </div>
  </section>

  <!-- Property Details Section -->
  <main class="container" style="padding: 40px 0;">
    <div class="property-details">
      <img src="{{ $imageUrl }}" alt="Property Image" style="width:100%; max-height:400px; object-fit: cover; border-radius: 8px; margin-bottom:20px;">
      <h2>Details for {{ $property->city }} Apartment</h2>
      <p class="price" style="font-size: 1.5rem; font-weight: bold;">
        ${{ number_format($property->price, 2) }}
      </p>
      <ul>
        <li><strong>Size:</strong> {{ $property->size }} sq ft</li>
        <li><strong>Address:</strong> {{ $property->street }}</li>
        <li><strong>Age:</strong> {{ $property->age }} years</li>
        <li><strong>Rooms:</strong> {{ $property->rooms }}</li>
        <li><strong>Bathrooms:</strong> {{ $property->bathrooms }}</li>
        <li><strong>Seller Contact:</strong> {{ $property->phone ?? 'Not Provided' }}</li>
      </ul>
      <a href="{{ route('property.compare', $property->id) }}" class="btn">Compare</a>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; {{ date('Y') }} Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>
</body>
</html>
