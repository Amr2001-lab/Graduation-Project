<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Buyer Inquiry</title>
</head>
<body>
    <h2>New Message from a Buyer</h2>

    <p><strong>Name:</strong> <?php echo e($buyerName); ?></p>
    <p><strong>Email:</strong> <?php echo e($buyerEmail); ?></p>
    <p><strong>Message:</strong></p>
    <p><?php echo e($buyerMessage); ?></p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fresh_start\firstwebsite\resources\views/buyer-inquiry.blade.php ENDPATH**/ ?>