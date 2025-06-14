<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Property Estimator</title>
    <link rel="stylesheet" href="<?php echo e(asset('look.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo">
                </a>
            </div>
            <nav class="main-nav">
                <ul class="nav-left">
                    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                </ul>
                <ul class="nav-right">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="user-dropdown">
                            <span class="welcome-msg">
                                Welcome, <?php echo e(Auth::user()->name); ?> <i class="fas fa-caret-down"></i>
                            </span>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo e(route('profile.show')); ?>">Profile</a></li>
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit">Logout</button>
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

    <section class="hero">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>Property Estimator</h1>
                <p>Quick and reliable property value estimates.</p>
            </div>
        </div>
    </section>

    <main class="container">
        <section class="estimator-section">
            <div class="card-estimator form-card">
                <h2>Estimate Your Property</h2>
                <?php if($errors->any()): ?>
                    <div class="error-message">
                        <?php echo e(implode(', ', $errors->all())); ?>

                    </div>
                <?php endif; ?>
                <form action="<?php echo e(route('estimate')); ?>" method="POST" class="estimator-form">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" value="<?php echo e(old('city', $city)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="size">Size (sq ft)</label>
                        <input type="number" name="size" id="size" value="<?php echo e(old('size', $size)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" name="age" id="age" value="<?php echo e(old('age', $age)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="rooms">Rooms</label>
                        <input type="number" name="rooms" id="rooms" value="<?php echo e(old('rooms', $rooms)); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Get Estimate</button>
                </form>
            </div>

            <?php if($estimatedPrice !== null): ?>
                <div class="card-estimator form-card estimate-result">
                    <h2>Estimated Price</h2>
                    <p><strong>Price:</strong> $<?php echo e(number_format($estimatedPrice, 2)); ?></p>
                    <p><strong>City:</strong> <?php echo e($city); ?></p>
                    <p><strong>Size:</strong> <?php echo e($size); ?> sq ft</p>
                    <p><strong>Age:</strong> <?php echo e($age); ?> years</p>
                    <p><strong>Rooms:</strong> <?php echo e($rooms); ?></p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> Real Estate Company. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>xx<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/estimate/form.blade.php ENDPATH**/ ?>