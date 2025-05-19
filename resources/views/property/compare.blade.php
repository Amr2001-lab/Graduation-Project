<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Compare Properties</title>
  <link rel="stylesheet" href="{{ asset('look.css') }}">
  <link rel="stylesheet" href="{{ asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css') }}"
        integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <header>
    <div class="container header-container">
      <div class="logo">
        <a href="{{ route('home') }}">
          <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Logo">
        </a>
      </div>
      <nav class="main-nav">
        <ul class="nav-left">
        </ul>
      </nav>
    </div>
  </header>

  <main class="container compare-container">
    <h1 class="compare-heading">Compare Properties</h1>
    <p class="compare-subtext">Select a property to compare with:</p>

    <form id="compare-search-form" class="compare-search" action="{{ route('search.index') }}" method="GET" autocomplete="off">
      <div class="search-input-wrapper">
        <input type="text" name="q" id="compare-search-input" placeholder="Type address or price">
        <button type="submit" class="btn">
          <i class="fas fa-search"></i> Search
        </button>
      </div>
      <div id="compare-search-results"></div>
    </form>

    <div class="compare-grid">
      <div class="compare-column">
        <h2 class="compare-column-title">Main Property</h2>
        @include('property._compareColumn', ['prop' => $property])
      </div>
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
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
