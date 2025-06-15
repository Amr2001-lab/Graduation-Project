<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo e($property->city); ?> Apartment Details</title>
  <meta name="description" content="Explore the details of this <?php echo e($property->city); ?> apartment – high-quality images, pricing, and property information." />

  <link rel="stylesheet" href="<?php echo e(asset('look.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('vendor/swiper/swiper-bundle.min.css')); ?>" />
</head>
<body>
  <header>
    <div class="container header-container">
      <div class="logo">
        <a href="/" aria-label="Real Estate Home">
          <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo" />
        </a>
      </div>
      <nav class="main-nav" role="navigation">
        <ul class="nav-left">
        </ul>
        <ul class="nav-right">
          <?php if(auth()->guard()->check()): ?>
            <li><a href="<?php echo e(route('estimate')); ?>" class="nav-btn">Estimate Property</a></li>
            <li class="user-dropdown">
              <span class="welcome-msg">
                Welcome, <?php echo e(Auth::user()->name); ?> <i class="fas fa-caret-down"></i>
              </span>
              <ul class="dropdown-menu">
                <li><a href="<?php echo e(route('profile.show')); ?>" class="nav-btn">Profile</a></li>
                <li>
                  <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-btn">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          <?php else: ?>
            <li><a href="<?php echo e(route('login.show')); ?>" class="nav-btn">Login</a></li>
            <li><a href="<?php echo e(route('register.show')); ?>" class="nav-btn">Register</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <section class="gallery-slider property-hero" aria-label="Property Gallery">
    <div class="swiper-container gallery-top">
      <div class="swiper-wrapper">
        <?php $__currentLoopData = $property->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="swiper-slide">
            <img src="<?php echo e(asset('storage/Images/' . $image->image_url)); ?>" alt="Image of <?php echo e($property->city); ?> Apartment" />
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($property->virtual_tour_path): ?>
          <div class="swiper-slide swiper-no-swiping">
            <iframe
              src="<?php echo e(asset(rtrim($property->virtual_tour_path, '/').'/index.html')); ?>"
              scrolling="no"
              style="width:100%; height:600px; border:none;">
          </iframe>
          </div>
        <?php endif; ?>
      </div>
      <div class="swiper-button-next" aria-label="Next Slide"></div>
      <div class="swiper-button-prev" aria-label="Previous Slide"></div>
      <div class="swiper-pagination"></div>
    </div>

    <div class="swiper-container gallery-thumbs" aria-label="Property Thumbnails">
      <div class="swiper-wrapper">
        <?php $__currentLoopData = $property->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="swiper-slide">
            <img src="<?php echo e(asset('storage/Images/' . $image->image_url)); ?>" alt="Thumbnail of <?php echo e($property->city); ?> Apartment" />
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($property->virtual_tour_path): ?>
          <div class="swiper-slide">
            <span style="display:flex;align-items:center;justify-content:center;height:100%;font-weight:bold;">Tour</span>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="hero-overlay">
      <div class="hero-content">
        <h1><?php echo e($property->city); ?> Apartment</h1>
        <p class="price">$<?php echo e(number_format($property->price, 2)); ?></p>
      </div>
    </div>
  </section>

  <main class="container property-details-page">
    <div class="property-details-container">
      <div class="property-summary">
        <h2><?php echo e($property->city); ?> Apartment Details</h2>
        <div class="key-info">
          <span><i class="fa-solid fa-ruler"></i> <?php echo e($property->size); ?> sq ft</span>
          <span><i class="fas fa-map-marker-alt"></i> <?php echo e($property->street); ?></span>
          <span><i class="fas fa-calendar-alt"></i> <?php echo e($property->age); ?> years</span>
          <span><i class="fas fa-bed"></i> <?php echo e($property->rooms); ?> Rooms</span>
          <span><i class="fas fa-bath"></i> <?php echo e($property->bathrooms); ?> Bathrooms</span>
        </div>
        <p class="exact-date">Posted on: <?php echo e($property->created_at->format('F j, Y')); ?></p>
      </div>
      </div>

      <div class="property-more-details">
        <h3>More Details</h3>
        <ul>
          <li><strong>Seller Contact:</strong> <?php echo e($property->phone ?? 'Not Provided'); ?></li>
          <li><i class="fa-solid fa-building"></i> Elevator: <?php echo e($property->elevator ? 'Yes' : 'No'); ?></li>
          <li><i class="fa-solid fa-door-open"></i> Balcony: <?php echo e($property->balcony ? 'Yes' : 'No'); ?></li>
          <li><i class="fa-solid fa-car"></i> Parking: <?php echo e($property->parking ? 'Yes' : 'No'); ?></li>
          <li><i class="fa-solid fa-tree"></i> Private Garden: <?php echo e($property->private_garden ? 'Yes' : 'No'); ?></li>
          <li><i class="fa-solid fa-snowflake"></i> Central Air Conditioning: <?php echo e($property->central_air_conditioning ? 'Yes' : 'No'); ?></li>
        </ul>
      </div>

      <div class="property-actions">
        <div class="card-actions">
          <a href="<?php echo e(route('property.compare', $property->id)); ?>" class="button primary">Compare</a>
          <?php if(auth()->guard()->check()): ?>
            <?php if(Auth::user()->id == $property->seller_id): ?>
              <a href="<?php echo e(route('seller.properties.edit', $property->id)); ?>" class="button secondary">Edit</a>
              <form method="POST" action="<?php echo e(route('seller.properties.destroy', $property->id)); ?>" style="display:inline-block;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="button danger" onclick="return confirm('Are you sure you want to delete this property?')">Delete</button>
              </form>
            <?php else: ?>
              <a id="openInquiryModal" href="#" onclick="return false;" class="button primary">Contact Seller</a>
            <?php endif; ?>
          <?php else: ?>
            <a id="openInquiryModal" href="#" onclick="return false;" class="button primary">Contact Seller</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <div class="container">
      <p>&copy; <?php echo e(date('Y')); ?> Real Estate Listings. All Rights Reserved.</p>
    </div>
  </footer>

  <div class="modal-overlay" id="inquiryModal">
    <div class="modal">
      <span class="modal-close" id="closeInquiryModal">&times;</span>
      <div class="modal-content">
        <h2>Contact Seller</h2>
        <form method="POST" action="<?php echo e(route('inquiry.store', $property->id)); ?>">
          <?php echo csrf_field(); ?>

          <?php if(auth()->guard()->check()): ?>
            <div class="form-group">
              <label for="contact_name">Your Name <span style="color: red;">*</span></label>
              <input type="text" name="name" id="contact_name" value="<?php echo e(Auth::user()->name); ?>" required>
            </div>
            <div class="form-group">
              <label for="contact_email">Your Email <span style="color: red;">*</span></label>
              <input type="email" name="email" id="contact_email" value="<?php echo e(Auth::user()->email); ?>" required>
            </div>
          <?php else: ?>
            <div class="form-group">
              <label for="contact_name">Your Name <span style="color: red;">*</span></label>
              <input type="text" name="name" id="contact_name" required>
            </div>
            <div class="form-group">
              <label for="contact_email">Your Email <span style="color: red;">*</span></label>
              <input type="email" name="email" id="contact_email" required>
            </div>
          <?php endif; ?>

          <div class="form-group">
            <label for="contact_phone">Phone</label>
            <input type="text" name="phone" id="contact_phone" required>
          </div>

          <div class="form-group">
            <label for="contact_message">Message <span style="color: red;">*</span></label>
            <textarea name="message" id="contact_message" rows="4" required>
I am interested in property ID: <?php echo e($property->id); ?>. Please provide more information.
            </textarea>
          </div>

          <button type="submit" class="button primary">Send Inquiry</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    window.flashMessages = <?php echo json_encode(session()->only(['message', 'success', 'error'])) ?>;
  </script>
  <script src="<?php echo e(asset('vendor/swiper/swiper-bundle.min.js')); ?>"></script>
  <script src="<?php echo e(asset('script.js')); ?>"></script>
  
</body>
</html>
```<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/property/show.blade.php ENDPATH**/ ?>