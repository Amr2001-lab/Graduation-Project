<link rel="stylesheet" href="<?php echo e(asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css')); ?>">
<?php
    $mainImage = $prop->images->first();
    $imgSrc = $mainImage
             ? asset('storage/Images/' . $mainImage->image_url)
             : 'https://via.placeholder.com/400x250.png?text=No+Image';
?>

<div style="text-align: center; margin-bottom: 15px;">
    <img src="<?php echo e($imgSrc); ?>" alt="Property Image" style="width:100%; max-width:400px; border-radius:4px; object-fit:cover;">
</div>

<h3 style="margin-bottom: 10px;"><?php echo e($prop->street); ?> (<?php echo e($prop->city); ?>)</h3>
<p style="font-weight: bold; margin-bottom: 10px;">$<?php echo e(number_format($prop->price, 2)); ?></p>
<ul style="list-style: none; padding: 0; margin-bottom: 10px;">
    <li>
        <i class="fa-solid fa-ruler-combined"></i>
        <strong>Size:</strong> <?php echo e($prop->size ?? 'N/A'); ?> sq ft
    </li>
    <li>
        <i class="fa-solid fa-bed"></i>
        <strong>Rooms:</strong> <?php echo e($prop->rooms ?? 'N/A'); ?>

    </li>
    <li>
        <i class="fa-solid fa-bath"></i>
        <strong>Bathrooms:</strong> <?php echo e($prop->bathrooms ?? 'N/A'); ?>

    </li>
    <li>
        <i class="fa-solid fa-calendar-alt"></i>
        <strong>Age:</strong> <?php echo e($prop->age ?? 'N/A'); ?> years
    </li>
    <li>
        <i class="fa-solid fa-phone"></i>
        <strong>Seller Phone:</strong> <?php echo e($prop->phone ?? 'N/A'); ?>

    </li>
    <li>
        <i class="fa-solid fa-building"></i>
        <strong>Elevator:</strong> <?php echo e($prop->elevator ? 'Yes' : 'No'); ?>

    </li>
    <li>
        <i class="fa-solid fa-window-maximize"></i>
        <strong>Balcony:</strong> <?php echo e($prop->balcony ? 'Yes' : 'No'); ?>

    </li>
    <li>
        <i class="fa-solid fa-parking"></i>
        <strong>Parking:</strong> <?php echo e($prop->parking ? 'Yes' : 'No'); ?>

    </li>
    <li>
        <i class="fa-solid fa-tree"></i>
        <strong>Private Garden:</strong> <?php echo e($prop->private_garden ? 'Yes' : 'No'); ?>

    </li>
    <li>
        <i class="fa-solid fa-snowflake"></i>
        <strong>Central Air Conditioning:</strong> <?php echo e($prop->central_air_conditioning ? 'Yes' : 'No'); ?>

    </li>
</ul>
<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/property/_compareColumn.blade.php ENDPATH**/ ?>