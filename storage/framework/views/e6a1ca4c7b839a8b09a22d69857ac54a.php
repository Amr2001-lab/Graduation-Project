<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit <?php echo e($apartment->city); ?> Listing</title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('look.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('vendor/swiper/swiper-bundle.min.css')); ?>" />
</head>
<body>
  
  <header>
    <div class="container header-container">
      <div class="logo">
        <a href="/" aria-label="Home">
          <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Logo">
        </a>
      </div>
    </div>
  </header>

  <section style="padding:40px 0 10px;text-align:center;">
    <h1 style="font-size:2rem;font-weight:700;margin:0;">Edit Property Listing</h1>
  </section>

  
  <main class="container" style="padding-bottom:40px;">
    <div class="form-card">
      <?php if($errors->any()): ?>
        <div class="error-message">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>

      
      <?php if($apartment->virtual_tour_path): ?>
        <div class="form-group">
          <label>Current Virtual Tour</label>
          <iframe src="<?php echo e(asset($apartment->virtual_tour_path.'/index.html')); ?>"
                  style="width:100%;height:400px;border:1px solid #ccc;" loading="lazy"></iframe>
          <form action="<?php echo e(route('seller.properties.removeTour', $apartment->id)); ?>" method="POST"
                style="display:inline-block;margin-top:0.5rem;">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="nav-btn danger">Remove Tour</button>
          </form>
        </div>
      <?php endif; ?>

      
      <form action="<?php echo e(route('seller.properties.update',$apartment->id)); ?>" method="POST"
            enctype="multipart/form-data">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        
        <div class="form-group"><label for="city">City</label>
          <input id="city" name="city" value="<?php echo e(old('city',$apartment->city)); ?>" required></div>
        
        <div class="form-group"><label for="street">Address</label>
          <input id="street" name="street" value="<?php echo e(old('street',$apartment->street)); ?>" required></div>
        
        <div class="form-group"><label for="size">Size (sq ft)</label>
          <input type="number" id="size" name="size" value="<?php echo e(old('size',$apartment->size)); ?>" required></div>
        
        <div class="form-group"><label for="price">Price</label>
          <input type="number" id="price" step="0.01" name="price"
                 value="<?php echo e(old('price',$apartment->price)); ?>" required></div>
        
        <div class="form-group"><label for="age">Building Age (years)</label>
          <input type="number" id="age" name="age" value="<?php echo e(old('age',$apartment->age)); ?>" required></div>
        
        <div class="form-group"><label for="rooms">Rooms</label>
          <input type="number" id="rooms" name="rooms" value="<?php echo e(old('rooms',$apartment->rooms)); ?>" required></div>
        
        <div class="form-group"><label for="bathrooms">Bathrooms</label>
          <input type="number" id="bathrooms" name="bathrooms"
                 value="<?php echo e(old('bathrooms',$apartment->bathrooms)); ?>" required></div>

        
        <div class="form-group features-checkboxes"><label>Features (Optional)</label>
          <div class="checkboxes-wrapper">
            <?php $__currentLoopData = [
              'elevator'=>'Elevator','balcony'=>'Balcony','parking'=>'Parking',
              'private_garden'=>'Private Garden','central_air_conditioning'=>'Central Air Conditioning',
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="checkbox-item">
                <input type="checkbox" id="<?php echo e($field); ?>" name="<?php echo e($field); ?>" value="1"
                       <?php echo e(old($field,$apartment->$field) ? 'checked' : ''); ?>>
                <label for="<?php echo e($field); ?>"><?php echo e($label); ?></label>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

        
        <div class="form-group"><label for="phone">Seller Contact Phone (Optional)</label>
          <input id="phone" name="phone" value="<?php echo e(old('phone',$apartment->phone)); ?>"></div>

        
        <div class="form-group"><label for="tour_zip">Upload Virtual Tour (ZIP)</label>
          <input type="file" id="tour_zip" name="tour_zip" accept=".zip">
          <small>Must contain <code>index.html</code>, <code>Build/</code>, and <code>TemplateData</code></small>
        </div>

        
        <div class="form-group">
          <label>Current Images</label>
          <div class="current-images-container">
            <?php $__empty_1 = true; $__currentLoopData = $apartment->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div class="current-image-item"
                   style="display:inline-block;margin:0.5rem;text-align:center;">
                <img src="<?php echo e(asset('storage/Images/'.$image->image_url)); ?>"
                     style="max-width:150px;display:block;margin-bottom:0.5rem;"
                     alt="Image #<?php echo e($loop->iteration); ?>">
                <button type="button"
                        class="nav-btn danger sm remove-image-btn"
                        data-image-id="<?php echo e($image->id); ?>">
                  Remove
                </button>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <p>No images uploaded yet.</p>
            <?php endif; ?>
          </div>
        </div>

        
        <div class="form-group">
          <label for="images">Add Property Images (multiple)</label>
          <input type="file" id="images" name="images[]" multiple accept="image/*">
          <div id="images-names" style="margin-top:0.5rem;"></div>
        </div>

        <button type="submit" class="nav-btn" style="margin-top:1.5rem;">Update Property</button>
      </form>
    </div>
  </main>

  <footer>
    <div class="container" style="padding:20px 0;text-align:center;color:#777;font-size:0.9rem;">
      &copy; <?php echo e(date('Y')); ?> Real Estate Listings. All rights reserved.
    </div>
  </footer>

  <script src="<?php echo e(asset('vendor/swiper/swiper-bundle.min.js')); ?>"></script>
  <script>
    window.flashMessages = <?php echo json_encode(session()->only(['message', 'success', 'error'])) ?>;
  </script>
  <script src="<?php echo e(asset('script.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/seller/edit-property.blade.php ENDPATH**/ ?>