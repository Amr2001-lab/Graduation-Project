<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Property Estimator</title>
  <link rel="stylesheet" href="{{ asset('look.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="{{ route('home') }}">
          <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo">
        </a>
      </div>
      <nav class="main-nav">
        <ul class="nav-left">
          <li><a href="{{ route('home') }}">Home</a></li>
        </ul>
        <ul class="nav-right">
          @auth
            <li class="user-dropdown">
              <span class="welcome-msg">
                Welcome, {{ Auth::user()->name }} <i class="fas fa-caret-down"></i>
              </span>
              <ul class="dropdown-menu">
                <li><a href="{{ route('profile.show') }}">Profile</a></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit">Logout</button>
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
  
  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>Property Estimator</h1>
        <p>Quick and reliable property value estimates.</p>
      </div>
    </div>
  </section>
  
  <main class="container">
    <!-- Estimator Form Card -->
    <div class="card-estimator">
      @if ($errors->any())
        <div class="error-message">
          {{ implode(', ', $errors->all()) }}
        </div>
      @endif
      
      <h2>Estimate Your Property</h2>
      <form action="{{ route('estimate') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="city">City</label>
          <input type="text" name="city" id="city" value="{{ old('city', $city) }}" required>
        </div>
        <div class="form-group">
          <label for="size">Size (sq ft)</label>
          <input type="number" name="size" id="size" value="{{ old('size', $size) }}" required>
        </div>
        <div class="form-group">
          <label for="age">Age (years)</label>
          <input type="number" name="age" id="age" value="{{ old('age', $age) }}" required>
        </div>
        <div class="form-group">
          <label for="rooms">Rooms</label>
          <input type="number" name="rooms" id="rooms" value="{{ old('rooms', $rooms) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Get Estimate</button>
      </form>
    </div>
    
    <!-- Estimated Price Card -->
    @if($estimatedPrice !== null)
      <div class="card-estimator" style="margin-top: 30px;">
        <h2>Estimated Price</h2>
        <p><strong>Price:</strong> ${{ number_format($estimatedPrice, 2) }}</p>
        <p><strong>City:</strong> {{ $city }}</p>
        <p><strong>Size:</strong> {{ $size }} sq ft</p>
        <p><strong>Age:</strong> {{ $age }} years</p>
        <p><strong>Rooms:</strong> {{ $rooms }}</p>
      </div>
    @endif
  </main>
  
  <footer>
    <div class="container">
      <p>&copy; {{ date('Y') }} Real Estate Company. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
