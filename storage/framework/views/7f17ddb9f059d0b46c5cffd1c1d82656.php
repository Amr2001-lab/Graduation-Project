<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo e(Auth::user()->name); ?>’s Dashboard – Real Estate Listings</title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('look.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css')); ?>">
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="<?php echo e(route('home')); ?>">
          <img src="<?php echo e(asset('storage/Images/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg')); ?>" alt="Real Estate Logo">
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
                <i class="fa-solid fa-chart-line"></i> Estimate Property
              </a>
            </li>
            <li>
              <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-btn">
                  <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>Welcome, <?php echo e(Auth::user()->name); ?>!</h1>
        <p>Manage your profile, bookmarks, and listings below.</p>
      </div>
    </div>
  </section>

  <main class="container dashboard" style="padding: 40px 0;">

    <section class="user-info" style="margin-bottom: 40px;">
      <h2>My Profile</h2>
      <p><strong>Name:</strong> <?php echo e(Auth::user()->name); ?></p>
      <p><strong>Email:</strong> <?php echo e(Auth::user()->email); ?></p>
    </section>
    <section class="listings" style="margin-bottom: 60px;">
      <h2>My Bookmarked Properties</h2>
      <?php if($bookmarks->isEmpty()): ?>
        <p style="text-align:center;">You have not bookmarked any properties yet.</p>
      <?php else: ?>
        <div id="apartment-grid" class="grid">
          <?php $__currentLoopData = $bookmarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $apt = $bookmark->apartment; ?>
            <div class="card">
              <div class="card-image">
                <img src="<?php echo e(optional($apt->images->first())->image_url
                    ? asset('storage/Images/' . $apt->images->first()->image_url)
                    : 'https://via.placeholder.com/400x300.png?text=No+Image'); ?>"
                     alt="Property">
              </div>
              <div class="card-content">
                <p class="price">$<?php echo e(number_format($apt->price, 2)); ?></p>
                <div class="key-info">
                  <span><i class="fa-solid fa-ruler"></i> <?php echo e($apt->size ?? 'N/A'); ?> sq ft</span>
                  <span><i class="fa-solid fa-bed"></i> <?php echo e($apt->rooms ?? 'N/A'); ?> Rooms</span>
                  <span><i class="fa-solid fa-bath"></i> <?php echo e($apt->bathrooms ?? 'N/A'); ?> Baths</span>
                  <span><i class="fa-solid fa-calendar-days"></i> <?php echo e($apt->age ?? 'N/A'); ?> yrs</span>
                  <p class="posted-time">Posted <?php echo e($apt->posted_time); ?></p>
                </div>
                <h3><i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo e($apt->street); ?>, <?php echo e($apt->city); ?></h3>
                <div class="card-actions" style="margin-top:10px; text-align:center;">
                  <a href="<?php echo e(route('property.show', $apt->id)); ?>" class="btn">View</a>
                  <form action="<?php echo e(route('bookmarks.store')); ?>" method="POST" class="bookmark-form" style="display:inline-block;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="apartment_id" value="<?php echo e($apt->id); ?>">
                    <button type="submit" class="bookmark-btn-only active" title="Remove Bookmark">
                      <svg viewBox="0 0 24 24"><path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
    </section>

    <section class="listings">
      <h2>My Listings</h2>
      <?php if($properties->isEmpty()): ?>
        <p style="text-align:center;">You have not listed any properties yet.</p>
      <?php else: ?>
        <div id="apartment-grid" class="grid">
          <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
              <div class="card-image">
                <img src="<?php echo e(optional($property->images->first())->image_url
                    ? asset('storage/Images/' . $property->images->first()->image_url)
                    : 'https://via.placeholder.com/400x300.png?text=No+Image'); ?>"
                     alt="Property">
              </div>
              <div class="card-content">
                <p class="price">$<?php echo e(number_format($property->price, 2)); ?></p>
                <div class="key-info">
                  <span><i class="fa-solid fa-ruler"></i> <?php echo e($property->size ?? 'N/A'); ?> sq ft</span>
                  <span><i class="fa-solid fa-bed"></i> <?php echo e($property->rooms ?? 'N/A'); ?> Rooms</span>
                  <span><i class="fa-solid fa-bath"></i> <?php echo e($property->bathrooms ?? 'N/A'); ?> Baths</span>
                  <span><i class="fa-solid fa-calendar-days"></i> <?php echo e($property->age ?? 'N/A'); ?> yrs</span>
                  <p class="posted-time">Posted <?php echo e($property->posted_time); ?></p>
                </div>
                <h3><i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo e($property->street); ?>, <?php echo e($property->city); ?></h3>
                <div class="card-actions" style="margin-top:10px; text-align:center;">
                  <a href="<?php echo e(route('seller.properties.edit', $property->id)); ?>" class="btn">Edit</a>
                  <form action="<?php echo e(route('seller.properties.destroy', $property->id)); ?>" method="POST" style="display:inline-block;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <div class="container">
      <p>&copy; <?php echo e(date('Y')); ?> Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>

  <script src="<?php echo e(asset('script.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/profile/show.blade.php ENDPATH**/ ?>