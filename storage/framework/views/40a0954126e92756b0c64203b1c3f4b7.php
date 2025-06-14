<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Real Estate Listings</title>
  <link rel="stylesheet" href="<?php echo e(asset('look.css')); ?>">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="/">
          <img src="storage/Images/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo">
        </a>
      </div>

    </div>
  </header>
  <main class="container" style="padding: 40px 0;">
    <div class="auth-form">
      <h2>Sign Up</h2>
      <?php if($errors->any()): ?>
        <p style="color:red;"><?php echo e($errors->first()); ?></p>
      <?php endif; ?>
      <form action="<?php echo e(route('register.submit')); ?>" method="POST">
        <?php echo csrf_field(); ?>
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
      <p>Already have an account? <a href="<?php echo e(route('login.show')); ?>">Login</a></p>
    </div>
  </main>
  <footer>
    <div class="container">
      <p>&copy; <?php echo e(date('Y')); ?> Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/register.blade.php ENDPATH**/ ?>