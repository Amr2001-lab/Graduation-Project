<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Real Estate Listings</title>
  <link rel="stylesheet" href="<?php echo e(asset('look.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css')); ?>">
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="<?php echo e(route('home')); ?>">
          <img src="storage/Images/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo">
        </a>
      </div>
      <nav class="main-nav">
        <ul class="nav-left">
          <?php if(auth()->guard()->check()): ?>
            <li>
              <a href="<?php echo e(route('property.create')); ?>">
                <i class="fa-solid fa-plus-circle"></i> Add Listing
              </a>
            </li>
          <?php endif; ?>
        </ul>
        <ul class="nav-right">
          <?php if(auth()->guard()->check()): ?>
            <li>
              <a href="<?php echo e(route('estimate')); ?>" class="nav-btn">
                <i class="fa-solid fa-chart-line"></i> Price Estimator
              </a>
            </li>
          <?php endif; ?>

          <?php if(Auth::check()): ?>
            <li class="user-dropdown">
              <span class="welcome-msg">
                Welcome, <?php echo e(Auth::user()->name); ?>

                <i class="fa-solid fa-caret-down"></i>
              </span>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo e(route('profile.show')); ?>" class="nav-btn">
                    <i class="fa-solid fa-user"></i> Profile
                  </a>
                </li>
                <li>
                  <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-btn">
                      <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                  </form>
                </li>
              </ul>
            </li>
          <?php else: ?>
            <li>
              <a href="<?php echo e(route('login.show')); ?>" class="nav-btn">
                <i class="fa-solid fa-right-to-bracket"></i> Login
              </a>
            </li>
            <li>
              <a href="<?php echo e(route('register.show')); ?>" class="nav-btn">
                <i class="fa-solid fa-user-plus"></i> Register
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>Find Your Dream Home</h1>
        <p>Search from thousands of listings across the country.</p>

        <form id="search-form" action="<?php echo e(route('search.index')); ?>" method="GET" class="search-form" autocomplete="off">
          <input type="text" name="q" id="search-input" placeholder="Enter address or price">
          <button type="submit" class="search-btn">
            <i class="fa-solid fa-magnifying-glass"></i> Search
          </button>
        </form>
        <div id="search-results" style="border: none;"></div>
      </div>
    </div>
  </section>

  <section class="filters">
    <div class="container">
      <form id="filter-form" action="<?php echo e(route('home')); ?>" method="GET">
        <div class="filter-item">
          <label for="price">Price Range</label>
          <select name="price" id="price">
            <option value="" <?php echo e(request('price') == "" ? 'selected' : ''); ?>>Any Price</option>
            <option value="0-200000" <?php echo e(request('price') == "0-200000" ? 'selected' : ''); ?>>Under $200K</option>
            <option value="200000-400000" <?php echo e(request('price') == "200000-400000" ? 'selected' : ''); ?>>$200K - $400K</option>
            <option value="400000-600000" <?php echo e(request('price') == "400000-600000" ? 'selected' : ''); ?>>$400K - $600K</option>
            <option value="600000-1000000" <?php echo e(request('price') == "600000-1000000" ? 'selected' : ''); ?>>$600K - $1M</option>
            <option value="1000000-" <?php echo e(request('price') == "1000000-" ? 'selected' : ''); ?>>Over $1M</option>
          </select>
        </div>

        <div class="filter-item">
          <label for="location">Location</label>
          <input type="text" name="location" id="location" placeholder="e.g. Los Angeles" value="<?php echo e(request('location')); ?>">
        </div>
      

        <div class="filter-item">
          <label for="age">Building Age</label>
          <select name="age" id="age">
            <option value="" <?php echo e(request('age') == "" ? 'selected' : ''); ?>>Any Age</option>
            <option value="0-5" <?php echo e(request('age') == "0-5" ? 'selected' : ''); ?>>0-5 years</option>
            <option value="6-10" <?php echo e(request('age') == "6-10" ? 'selected' : ''); ?>>6-10 years</option>
            <option value="11-20" <?php echo e(request('age') == "11-20" ? 'selected' : ''); ?>>11-20 years</option>
            <option value="21+" <?php echo e(request('age') == "21+" ? 'selected' : ''); ?>>21+ years</option>
          </select>
        </div>

        <div class="filter-item">
          <label for="rooms">Rooms</label>
          <select name="rooms" id="rooms">
            <option value="" <?php echo e(request('rooms') == "" ? 'selected' : ''); ?>>Any</option>
            <option value="1" <?php echo e(request('rooms') == "1" ? 'selected' : ''); ?>>1</option>
            <option value="2" <?php echo e(request('rooms') == "2" ? 'selected' : ''); ?>>2</option>
            <option value="3" <?php echo e(request('rooms') == "3" ? 'selected' : ''); ?>>3</option>
            <option value="4" <?php echo e(request('rooms') == "4" ? 'selected' : ''); ?>>4+</option>
          </select>
        </div>

        <div class="filter-item">
          <label for="time_posted">Date Posted</label>
          <select name="time_posted" id="time_posted">
            <option value="" <?php echo e(request('time_posted') == "" ? 'selected' : ''); ?>>Any</option>
            <option value="24h" <?php echo e(request('time_posted') == "24h" ? 'selected' : ''); ?>>Past 24 Hours</option>
            <option value="week" <?php echo e(request('time_posted') == "week" ? 'selected' : ''); ?>>Past Week</option>
            <option value="month" <?php echo e(request('time_posted') == "month" ? 'selected' : ''); ?>>Past Month</option>
            <option value="year" <?php echo e(request('time_posted') == "year" ? 'selected' : ''); ?>>Past Year</option>
          </select>
        </div>
      

        <button type="submit" class="filter-btn">Filter</button>
      </form>
    </div>
  </section>

  <main class="container listings">
    <h2>Featured Listings</h2>
    <?php if($apartment->isEmpty()): ?>
      <p style="text-align: center;">No apartments available at the moment.</p>
    <?php else: ?>
      <div id="apartment-grid" class="grid">
        <?php $__currentLoopData = $apartment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card">
            <div class="card-image">
              <img
                src="<?php echo e($variable->images === null
                  ? 'https://via.placeholder.com/400x300.png?text=No+Image'
                  : (
                    optional($variable->images->first())->image_url
                      ? asset('storage/Images/' . optional($variable->images->first())->image_url)
                      : 'https://via.placeholder.com/400x300.png?text=No+Image'
                  )); ?>"
                alt="Property"
              />
            </div>
            <div class="card-content">
              <p class="price">$<?php echo e(number_format($variable->price, 2)); ?></p>
              
              <div class="key-info">
                <span><i class="fa-solid fa-ruler"></i> <?php echo e($variable->size ?? 'N/A'); ?> sq ft</span>
                <span><i class="fa-solid fa-bed"></i> <?php echo e($variable->rooms ?? 'N/A'); ?> Rooms</span>
                <span><i class="fa-solid fa-bath"></i> <?php echo e($variable->bathrooms ?? 'N/A'); ?> Bathrooms</span>
                <span><i class="fa-solid fa-calendar-days"></i> <?php echo e($variable->age ?? 'N/A'); ?> years</span>
                 <p class="posted-time">Posted <?php echo e($variable->posted_time); ?></p>
              </div>
              
              <h3><span><i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo e($variable->street); ?>, <?php echo e($variable->city); ?></h3>
            
              <div class="card-actions" style="margin-top: 10px; text-align: center;">
                <a href="<?php echo e(route('property.show', $variable->id)); ?>" class="btn">View</a>
                <?php if(auth()->guard()->check()): ?>
                  <form action="<?php echo e(route('bookmarks.store')); ?>" method="POST" class="bookmark-form" style="display: inline-block;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="apartment_id" value="<?php echo e($variable->id); ?>">
                    <button type="submit" class="bookmark-btn-only <?php if(auth()->user()->bookmarkedApartments->contains($variable->id)): ?> active <?php endif; ?>">
                      <svg viewBox="0 0 24 24">
                        <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"></path>
                      </svg>
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
            
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div id="pagination" class="pagination">
        <span class="pagination-text">Pages:</span>
        <?php if($apartment->currentPage() > 1): ?>
          <button class="prev-page" data-page="<?php echo e($apartment->currentPage() - 1); ?>">
              Previous
          </button>
        <?php endif; ?>

        <?php for($page = 1; $page <= $apartment->lastPage(); $page++): ?>
          <button
            class="page-number <?php echo e($page == $apartment->currentPage() ? 'active' : ''); ?>"
            data-page="<?php echo e($page); ?>"
          >
            <?php echo e($page); ?>

          </button>
        <?php endfor; ?>

        <?php if($apartment->currentPage() < $apartment->lastPage()): ?>
          <button class="next-page" data-page="<?php echo e($apartment->currentPage() + 1); ?>">
            Next
          </button>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </main>

  <footer>
    <div class="container">
      <p>&copy; <?php echo e(date('Y')); ?> Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>
  <script>
    var homeUrl = "<?php echo e(route('home')); ?>";
  </script>
  <script src="<?php echo e(asset('script.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/homepage.blade.php ENDPATH**/ ?>