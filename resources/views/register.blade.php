<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Real Estate Listings</title>
  <link rel="stylesheet" href="{{ asset('look.css') }}">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>
<body>
  <!-- Header -->
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
  
      <!-- Main Navigation with left section only -->
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
  
  

  <!-- Main Content: Registration Form -->
  <main class="container" style="padding: 40px 0;">
    <div class="auth-form">
      <h2>Sign Up</h2>
      @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
      @endif
      <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        <div>
          <label for="name">Name</label>
          <input type="text" name="name" id="name" required>
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" name="email" id="email" required>
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required>
        </div>
        <div>
          <label for="password_confirmation">Confirm Password</label>
          <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div>
          <label for="role">Account Type</label>
          <select name="role" id="role">
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
          </select>
        </div>
        <button type="submit">Register</button>
      </form>
      <p>Already have an account? <a href="{{ route('login.show') }}">Login</a></p>
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
