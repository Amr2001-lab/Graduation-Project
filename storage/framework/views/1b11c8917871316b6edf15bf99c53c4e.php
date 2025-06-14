<!DOCTYPE html>
<html>
<head>
    <title>List a New Property</title>
    <link rel="stylesheet" href="<?php echo e(asset('look.css')); ?>">
</head>
<body>
    <header>
    </header>

    <main class="container" style="padding: 40px;">
        <div class="card form-card">
            <h1 class="form-heading">List a New Property</h1>
            <?php if($errors->any()): ?>
                <div class="error-message">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('property.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="size">Size (sq ft)</label>
                    <input
                      type="number"
                      name="size"
                      id="size"
                      required
                      value="<?php echo e(old('size')); ?>"
                      placeholder="e.g. 1200">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input
                      type="number"
                      name="price"
                      id="price"
                      required
                      step="0.01"
                      value="<?php echo e(old('price')); ?>"
                      placeholder="e.g. 250000">
                </div>

                <div class="form-group">
                    <label for="street">Street</label>
                    <input
                      type="text"
                      name="street"
                      id="street"
                      required
                      value="<?php echo e(old('street')); ?>"
                      placeholder="e.g. 123 Main St">
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input
                      type="text"
                      name="city"
                      id="city"
                      required
                      value="<?php echo e(old('city')); ?>"
                      placeholder="e.g. Los Angeles">
                </div>

                <div class="form-group">
                    <label for="age">Building Age (years)</label>
                    <input
                      type="number"
                      name="age"
                      id="age"
                      value="<?php echo e(old('age')); ?>"
                      placeholder="e.g. 5">
                </div>

                <div class="form-group">
                    <label for="rooms">Rooms</label>
                    <input
                      type="number"
                      name="rooms"
                      id="rooms"
                      value="<?php echo e(old('rooms')); ?>"
                      placeholder="e.g. 3">
                </div>

                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input
                      type="number"
                      name="bathrooms"
                      id="bathrooms"
                      value="<?php echo e(old('bathrooms')); ?>"
                      placeholder="e.g. 2">
                </div>

                <div class="form-group features-checkboxes">
                    <label>Features</label>
                    <div class="checkboxes-wrapper">
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="elevator"
                              id="elevator"
                              value="1"
                              <?php echo e(old('elevator') ? 'checked' : ''); ?>>
                            <label for="elevator">Elevator</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="balcony"
                              id="balcony"
                              value="1"
                              <?php echo e(old('balcony') ? 'checked' : ''); ?>>
                            <label for="balcony">Balcony</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="parking"
                              id="parking"
                              value="1"
                              <?php echo e(old('parking') ? 'checked' : ''); ?>>
                            <label for="parking">Parking</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="private_garden"
                              id="private_garden"
                              value="1"
                              <?php echo e(old('private_garden') ? 'checked' : ''); ?>>
                            <label for="private_garden">Private Garden</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="central_air_conditioning"
                              id="central_air_conditioning"
                              value="1"
                              <?php echo e(old('central_air_conditioning') ? 'checked' : ''); ?>>
                            <label for="central_air_conditioning">Central Air Conditioning</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Contact Phone</label>
                    <input
                      type="text"
                      name="phone"
                      id="phone"
                      value="<?php echo e(old('phone')); ?>"
                      placeholder="e.g. +1 555-555-5555">
                </div>

                
                <div class="form-group">
                    <label for="tour_zip">Virtual Tour (ZIP)</label>
                    <input
                      type="file"
                      name="tour_zip"
                      id="tour_zip"
                      accept=".zip">
                    <small>
                      Must contain <code>index.html</code>, a <code>Build/</code> folder and <code>TemplateData/</code>
                    </small>
                </div>

                <div class="form-group">
                    <label for="images">Property Images</label>
                    <input
                      type="file"
                      name="images[]"
                      id="images"
                      multiple
                      accept="image/*">
                    <div id="image-names" style="margin-top:0.5rem;"></div>
                </div>

                <button type="submit" class="btn btn-primary">
                  List Property
                </button>
            </form>
        </div>
    </main>

    <footer>
    </footer>

    <script>
      document.getElementById('images').addEventListener('change', function() {
        const names = Array.from(this.files).map(f => f.name).join(', ');
        document.getElementById('image-names').innerText = names ? `Selected: ${names}` : '';
      });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/property/create.blade.php ENDPATH**/ ?>