<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Compare Properties</title>
  <link rel="stylesheet" href="{{ asset('look.css') }}">
  <!-- Font Awesome (if needed for search icon) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" 
        integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container header-container">
      <div class="logo">
        <a href="{{ route('home') }}">
          <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Logo">
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

  <!-- Main Content -->
  <main class="container compare-container">
    <h1 class="compare-heading">Compare Properties</h1>
    <p class="compare-subtext">Select a property to compare with:</p>

    <!-- Search Form -->
    <form id="compare-search-form" class="compare-search" action="{{ route('search.index') }}" method="GET" autocomplete="off">
      <div class="search-input-wrapper">
        <input type="text" name="q" id="compare-search-input" placeholder="Type address or price">
        <button type="submit" class="btn">
          <i class="fas fa-search"></i> Search
        </button>
      </div>
      <!-- Added results container for live search -->
      <div id="compare-search-results"></div>
    </form>

    <!-- Comparison Grid -->
    <div class="compare-grid">
      <!-- Primary Property -->
      <div class="compare-column">
        <h2 class="compare-column-title">Main Property</h2>
        @include('property._compareColumn', ['prop' => $property])
      </div>
    
      <!-- Secondary Property -->
      <div id="compare-secondary" class="compare-column">
        <h2 class="compare-column-title">Second Property</h2>
        <div id="compare-secondary-content">
            @if($otherProperty)
              @include('property._compareColumn', ['prop' => $otherProperty])
            @else
              <p class="compare-empty">No property selected yet.</p>
            @endif
        </div>
    </div>
    </div>
    
  </main>

  <!-- External JavaScript File -->
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
